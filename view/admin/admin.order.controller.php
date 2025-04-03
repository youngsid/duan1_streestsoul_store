<!-- Tuan Nhi - Xác nhận, hủy, cập nhật đơn hàng -->
<?php
include_once "../model/order.model.php";

$orderModel = new Order();

if (isset($_GET['action']) && isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];
    $status = "";

    switch ($_GET['action']) {
        case "confirm":
            $status = "Đang giao hàng";
            break;
        case "cancel":
            $status = "Đã hủy";
            break;
        case "complete":
            $status = "Hoàn thành";
            break;
    }

    if ($status) {
        $orderModel->updateOrderStatus($orderId, $status);
        header("Location: order.php");
        exit();
    }
}
?>
