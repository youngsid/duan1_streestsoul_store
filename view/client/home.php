<?php
// ======= FILE: home.php =======

include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../../model/product.model.php";
include_once __DIR__ . "/../layout/header.php";

$featuredProducts = [];
$hotSaleProducts = [];

foreach ($allProducts as $product) {
    if ($product['is_featured']) {
        $featuredProducts[] = $product;
    } elseif ($product['is_hot_sale']) {
        $hotSaleProducts[] = $product;
    }
}
?>

<!-- banenr -->
<div class="banner">
    <img src="public/images/banner-trangchu.jpg" alt="StreetSoul Banner" class="logo">
    <h2>StreetSoul Collection</h2>
</div>

<!-- Sản phẩm nổi bật -->
<div class="container">
    <h2>Sản phẩm nổi bật</h2>
    <div class="product-list">
        <?php foreach (array_slice($featuredProducts, 0, 4) as $product): ?>
            <div class="product">
                <a href="/streestsoul_store1/view/client/productDetail.php?id=<?php echo $product['id']; ?>">
                    <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                        alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">
                        <?php echo number_format($product['price']); ?> VNĐ
                    </p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Sản phẩm giảm giá -->
<div class="container">
    <h2>Sản phẩm giá ưu đãi</h2>
    <div class="product-list">
        <?php foreach (array_slice($hotSaleProducts, 0, 4) as $product): 
            $originalPrice = $product['price'];
            $discountedPrice = $originalPrice * 0.9;
        ?>
            <div class="product">
                <a href="/streestsoul_store1/view/client/productDetail.php?id=<?php echo $product['id']; ?>">
                    <img src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                        alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="original-price" style="text-decoration: line-through; color: #999;">
                        <?php echo number_format($originalPrice); ?> VNĐ
                    </p>
                    <p class="discounted-price" style="color: #ff6600; font-weight: bold;">
                        <?php echo number_format($discountedPrice); ?> VNĐ
                    </p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>