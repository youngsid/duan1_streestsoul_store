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
            <a href="/streestsoul_store1/orderUser.php">Đơn hàng</a>
        </div>

        <!-- Menu phải -->
        <div class="nav-right">
            <a href="/streestsoul_store1/view/client/cart.php" class="cart-icon">
                <i class="fa fa-shopping-cart"></i>
                <span id="cart-count">
                    <?php echo $totalCartItems; ?>
                </span>
            </a>
            <a href="/streestsoul_store1/login.php" class="login-btn">Đăng nhập</a>
        </div>
    </div>
</div>
</header>
