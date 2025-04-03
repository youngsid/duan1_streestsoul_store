<!-- Tuan Nhi - Danh sach don hang + giao dien -->
<?php
include_once "../model/order.model.php";
$orderModel = new Order();
$orders = $orderModel->getAllOrders();
?>

<?php include "layout/header.php"; ?>
<div class="container">
    <h2>Quản lý đơn hàng</h2>
    <table>
        <tr><th>Mã Đơn</th><th>Khách Hàng</th><th>Trạng Thái</th><th>Hành động</th></tr>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['user_id']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td>
                    <?php if ($order['status'] === "Chờ xử lý"): ?>
                        <a href="admin.order.controller.php?action=confirm&order_id=<?php echo $order['id']; ?>">✅ Xác nhận</a> | 
                        <a href="admin.order.controller.php?action=cancel&order_id=<?php echo $order['id']; ?>">❌ Hủy</a>
                    <?php elseif ($order['status'] === "Đang giao hàng"): ?>
                        <a href="admin.order.controller.php?action=complete&order_id=<?php echo $order['id']; ?>">✔ Hoàn thành</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include "layout/footer.php"; ?>
