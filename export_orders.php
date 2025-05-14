<?php
session_start();
if (!isset($_SESSION['userloggedin'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Unauthorized');
}

include 'db_connection.php';

// Lấy tham số tìm kiếm và lọc
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Xây dựng câu truy vấn
$sql = "SELECT o.*, GROUP_CONCAT(CONCAT(p.name, ' x', oi.quantity) SEPARATOR '; ') as items 
        FROM orders o 
        LEFT JOIN order_items oi ON o.order_id = oi.order_id 
        LEFT JOIN products p ON oi.product_id = p.id 
        WHERE o.user_id = ?";
$params = array($_SESSION['user_id']);
$types = "i";

if (!empty($search)) {
    $sql .= " AND (o.order_id LIKE ? OR o.customer_name LIKE ? OR o.phone LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if (!empty($status_filter)) {
    $sql .= " AND o.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$sql .= " GROUP BY o.order_id ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Tạo nội dung CSV
$output = fopen('php://temp', 'r+');

// Thêm header
fputcsv($output, array(
    'Mã đơn hàng',
    'Ngày đặt',
    'Tên khách hàng',
    'Số điện thoại',
    'Địa chỉ',
    'Sản phẩm',
    'Tổng tiền',
    'Trạng thái'
));

// Thêm dữ liệu
while ($row = $result->fetch_assoc()) {
    $status_text = array(
        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'on_the_way' => 'Đang giao',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy'
    );
    
    fputcsv($output, array(
        $row['order_id'],
        date('d/m/Y H:i', strtotime($row['order_date'])),
        $row['customer_name'],
        $row['phone'],
        $row['address'],
        $row['items'],
        number_format($row['total_amount']) . 'đ',
        $status_text[$row['status']]
    ));
}

// Đọc nội dung từ temp stream
rewind($output);
$csv = stream_get_contents($output);
fclose($output);

// Trả về nội dung CSV
header('Content-Type: text/csv; charset=utf-8');
echo $csv; 