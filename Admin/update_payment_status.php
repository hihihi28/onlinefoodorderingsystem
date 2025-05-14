<?php
session_start();
if (!isset($_SESSION['adminloggedin'])) {
    header("Location: ../login.php");
    exit();
}

include 'db_connection.php';

// Nhận dữ liệu POST
$orderId = isset($_POST['order_id']) ? $_POST['order_id'] : '';
$paymentStatus = isset($_POST['payment_status']) ? $_POST['payment_status'] : '';

// Xác thực đầu vào
if ($orderId && $paymentStatus) {
    // Chuẩn bị truy vấn SQL để cập nhật trạng thái thanh toán
    $updateQuery = "UPDATE orders SET payment_status = ? WHERE order_id = ?";
    
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $paymentStatus, $orderId);
    
    // Thực hiện truy vấn
    if ($stmt->execute()) {
        echo "Thành công";
    } else {
        echo "Có lỗi khi cập nhật trạng thái thanh toán.";
    }
    
    $stmt->close();
} else {
    echo "Mã đơn hàng hoặc trạng thái thanh toán không hợp lệ.";
}

$conn->close();
?>
