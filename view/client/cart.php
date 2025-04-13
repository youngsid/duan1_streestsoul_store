<?php
// view/cart.php
session_start();
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../layout/header.php";

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý xóa sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    unset($_SESSION['cart'][$_POST['remove_id']]);
}

// Xử lý cập nhật số lượng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id']) && isset($_POST['quantity'])) {
    $updateId = $_POST['update_id'];
    $newQuantity = (int) $_POST['quantity'];
    if ($newQuantity > 0) {
        $_SESSION['cart'][$updateId]['quantity'] = $newQuantity;
    }
}

// Thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $cartItem = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1, // Mặc định số lượng là 1
            'image' => $product['image'] ? $product['image'] : 'default.jpg' // Kiểm tra ảnh sản phẩm
        ];

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productId] = $cartItem;
        }
    }
}
?>

<div class="container">
    <h2>Giỏ hàng của bạn</h2>

    <table class="cart-table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $product): 
                $name = $product['name'];
                $price = $product['price'];
                $quantity = $product['quantity'];
                $image = $product['image'];
                $subtotal = $price * $quantity;
                $total += $subtotal;
            ?>
            <tr>
                <td class="product-name">
                    <!-- Đảm bảo đường dẫn ảnh là chính xác và đầy đủ -->
                    <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($image); ?>" width="50" alt="<?php echo htmlspecialchars($name); ?>"> 
                    <?php echo htmlspecialchars($name); ?>
                </td>
                <td class="product-price"><?php echo number_format($price); ?> VNĐ</td>
                <td class="product-quantity">
                    <form method="POST">
                        <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1">
                        <input type="hidden" name="update_id" value="<?php echo $id; ?>">
                        <button type="submit">Cập nhật</button>
                    </form>
                </td>
                <td class="product-subtotal"><?php echo number_format($subtotal); ?> VNĐ</td>
                <td class="product-remove">
                    <form method="POST">
                        <input type="hidden" name="remove_id" value="<?php echo $id; ?>">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <p><strong>Tổng tiền: <?php echo number_format($total); ?> VNĐ</strong></p>
    </div>

    <!-- Form "Mua ngay" -->
    <form method="GET" action="/streestsoul_store1/view/client/order.php">
        <div class="checkout-button">
            <input type="submit" value="Mua ngay" />
        </div>
    </form>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
