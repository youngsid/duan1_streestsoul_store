use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your-email@gmail.com';
    $mail->Password   = 'your-app-password'; // Nếu bật xác minh 2 bước, dùng mật khẩu ứng dụng
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('your-email@gmail.com', 'StreetSoul Support');
    $mail->addAddress('support@streestsoul_store1.com');

    $mail->Subject = "Liên hệ từ khách hàng";
    $mail->Body    = "Tên: $_POST[name]\nEmail: $_POST[email]\nNội dung: $_POST[message]";

    $mail->send();
    echo "<h3>Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.</h3>";
} catch (Exception $e) {
    echo "<h3>Có lỗi xảy ra khi gửi email: {$mail->ErrorInfo}</h3>";
}
