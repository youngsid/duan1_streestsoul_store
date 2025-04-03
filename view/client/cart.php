<?php
session_start();
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../layout/header.php";

// Nếu chưa có giỏ hàng, tạo mảng giỏ hàng
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_id'])) {
    $removeId = $_POST['remove_id'];
    unset($_SESSION['cart'][$removeId]);
}

// Hiển thị danh sách sản phẩm trong giỏ hàng
?>
<div class="container">
    <h2>Giỏ hàng của bạn</h2>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Thao tác</th>
        </tr>
        <?php foreach ($_SESSION['cart'] as $id => $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo number_format($product['price']); ?> VNĐ</td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="remove_id" value="<?php echo $id; ?>">
                        <button type="submit">Xóa</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include __DIR__ . "/../layout/footer.php"; ?>
