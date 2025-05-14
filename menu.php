<?php
session_start();
include 'db_connection.php';

// Fetch all unique categories from the database
$categoryQuery = 'SELECT DISTINCT catName FROM menuitem';
$categoryResult = $conn->query($categoryQuery);

$categories = [];
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row['catName'];
}
function slugify($text) {
    // Check if $text is a valid string
    if (!is_string($text) || empty($text)) {
        return '';
    }

    // Ensure the input is valid UTF-8
    $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

    // Map Vietnamese characters to non-diacritic equivalents
    $vietnameseMap = [
        'à' => 'a', 'á' => 'a', 'ả' => 'a', 'ã' => 'a', 'ạ' => 'a',
        'ă' => 'a', 'ằ' => 'a', 'ắ' => 'a', 'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a',
        'â' => 'a', 'ầ' => 'a', 'ấ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a',
        'è' => 'e', 'é' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
        'ê' => 'e', 'ề' => 'e', 'ế' => 'e', 'ể' => 'e', 'ễ' => 'e', 'ệ' => 'e',
        'ì' => 'i', 'í' => 'i', 'ỉ' => 'i', 'ĩ' => 'i', 'ị' => 'i',
        'ò' => 'o', 'ó' => 'o', 'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o',
        'ô' => 'o', 'ồ' => 'o', 'ố' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o',
        'ơ' => 'o', 'ờ' => 'o', 'ớ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
        'ù' => 'u', 'ú' => 'u', 'ủ' => 'u', 'ũ' => 'u', 'ụ' => 'u',
        'ư' => 'u', 'ừ' => 'u', 'ứ' => 'u', 'ử' => 'u', 'ữ' => 'u', 'ự' => 'u',
        'ỳ' => 'y', 'ý' => 'y', 'ỷ' => 'y', 'ỹ' => 'y', 'ỵ' => 'y',
        'đ' => 'd',
        'À' => 'A', 'Á' => 'A', 'Ả' => 'A', 'Ã' => 'A', 'Ạ' => 'A',
        'Ă' => 'A', 'Ằ' => 'A', 'Ắ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A', 'Ặ' => 'A',
        'Â' => 'A', 'Ầ' => 'A', 'Ấ' => 'A', 'Ẩ' => 'A', 'Ẫ' => 'A', 'Ậ' => 'A',
        'È' => 'E', 'É' => 'E', 'Ẻ' => 'E', 'Ẽ' => 'E', 'Ẹ' => 'E',
        'Ê' => 'E', 'Ề' => 'E', 'Ế' => 'E', 'Ể' => 'E', 'Ễ' => 'E', 'Ệ' => 'E',
        'Ì' => 'I', 'Í' => 'I', 'Ỉ' => 'I', 'Ĩ' => 'I', 'Ị' => 'I',
        'Ò' => 'O', 'Ó' => 'O', 'Ỏ' => 'O', 'Õ' => 'O', 'Ọ' => 'O',
        'Ô' => 'O', 'Ồ' => 'O', 'Ố' => 'O', 'Ổ' => 'O', 'Ỗ' => 'O', 'Ộ' => 'O',
        'Ơ' => 'O', 'Ờ' => 'O', 'Ớ' => 'O', 'Ở' => 'O', 'Ỡ' => 'O', 'Ợ' => 'O',
        'Ù' => 'U', 'Ú' => 'U', 'Ủ' => 'U', 'Ũ' => 'U', 'Ụ' => 'U',
        'Ư' => 'U', 'Ừ' => 'U', 'Ứ' => 'U', 'Ử' => 'U', 'Ữ' => 'U', 'Ự' => 'U',
        'Ỳ' => 'Y', 'Ý' => 'Y', 'Ỷ' => 'Y', 'Ỹ' => 'Y', 'Ỵ' => 'Y',
        'Đ' => 'D',
    ];
    $text = strtr($text, $vietnameseMap);

    $text = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    if ($text === false) {
        $text = '';
    }

    $text = strtolower($text);

    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);

    $text = preg_replace('/[\s-]+/', '-', $text);

    $text = trim($text, '-');

    return $text;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--poppins-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="menu.css" />
    <title>Thực đơn</title>
    <style>
        .disabled-button {
            background-color: gray;
            color: white;
            cursor: not-allowed;
            pointer-events: none;
        }

        .disabled-button i {
            color: white;
        }

        section:nth-child(odd) {
            background-color: #ffe4c2;

            /* Set background color for odd sections */
        }

        section:nth-child(even) {
            background-color: #feead4;
            /* Set background color for even sections */
        }
    </style>
    
</head>

<body>
    <?php

    if (isset($_SESSION['userloggedin']) && $_SESSION['userloggedin']) {
        include 'nav-logged.php';
    } else {
        include 'navbar.php';
    }
    ?>
    <div class="heading">
        <div class="row heading-title">Thực đơn của chúng tôi</div>
        <div class="row heading-description">~Khám phá bữa tiệc hương vị với thực đơn hấp dẫn của chúng tôi!</div>
    </div>
    <?php foreach ($categories as $category): ?>
        <section id="<?= slugify($category) ?>">
      
            <div id="message"></div>
            <div class="container-fluid">
                <h1 class="mt-1"> <?= strtoupper($category) ?> </h1>
                <div class="row">
                    <?php
                    $stmt = $conn->prepare('SELECT * FROM menuitem WHERE catName = ?');
                    $stmt->bind_param('s', $category);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) :
                        $buttonClass = $row['status'] == 'Unavailable' ? 'disabled-button' : '';
                    ?>
                        <div class="col-md-6 col-lg-3 col-sm-12 menu-item col-xs-12">
                            <div class=" mt-4" style="background-color: #fdd9c9; border-radius: 5px;">
                                <img src="uploads/<?= $row['image'] ?>" alt="image" class="card-img-top" height="250">
                                <div class="card-body">
                                    <h4 class="card-title text-center mt-3"><?= $row['itemName'] ?></h4>
                                    <p class="card-title text-center description ps-3 pe-3 pt-2 pb-3"><?= $row['description'] ?></p>
                                    <?php if ($row['status'] == 'Unavailable') : ?>
                                        <p class="card-status" style="color: red; text-align: center; font-size: 1.3em;"><?php echo $row['status']; ?></p>
                                    <?php endif; ?>
                                    <div style="text-align: center;">
                                        <form action="" class="form-submit">
                                            <input type="hidden" class="pid" value='<?= $row['id'] ?>'>
                                            <input type="hidden" class="pname" value="<?= $row['itemName'] ?>">
                                            <input type="hidden" class="pprice" value="<?= $row['price'] ?>">
                                            <input type="hidden" class="pimage" value="<?= $row['image'] ?>">
                                            <input type="hidden" class="pcode" value="<?= $row['catName'] ?>">
                                            <div class="button-container mt-2">
                                                <div>
                                                    <p class="card-text text-center "><?= $row['price'] ?>&nbsp;đ</p>

                                                </div>
                                                <div>
                                                    <button class="addItemBtn <?= $buttonClass ?>" type="button">
                                                        <i class="fas fa-cart-plus"></i> &nbsp;&nbsp;Thêm vào giỏ
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
    <!-- Toast Notification Container -->
    <div id="toast" class="toast" style="background: rgba(255, 182, 182, 0.9); border: 1px solid rgba(255, 182, 182, 1); font-size: 16px;">
        <button class="toast-btn toast-close">&times;</button>
        <span class="pt-3"><strong>
                Bạn phải đăng nhập để thêm sản phẩm vào giỏ hàng.</strong></span><br>
        <button class="toast-btn toast-ok">Đồng ý</button>
    </div>
    <!--Footer-->
    <?php
    include_once('footer.html');
    ?>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script type="text/javascript">
        $(document).ready(function() {

            function userIsLoggedIn() {
                return <?php echo isset($_SESSION['userloggedin']) && $_SESSION['userloggedin'] === true ? 'true' : 'false'; ?>;
            }

            function showToast() {
                var toast = $('#toast');
                toast.addClass('show');

                setTimeout(function() {
                    toast.removeClass('show');
                }, 5000);
            }

            function getUserEmail() {
                return "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>";
            }

            $(".addItemBtn").click(function(e) {
                e.preventDefault(); // Prevent the default action

                if (!userIsLoggedIn()) {
                    showToast();
                    return;
                }

                // Check if the button has the 'disabled-button' class
                if ($(this).hasClass('disabled-button')) {
                    return; // Do nothing if the item is unavailable
                }

                var email = getUserEmail();

                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimage = $form.find(".pimage").val();
                var pcode = $form.find(".pcode").val();
                var pqty = 1;

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {
                        pid: pid,
                        pname: pname,
                        pprice: pprice,
                        pqty: pqty,
                        pimage: pimage,
                        pcode: pcode,
                        email: email
                    },
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0, 0);
                        load_cart_item_number();
                    }
                });
            });

            // Close button functionality
            $('.toast-close').click(function() {
                $('#toast').removeClass('show');
            });
            // Okay button redirection
            $('.toast-ok').click(function() {
                window.location.href = 'login.php';
            });

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

</body>

</html>