<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    $totalCartItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
<header>
    <h1>StreetSoul Store</h1>
    <nav>
        <a href="../../index.php">Trang chủ</a>
        <a href="../../view/client/cart.php">Giỏ hàng 
            <span id="cartCount" style="color: red; font-weight: bold;"><?php echo $totalCartItems; ?></span>
        </a>
        <a href="../../orderUser.php">Đơn hàng</a>
    </nav>
</header>
