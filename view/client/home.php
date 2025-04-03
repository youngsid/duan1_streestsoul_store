<?php
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../../model/product.model.php";
include_once __DIR__ . "/../layout/header.php";

// Tạo mảng chứa sản phẩm theo loại
$featuredProducts = [];
$hotSaleProducts = [];

// lay danh sach san pham
foreach ($allProducts as $product) {
    if ($product['is_featured']) {
        $featuredProducts[] = $product;
    } elseif ($product['is_hot_sale']) {
        $hotSaleProducts[] = $product;
    }
}


?>

<div class="banner">
    <h2>StreetSoul Collection</h2>
</div>

<!-- Hiển thị sản phẩm nổi bật -->
<div class="container">
    <h2>Sản phẩm nổi bật</h2>
    <div class="product-list">
        <?php foreach (array_slice($featuredProducts, 0, 4) as $product): ?>
            <div class="product featured">
            <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo number_format($product['price']); ?> VNĐ</p>
                <a href="/streestsoul_store1/view/client/productDetail.php?id=<?php echo $product['id']; ?>">Xem chi tiết</a>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <button type="submit">Thêm vào giỏ hàng</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<!-- Hiển thị sản phẩm hot giảm giá -->
<div class="container">
    <h2>Sản phẩm hot giảm giá</h2>
    <div class="product-list">
        <?php foreach (array_slice($hotSaleProducts, 0, 4) as $product): ?>
            <div class="product hot-sale">
            <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p><?php echo number_format($product['price']); ?> VNĐ</p>
                <a href="/streestsoul_store1/view/client/productDetail.php?id=<?php echo $product['id']; ?>">Xem chi tiết</a>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <button type="submit">Thêm vào giỏ hàng</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
