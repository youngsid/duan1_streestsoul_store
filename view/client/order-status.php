<?php
session_start();
include_once __DIR__ . "/../layout/header.php";
include_once __DIR__ . "/../../config/db.php";

$database = new Database();
$conn = $database->conn;

// Lấy số điện thoại để tra cứu đơn hàng
$phone = $_GET['phone'] ?? '';

$orders = [];
if (!empty($phone)) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE phone = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $orders = $stmt->get_result();
}
?>

<div class="order-status-container">
    <h2>Tra cứu đơn hàng</h2>
    <form method="GET">
        <label for="phone">Nhập số điện thoại:</label>
        <input type="text" name="phone" required>
        <button type="submit">Xem đơn hàng</button>
    </form>

    <?php if ($orders && $orders->num_rows > 0): ?>
        <h3>Kết quả:</h3>
        <table>
            <thead>
                <tr>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php while($order = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                        <td><?php echo number_format($order['total_price']); ?> VNĐ</td>
                        <td><?php echo $order['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php elseif (!empty($phone)): ?>
        <p>Không tìm thấy đơn hàng nào.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
