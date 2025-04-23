<?php
include_once __DIR__ . "/../layout/header.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Liên hệ</title>
    <style>
/* Căn chỉnh container chính */
.contact-container {
    max-width: 1200px; /* Mở rộng khung chứa */
    margin: 50px auto;
    text-align: center;
    padding: 40px; /* Tạo khoảng cách thoáng hơn */
}

/* Bố cục hai phần bằng nhau */
.contact-content {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Căn giữa theo chiều dọc */
    gap: 30px;
}

/* Định dạng cả form và Google Maps */
.contact-form, .contact-map {
    flex: 1; /* Cả hai phần bằng nhau */
    max-width: 50%; /* Chia đều không gian */
}

/* Thiết kế form liên hệ */
.contact-form {
    background: #f9f9f9;
    padding: 30px; /* Tăng kích thước padding */
    border-radius: 12px; /* Bo góc mềm mại */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); /* Đổ bóng tinh tế */
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    font-size: 18px;
    display: block;
    margin-bottom: 8px;
}

input, textarea {
    width: 100%;
    padding: 12px;
    border: 3px solid #ff6600;
    border-radius: 8px;
    font-size: 16px;
}

.btn {
    background-color: #ff6600;
    color: white;
    font-size: 20px;
    padding: 12px 24px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #cc5200;
}

/* Căn chỉnh bản đồ Google Maps */
.contact-map {
    text-align: center;
}

iframe {
    width: 100%;
    height: 100%;
    min-height: 450px; /* Đảm bảo bản đồ có độ cao lớn */
    border-radius: 12px;
    border: none;
}

    </style>
</head>
<body>

<div class="contact-container">
    <h2>Liên hệ với chúng tôi</h2>

    <div class="contact-content">
        <!-- Form liên hệ -->
        <form method="POST" action="process_contact.php" class="contact-form">
            <div class="form-group">
                <label for="name">Họ và tên:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Nội dung:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn">Gửi liên hệ</button>
        </form>

        <!-- Google Maps -->
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5270574260617!2d106.6933126!3d10.7769388!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752eb2830424eb%3A0xf7d924e882b0b9f9!2zMTIzIMSQxrDhu51uZyBBQkMsIFF14bqtbiBYWlksIFRwLiBI4buNYyBDaMOtIE1pbmggNQ!5e0!3m2!1svi!2s!4v1682970743292!5m2!1svi!2s"
                loading="lazy"></iframe>
        </div>
    </div>
</div>

<?php include __DIR__ . "/../layout/footer.php"; ?>

</body>
</html>
