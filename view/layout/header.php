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
</head>
<body>
<header>
    <div class="header-content container">
        <h1>StreetSoul Store</h1>
        <nav class="nav-container">
            <div class="nav-left">
                <a href="/streestsoul_store1/index.php">Trang chủ</a>
                <a href="/streestsoul_store1/view/client/products.php">Sản phẩm</a>
                <a href="/streestsoul_store1/orderUser.php">Đơn hàng</a>
            </div>
            <div class="nav-right">
                <a href="/streestsoul_store1/view/client/cart.php" class="cart-icon">
                    🛒 <span id="cart-count">
                        <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                    </span>
                </a>
                <a href="/streestsoul_store1/login.php" class="login-btn">Đăng nhập</a>
            </div>
        </nav>
    </div>
</header>
