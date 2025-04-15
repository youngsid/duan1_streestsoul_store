<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tendangnhap = $_POST['tendangnhap'] ?? '';
    $matkhau = $_POST['matkhau'] ?? '';

    try {
        $conn = new PDO("mysql:host=localhost;dbname=streestsoul_store999;charset=utf8", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM users WHERE tendangnhap = ? AND matkhau = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tendangnhap, $matkhau]);

        if ($stmt->rowCount() === 1) {
            // Đăng nhập thành công
            $_SESSION['user'] = $stmt->fetch(PDO::FETCH_ASSOC);
            header("Location:/streestsoul_store1/index.php"); // 👉 Quay về trang chủ
            exit;
        } else {
            $error = "Sai tên đăng nhập hoặc mật khẩu!";
        }
    } catch (PDOException $e) {
        $error = "Lỗi kết nối CSDL: " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">

<form method="POST" style="width: 50%; margin: auto; margin-top: 50px;" class="border border-info border-2 rounded p-4">
  <h3 class="text-center mb-4">Đăng nhập</h3>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <div class="mb-3">
    <label for="tendangnhap" class="form-label">Tên đăng nhập</label>
    <input type="text" class="form-control" id="tendangnhap" name="tendangnhap" required>
  </div>
  <div class="mb-3">
    <label for="matkhau" class="form-label">Mật khẩu</label>
    <input type="password" class="form-control" id="matkhau" name="matkhau" required>
  </div>
  <button type="submit" class="btn btn-primary">Đăng nhập</button>
  <a href="/streestsoul_store1/index.php" class="btn btn-secondary ms-2">Về trang chủ</a>

  <!-- Thêm thông báo và nút đăng ký -->
  <div class="mt-3 text-center">
    <p>Bạn chưa có tài khoản? <a href="/streestsoul_store1/view/client/register.php">Đăng ký ngay</a></p>
  </div>
</form>
