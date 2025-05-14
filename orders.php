<?php
session_start();
if (!isset($_SESSION['userloggedin'])) {
    header("Location: login.php");
    exit();
}
include 'db_connection.php'; // Đảm bảo bạn có tệp db_connection.php để kết nối với cơ sở dữ liệu của mình
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <title>Đơn hàng của tôi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding-top: 100px;
            background: #fef0e8;
        }

        .tabs {
            display: flex;
            cursor: pointer;
            justify-content: space-evenly;
            background-color: #faa79d;
            color: black;
            padding: 10px 0 15px 0;
        }

        .tab {
            padding: 10px 20px;
            border-bottom: 2px solid transparent;
            transition: all 0.3s;
            font-size: 1.2rem;
            position: relative; /* Để định vị số lượng */
        }

        .tab:hover {
            background-color: rgba(255, 99, 132, 0.4);
        }

        .tab.active {
            border-bottom: 2px solid rgba(255, 99, 132, 5);
        }

        .tab .order-count {
            position: absolute;
            top: 0;
            right: 0;
            background: #ff4d4d;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .tab-content {
            display: none;
            padding: 40px 60px;
            background-color: #fdd9c9;
            margin-bottom: 50px;
        }

        .tab-content.active {
            display: block;
        }

        .order {
            background-color: #fcbbb3;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(255, 99, 132, 0.2);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid rgba(255, 99, 132, 0.8);
            padding-bottom: 10px;
        }

        .order-header div {
            font-weight: bold;
        }

        .order-details {
            margin-bottom: 10px;
        }

        .order-items {
            border-top: 1px solid rgba(255, 99, 132, 0.8);
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 99, 132, 0.8);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }

        .cancel-btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container-div {
            width: 85%;
        }

        .customer-details {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
        }

        .customer-details strong,
        .order-items strong {
            font-weight: 600;
        }

        .order-items strong {
            padding-right: 5px;
        }

        /* CSS cho các trạng thái đơn hàng */
        .status-dang-cho .status-text { /* Đang chờ */
            color: #fb4a36; /* Orange */
        }

        .status-dang-xu-ly .status-text { /* Đang xử lý */
            color: #f39c12; /* Yellow */
        }

        .status-dang-tren-duong .status-text { /* Đang trên đường */
            color: #3498db; /* Blue */
        }

        .status-da-hoan-thanh .status-text { /* Đã hoàn thành */
            color: #27ae60; /* Green */
        }

        .status-da-huy .status-text { /* Đã hủy */
            color: #e74c3c; /* Red */
        }

        /* Modal Background */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
            position: relative;
        }

        /* Close Button */
        .modal-close {
            position: absolute;
            color: red;
            font-size: 30px;
            font-weight: bold;
            top: 0px;
            right: 10px;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: orangered;
            text-decoration: none;
            cursor: pointer;
        }

        /* Cancel Reason Textarea */
        textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 20px !important;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #ccc;
            box-sizing: border-box;
        }

        /* Cancel Order Button */
        button {
            background-color: #f44336;
            /* Red */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px !important;
            cursor: pointer;
        }

        button:hover {
            background-color: #c62828;
            /* Darker Red */
        }

        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 2rem;
            unicode-bidi: bidi-override;
        }

        .review-btn {
            background: #27ae60 !important;
            transition: background 0.3s ease;
        }

        .review-btn:hover {
            background: green !important;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            color: #ccc;
            /* Gray color for unselected stars */
            cursor: pointer;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffcc00;
            /* Yellow color for hovered stars */
        }

        .star-rating input[type="radio"]:checked~label {
            color: #ffcc00;
            /* Yellow color for selected stars */
        }

        .review-section strong {
            font-weight: 600;
            font-size: 1.1rem;
            text-align: left;
        }

        .review-section span {
            font-size: 1.1rem;
        }

        .review {
            display: flex;
            justify-content: space-between;
        }

        @media screen and (max-width: 900px) {
            .tabs {
                display: none;
            }

            .tab-content {
                display: none;
                padding: 0px;
                background-color: transparent !important; 
                background: transparent !important; 
                margin-bottom: 50px;
            }

            .customer-details {
                display: flex;
                justify-content: flex-start !important;
                gap: 20px;
                font-size: 1rem;
            }

            .order-header {
                font-size: 1rem !important;
            }

            .review {
                display: flex;
                justify-content: flex-start !important;
                gap: 20px;
                font-size: 1rem;
            }
        }

        #reviewModal .review-btn {
            margin-top: 0px !important;
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    include_once("nav-logged.php");
    ?>
    <div class="main-container">
        <div class="container-div">
            <div class="tabs">
                <div class="tab active" data-status="All">Tất cả<span class="order-count" id="count-all"></span></div>
                <div class="tab" data-status="Đang chờ">Đang chờ<span class="order-count" id="count-dang-cho"></span></div>
                <div class="tab" data-status="Đang xử lý">Đang xử lý<span class="order-count" id="count-dang-xu-ly"></span></div>
                <div class="tab" data-status="Đang trên đường">Đang trên đường<span class="order-count" id="count-dang-tren-duong"></span></div>
                <div class="tab" data-status="Đã hoàn thành">Đã hoàn thành<span class="order-count" id="count-da-hoan-thanh"></span></div>
                <div class="tab" data-status="Đã hủy">Đã hủy<span class="order-count" id="count-da-huy"></span></div>
            </div>
            <div id="orders">
                <div class="tab-content active" id="all-orders"></div>
                <div class="tab-content" id="dang-cho-orders"></div>
                <div class="tab-content" id="dang-xu-ly-orders"></div>
                <div class="tab-content" id="dang-tren-duong-orders"></div>
                <div class="tab-content" id="da-hoan-thanh-orders"></div>
                <div class="tab-content" id="da-huy-orders"></div>
            </div>
        </div>
    </div>

    <div id="cancelModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeCancelModal()">&times;</span>
            <h2>Hủy đơn hàng</h2>
            <textarea id="cancelReason" placeholder="Nhập lý do hủy đơn..."></textarea>
            <button id="cancelOrderBtn">Xác nhận hủy</button>
        </div>
    </div>

    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeReviewModal()">&times;</span>
            <h2>Gửi đánh giá của bạn</h2>
            <form id="reviewForm" action="submit_reviews.php" method="POST">
                <input type="hidden" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>"> 
                <input type="hidden" id="reviewOrderId" name="orderId">
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label for="star5" title="5 sao">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4" title="4 sao">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3" title="3 sao">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2" title="2 sao">&#9733;</label>
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1" title="1 sao">&#9733;</label>
                </div>
                <br>
                <label for="reviewText">Đánh giá:</label>
                <textarea id="reviewText" name="reviewText" rows="4" cols="50"></textarea>
                <br>
                <button type="submit" id="submitReviewBtn" class="review-btn">Gửi đánh giá</button>
            </form>
        </div>
    </div>
   
    <?php
    include_once ('footer.html');
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
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
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating input[type="radio"]');

            stars.forEach(star => {
                star.addEventListener('change', function() {
                    const rating = this.value;
                });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelector('.tab.active').classList.remove('active');
                this.classList.add('active');

                const status = this.getAttribute('data-status');
                document.querySelector('.tab-content.active').classList.remove('active');
                
                let statusId = status.toLowerCase().replace(/ /g, '-');
                statusId = removeVietnameseTones(statusId); // Loại bỏ dấu cho ID
                document.getElementById(`${statusId}-orders`).classList.add('active');
                fetchOrders(status);
            });
        });
        
        function removeVietnameseTones(str) {
            str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
            str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
            str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
            str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
            str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
            str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
            str = str.replace(/đ/g, "d");
            str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầusia|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
            str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
            str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
            str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
            str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
            str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
            str = str.replace(/Đ/g, "D");
            return str;
        }

        function fetchOrders(status) {
            fetch(`fetch_orders.php?status=${encodeURIComponent(status)}`) 
                .then(response => response.json())
                .then(data => {
                    // Cập nhật số lượng đơn hàng cho các tab
                    if (data.statusCounts) {
                        document.getElementById('count-all').textContent = data.statusCounts['All'] || 0;
                        document.getElementById('count-dang-cho').textContent = data.statusCounts['Đang chờ'] || 0;
                        document.getElementById('count-dang-xu-ly').textContent = data.statusCounts['Đang xử lý'] || 0;
                        document.getElementById('count-dang-tren-duong').textContent = data.statusCounts['Đang trên đường'] || 0;
                        document.getElementById('count-da-hoan-thanh').textContent = data.statusCounts['Đã hoàn thành'] || 0;
                        document.getElementById('count-da-huy').textContent = data.statusCounts['Đã hủy'] || 0;
                    }

                    data.orders.sort((a, b) => new Date(b.order_date) - new Date(a.order_date)); 

                    let statusId = status.toLowerCase().replace(/ /g, '-');
                    statusId = removeVietnameseTones(statusId); // Loại bỏ dấu cho ID
                    const ordersContainer = document.getElementById(`${statusId}-orders`);
                    
                    if (!ordersContainer) {
                        console.error(`Không tìm thấy container cho trạng thái: ${statusId}-orders`);
                        return;
                    }

                    ordersContainer.innerHTML = data.orders.map(order => `
                        <div class="order container" style="padding: 20px 30px;">
                            <div class="order-header" style="font-size: 1.3rem;">
                                <div>Mã đơn: #${order.order_id}</div>
                                <div class="status ${getStatusClass(order.order_status)}">Trạng thái: <span class="status-text">${order.order_status}</span></div>
                            </div>
                            <div class="order-details">
                                <div class="customer-details">
                                    <div><p><strong>Tên: </strong></p></div>
                                    <div><p>${order.firstName} ${order.lastName}</p></div>
                                </div>
                                <div class="customer-details">
                                    <div><p><strong>Địa chỉ: </strong></p></div>
                                    <div><p>${order.address}</p></div>
                                </div>
                                <div class="customer-details">
                                    <div><p><strong>Liên hệ: </strong></p></div>
                                    <div><p>${order.phone}</p></div>
                                </div>
                                <div class="customer-details">
                                    <div><p><strong>Thanh toán: </strong></p></div>
                                    <div><p>${order.pmode}</p></div>
                                </div>
                                <div class="customer-details">
                                    <div><p><strong>Ngày đặt: </strong></p></div>
                                    <div><p>${new Date(order.order_date).toLocaleString('vi-VN')}</p></div>
                                </div>
                                <div class="customer-details">
                                    <div><p><strong>Ghi chú: </strong></p></div>
                                    <div><p>${order.note || 'Không có'}</p></div>
                                </div>
                            </div>
                            <div class="order-items" style="font-size: 1.1rem;">
                                ${order.items.map(item => `
                                    <div class="order-item">
                                        <div>${item.itemName} (x${item.quantity})</div>
                                        <div>${item.total_price}</div>
                                    </div>
                                `).join('')}
                                 <div class="order-total">Tổng cộng: ${order.grand_total}</div>
                        ${order.order_status === 'Đã hủy' ? `
                        <div class="review mt-3">
                        <div><p><strong>Lý do hủy: </strong></div>
                        <div><p>${order.cancel_reason || 'Không có'}</p></div>
                        </div>` : ''}
                    </div>
                   ${order.order_status !== 'Đã hoàn thành' && order.order_status !== 'Đã hủy' ? `<button class="cancel-btn" onclick="openCancelModal(${order.order_id})">Hủy đơn hàng</button>` : ''}
                    ${(order.order_status === 'Đã hoàn thành' || order.order_status === 'Đã hủy') && !order.review_text ? `
                        <button class="review-btn" onclick="openReviewModal(${order.order_id})">Viết đánh giá</button>
                    ` : ''}
                    ${(order.order_status === 'Đã hoàn thành' || order.order_status === 'Đã hủy') && order.review_text ? `
                        <div class="review-section">
                         <div class=" review">
                            <div><p><strong>Đánh giá của bạn: </strong></p></div>
                            <div><p><span>${order.review_text}</span></p></div>
                         </div>
                            ${order.response ? `
                            <div class=" review">
                              <div><p><strong>Phản hồi: </strong></p></div>
                              <div><p><span>${order.response}</span></p></div>
                            </div>` : ''}
                        </div>
                    ` : ''}
                </div>
            `).join('');
            
                })
                .catch(error => console.error('Lỗi khi tải đơn hàng:', error));
        }

        function getStatusClass(status) {
            let className = removeVietnameseTones(status.toLowerCase().replace(/ /g, '-'));
            return `status-${className}`;
        }

        fetchOrders('All');

        var cancelModal = document.getElementById("cancelModal");
        var reviewModal = document.getElementById("reviewModal");

        function openCancelModal(orderId) {
            cancelModal.setAttribute("data-order-id", orderId);
            cancelModal.style.display = "block";
        }
        function closeCancelModal() {
            cancelModal.style.display = "none";
        }
        
        function openReviewModal(orderId) {
            document.getElementById("reviewOrderId").value = orderId;
            reviewModal.style.display = "block";
        }
        function closeReviewModal() {
            reviewModal.style.display = "none";
        }

        document.getElementById("cancelOrderBtn").onclick = function() {
            var cancelReason = document.getElementById("cancelReason").value;
            var orderId = cancelModal.getAttribute("data-order-id");

            if (cancelReason.trim() === "") {
                alert("Vui lòng nhập lý do hủy đơn.");
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cancel_order.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("Đơn hàng đã được hủy.");
                    closeCancelModal();
                    fetchOrders(document.querySelector('.tab.active').getAttribute('data-status')); 
                } else {
                    alert("Không thể hủy đơn hàng. Vui lòng thử lại.");
                }
            };
            xhr.onerror = function() {
                console.error("Yêu cầu thất bại.");
                alert("Đã xảy ra lỗi. Vui lòng thử lại.");
            };
            xhr.send("orderId=" + encodeURIComponent(orderId) + "&reason=" + encodeURIComponent(cancelReason));
        };
        
        window.onclick = function(event) {
            if (event.target == cancelModal) {
                closeCancelModal();
            }
            if (event.target == reviewModal) {
                closeReviewModal();
            }
        };
    </script>
</body>
</html>