<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $reviewText = $_POST['reviewText'];
    $rating = $_POST['rating'];
    $email = $_SESSION['email']; 

    $emailQuery = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $emailQuery->bind_param('s', $email);
    $emailQuery->execute();
    $emailResult = $emailQuery->get_result();
    if ($emailResult->num_rows === 0) {
        die('Error: The email does not exist in the users table.');
    }
    $emailQuery->close();

    $stmt = $conn->prepare("INSERT INTO reviews (order_id, email, rating, review_text, response) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE review_text = VALUES(review_text)");
    $stmt->bind_param('isiss', $orderId, $email, $rating, $reviewText, $reviewResponse);

    if ($stmt->execute()) {
        echo '<script>alert("Đã gửi đánh giá thành công!");</script>';
        echo '<script>window.location.href = "orders.php";</script>';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
