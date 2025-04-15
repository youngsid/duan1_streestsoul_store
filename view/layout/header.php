<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    $totalCartItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>StreetSoul Store</title>
    <link rel="stylesheet" href="/streestsoul_store1/public/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-dropdown {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            top: 100%;
            right: 0;
            width: 160px;
            z-index: 1000;
        }
        .user-menu:hover .user-dropdown {
            display: block;
        }
        .user-dropdown a {
            display: block;
            padding: 10px;
            color: black;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
        }
        .user-dropdown a:last-child {
            border-bottom: none;
        }
        .user-dropdown a:hover {
            background: #f8f9fa;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="nav-container">

            <!-- Logo -->
            <div class="logo">
                <a href="/streestsoul_store1/index.php">
                    <img src="/streestsoul_store1/public/images/logoweb.jpg" alt="Logo" class="logo-img">
                </a>
            </div>

            <!-- Menu trái -->
            <div class="nav-left">
                <a href="/streestsoul_store1/index.php">Trang chủ</a>
                <a href="/streestsoul_store1/view/client/products.php">Sản phẩm</a>
                <a href="/streestsoul_store1/view/client/orderUser.php">Đơn hàng</a>
            </div>

            <!-- Menu phải -->
            <div class="nav-right">
                <a href="/streestsoul_store1/view/client/cart.php" class="cart-icon">
                    <i class="fa fa-shopping-cart"></i>
                    <span id="cart-count"><?php echo $totalCartItems; ?></span>
                </a>

                <?php if (isset($_SESSION['user'])): ?>
                    <div class="user-menu">
                        <span class="user-name">Xin chào, <?= htmlspecialchars($_SESSION['user']['hoten']) ?></span>
                        <div class="user-dropdown">
                            <?php if ($_SESSION['user']['vaitro'] === 1): ?>
                                <a href="/streestsoul_store1/view/admin/dashboard.php">Quản trị</a>
                            <?php endif; ?>
                            <a href="/streestsoul_store1/view/client/logout.php">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/streestsoul_store1/view/client/login.php" class="login-btn">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
</body>
</html>
