<?php

include 'db_connection.php';

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$orderId = $data['orderId'];
$email = $data['email'];

if (empty($orderId) || empty($email)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit();
}


$stmt = $conn->prepare("DELETE FROM reviews WHERE order_id = ? AND email = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Statement preparation failed']);
    exit();
}


$stmt->bind_param('is', $orderId, $email);


if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Review deleted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting review']);
}

$stmt->close();
$conn->close();
?>
