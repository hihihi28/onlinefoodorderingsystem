<?php
session_start();

include 'db_connection.php';

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// lấy các mục phổ biến
$sql = "SELECT itemName, image, price FROM menuitem WHERE is_popular = 1";

// Kiểm tra xem truy vấn có thành công không
if ($result = $conn->query($sql)) {
  $popularItems = [];

  // Lấy và lưu trữ kết quả truy vấn
  while ($row = $result->fetch_assoc()) {
    $popularItems[] = $row;
  }

  $result->close();
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Bootstrap CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!--poppins-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!--Icon-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
  <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Chewy Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Chewy&display=swap" rel="stylesheet">
  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <title>Trang chủ</title>

</head>

<body>
  <?php
  if (isset($_SESSION['userloggedin']) && $_SESSION['userloggedin']) {
    include 'nav-logged.php';
  } else {
    include 'navbar.php';
  }
  ?>

  <div class="main">
    <section>
      <div class="container mt-3">
        <div class="row d-flex justify-content-start align-items-start main-container">
          <div class="col-md-5 col-sm-12 col-lg-5 reveal main-text mb-4 text-align-justify mt-5" data-aos="fade-up">
            <h2>Chào mừng đến với <span style="color: #fb4a36;"> Steakout ,</span></h2>
            <h4 style="color: gray; font-weight: 450;">"Nơi hương vị cay nồng hòa quyện cùng sự thoải mái mát lạnh."</h4>
            <p style="font-size: 18px; text-align: justify;">
              Hãy đắm mình trong một hành trình ẩm thực tràn đầy hương vị. Tại Steakout , chúng tôi tin rằng mỗi
              bữa ăn đều xứng đáng là một trải nghiệm khó quên. Dù bạn đến để thưởng thức bữa ăn thân mật hay kỷ niệm một
              dịp đặc biệt, những món ăn đầy màu sắc và tinh tế của chúng tôi sẽ để lại dấu ấn khó phai.
            </p>
            <div class="buttondiv">
              <div>
                <a href="login.php">
                  <button class="button">
                    Bắt đầu đặt hàng
                  
                    <svg class="cartIcon" viewBox="0 0 576 512">
                      <path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"></path>
                    </svg>
                  </button>
                </a>
              </div>
              <div>
                <a class="button1" href="menu.php">
                  <span class="button__icon-wrapper">
                    <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                      <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                    </svg>
                    <svg class="button__icon-svg button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                      <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                    </svg>
                  </span>
                  Khám phá thực đơn
                </a>
              </div>
            </div>
          </div>
          <div class="col-md-7 col-sm-12 col-lg-7 d-flex justify-content-center align-items-start slide-in-right main-image">
            <img src="images/index-bittet.jpg" class="img" style=" width: 85%; height: 80%;margin-top:auto">
          </div>
        </div>
        <div class="row mt-1">
          <!--Phần thực đơn -->
          <section>
            <div class="menu-section">
              <div class="container-fluid">
                <div class="row">
                  <div class="row d-flex justify-content-center align-items-center mb-4 font-weight-bold" id="text">
                    <h1>Thực đơn của chúng tôi</h1>
                  </div>
                  <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" style="background-image: url('images/appe-index.avif');" data-aos="fade-up">
                      <div class="card-overlay">
                        <div class="overlay-content">
                          <h3>Món khai vị</h3>
                          <p>Bắt đầu bữa ăn của bạn với món khai vị hấp dẫn của chúng tôi để tạo nên trải nghiệm ẩm thực thú vị.</p>
                          <a href="menu.php#mon-khai-vi">
                            <button class="explore-btn">Khám phá sự đa dạng</button></a>
                        </div>
                      </div>
                      <div class="card-bottom">
                        <h3>Món khai vị</h3>
                        <a href="menu.php#mon-khai-vi">
                          <button class="explore-btn">Khám phá sự đa dạng</button></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" style="background-image: url('images/index-pizza.jpg');" data-aos="fade-up">
                      <div class="card-overlay">
                        <div class="overlay-content">
                          <h3>Món chính</h3>
                          <p>Khám phá thực đơn món Âu hấp dẫn với nhiều loại món ăn đặc sắc</p>
                          <a href="menu.php#mon-chinh">
                            <button class="explore-btn">Khám phá sự đa dạng</button></a>
                        </div>
                      </div>
                      <div class="card-bottom">
                        <h3>Món chính</h3>
                        <a href="menu.php#mon-chinh">
                          <button class="explore-btn">Khám phá sự đa dạng</button></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" style="background-image: url('images/index-banhtao.jpg');" data-aos="fade-up">
                      <div class="card-overlay">
                        <div class="overlay-content">
                          <h3>Món tráng miệng</h3>
                          <p>Khép lại bữa ăn ngọt ngào với các món tráng miệng tinh tế, từ bánh ngọt mềm mịn đến các món kem mát lạnh.</p>
                          <a href="menu.php#mon-trang-mieng">
                            <button class="explore-btn">Khám phá sự đa dạng</button></a>
                        </div>
                      </div>
                      <div class="card-bottom">
                        <h3>Món tráng miệng</h3>
                        <a href="menu.php#mon-trang-mieng">
                          <button class="explore-btn">Khám phá sự đa dạng</button></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card" style="background-image: url('images/bev-index.jpeg');" data-aos="fade-up">
                      <div class="card-overlay">
                        <div class="overlay-content">
                          <h3>Đồ uống</h3>
                          <p>Giải cơn khát của bạn với nhiều loại đồ uống giải khát, phù hợp cho mọi bữa ăn.</p>
                          <a href="menu.php#do-uong">
                            <button class="explore-btn">Khám phá sự đa dạng</button></a>
                        </div>
                      </div>
                      <div class="card-bottom">
                        <h3>Đồ uống</h3>
                        <a href="menu.php#do-uong">
                          <button class="explore-btn">Khám phá sự đa dạng</button></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </section>
  </div>

  <!-- Tại sao chọn chúng tôi  -->
  <section class="why-choose-us" id="why-choose-us">
    <div class="container">
      <div class="row why-us-content">
        <div class="col-md-12 col-lg-6 col-sm-12 col-xs-12 mt-5 reveal d-flex justify-content-start align-items-start" data-aos="fade-up">
          <img src="images/Why-Us.png" width="100%" height="auto" loading="lazy" alt="delivery boy" class="w-100 delivery-img" data-delivery-boy>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex flex-column justify-content-center reveal" data-aos="fade-up">
          <h1>Tại sao chọn chúng tôi</h1>
          <p class="content">Nhà hàng của chúng tôi cung cấp dịch vụ giao đồ ăn tốt nhất với nguyên liệu tươi ngon và chất lượng cao.</p>
          <ul class="why-choose-us-list">
            <li data-aos="fade-up">
              <div class="image-wrapper mt-1">
                <img src="icons/delivery-man.png" alt="Fast Delivery">
              </div>
              <div class="feature-content">
                <h4>Giao hàng nhanh</h4>
                <p>Tận hưởng dịch vụ giao hàng nhanh chóng và đáng tin cậy tận nhà.</p>
              </div>
            </li>
            <li data-aos="fade-up">
              <div class="image-wrapper">
                <img src="icons/vegetables.png" alt="Fresh Ingredients">
              </div>
              <div class="feature-content">
                <h4>Nguyên liệu tươi</h4>
                <p>Chúng tôi chỉ sử dụng những nguyên liệu tươi ngon nhất và chất lượng cao nhất.</p>
              </div>
            </li>
            <li data-aos="fade-up">
              <div class="image-wrapper">
                <img src="icons/waiter (1).png" alt="Friendly Service" class="why-us-image">
              </div>
              <div class="feature-content">
                <h4>Dịch vụ thân thiện</h4>
                <p>Trải nghiệm dịch vụ chăm sóc khách hàng nồng nhiệt và thân thiện.</p>
              </div>
            </li>
            <li data-aos="fade-up">
              <div class="image-wrapper">
                <img src="icons/tasty.png" alt="Exceptional Taste">
              </div>
              <div class="feature-content">
                <h4>Hương vị đặc biệt</h4>
                <p>Hãy thưởng thức hương vị thực sự đặc biệt.</p>
              </div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Phần lựa chọn hàng đầu -->
      <div class="popular reveal" data-aos="fade-up" style="background-color:bisque; background-size: cover; background-position: center;background-repeat: no-repeat;width: 100%;">
        <h1 class="text-center mt-4">Lựa chọn hàng đầu của chúng tôi</h1>

        <div id="cardCarousel" class="carousel slide mt-5" data-bs-ride="carousel" data-bs-interval="8000" data-aos="fade-up">
          <div class="carousel-inner">

            <div id="toast" class="toast">
              <button class="toast-btn toast-close">&times;</button>
              <span class="pt-3"><strong>Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng.</strong></span>
              <button class="toast-btn toast-ok">Đồng ý</button>
            </div>

            <?php
            $chunkedItems = array_chunk($popularItems, 3); // Nhóm 3 sản phẩm 1 slide
            $isActive = true;

            foreach ($chunkedItems as $items) {
              echo '<div class="carousel-item' . ($isActive ? ' active' : '') . '">';
              echo '<div class="d-flex justify-content-center align-items-stretch">'; // align-items-stretch giữ chiều cao bằng nhau

              foreach ($items as $item) {
                echo '<div class="card popular-card">';
                echo '<img src="uploads/' . $item['image'] . '" class="card-img-top" alt="' . $item['itemName'] . '">';
                echo '<div class="card-body d-flex flex-column justify-content-between">';
                echo '<h5 class="card-title text-center">' . $item['itemName'] . '</h5>';
                echo '<p class="card-text text-center">' . $item['price'] . ' đ</p>';
                echo '<a class="button-cart mt-auto text-center" onclick="addToCart()">Thêm vào giỏ hàng</a>';
                echo '</div>';
                echo '</div>';
              }

              echo '</div>';
              echo '</div>';
              $isActive = false;
            }
            ?>
          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Trước</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sau</span>
          </button>
        </div>
      </div>


      <!-- Phần về chúng tôi -->
      <div class="aboutus" id="About-Us" style="background-color: white; background-size: cover; background-position: center; background-repeat: no-repeat;">
        <section class="our-story-section p-5">
          <div class="container ">
            <div class="row" data-aos="fade-up">
              <h1 style="text-align: center;"><span style="color: #fb4a36;">Về </span>chúng tôi</h1>
              <h4 style="text-align: center;" class="mb-5">
                Tạo nên những bữa ăn đáng nhớ!</h4>
            </div>
            <div class="story-content row mb-2">
              <div class="story-text col-lg-6 col-md-6 col-sm-12 reveal mt-2" data-aos="fade-up" data-os-interval="300">
                <p>Tại <strong>Steakout </strong>, chúng tôi đam mê tôn vinh ẩm thực. Các đầu bếp của chúng tôi mang đến một chút sáng tạo cho mỗi món ăn, đảm bảo một bữa tiệc cho các giác quan của bạn. Hãy tham gia cùng chúng tôi để có một trải nghiệm ẩm thực phi thường tôn vinh hương vị và niềm vui.</p>
                <p>Được thành lập vào năm [2020], Steakout  luôn đi đầu trong đổi mới ẩm thực. Cam kết sử dụng những nguyên liệu tươi ngon nhất, kết hợp với chuyên môn của đầu bếp, đã mang lại cho chúng tôi danh tiếng về sự xuất sắc. Chúng tôi tin rằng ăn uống không chỉ là ăn; mà là trải nghiệm nghệ thuật ẩm thực.</p>
                <p>Cho dù bạn đang tìm kiếm một bữa tối lãng mạn, một buổi họp mặt gia đình hay một nơi để kỷ niệm những dịp đặc biệt, Steakout  cung cấp bầu không khí hoàn hảo và ẩm thực tinh tế để chuyến thăm của bạn trở nên khó quên. Hãy đến và trải nghiệm niềm vui hương vị cùng chúng tôi!</p>
                <a href="menu.php" class="about_btn">
                  <i class="fa-solid fa-burger"></i>Đặt hàng ngay
                </a>
              </div>
              <div class="story-image col-lg-6 col-md-6 col-sm-12 d-flex justify-content-end align-items-start slide-in-right" data-aos="fade-up" style="margin-top: 70px;">
                <img src="images/index-abouus.jpg" alt="Crafting Memorable Meals" style="width: 100%; height: auto;">
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Đặt bàn -->
      <section class="table-reservation" id="Reservation" style="background-color:bisque;">
        <div class="row text-center ms-4" data-aos="fade-up">
          <h1 class="mb-2">Đặt bàn</h1>
          <h5 class="mb-5">Hãy đặt bàn ăn với chúng tôi và thưởng thức bữa ăn tuyệt vời.</h5>
        </div>
        <div class="table ms-4 me-5" data-aos="fade-up">
          <div class="reservation row reveal">
            <div class="reservation-image col-lg-7 col-md-6 col-sm-12" style="background: none !important; padding: 0 !important;">
              <img src="images/table.jpg" alt="Reservation" style="background: none ; width: 100%; height: 100%; padding: 0 !important; margin-top: 2px;" class=" w-100 h-100">
            </div>
            <div class="reservation-section col-lg-5 col-md-6 col-sm-12">
              <h2 style="background-color: #feead4;">Đặt ngay!</h2>
              <form id="reservation-form" action="reservations.php" method="POST">
                <div class="form-row">
                  <div class="form-group">
                    <label for="name">Tên:</label>
                    <input type="text" id="name" name="name" required>
                  </div>
                  <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label for="phone">Liên hệ:</label>
                    <input type="tel" id="phone" name="contact" required>
                  </div>
                  <div class="form-group">
                    <label for="date">Ngày:</label>
                    <input type="date" id="date" name="reservedDate" required>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group">
                    <label for="reservedTime">Thời gian:</label>
                    <input type="time" id="time" name="reservedTime" required>
                  </div>
                  <div class="form-group">
                    <label for="guests">Số người:</label>
                    <input type="number" id="guests" name="noOfGuests" required min="1">
                  </div>
                </div>
                <button type="submit" value="submit">Đặt ngay</button>
              </form>
            </div>
          </div>
        </div>
      </section>

      <!-- đánh giá  -->
      <section class="testimonial" id="review" style="background-color: #f9f9f9;">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
              <div class="text-center mb-5" data-aos="fade-up">
                <h1>Ý kiến ​​từ khách hàng của chúng tôi</h1>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="clients-carousel owl-carousel" data-aos="fade-up">
              <div class="single-box">
                <div class="img-area"><img alt="" class="img-fluid" src="uploads/user-girl.png"></div>
                <div class="content">
                  <p>"Thức ăn tươi ngon và hương vị tuyệt vời. Tôi thích sự đa dạng trong thực đơn. Một nơi tuyệt vời cho bữa tối gia đình."</p>
                  <h4>-Hang Le</h4>
                </div>
              </div>
              <div class="single-box">
                <div class="img-area"><img alt="" class="img-fluid" src="uploads/user-boy.jpg"></div>
                <div class="content">
                  <p>"Quá trình đặt hàng trực tuyến diễn ra liền mạch và dễ dàng điều hướng. Đồ ăn của tôi được giao nóng và đúng giờ. Dịch vụ giao hàng rất chuyên nghiệp."</p>
                  <h4>-Duong Nguyen</h4>
                </div>
              </div>
              <div class="single-box">
                <div class="img-area"><img alt="" class="img-fluid" src="uploads/default.jpg"></div>
                <div class="content">
                  <p>"Địa điểm tuyệt vời! Các loại burger rất ngon, và pizza thì đầy ắp topping. Nhân viên siêu thân thiện, và dịch vụ nhanh chóng. Một địa điểm yêu thích mới!"</p>
                  <h4>-Anh Tran</h4>
                </div>
              </div>
              <div class="single-box">
                <div class="img-area"><img alt="" class="img-fluid" src="uploads/default.jpg"></div>
                <div class="content">
                  <span class="rating-star"><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i><i class="icofont-star"></i></span>
                  <p>"Hệ thống đặt hàng trực tuyến thật tuyệt vời. Tôi có thể dễ dàng tùy chỉnh đơn hàng của mình và việc giao hàng luôn nhanh chóng. Đồ ăn luôn nóng hổi và ngon miệng."</p>
                  <h4>-Khanh Vy</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.3231932626995!2d105.78426377502998!3d20.979677980657364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135accdee9d8287%3A0xc8ca28991fac5a21!2zOTYgxJAuIFRy4bqnbiBQaMO6LCBQLiBN4buZIExhbywgSMOgIMSQw7RuZywgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1744606914000!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      <!-- footer -->
      <footer>
        <div class="footer-container">
          <div class="footer-row">
            <div class="footer-col" id="contact">
              <h4>Liên hệ chúng tôi</h4>
              <p>96 Tran Phu Ha Dong</p>
              <p>Email: hienk54t1@gmail.com</p>
              <p>Phone: +84 77 123 4567</p>
            </div>
            <div class="footer-col">
              <h4>Theo dõi chúng tôi</h4>
              <div class="social-icons">
                <a href="https://www.facebook.com/steakoutbd"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
              </div>
            </div>
            <div class="footer-col">
              <h4>Đặt mua</h4>
              <form action="#">
                <input type="email" placeholder="Email của bạn là" required style="background-color: #f9f9f9; color: #333; margin-top: 12px;">
                <button type="submit">Đặt mua</button>
              </form>
            </div>
          </div>
          <div class="footer-bottom">
            <h4>&copy; 2025 By Hien Nguyen. All Rights Reserved.</h4>
          </div>
        </div>
      </footer>
      <button id="backToTop" class="back-to-top" title="Lên đầu trang">
        <i class="fas fa-arrow-up"></i>
      </button>

      <!-- Existing scripts -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <!-- Other scripts -->

      <!-- New Back to Top Script -->
      <script>
        // Back to Top Button Functionality
        document.addEventListener('DOMContentLoaded', () => {
          const backToTopButton = document.getElementById('backToTop');
          window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
              backToTopButton.classList.add('show');
            } else {
              backToTopButton.classList.remove('show');
            }
          });
          backToTopButton.addEventListener('click', () => {
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });
          });
        });
      </script>

      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js">
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js">
      </script>
      <!-- AOS -->
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
      <script>
        AOS.init();
      </script>
      <script>
        $(document).ready(function() {
          console.log('Page is ready. Calling load_cart_item_number.');
          load_cart_item_number();

          function load_cart_item_number() {
            $.ajax({
              url: 'action.php',
              method: 'get',
              data: {
                cartItem: "cart_item"
              },
              success: function(response) {
                $("#cart-item").html(response);
              }
            });
          }
        });
      </script>
      <script>
        $('.clients-carousel').owlCarousel({
          loop: true,
          nav: false,
          autoplay: true,
          autoplayTimeout: 5000,
          animateOut: 'fadeOut',
          animateIn: 'fadeIn',
          smartSpeed: 450,
          margin: 30,
          responsive: {
            0: {
              items: 1
            },
            768: {
              items: 2
            },
            991: {
              items: 2
            },
            1200: {
              items: 2
            },
            1920: {
              items: 2
            }
          }
        });
      </script>
      <script>
        function addToCart() {
          var userLoggedIn = <?php echo isset($_SESSION['userloggedin']) ? 'true' : 'false'; ?>;

          if (!userLoggedIn) {
            showToast();
          } else {
            // Add to cart logic goes here
          }
        }

        function showToast() {
          var toast = document.getElementById("toast");
          toast.className = "toast show";

          // Handle "Okay" button click
          document.querySelector('.toast-ok').onclick = function() {
            window.location.href = 'login.php'; // Redirect to login page
          };

          // Handle "Close (X)" button click
          document.querySelector('.toast-close').onclick = function() {
            toast.className = toast.className.replace("show", "hide");
          };
        }
      </script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <!-- Bootstrap JS and dependencies -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
      <script>
        document.addEventListener("DOMContentLoaded", () => {
          const elements = document.querySelectorAll('.animate-on-scroll');
          const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                entry.target.classList.add('reveal');
              }
            });
          }, {
            threshold: 0.1
          });

          elements.forEach(element => {
            observer.observe(element);
          });
        });
      </script>


</body>

</html>