<?php
// Kiểm tra quyền truy cập
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['vaitro'] !== 1) {
    header("Location: /streestsoul_store1/view/client/login.php");
    exit;
}

try {
    // Kết nối CSDL
    $conn = new PDO("mysql:host=localhost;dbname=streestsoul_store999;charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Truy vấn tất cả đơn hàng
    $sql = "SELECT * FROM orders ORDER BY order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Đảm bảo có dữ liệu, nếu không gán mảng rỗng
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    echo "<p style='color: red;'>Lỗi kết nối: " . htmlspecialchars($e->getMessage()) . "</p>";
    $orders = [];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="/streestsoul_store1/public/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; background: #f8f9fa; }

        .sidebar { width: 250px; height: 100vh; background: #343a40; color: white; padding: 20px; position: fixed; }
        .sidebar a { display: block; color: white; padding: 10px; text-decoration: none; margin: 10px 0; transition: 0.3s; }
        .sidebar a:hover { background: #495057; }

        .content { margin-left: 270px; padding: 20px; width: 100%; }
        .dashboard-card {
            background: white; padding: 20px; border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px;
        }

        .dashboard-card h2 { color:rgb(0, 0, 0); margin-bottom: 10px; }
        .dashboard-card p { color: #555; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); }
        th, td { padding: 12px; text-align: left; }
        th { background:rgb(255, 255, 255); color: black; }
        tr:nth-child(even) { background: #f1f1f1; }
        .btn {
    display: inline-block;
    padding: 8px 12px;
    text-decoration: none;
    background:rgb(255, 255, 255); /* Màu xanh đậm hơn */
    color: black;
    border-radius: 5px;
    border: 2px solid black; /* Viền đen */
    }

    .btn:hover {
        background: #1e7e34; /* Giữ nguyên màu khi hover */
    }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3>Quản trị</h3>
        <a href="/streestsoul_store1/index.php"><i class="fa fa-home"></i> Trang chủ</a>
        <a href="/streestsoul_store1/view/admin/orders.php"><i class="fa fa-shopping-cart"></i> Quản lý đơn hàng</a>
        <a href="/streestsoul_store1/view/admin/users.php"><i class="fa fa-user"></i> Quản lý người dùng</a>
        <a href="/streestsoul_store1/view/admin/products.php"><i class="fa fa-box"></i> Quản lý sản phẩm</a>
        <a href="/streestsoul_store1/view/client/logout.php"><i class="fa fa-sign-out"></i> Đăng xuất</a>
    </div>

    <div class="content">
        <div class="dashboard-card">
            <h2>Quản lý đơn hàng</h2>
            <p>Bạn có thể theo dõi và xác nhận các đơn hàng của khách hàng tại đây.</p>
        </div>

        <?php if (!empty($orders)): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt</th>
                    <th>Tên khách hàng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td>
                        <?php if ($order['status'] == 'Đang xử lý'): ?>
                            <a class="btn" href="confirm_order.php?id=<?= $order['id'] ?>">Xác nhận</a>
                        <?php elseif ($order['status'] == 'Đã xác nhận'): ?>
                            <a class="btn" href="delivery_order.php?id=<?= $order['id'] ?>">Giao hàng</a>
                        <?php else: ?>
                            <span>Đã giao</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <div class="dashboard-card">
                <p style="text-align:center; color:#777;">Không có đơn hàng nào cần xử lý.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
