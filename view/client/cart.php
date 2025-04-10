<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../layout/header.php";

// Debug thử session
// echo '<pre>'; print_r($_SESSION['cart']); echo '</pre>';

// Khởi tạo session giỏ hàng nếu chưa có
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
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
?>

<div class="container">
    <h2>Giỏ hàng của bạn</h2>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Thao tác</th>
        </tr>
        <?php 
        $total = 0;
        if (!empty($_SESSION['cart'])):
            foreach ($_SESSION['cart'] as $id => $product): 
                $name = htmlspecialchars($product['name'] ?? 'Sản phẩm');
                $price = $product['price'] ?? 0;
                $quantity = $product['quantity'] ?? 1;
                $image = !empty($product['image']) ? htmlspecialchars($product['image']) : 'default.jpg';

                $subtotal = $price * $quantity;
                $total += $subtotal;
        ?>
            <tr>
                <td>
                    <img src="/streestsoul_store1/public/images/<?php echo $image; ?>" alt="<?php echo $name; ?>" width="50">
                    <?php echo $name; ?>    
                </td>
                <td><?php echo number_format($price); ?> VNĐ</td>
                <td>
                    <form method="POST">
                        <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1">
                        <input type="hidden" name="update_id" value="<?php echo $id; ?>">
                        <button type="submit">Cập nhật</button>
                    </form>
                </td>
                <td><?php echo number_format($subtotal); ?> VNĐ</td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="remove_id" value="<?php echo $id; ?>">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Giỏ hàng của bạn đang trống.</td>
            </tr>
        <?php endif; ?>
    </table>

    <p><strong>Tổng tiền: <?php echo number_format($total); ?> VNĐ</strong></p>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
