<?php
session_start();
if (!isset($_SESSION['adminloggedin'])) {
  header("Location: ../login.php");
  exit();
}
include 'db_connection.php';
// khởi tạo biến tìm kiếm
$search = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  $search = $conn->real_escape_string($_POST['search']);
}

?>
<?php
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lý người dùng</title>
  <!-- Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="admin_user.css">
  <link rel="stylesheet" href="sidebar.css">
  <style>
    .sidebar ul li a i {
      margin-right: 10px;
    }

    .sidebar ul li a.active {
      font-weight: bold;
    }
  </style>
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

    
    <ul>
      <li><a href="index.php"><i class="fas fa-chart-line"></i> Tổng quan</a></li>
      <li><a href="admin_menu.php"><i class="fas fa-utensils"></i> Quản lý thực đơn</a></li>
      <li><a href="admin_orders.php"><i class="fas fa-shopping-cart"></i> Đơn đặt hàng</a></li>
      <li><a href="reservations.php"><i class="fas fa-calendar-alt"></i> Đặt bàn</a></li>
      <li><a href="users.php" class="active"><i class="fas fa-users"></i> Người dùng</a></li>
      <li><a href="reviews.php"><i class="fas fa-star"></i> Đánh giá </a></li>
      <li><a href="staffs.php"><i class="fas fa-users"></i> Nhân viên</a></li>
      <li><a href="profile.php"><i class="fas fa-user"></i> Cài đặt hồ sơ</a></li>
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
    </ul>
  </div>
  <div class="content">
    <div class="header">
      <button id="toggleSidebar" class="toggle-button">
        <i class="fas fa-bars"></i>
      </button>
      <h2><i class="fas fa-users"></i>&nbsp;Danh sách người dùng</h2>
    </div>



    <div class="actions">
      <button onclick="openaddUserModal()"><i class="fas fa-user-plus"></i> &nbsp; Thêm người dùng </button>
      <form method="POST" id="searchForm" class="search-bar">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
      </form>


    </div>

    <table id="userTable">
      <thead>
        <tr>
          <th>STT</th>
          <th>Ngày tạo</th>
          <th>Email</th>
          <th>Họ và tên đệm</th>
          <th>Tên</th>
          <th>Số điện thoại</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        
        $sql = "SELECT * FROM users";
        if (!empty($search)) {
          $sql .= " WHERE email LIKE '%$search%' OR firstName LIKE '%$search%' OR lastName LIKE '%$search%'";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $counter = 1;
          while ($row = $result->fetch_assoc()) {
            $passwordMasked = str_repeat('*', strlen($row['password']));
            echo "<tr>
                      <td>{$counter}</td>
                      <td>{$row['dateCreated']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['firstName']}</td>
                      <td>{$row['lastName']}</td>
                      <td>{$row['contact']}</td>
                     
                      <td>
                          <button id='editbtn' onclick='openEditUserModal(this)' data-email='{$row['email']}' data-firstname='{$row['firstName']}' data-lastname='{$row['lastName']}' data-contact='{$row['contact']}' data-password='{$row['password']}'><i class='fas fa-edit'></i></button>
                          <button id='deletebtn' onclick=\"deleteItem('{$row['email']}')\"><i class='fas fa-trash'></i></button>
                      </td>
                  </tr>";
            $counter++;
          }
        } else {
          echo "<tr><td colspan='8' style='text-align: center;'>Ko tìm thấy</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>


  <!-- Modal để thêm người dùng -->
  <div id="addUserModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
      <form id="addUserForm" method="POST" action="add_user.php">
        <div class="modal-header">
          <h2>thêm người dùng</h2>
          <span class="close-icon" onclick="closeaddUserModal()">&times;</span>
        </div>
        <div class="modal-content">
          <div class="input-group">
            <input type="email" name="email" id="email" class="input" required>
            <label for="email" class="label">Email</label>
          </div>
        </div>

        <div class="modal-content">
          <div class="input-group">
            <input type="text" name="firstName" id="firstName" class="input" required>
            <label for="firstName" class="label">Họ và tên đệm</label>
          </div>
        </div>

        <div class="modal-content">
          <div class="input-group">
            <input type="text" name="lastName" id="lastName" class="input" required>
            <label for="lastName" class="label">Tên</label>
          </div>
        </div>

        <div class="modal-content">
          <div class="input-group">
            <input type="text" name="contact" id="contact" class="input" required>
            <label for="contact" class="label">Số điện thoại</label>
          </div>
        </div>

        <div class="modal-content">
          <div class="input-group">
            <input type="password" name="password" id="Password" class="input" required>
            <span class="toggle-password" onclick="togglePasswordVisibility()">
              <i class="fas fa-eye-slash" id="passwordIcon"></i>
            </span>
            <label for="password" class="label">Mật khẩu</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="button" onclick="closeaddUserModal()">Hủy bỏ</button>
          <button type="submit" class="button">Lưu</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal để chỉnh sửa người dùng -->
  <div id="editUserModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
      <form id="editUserForm" method="POST" action="edit_user.php">
        <div class="modal-header">
          <h2>Sửa thông tin</h2>
          <span class="close-icon" onclick="closeEditUserModal()">&times;</span>
        </div>
        <div class="modal-content">
          <div class="input-group">
            <input type="email" name="email" id="editEmail" class="input" required readonly>
            <label for="editEmail" class="label">Email</label>
          </div>
          <div class="input-group">
            <input type="text" name="firstName" id="editFirstName" class="input" required>
            <label for="editFirstName" class="label">Họ và tên đệm</label>
          </div>
          <div class="input-group">
            <input type="text" name="lastName" id="editLastName" class="input" required>
            <label for="editLastName" class="label">Tên</label>
          </div>
          <div class="input-group">
            <input type="text" name="contact" id="editContact" class="input" required>
            <label for="editContact" class="label">Số điện thoại</label>
          </div>
          <div class="input-group">
            <input type="password" name="password" id="editPassword" class="input" required readonly>
            <label for="editPassword" class="label">Password</label>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="button" onclick="closeEditUserModal()">Hủy bỏ</button>
          <button type="submit" class="button">Lưu</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  include_once('footer.html');
  ?>
  <script src="sidebar.js"></script>
  <script>
    const modal = document.querySelector('.modal');
    const buttons = document.querySelectorAll('.toggleButton');

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        modal.classList.toggle('open');
      });
    });
//chuyển đổi qua lại giữa việc hiển thị và ẩn mật khẩu
    function togglePassword(element) {
      const passwordMasked = element.previousElementSibling.previousElementSibling;
      const passwordVisible = element.previousElementSibling;
      if (passwordMasked.style.display === 'none') {
        passwordMasked.style.display = 'inline';
        passwordVisible.style.display = 'none';
        element.classList.remove('fa-eye');
        element.classList.add('fa-eye-slash');
      } else {
        passwordMasked.style.display = 'none';
        passwordVisible.style.display = 'inline';
        element.classList.remove('fa-eye-slash');
        element.classList.add('fa-eye');
      }
    }
// chuyển đổi qua lại giữa việc hiển thị mật khẩu dưới dạng văn bản rõ ràng và ẩn mật khẩu 
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('Password');
      const passwordIcon = document.getElementById('passwordIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
      } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
      }
    }


    function openModal() {
      document.getElementById('addUserModal').classList.add('open');
    }

    function closeModal() {
      document.getElementById('addUserModal').classList.remove('open');
    }

    function openaddUserModal() {
      document.getElementById('addUserModal').classList.add('open');
    }

    function closeaddUserModal() {
      document.getElementById('addUserModal').classList.remove('open');
    }

    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.querySelector('input[name="search"]');

      searchInput.addEventListener('keyup', function() {
        const searchQuery = searchInput.value;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'search_users.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const response = xhr.responseText;
            document.querySelector('#userTable tbody').innerHTML = response;
          }
        };
        xhr.send('search=' + encodeURIComponent(searchQuery));
      });
    });

    function deleteItem(email) {
      if (confirm('Are you sure you want to delete this User?')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            location.reload();
          }
        };
        xhr.send("email=" + encodeURIComponent(email));
      }
    }

    function toggleEditPasswordVisibility() {
      const passwordField = document.getElementById('editPassword');
      const passwordIcon = document.getElementById('editPasswordIcon');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
      } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
      }
    }


    function openModal() {
      document.getElementById('editUserModal').classList.add('open');
    }

    function closeModal() {
      document.getElementById('editUserModal').classList.remove('open');
    }


    function openEditUserModal(button) {
      //Lấy dữ liệu người dùng từ các thuộc tính dữ liệu
      const email = button.getAttribute('data-email');
      const firstName = button.getAttribute('data-firstname');
      const lastName = button.getAttribute('data-lastname');
      const contact = button.getAttribute('data-contact');
      const password = button.getAttribute('data-password');

      // Đặt các giá trị trong editUserForm
      document.getElementById('editEmail').value = email;
      document.getElementById('editFirstName').value = firstName;
      document.getElementById('editLastName').value = lastName;
      document.getElementById('editContact').value = contact;
      document.getElementById('editPassword').value = password;

      // mở modal
      document.getElementById('editUserModal').classList.add('open');
    }


    function closeEditUserModal() {
      document.getElementById('editUserModal').classList.remove('open');
    }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

</body>

</html>