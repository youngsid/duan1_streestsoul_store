<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . "/../layout/header.php";


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='color:red;'>Không có sản phẩm nào trong giỏ hàng!</p>";
    exit();
}


$total = 0;
$shippingFee = 30000; // Phí ship cố định

// Tính tổng tiền từ giỏ hàng
foreach ($_SESSION['cart'] as $item) {
    $price = isset($item['price']) ? $item['price'] : 0;
    $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
    $total += $price * $quantity;
}
$grandTotal = $total + $shippingFee;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    include_once __DIR__ . "/../../config/db.php";
    $database = new Database();
    $conn = $database->conn;

    // Thêm đơn hàng vào bảng orders
    $query = "INSERT INTO orders ( customer_name, phone, address, total_price, shipping_fee, status, created_at)
    VALUES (?, ?, ?, ?, ?, 'Đang xử lý', NOW())";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssii", $name, $phone, $address, $grandTotal, $shippingFee);
$stmt->execute();


    $order_id = $conn->insert_id;

    // Thêm chi tiết đơn hàng vào bảng order_details
    $sqlDetail = "INSERT INTO order_details (order_id, product_id, product_name, quantity, price)
    VALUES (?, ?, ?, ?, ?)";
$stmtDetail = $conn->prepare($sqlDetail);

foreach ($_SESSION['cart'] as $item) {
$price = isset($item['price']) ? $item['price'] : 0;
$quantity = isset($item['quantity']) ? $item['quantity'] : 1;
$id = isset($item['id']) ? $item['id'] : 0;
$product_name = isset($item['name']) ? $item['name'] : '';

$sqlCheckProduct = "SELECT id FROM products WHERE id = ?";
$stmtCheckProduct = $conn->prepare($sqlCheckProduct);
$stmtCheckProduct->bind_param("i", $id);
$stmtCheckProduct->execute();
$resultCheckProduct = $stmtCheckProduct->get_result();

if ($resultCheckProduct->num_rows > 0) {
$stmtDetail->bind_param("iisid", $order_id, $id, $product_name, $quantity, $price);
$stmtDetail->execute();
}


    }

    // Xóa giỏ hàng sau khi đặt hàng
    unset($_SESSION['cart']);
    header('Location: order-success.php');
    exit();
}
?>

<div class="order-container">
    <h2>Thông tin đơn hàng</h2>

    <!-- Danh sách sản phẩm trong đơn hàng -->
    <div class="order-products">
        <h3>Sản phẩm:</h3>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): 
                    $image = isset($item['image']) ? $item['image'] : 'no-image.jpg';
                    $name = isset($item['name']) ? $item['name'] : 'Sản phẩm không tên';
                    $price = isset($item['price']) ? $item['price'] : 0;
                    $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
                    $subtotal = $price * $quantity;
                ?>
                <tr>

                     <td><img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($image); ?>" width="50" alt="<?php echo htmlspecialchars($name); ?>"></td>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo number_format($price); ?> VNĐ</td>
                    <td><?php echo number_format($subtotal); ?> VNĐ</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Form nhập thông tin đặt hàng -->
    <form method="POST" action="">
        <div>
            <label for="name">Họ và tên:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" required>
        </div>
        <div>
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" required>
        </div>

        <div>
            <p>Phí vận chuyển: <?php echo number_format($shippingFee); ?> VNĐ</p>
            <p><strong>Tổng tiền: <?php echo number_format($grandTotal); ?> VNĐ</strong></p>
        </div>
        <button type="submit" name="place_order" class="btn btn-primary">Đặt hàng</button>
        <!-- <button type="button" class="btn btn-primary" onclick="window.location.href='order-success.php';"> -->

    </form>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
