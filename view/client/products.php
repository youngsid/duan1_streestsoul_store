<?php
// Đảm bảo đường dẫn đúng
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../../model/product.model.php";
include_once __DIR__ . "/../../model/category.model.php";
include_once __DIR__ . "/../layout/header.php";

$productModel = new Product();
$categoryModel = new Category();

$categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

if ($categoryId) {
    $allProducts = $productModel->getProductsByCategory($categoryId);
    $categoryName = $categoryModel->getCategoryNameById($categoryId);
} else {
    $allProducts = $productModel->getAllProducts();
    $categoryName = null;
}

$allCategories = $categoryModel->getAllCategories();
?>

<!-- Banner -->
<!-- <div style="width: 100%; margin: 0 auto 30px; padding: 0;">
    <img src="/streestsoul_store1/public/images/banner.jpg" alt="Banner Sản phẩm" 
         style="width: 100%; max-height: 350px; object-fit: cover; border-radius: 10px;">
</div> -->

<div class="container" style="display: flex; gap: 30px; flex-wrap: wrap; padding: 20px;">
    <!-- Sidebar -->
    <aside style="flex: 1 1 20%; padding: 20px; background-color: #f9f9f9; border-radius: 10px;">
        <h3 style="margin-bottom: 15px; color: #333;">Danh mục</h3>
        <ul style="list-style: none; padding-left: 0; font-size: 16px;">
            <?php if (!empty($allCategories)): ?>
                <?php foreach ($allCategories as $category): ?>
                    <li style="margin-bottom: 10px;">
                        <a href="?category_id=<?php echo $category['id']; ?>" 
                           style="text-decoration: none; color: #007BFF; font-weight: 500;">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Không có danh mục</li>
            <?php endif; ?>
        </ul>
    </aside>

    <!-- Sản phẩm -->
    <section style="flex: 1 1 75%;">
        <h2>
            <?php echo $categoryName ? "Sản phẩm thuộc danh mục: <em>$categoryName</em>" : "Tất cả sản phẩm"; ?>
        </h2>
        <div class="product-list">
            <?php if (!empty($allProducts)): ?>
                <?php foreach ($allProducts as $product): ?>
                    <div class="product">
                        <a href="productDetail.php?id=<?php echo $product['id']; ?>" style="text-decoration: none; color: inherit;">
                            <img src="/streestsoul_store1/public/images/<?php echo $product['image']; ?>" alt="" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
                            <h3 style="font-size: 16px; margin: 10px 0;"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="price" style="color:rgb(0, 0, 0); font-weight: bold;"><?php echo number_format($product['price']); ?> VNĐ</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </section>
</div>
<?php include_once __DIR__ . "/../layout/footer.php"; ?>
