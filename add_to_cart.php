<?php
session_start();
require 'db_connection.php';

// Khởi tạo mảng phản hồi
$response = array('status' => '', 'message' => '');

// Kiểm tra xem biến phiên email đã được thiết lập chưa
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    //Thêm sản phẩm vào bảng giỏ hàng
    if (isset($_POST['pid']) && isset($_POST['pname']) && isset($_POST['pprice'])) {
        $pid = $_POST['pid'];
        $pname = $_POST['pname'];
        $pprice = $_POST['pprice'];
        $pimage = $_POST['pimage'];
        $pcode = $_POST['pcode'];
        $pqty = 1;

        $total_price = $pprice * $pqty;

        $stmt = $conn->prepare('SELECT itemName FROM cart WHERE itemName=? AND email=?');
        $stmt->bind_param('ss', $pname, $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $r = $res->fetch_assoc();
        $code = $r['itemName'] ?? '';

        if (!$code) {
            $query = $conn->prepare('INSERT INTO cart (itemName, price, image, quantity, total_price, catName, email) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $query->bind_param('sdsisss', $pname, $pprice, $pimage, $pqty, $total_price, $pcode, $email);
            $query->execute();

            $response['status'] = 'success';
            $response['message'] = 'Sản phẩm đã được thêm vào giỏ hàng của bạn!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Sản phẩm đã có trong giỏ hàng của bạn!';
        }
    } else {
        $response['status'] = 'Lỗi';
        $response['message'] = 'Invalid item data!';
    }
} else {
    $response['status'] = 'Lỗi';
    $response['message'] = 'Người dùng chưa đăng nhập!';
}

echo json_encode($response);
?>
