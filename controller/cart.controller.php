<!-- Tuan Nhi -->
<?php
session_start();
include_once "/model/product.model.php";

$productModel = new Product();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $product = $productModel->getProductById($_GET['id']);
    $_SESSION['cart'][$product['id']] = $product;
    header("Location: /view/client/cart.php");
    exit();
}
?>
