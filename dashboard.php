<?php
session_start();
if (!isset($_SESSION['userloggedin'])) {
    header("Location: login.php");
    exit();
}
include 'db_connection.php';

// Lấy thống kê đơn hàng
$user_id = $_SESSION['user_id'];
$stats = array();

// Tổng số đơn hàng
$sql = "SELECT COUNT(*) as total FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['total_orders'] = $result->fetch_assoc()['total'];

// Đơn hàng đang xử lý
$sql = "SELECT COUNT(*) as processing FROM orders WHERE user_id = ? AND status = 'processing'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['processing_orders'] = $result->fetch_assoc()['processing'];

// Đơn hàng đang giao
$sql = "SELECT COUNT(*) as delivering FROM orders WHERE user_id = ? AND status = 'on_the_way'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['delivering_orders'] = $result->fetch_assoc()['delivering'];

// Tổng chi tiêu
$sql = "SELECT SUM(total_amount) as total_spent FROM orders WHERE user_id = ? AND status != 'cancelled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stats['total_spent'] = $result->fetch_assoc()['total_spent'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fef0e8;
            padding-top: 80px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #faa79d;
        }
        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            color: #666;
            font-size: 1.1rem;
        }
        .recent-orders {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        .loading i {
            font-size: 2rem;
            color: #faa79d;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="dashboard-container">
        <h2 class="mb-4">Dashboard</h2>
        
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['total_orders']; ?></div>
                    <div class="stat-label">Tổng đơn hàng</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['processing_orders']; ?></div>
                    <div class="stat-label">Đang xử lý</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-value"><?php echo $stats['delivering_orders']; ?></div>
                    <div class="stat-label">Đang giao</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-value"><?php echo number_format($stats['total_spent']); ?>đ</div>
                    <div class="stat-label">Tổng chi tiêu</div>
                </div>
            </div>
        </div>

        <div class="recent-orders">
            <h3 class="mb-4">Đơn hàng gần đây</h3>
            <div class="loading">
                <i class="fas fa-spinner"></i>
            </div>
            <div id="recent-orders-list"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hiển thị loading
            $('.loading').show();
            
            // Load đơn hàng gần đây
            $.ajax({
                url: 'fetch_orders.php',
                method: 'GET',
                success: function(response) {
                    $('.loading').hide();
                    $('#recent-orders-list').html(response);
                },
                error: function() {
                    $('.loading').hide();
                    $('#recent-orders-list').html('<div class="alert alert-danger">Không thể tải đơn hàng</div>');
                }
            });
        });
    </script>
</body>
</html> 