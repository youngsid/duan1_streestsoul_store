<?php
session_start();

// Xử lý khi người dùng nhấn "Mua ngay"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mua_ngay'])) {
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? 'Không tên';
    $price = $_POST['price'] ?? 0;
    $image = $_POST['image'] ?? 'no-image.jpg';

    // Reset giỏ hàng chỉ còn 1 sản phẩm (theo ý nghĩa của "mua ngay")
    $_SESSION['cart'] = [];

    $_SESSION['cart'][] = [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'image' => $image,
        'quantity' => 1
    ];

    // Chuyển hướng sang trang đặt hàng
    header('Location: /streestsoul_store1/view/client/order.php');
    exit();
}
?>
