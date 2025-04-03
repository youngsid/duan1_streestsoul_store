<?php
session_start();
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../../model/product.model.php";
include_once __DIR__ . "/../layout/header.php";

$productModel = new Product();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Không tìm thấy sản phẩm!");
}

$id = intval($_GET['id']);
$product = $productModel->getProductById($id);

if (!$product) {
    die("Sản phẩm không tồn tại!");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="/streestsoul_store1/public/style.css">
</head>
<body>

<div class="container">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <div class="product-detail">
        <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
        alt="<?php echo htmlspecialchars($product['name']); ?>">
        <p><strong>Giá:</strong> <?php echo number_format($product['price']); ?> VNĐ</p>
        <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
        <form method="POST" action="cart.php">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
            <button type="submit">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>

</body>
</html>
echo "<link rel='stylesheet' href='/streestsoul_store1/public/style.css'>";
