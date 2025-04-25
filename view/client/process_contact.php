<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Kiểm tra xem form có gửi dữ liệu chưa
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Bảo vệ dữ liệu đầu vào
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';                  // Máy chủ SMTP Gmail
        $mail->SMTPAuth   = true;                              
        $mail->Username   = 'anhlvpps39871@gmail.com';             // Thay bằng email của bạn
        $mail->Password   = 'Tuyen22122004';                // Thay bằng mật khẩu ứng dụng của bạn
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Bảo mật SMTP
        $mail->Port       = 587;                                // Cổng SMTP

        // Gửi từ và gửi đến
        $mail->setFrom('your-email@gmail.com', 'StreetSoul Support');
        $mail->addAddress('anhlvpps39871@gmail.com');            // Thay bằng email bạn muốn nhận thông báo

        // Nội dung email
        $mail->Subject = "Liên hệ từ khách hàng";
        $mail->Body    = "Tên: $name\nEmail: $email\nNội dung: $message";

        // Gửi email
        $mail->send();
        echo "<h3 style='color:green;'>Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.</h3>";
    } catch (Exception $e) {
        echo "<h3 style='color:red;'>Có lỗi xảy ra khi gửi email: {$mail->ErrorInfo}</h3>";
    }
} else {
    echo "<h3 style='color:red;'>Vui lòng gửi biểu mẫu từ trang liên hệ.</h3>";
}
?>
