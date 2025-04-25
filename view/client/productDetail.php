<?php
session_start();
include_once __DIR__ . "/../../config/db.php";
include_once __DIR__ . "/../../model/product.model.php";

$productModel = new Product();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<h2 style='color: red; text-align: center'>Không tìm thấy sản phẩm!</h2>";
    include_once __DIR__ . "/../layout/header.php";
    include_once __DIR__ . "/../layout/footer.php";
    exit;
}

$id = intval($_GET['id']);
$product = $productModel->getProductById($id);

if (!$product) {
    echo "<h2 style='color: red; text-align: center'>Sản phẩm không tồn tại!</h2>";
    include_once __DIR__ . "/../layout/header.php";
    include_once __DIR__ . "/../layout/footer.php";
    exit;
}

include_once __DIR__ . "/../layout/header.php";

$originalPrice = $product['price'];
$isHotSale = !empty($product['is_hot_sale']);

if ($isHotSale) {
    $discountRate = 0.30;
    $discountedPrice = $originalPrice * (1 - $discountRate);
} else {
    $discountedPrice = $originalPrice;
}

$product['gallery'] = !empty($product['gallery']) ? json_decode($product['gallery'], true) : [];
$otherProducts = $productModel->getRandomProducts(4, $product['id']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="/streestsoul_store1/public/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container product-detail-container">
    <div class="product-image">
        <img id="mainImage" src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <div class="thumbnail-container">
            <?php foreach ($product['gallery'] as $image): ?>
                <img class="thumbnail" src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($image); ?>" alt="Thumbnail" onclick="changeImage(this)">
            <?php endforeach; ?>
        </div>
    </div>

    <div class="product-info">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>

        <?php if ($isHotSale): ?>
            <p class="original-price" style="text-decoration: line-through; color: #999;">
                <?php echo number_format($originalPrice); ?> VNĐ
            </p>
            <p class="discounted-price" id="discountedPrice" style="color: #ff6600; font-weight: bold;">
                <?php echo number_format($discountedPrice); ?> VNĐ
            </p>
        <?php else: ?>
            <p class="price" id="discountedPrice" style="font-weight: bold;">
                <?php echo number_format($originalPrice); ?> VNĐ
            </p>
        <?php endif; ?>

        <div class="shipping-table">
            <h3>Khu vực giao hàng</h3>
            <table>
                <tr><td>Hà Nội</td><td><span class="out-of-stock">Hết hàng</span></td></tr>
                <tr><td>TP. Hồ Chí Minh</td><td><span class="in-stock">Còn hàng</span></td></tr>
                <tr><td>Đà Nẵng</td><td><span class="out-of-stock">Hết hàng</span></td></tr>
                <tr><td>Cần Thơ</td><td><span class="out-of-stock">Hết hàng</span></td></tr>
            </table>
        </div>

        <div class="description">
            <h3>Mô tả sản phẩm</h3>
            <p>Đây là một chiếc áo thun cotton cao cấp,
            thoáng mát, thích hợp cho mọi thời tiết.
            Thiết kế trẻ trung, dễ phối đồ.
            </p>
        </div>

      <div class="voucher-section">
    <input type="text" id="voucherCode" class="voucher-input" placeholder="Nhập mã giảm giá">
    <button class="custom-btn" onclick="applyVoucher()">Áp dụng</button>
</div>

<div class="buttons"> 
    <button class="custom-btn" id="addToCartBtn" 
        data-id="<?= $product['id'] ?>" 
        data-name="<?= htmlspecialchars($product['name']) ?>" 
        data-price="<?= $discountedPrice ?>"
        data-image="<?= htmlspecialchars($product['image']) ?>">
        
         Thêm vào giỏ hàng 
    </button>

            <form id="buyNowForm" action="order.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="image" value="<?php echo htmlspecialchars($product['image']); ?>">
                <button type="submit" class="buy-now-btn">Mua ngay</button>
            </form>

        </div>
    </div>
</div>
                
<div class="container related-products">
    <h3>Các sản phẩm khác</h3>
    <div class="product-list">
        <?php foreach ($otherProducts as $item): ?>
            <?php
                $isItemHotSale = !empty($item['is_hot_sale']);
                $itemOriginalPrice = $item['price'];
                $itemDiscountedPrice = $isItemHotSale ? $itemOriginalPrice * 0.7 : $itemOriginalPrice;
            ?>
            <div class="product">
                <a href="productDetail.php?id=<?= $item['id'] ?>">
                    <img src="/streestsoul_store1/public/images/<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <?php if ($isItemHotSale): ?>
                        <p class="original-price" style="text-decoration: line-through; color: #999;">
                            <?= number_format($itemOriginalPrice) ?> VNĐ
                        </p>
                        <p class="discounted-price" style="color: #ff6600; font-weight: bold;">
                            <?= number_format($itemDiscountedPrice) ?> VNĐ
                        </p>
                    <?php else: ?>
                        <p class="price" style="font-weight: bold;">
                            <?= number_format($itemOriginalPrice) ?> VNĐ
                        </p>
                    <?php endif; ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
function changeImage(el) {
    document.getElementById("mainImage").src = el.src;
}

function applyVoucher() {
    let voucherCode = document.getElementById("voucherCode").value;
    let currentPrice = <?= $discountedPrice ?>;
    if (voucherCode === "SALE30") {
        let newPrice = currentPrice * 0.7;
        document.getElementById("discountedPrice").textContent = newPrice.toLocaleString() + " VNĐ";
        alert("Giảm giá thành công!");
    } else {
        alert("Mã không hợp lệ!");
    }
}

$('#addToCartBtn').on('click', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const price = $(this).data('price');
    const image = $(this).data('image') || 'default.jpg'; // Kiểm tra hình ảnh hợp lệ

    $.post('/streestsoul_store1/controller/cart.controller.php', {
        action: 'add',
        id,
        name,
        price,
        image
        

    }, function (res) {
        if (res.success) {
            $('#cart-count').text(res.totalItems);
            alert('Đã thêm vào giỏ hàng!');
        } else {
            alert('Thêm vào giỏ thất bại!');
        }
    }, 'json');
});
</script>

<?php include __DIR__ . "/../layout/footer.php"; ?>
