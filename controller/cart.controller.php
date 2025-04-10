<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $image = $_POST['image'] ?? 'default.jpg'; // thêm ảnh nếu có hoặc dùng mặc định

    if ($id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'quantity' => 1
            ];
        }

        echo json_encode(['success' => true, 'cartCount' => count($_SESSION['cart'])]);
    } else {
        echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
    }
}
