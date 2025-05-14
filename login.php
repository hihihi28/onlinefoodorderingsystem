<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="login.css" />
	<title>Đăng nhập/Đăng kí</title>
	<style>
	
.input-field .fa-eye,
.input-field .fa-eye-slash {
    position: absolute;
    right: 10px;
    cursor: pointer;
    color: #007bff;
    transition: color 0.3s ease;
}

.input-field .fa-eye:hover,
.input-field .fa-eye-slash:hover {
  color: #0056b3;
}
	</style>
</head>

<body>

	<?php
	include_once("navbar.php");
	?>

	<div class="container">
		<div class="forms-container">
			<div class="signin-signup">
				<form action="dblogin.php" class="sign-in-form" method="POST">
					<h2 class="title">Đăng nhập</h2>
					<div class="input-field">
						<i class="fas fa-envelope"></i>
						<input type="email" placeholder="Email" name="email" required onkeyup="hideAlertBox()" />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" id="loginPassword" placeholder="Mật khẩu" name="password" required onkeyup="hideAlertBox()" />
						<i class="fas fa-eye-slash" id="toggleLoginPassword" style="cursor: pointer;"></i>
					</div>
					<input type="submit" value="Đăng nhập" class="submit solid" id="loginButton" />

					<?php

					if (isset($_GET['error'])) {
						echo ('
	        <div class="alert alert-danger" id="alertbox" role="alert">
	        Email or Password is incorrect.
          </div>');
					}

					?>

				</form>
				<form action="dbregister.php" class="sign-up-form" method="POST" id="registerForm">
					<h2 class="title">Đăng ký</h2>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" placeholder="Họ và tên đệm" name="firstName" onkeyup="hideAlertBox()" required />
					</div>
					<div class="input-field">
						<i class="fas fa-user"></i>
						<input type="text" placeholder="Tên" name="lastName" onkeyup="hideAlertBox()" required />
					</div>
					<div class="input-field">
						<i class="fas fa-envelope"></i>
						<input type="email" placeholder="Email" name="email" onkeyup="hideAlertBox()" required />
					</div>
					<div class="input-field">
						<i class="fas fa-phone" style="transform: rotate(90deg);"></i>
						<input type="text" placeholder="Số điện thoại" name="contact" onkeyup="hideAlertBox()" required />
					</div>
					<div class="input-field">
						<i class="fas fa-lock"></i>
						<input type="password" id="registerPassword" placeholder="Mật khẩu" name="password" required onkeyup="hideAlertBox()" />
						<i class="fas fa-eye-slash" id="toggleRegisterPassword" style="cursor: pointer;"></i>
					</div>
					<input type="submit" class="submit" value="Đăng kí" id="registerButton" />



				</form>
			</div>
		</div>

		<div class="panels-container">
			<div class="panel left-panel">
				<div class="content">
					<h3>Bạn mới đến nhà hàng của chúng tôi?</h3>
					<p>
					Hãy tham gia cùng chúng tôi ngay hôm nay và tận hưởng sự tiện lợi của việc đặt hàng trực tuyến. Nhận ưu đãi độc quyền và theo dõi đơn hàng của bạn một cách dễ dàng.
					</p>
					<button class="btn transparent" id="sign-up-btn">
						Đăng kí
					</button>
				</div>
				<img src="images/form-pic.png" class="image" alt="" />
			</div>
			<div class="panel right-panel">
				<div class="content">
					<h3>Bạn là khách hàng mới?</h3>
					<p>
					Đăng nhập để tiếp tục thưởng thức những bữa ăn ngon của chúng tôi và quản lý đơn hàng của bạn một cách dễ dàng.
					</p>
					<button class="btn transparent" id="sign-in-btn">
						Đăng nhập
					</button>
				</div>
				<img src="images/form-pic2.png" class="image" alt="" style="margin-bottom: 400px" />
			</div>
		</div>
	</div>

	<script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
	<script>
		// Toggle password visibility for login form
const toggleLoginPassword = document.querySelector('#toggleLoginPassword');
const loginPassword = document.querySelector('#loginPassword');

toggleLoginPassword.addEventListener('click', function() {
    const type = loginPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    loginPassword.setAttribute('type', type);

    // Toggle between eye and eye-slash icons
    if (type === 'password') {
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
    }
});

// Toggle password visibility for register form
const toggleRegisterPassword = document.querySelector('#toggleRegisterPassword');
const registerPassword = document.querySelector('#registerPassword');

toggleRegisterPassword.addEventListener('click', function() {
    const type = registerPassword.getAttribute('type') === 'password' ? 'text' : 'password';
    registerPassword.setAttribute('type', type);

    // Toggle between eye and eye-slash icons
    if (type === 'password') {
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
    }
});

	</script>

	<script>
		const sign_in_btn = document.querySelector("#sign-in-btn");
		const sign_up_btn = document.querySelector("#sign-up-btn");
		const container = document.querySelector(".container");

		sign_up_btn.addEventListener("click", () => {
			container.classList.add("sign-up-mode");
		});

		sign_in_btn.addEventListener("click", () => {
			container.classList.remove("sign-up-mode");
		});
	</script>
	<script>
		function hideAlertBox() {
			const alertBox = document.getElementById('alertbox');
			alertBox.style.display = 'none';
		}
	</script>

</body>

</html>