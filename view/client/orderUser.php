<?php
session_start();
include_once __DIR__ . "/../layout/header.php";
include_once __DIR__ . "/../../config/db.php";

// Kết nối DB
$database = new Database();
$conn = $database->conn;

// Truy vấn tất cả đơn hàng
$query = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!-- Gọi file CSS riêng cho giao diện đơn hàng -->
<link rel="stylesheet" href="/streestsoul_store1/public/css/orderUser.css">

<div class="order-history container">
    <h2>Trạng thái đơn hàng</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <div class="order-box">
                <p><strong>Mã đơn:</strong> #<?php echo $order['id']; ?></p>
                <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                <p><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order['created_at'])); ?></p>
                <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total_price']); ?> VNĐ</p>
                <p><strong>Trạng thái:</strong> 
                    <span class="status-label">
                        <?php echo !empty($order['status']) ? htmlspecialchars($order['status']) : "Đang chờ xác nhận"; ?>
                    </span>
                </p>

                <!-- Chi tiết sản phẩm của đơn -->
                <div class="order-products">
                    <table>
                        <tbody>
                        <?php
                            $order_id = $order['id'];
                            $detailQuery = "SELECT od.*, p.gallery FROM order_details od
                                            LEFT JOIN products p ON od.product_id = p.id
                                            WHERE od.order_id = $order_id";
                            $detailsResult = $conn->query($detailQuery);

                            while ($item = $detailsResult->fetch_assoc()):
                                // Giải mã JSON để lấy ảnh đầu tiên từ cột gallery
                                $gallery = json_decode($item['gallery'], true);
                                $thumbnail = isset($gallery[0]) ? $gallery[0] : 'default-thumbnail.jpg'; // Nếu không có ảnh thì dùng ảnh mặc định
                        ?>
                            <tr>
                                <td><img src="/streestsoul_store1/public/images/<?php echo $thumbnail; ?>" alt="Ảnh sản phẩm" /></td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price']); ?> VNĐ</td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Chưa có đơn hàng nào được đặt.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . "/../layout/footer.php"; ?>
