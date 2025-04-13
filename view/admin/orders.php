<?php
// Kiểm tra xem người dùng đã đăng nhập và là admin hay chưa
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['vaitro'] !== 1) {
    header("Location: /streestsoul_store1/view/client/login.php"); // Nếu không phải admin, chuyển hướng về trang login
    exit;
}

try {
    // Kết nối CSDL
    $conn = new PDO("mysql:host=localhost;dbname=streestsoul_store999;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn tất cả đơn hàng
    $sql = "SELECT * FROM orders";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
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
        <h2>Quản lý đơn hàng</h2>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Tên khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                            <?php if ($order['status'] != 'Đã xác nhận'): ?>
                                <a href="confirm_order.php?id=<?= $order['id'] ?>">Xác nhận</a>
                            <?php else: ?>
                                <span>Đã xác nhận</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
