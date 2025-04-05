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

// Kiểm tra nếu trường gallery có dữ liệu và chuyển đổi JSON thành mảng nếu cần
$product['gallery'] = !empty($product['gallery']) ? json_decode($product['gallery'], true) : [];
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

<div class="container product-detail-container">
    <!-- Phần bên trái: hình ảnh sản phẩm -->
    <div class="product-image">
        <img id="mainImage" src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($product['image']); ?>" 
        alt="<?php echo htmlspecialchars($product['name']); ?>">

        <!-- Hình ảnh mô tả nhỏ -->
        <div class="thumbnail-container">
            <?php if (!empty($product['gallery']) && is_array($product['gallery'])): ?>
                <?php foreach ($product['gallery'] as $image): ?>
                    <img class="thumbnail" src="/streestsoul_store1/public/images/<?php echo htmlspecialchars($image); ?>" 
                    alt="Thumbnail" onclick="changeImage(this)">
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có hình ảnh mô tả.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Phần bên phải: thông tin sản phẩm + giỏ hàng -->
    <div class="product-info">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    
    <!-- Hiển thị giá gốc -->
    <p class="original-price" style="text-decoration: line-through; color: #999;">
        <?php echo number_format($product['price'] * 1.1); ?> VNĐ
    </p>

    <!-- Hiển thị giá đã giảm xuống 720.000 VNĐ -->
    <p class="discounted-price" id="discountedPrice" style="color: #ff6600; font-weight: bold;">
        720,000 VNĐ
    </p>

    <p class="description"><strong>Mô tả:</strong> <?php echo htmlspecialchars($product['description']); ?></p>

    <!-- Nhập voucher giảm giá -->
    <div class="voucher-section">
        <input type="text" id="voucherCode" placeholder="Nhập mã giảm giá">
        <button onclick="applyVoucher()">Áp dụng</button>
    </div>

    <!-- Nút thêm giỏ hàng và mua ngay -->
    <div class="buttons">
        <form method="POST" action="cart.php">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
            <input type="hidden" name="price" id="finalPrice" value="720000">
            <button type="submit">Thêm vào giỏ hàng</button>
        </form>
        <button class="buy-now">Mua ngay</button>
    </div>
</div>

<!-- JS cho phần voucher -->
<script>
function applyVoucher() {
    let voucherCode = document.getElementById("voucherCode").value;
    let originalDiscountedPrice = 720000; // Giá đã giảm trước khi áp dụng voucher
    let finalPriceElement = document.getElementById("discountedPrice");

    if (voucherCode === "SALE10") {
        let newPrice = originalDiscountedPrice * 0.9; // Giảm thêm 10%
        finalPriceElement.textContent = newPrice.toLocaleString() + " VNĐ";
        document.getElementById("finalPrice").value = newPrice;
        alert("Áp dụng giảm giá thành công! Giá mới: " + newPrice.toLocaleString() + " VNĐ");
    } else {
        alert("Mã giảm giá không hợp lệ!");
    }
}
</script>


<?php include __DIR__ . "/../layout/footer.php"; ?>
