<?php
session_start();
include_once __DIR__ . "/../layout/header.php";
?>

<style>
    .success-container {
        max-width: 500px;
        margin: 100px auto;
        padding: 30px;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    .success-container h2 {
        color: #28a745;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .success-container p {
        font-size: 16px;
        color: #555;
        margin-bottom: 20px;
    }

    .btn-orange {
        background-color: #ff9800; /* Màu cam */
        color: white;
        font-size: 18px;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s ease;
    }

    .btn-orange:hover {
        background-color: #e68900; /* Màu cam đậm khi di chuột */
    }
</style>

<div class="success-container">
    <h2>Đặt hàng thành công!</h2>
    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn sẽ được xử lý sớm nhất.</p>
    <a href="/streestsoul_store1/index.php" class="btn-orange">Tiếp tục mua sắm</a>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>
