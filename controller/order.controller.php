<!-- Tuan Nhi - Xy ly don hang tu nguoi dung-->
<?php
session_start();
include_once "/model/order.model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderModel = new Order();
    $orderId = $orderModel->createOrder($_SESSION['user_id'], $_SESSION['cart']);
    unset($_SESSION['cart']);

    header("Location: /view/client/success.php");
    exit();
}
?>
