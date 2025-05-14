<?php
session_start();
include 'db_connection.php'; // Đảm bảo bạn có tệp db_connection.php để kết nối với cơ sở dữ liệu của mình

// Kiểm tra xem session email có tồn tại không
if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Người dùng chưa đăng nhập.']);
    exit;
}
$email = $_SESSION['email'];
$orderStatus = isset($_GET['status']) ? $_GET['status'] : 'All';

// Tính số lượng đơn hàng cho mỗi trạng thái
$countQuery = "SELECT order_status, COUNT(*) as count 
               FROM orders 
               WHERE email = ? 
               GROUP BY order_status";
$countStmt = $conn->prepare($countQuery);
$countStmt->bind_param('s', $email);
$countStmt->execute();
$countResult = $countStmt->get_result();
$statusCounts = [
    'All' => 0,
    'Đang chờ' => 0,
    'Đang xử lý' => 0,
    'Đang trên đường' => 0,
    'Đã hoàn thành' => 0,
    'Đã hủy' => 0
];
while ($row = $countResult->fetch_assoc()) {
    $statusCounts[$row['order_status']] = $row['count'];
    $statusCounts['All'] += $row['count']; // Tổng số đơn hàng
}
$countStmt->close();

// Câu truy vấn để lấy thông tin đơn hàng và đánh giá (review) bằng LEFT JOIN
$query = "SELECT orders.*, reviews.review_text, reviews.response 
          FROM orders 
          LEFT JOIN reviews ON orders.order_id = reviews.order_id 
          WHERE orders.email = ?";

if ($orderStatus !== 'All') {
    $query .= " AND orders.order_status = ?";
}

$stmt = $conn->prepare($query);

if (!$stmt) {
    // Xử lý lỗi nếu prepare thất bại
    echo json_encode(['error' => 'Lỗi khi chuẩn bị câu truy vấn: ' . $conn->error]);
    exit;
}

if ($orderStatus === 'All') {
    $stmt->bind_param('s', $email);
} else {
    $stmt->bind_param('ss', $email, $orderStatus);
}

$executeResult = $stmt->execute();

if (!$executeResult) {
    // Xử lý lỗi nếu execute thất bại
    echo json_encode(['error' => 'Lỗi khi thực thi câu truy vấn: ' . $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$result = $stmt->get_result();
$orders = [];

while ($order = $result->fetch_assoc()) {
    $orderId = $order['order_id'];
    
    // Lấy các sản phẩm trong đơn hàng
    $itemsQuery = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    if ($itemsQuery) {
        $itemsQuery->bind_param('i', $orderId);
        $itemsQuery->execute();
        $itemsResult = $itemsQuery->get_result();
        $order['items'] = $itemsResult->fetch_all(MYSQLI_ASSOC);
        $itemsQuery->close();
    } else {
        $order['items'] = []; // Trả về mảng rỗng nếu có lỗi
    }

    // Bao gồm lý do hủy nếu đơn hàng bị hủy
    if ($order['order_status'] === 'Đã hủy') {
        if (!isset($order['cancel_reason'])) {
            $cancelQuery = $conn->prepare("SELECT cancel_reason FROM orders WHERE order_id = ?");
            if ($cancelQuery) {
                $cancelQuery->bind_param('i', $orderId);
                $cancelQuery->execute();
                $cancelResult = $cancelQuery->get_result();
                $cancelData = $cancelResult->fetch_assoc();
                $order['cancel_reason'] = $cancelData ? $cancelData['cancel_reason'] : null;
                $cancelQuery->close();
            } else {
                $order['cancel_reason'] = null;
            }
        }
    }

    $orders[] = $order;
}

// Đặt header là JSON trước khi echo
header('Content-Type: application/json');
echo json_encode([
    'orders' => $orders,
    'statusCounts' => $statusCounts
]);

$stmt->close();
$conn->close();
?>