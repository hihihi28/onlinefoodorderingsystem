<?php
session_start();
if (!isset($_SESSION['adminloggedin'])) {
    header("Location: ../login.php");
    exit();
}

include 'db_connection.php';    

$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';
$searchOrderId = isset($_GET['searchOrderId']) ? $_GET['searchOrderId'] : '';

$query = "SELECT order_id, order_date, firstName, lastName, phone, grand_total, order_status, pmode, cancel_reason FROM orders";
$conditions = [];

if (!empty($statusFilter)) {
    $conditions[] = "order_status = '" . $conn->real_escape_string($statusFilter) . "'";
}

if (!empty($searchOrderId)) {
    $conditions[] = "order_id LIKE '%" . $conn->real_escape_string($searchOrderId) . "%'";
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$query .= " ORDER BY order_id DESC";

$result = $conn->query($query);

?>
<?php
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng </title>
    <!--poppins-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="admin_orders.css">
    <style>
  .content{
    margin-bottom: 40px;
  }
</style>
</head>

<body>
    <div class="sidebar">
        <button class="close-sidebar" id="closeSidebar">&times;</button>
       
        <!-- phần hồ sơ -->
    <div class="profile-section">
      <img src="../uploads/<?php echo htmlspecialchars($admin_info['profile_image']); ?>" alt="Profile Picture">
      <div class="info">
        <h3>Chào mừng trở lại!</h3>
        <p><?php echo htmlspecialchars($admin_info['firstName']) . ' ' . htmlspecialchars($admin_info['lastName']); ?></p>
      </div>
    </div>

    <!-- Mục điều hướng -->

    <ul>
            <li><a href="index.php" ><i class="fas fa-chart-line"></i> Tổng quan</a></li>
            <li><a href="admin_menu.php"><i class="fas fa-utensils"></i> Quản lý thực đơn</a></li>
            <li><a href="admin_orders.php" class="active"><i class="fas fa-shopping-cart"></i> Đơn đặt hàng</a></li>
            <li><a href="reservations.php"><i class="fas fa-calendar-alt"></i> Đặt bàn</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Người dùng</a></li>
            <li><a href="reviews.php"><i class="fas fa-star"></i> Đánh giá</a></li>
            <li><a href="staffs.php" ><i class="fas fa-users"></i> Nhân viên</a></li>
            <li><a href="profile.php"><i class="fas fa-user"></i> Cài đặt hồ sơ</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="header">
            <button id="toggleSidebar" class="toggle-button">
                <i class="fas fa-bars"></i>
            </button>
            <h2><i class="fas fa-shopping-cart"></i> Đơn đặt hàng</h2>
        </div>

        <div class="actions">
            <div>
            <button id="refreshButton" onclick="refreshPage()" title="Refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
           
            </div>
         
            <div class="filter-orders">
                <select id="statusFilter" name="statusFilter" onchange="filterByStatus()">
                    <option value="">Tất cả đơn hàng</option>
                    <option value="Đang chờ">Đang chờ</option>
                    <option value="Đang xử lý">Đang xử lý</option>
                    <option value="Đang trên đường">Đang trên đường</option>
                    <option value="Đã hoàn thành">Đã hoàn thành</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
                <input type="text" id="searchOrderId" placeholder="Tìm theo mã đơn hàng" oninput="searchByOrderId()">
            </div>
        </div>
        <?php
        // Hiển thị đơn hàng trong bảng
        echo "<table>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Thành tiền</th>
                    <th>Trạng thái đơn</th>
                    <th>Phương thức thanh toán</th>
                    <th>Lý do hủy</th>
                    <th>Hành động</th>
                </tr>";
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = '';
                switch ($row['order_status']) {
                    case 'Đang chờ':
                        $statusClass = 'status-pending';
                        $displayStatus = 'Đang chờ';
                        break;
                    case 'Đang xử lý':
                        $statusClass = 'status-processing';
                        $displayStatus = 'Đang xử lý';
                        break;
                    case 'Đang trên đường':
                        $statusClass = 'status-ontheway';
                        $displayStatus = 'Đang trên đường';
                        break;
                    case 'Đã hoàn thành':
                        $statusClass = 'status-completed';
                        $displayStatus = 'Đã hoàn thành';
                        break;
                    case 'Đã hủy':
                        $statusClass = 'status-cancelled';
                        $displayStatus = 'Đã hủy';
                        break;
                    default:
                        $statusClass = '';
                        $displayStatus = $row['order_status'];
                }
                echo "<tr>
                    <td>" . $row['order_id'] . "</td>
                    <td>" . $row['firstName'] . " " . $row['lastName'] . "</td>
                    <td>" . $row['phone'] . "</td>
                    <td>"  . $row['grand_total']  . 'đ ' ."</td>
                    <td><span class='status $statusClass'>" . $displayStatus . "</span></td>
                    <td>" . $row['pmode'] . "</td>
                    <td>" . ($row['order_status'] == 'Cancelled' ? $row['cancel_reason'] : '-') . "</td>
                    <td><button id='viewbtn' onclick=\"viewDetails(" . $row['order_id'] . ")\">Xem chi tiết</button></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='8' style='text-align: center;'>Không tìm thấy</td></tr>";
        }

        echo "</table>";

        $conn->close();
        ?>
    </div>

    <?php
    include_once ('footer.html');
    ?>
    <script src="sidebar.js"></script>
    <script>
                function viewDetails(orderId) {
            window.location.href = 'view_order.php?orderId=' + orderId;
        }
    const modal = document.querySelector('.modal');
    const buttons = document.querySelectorAll('.toggle-button');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.toggle('open');
        });
    });

    function filterByStatus() {
        var statusFilter = document.getElementById('statusFilter').value;
        var dateFilter = document.getElementById('dateFilter') ? document.getElementById('dateFilter').value : ''; // Optional date filter
        var searchOrderId = document.getElementById('searchOrderId').value.trim();
        window.location.href = 'admin_orders.php?statusFilter=' + encodeURIComponent(statusFilter) + '&dateFilter=' + encodeURIComponent(dateFilter) + '&searchOrderId=' + encodeURIComponent(searchOrderId);
    }

    function searchByOrderId() {
        filterByStatus(); // Gọi filterByStatus để cập nhật kết quả dựa trên thông tin tìm kiếm
    }

    function refreshPage() {
        window.location.href = 'admin_orders.php'; // Reload trang
    }

    // Đặt giá trị chọn bộ lọc trạng thái dựa trên tham số truy vấn
    document.getElementById('statusFilter').value = "<?= isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '' ?>";

    // Tùy chọn: Đặt giá trị bộ lọc ngày nếu bạn có bộ lọc ngày
    if (document.getElementById('dateFilter')) {
        document.getElementById('dateFilter').value = "<?= isset($_GET['dateFilter']) ? $_GET['dateFilter'] : '' ?>";
    }

    // Đặt giá trị đầu vào tìm kiếm dựa trên tham số truy vấn
    document.getElementById('searchOrderId').value = "<?= isset($_GET['searchOrderId']) ? $_GET['searchOrderId'] : '' ?>";

    // lắng nghe sự kiện cho các bộ lọc
    document.getElementById('statusFilter').addEventListener('change', filterByStatus);
    if (document.getElementById('dateFilter')) {
        document.getElementById('dateFilter').addEventListener('change', filterByStatus);
    }
    document.getElementById('searchOrderId').addEventListener('input', searchByOrderId);
    document.getElementById('refreshButton').addEventListener('click', refreshPage);
</script>



</body>

</html>