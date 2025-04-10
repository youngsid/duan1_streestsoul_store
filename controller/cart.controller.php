<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = floatval($_POST['price']);

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => 1
        ];
    }

    // Tính tổng số lượng sản phẩm trong giỏ
    $totalItems = 0;
    foreach ($_SESSION['cart'] as $item) {
        $totalItems += $item['quantity'];
    }

    echo json_encode([
        'success' => true,
        'totalItems' => $totalItems
    ]);
    exit;
}

echo json_encode(['success' => false, 'error' => 'Yêu cầu không hợp lệ']);
http_response_code(400);
exit;
