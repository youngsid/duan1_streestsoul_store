<?php
// Kiểm tra xem người dùng đã đăng nhập và là admin hay chưa
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['vaitro'] !== 1) {
    header("Location: /streestsoul_store1/view/client/login.php"); // Nếu không phải admin, chuyển hướng về trang login
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/streestsoul_store1/public/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="nav-container">
                <!-- Logo và các menu -->
                <div class="logo">
                    <a href="/streestsoul_store1/index.php">
                        <img src="/streestsoul_store1/public/images/logoweb.jpg" alt="Logo" class="logo-img">
                    </a>
                </div>

                <div class="nav-left">
                    <a href="/streestsoul_store1/view/admin/dashboard.php">Trang Admin</a>
                    <a href="/streestsoul_store1/view/admin/orders.php">Quản lý đơn hàng</a>
                </div>

                <div class="nav-right">
                    <span class="user-name">Xin chào, <?= htmlspecialchars($_SESSION['user']['hoten']) ?></span>
                    <a href="/streestsoul_store1/view/client/logout.php">Đăng xuất</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <h2>Chào mừng đến với trang quản trị</h2>
        <p>Ở đây bạn có thể quản lý các đơn hàng, người dùng và các chức năng khác.</p>
    </div>
</body>
</html>
