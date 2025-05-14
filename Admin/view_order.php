<?php
session_start();
// kiểm tra có phải admin đăng nhập k
if (!isset($_SESSION['adminloggedin'])) {
  header("Location: ../login.php");
  exit();
}

include 'db_connection.php';
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';

if ($orderId) {
  $orderQuery = "SELECT * FROM orders WHERE order_id = ?";
  $stmt = $conn->prepare($orderQuery);
  $stmt->bind_param('i', $orderId);
  $stmt->execute();
  $orderResult = $stmt->get_result();
  $order = $orderResult->fetch_assoc();

  $itemsQuery = "SELECT * FROM order_items WHERE order_id = ?";
  $itemsQuery = "SELECT itemName, quantity, price, total_price, image FROM order_items WHERE order_id = ?";

  $stmt = $conn->prepare($itemsQuery);
  $stmt->bind_param('i', $orderId);
  $stmt->execute();
  $itemsResult = $stmt->get_result();
} else {
  echo "Mã đơn hàng không hợp lệ";
  exit();
}
$paymentMode = $order['pmode'] ?? 'takeaway'; //Mặc định là 'mang về' nếu không được thiết lập

// Xác định phí giao hàng dựa trên phương thức thanh toán
$deliveryFee = ($paymentMode === 'takeaway') ? 0 : 13000;
?>
<?php
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý đơn hàng</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="sidebar.css">
  <link rel="stylesheet" href="admin_orders.css">
  <link rel="stylesheet" href="view_order.css">

</head>

<body>
  <div class="sidebar">
    <button class="close-sidebar" id="closeSidebar">&times;</button>

    <!-- Profile Section -->
    <div class="profile-section">
      <img src="../uploads/<?php echo htmlspecialchars($admin_info['profile_image']); ?>" alt="Profile Picture">
      <div class="info">
        <h3>Chào mừng trở lại!</h3>
        <p><?php echo htmlspecialchars($admin_info['firstName']) . ' ' . htmlspecialchars($admin_info['lastName']); ?></p>
      </div>
    </div>

    <!-- mục điều hướng-->
    <ul>
      <li><a href="index.php"><i class="fas fa-chart-line"></i> Tổng quan</a></li>
      <li><a href="admin_menu.php"><i class="fas fa-utensils"></i> Quản lý thực đơn</a></li>
      <li><a href="admin_orders.php" class="active"><i class="fas fa-shopping-cart"></i> Đơn đặt hàng</a></li>
      <li><a href="reservations.php"><i class="fas fa-calendar-alt"></i> Đơn đặt chỗ</a></li>
      <li><a href="users.php"><i class="fas fa-users"></i> Khách hàng</a></li>
      <li><a href="reviews.php"><i class="fas fa-star"></i> Đánh giá</a></li>
      <li><a href="staffs.php"><i class="fas fa-users"></i> Nhân viên</a></li>
      <li><a href="profile.php"><i class="fas fa-user"></i> Cài đặt hồ sơ</a></li>
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
    </ul>
  </div>
  <div class="content">
    <div class="header">
      <div class="col">
        <button id="toggleSidebar" class="toggle-button">
          <i class="fas fa-bars"></i>
        </button>
        <h2><i class="fas fa-shopping-cart"></i>#<?php echo $order['order_id']; ?> Chi tiết đơn hàng</h2>
      </div>
      <div class="col d-flex justify-content-end">
        <a href="admin_orders.php" class="button"><i class="fas fa-arrow-left"></i>&nbsp; Đơn hàng</a>
      </div>
    </div>
    <div class="details">
      <div class="order-details">
        <div class="order-items">
          <h4 class="mt-2">Đơn hàng đã đặt</h4>
          <hr>
          <ul class="list-group">
            <?php while ($item = $itemsResult->fetch_assoc()) : ?>
              <li class=" d-flex justify-content-between  mb-3">
                <div class="d-flex align-items-start">
                  <?php
                  if (!empty($item['image'])) {
                    echo '<img src="../uploads/' . htmlspecialchars($item['image']) . '" alt="Item Image" style="width: 70px; height: 70px; object-fit: cover;">';
                  } else {
                    echo '<span>No image available</span>';
                  }
                  ?>
                  <?php echo $item['itemName']; ?>
                </div>
                <div>
                  <div class="d-flex flex-row justify-content-between align-items-start quantity-price">
                    <div>
                      <?php echo $item['price'] . 'đ'; ?> x <?php echo $item['quantity']; ?>

                    </div>
                  </div>
                  <div class="d-flex flex-row justify-content-end align-items-end">
                    <span class="badge rounded-pill text-light p-2 mt-2" style="background-color: #fb4a36; "> <?php echo $item['total_price']; ?> đ</span>
                  </div>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        </div>
        <div class="order-summary">
          <h4 class="mt-2">Phí đơn hàng</h4>
          <hr>
          <div class="summary-details">
            <p><strong>Tổng phụ:</strong></p>
            <p> <?= str_replace(',', '.', number_format($order['sub_total'])) ?>đ</p>
          </div>

          <div class="summary-details">
            <p><strong>Phí:</strong></p>
            <p> <?= str_replace(',', '.', number_format($deliveryFee)) ?>đ</p>
          </div>
          <div class="summary-details">
            <p><strong>Thành tiền:</strong></p>
            <p> <?= str_replace(',', '.', number_format($order['grand_total'])) ?>đ</p>
          </div>
          <div class="summary-details">
            <p><strong>Phương thức thanh toán:</strong></p>
            <p><?php echo $order['pmode']; ?></p>
          </div>
          <div class="summary-details">
            <p style="width: 60%;"><strong>Trạng thái thanh toán:</strong></p>
            <select class="form-select" id="paymentStatus" name="payment_status">
              <option value="Đang chờ" <?php if ($order['payment_status'] == 'Đang chờ') echo 'selected'; ?>>Đang chờ</option>
              <option value="Thành công" <?php if ($order['payment_status'] == 'Thành công') echo 'selected'; ?>>Thành công</option>
              <option value="Bị từ chối" <?php if ($order['payment_status'] == 'Bị từ chối') echo 'selected'; ?>>Bị từ chối</option>
            </select>
          </div>
          <div class="summary-details">
            <p><strong>Lý do hủy:</strong></p>
            <p><?php echo $order['cancel_reason']; ?></p>
          </div>
          <hr>
          <form method="post" action="update_order_status.php" onsubmit="return validateForm()">
            <div class="status-container">
              <label for="orderStatus" class="form-label"><strong>Trạng thái đơn hàng</strong></label>
              <select class="form-select" id="orderStatus" name="order_status">
                <option value="Đang chờ" <?php if ($order['order_status'] == 'Đang chờ') echo 'selected'; ?>>Đang chờ</option>
                <option value="Đang xử lý" <?php if ($order['order_status'] == 'Đang xử lý') echo 'selected'; ?>>Đang xử lý</option>
                <option value="Đã hoàn thành" <?php if ($order['order_status'] == 'Đã hoàn thành') echo 'selected'; ?>>Đã hoàn thành</option>
                <option value="Đã hủy" <?php if ($order['order_status'] == 'Đã hủy') echo 'selected'; ?>>Đã hủy</option>
                <option value="Đang trên đường" <?php if ($order['order_status'] == 'Đang trên đường') echo 'selected'; ?>>Đang trên đường</option>
              </select>
            </div>
            <div class="mb-3" id="cancelReasonContainer" style="display: none;">
              <label for="cancelReason" class="form-label">Lý do hủy</label>
              <textarea class="form-control" id="cancelReason" name="cancel_reason"></textarea>
            </div>
            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
            <button type="submit" id="statusbtn">Cập nhật trạng thái</button>
          </form>
        </div>
      </div>
      <div class="customer mb-4">
        <h4 class="mt-2">Chi tiết khách hàng </h4>
        <hr>
        <div class="customer-details">
          <div class="summary-details">
            <p><strong>Tên:</strong></p>
            <p><?php echo $order['firstName'] . ' ' . $order['lastName']; ?></p>
          </div>
          <div class="summary-details">
            <p><strong>Email:</strong></p>
            <p><?php echo $order['email']; ?></p>
          </div>
          <div class="summary-details">
            <p><strong>Số điện thoại:</strong></p>
            <p><?php echo $order['phone']; ?></p>
          </div>
          <div class="summary-details">
            <p><strong>Địa chỉ:</strong></p>
            <p><?php echo $order['address']; ?></p>
          </div>
          <div class="summary-details">
            <p><strong>Ghi chú đơn hàng:</strong></p>
            <p><?php echo $order['note']; ?></p>
          </div>
        </div>
      </div>
    </div>

  </div>
  <?php
  include_once('footer.html');
  ?>
  <script src="sidebar.js"></script>
  <script>
    document.getElementById('paymentStatus').addEventListener('change', function() {
      var paymentStatus = this.value;
      var orderId = <?php echo $order['order_id']; ?>; // lấy mã đơn hàng

      // Tạo yêu cầu AJAX
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'update_payment_status.php', true);
      // gửi dữ liệu dạng key=value như form html
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

      // Xử lý phản hồi
      xhr.onload = function() {
        if (xhr.status === 200) {
          alert('Trạng thái thanh toán được cập nhật thành công');
        } else {
          console.error('Lỗi cập nhật trạng thái thanh toán');
        }
      };

      // Gửi yêu cầu kèm theo ID đơn hàng và trạng thái thanh toán
      xhr.send('order_id=' + encodeURIComponent(orderId) + '&payment_status=' + encodeURIComponent(paymentStatus));
    });


    document.getElementById('orderStatus').addEventListener('change', function() {
      const cancelReasonContainer = document.getElementById('cancelReasonContainer');
      if (this.value === 'Đã hủy') {
        cancelReasonContainer.style.display = 'block';
      } else {
        cancelReasonContainer.style.display = 'none';
      }
    });

    function validateForm() {
      const orderStatus = document.getElementById('orderStatus').value;
      if (orderStatus === 'Đã hủy') {
        const cancelReason = document.getElementById('cancelReason').value;
        if (cancelReason.trim() === '') {
          alert('Vui lòng cung cấp lý do hủy.');
          return false;
        }
      }
      return true;
    }
  </script>
</body>

</html>