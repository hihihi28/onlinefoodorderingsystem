<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $orderId = isset($_POST['orderId']) ? intval($_POST['orderId']) : 0;
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

    error_log("Received order ID: $orderId, reason: $reason"); 

    if ($orderId > 0 && !empty($reason)) {
        $stmt = $conn->prepare("UPDATE orders SET order_status = 'Đã hủy', cancel_reason = ? WHERE order_id = ?");
        $stmt->bind_param("si", $reason, $orderId);

        if ($stmt->execute()) {
            echo "Đơn hàng đã được hủy.";
        } else {
            error_log("Database error: " . $stmt->error); 
            echo "Không thể hủy đơn hàng.";
        }

        $stmt->close();
    } else {
        echo "Invalid order ID or reason.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>

