<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$totalCartItems = 0;
if (isset($_SESSION['cart'])) {
    $totalCartItems = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>StreetSoul Store</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS của bạn -->
    <link rel="stylesheet" href="/streestsoul_store1/public/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Giữ nguyên font chữ cũ */
        body, button, input, select, textarea {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo-img {
            height: 50px;
        }

        .nav-left a, .nav-right a, .user-name {
            margin-right: 20px;
            text-decoration: none;
            color: #000;
        }

        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            background: white;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            top: 100%;
            right: 0;
            width: 200px;
            z-index: 1000;
        }

        .user-menu:hover .user-dropdown {
            display: block;
        }

        .user-dropdown a {
            display: block;
            padding: 10px;
            color: black;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
        }

        .user-dropdown a:last-child {
            border-bottom: none;
        }

        .user-dropdown a:hover {
            background: #f8f9fa;
        }

        .cart-icon {
            position: relative;
        }

        .cart-icon i {
            font-size: 20px;
        }

        #cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            padding: 2px 8px;
            border-radius: 50%;
            font-size: 12px;
        }

        .user-menu i {
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="nav-container">
            <!-- Logo -->
            <div class="logo">
                <a href="/streestsoul_store1/index.php">
                    <img src="/streestsoul_store1/public/images/logoweb.jpg" alt="Logo" class="logo-img">
                </a>
            </div>

            <!-- Menu trái -->
            <div class="nav-left d-flex">
                <a href="/streestsoul_store1/index.php">Trang chủ</a>
                <a href="/streestsoul_store1/view/client/products.php">Sản phẩm</a>
                <a href="/streestsoul_store1/view/client/contact.php">Liên hệ</a>
            </div>

            <!-- Menu phải -->
            <div class="nav-right d-flex align-items-center">
                <!-- Giỏ hàng -->
                <a href="/streestsoul_store1/view/client/cart.php" class="cart-icon me-3">
                    <i class="fa fa-shopping-cart"></i>
                    <span id="cart-count"><?= $totalCartItems; ?></span>
                </a>

                <!-- Tài khoản -->
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Đã đăng nhập -->
                    <div class="user-menu">
                        <i class="fa fa-user me-1"></i>
                        <span class="user-name">Xin chào, <?= htmlspecialchars($_SESSION['user']['hoten']) ?></span>
                        <div class="user-dropdown">
                            <a href="/streestsoul_store1/view/client/orderUser.php">Đơn hàng</a>
                            <?php if ($_SESSION['user']['vaitro'] === 1): ?>
                                <a href="/streestsoul_store1/view/admin/dashboard.php">Quản trị</a>
                            <?php endif; ?>
                            <a href="/streestsoul_store1/view/client/logout.php">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Chưa đăng nhập -->
                    <div class="user-menu">
                        <i class="fa fa-user" data-bs-toggle="dropdown"></i>
                        <div class="user-dropdown">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<!-- Modal Đăng nhập -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/streestsoul_store1/view/client/login.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Đăng nhập</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        <div class="mb-3">
          <label class="form-label">Tên đăng nhập</label>
          <input type="text" class="form-control" name="tendangnhap" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" name="matkhau" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Đăng nhập</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Đăng ký -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/streestsoul_store1/view/client/register.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Đăng ký tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($_GET['register_error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['register_error']) ?></div>
        <?php endif; ?>
        <div class="mb-3">
          <label class="form-label">Họ tên</label>
          <input type="text" class="form-control" name="hoten" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tên đăng nhập</label>
          <input type="text" class="form-control" name="tendangnhap" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mật khẩu</label>
          <input type="password" class="form-control" name="matkhau" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email">
        </div>
        <div class="mb-3">
          <label class="form-label">Ngày sinh</label>
          <input type="date" class="form-control" name="ngaysinh">
        </div>
        <label class="form-label">Giới tính</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="phai" value="1" id="nam">
          <label class="form-check-label" for="nam">Nam</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="phai" value="0" id="nu" checked>
          <label class="form-check-label" for="nu">Nữ</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Đăng ký</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<!-- Hiển thị modal khi có lỗi -->
<?php if (!empty($_GET['error'])): ?>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    new bootstrap.Modal(document.getElementById('loginModal')).show();
  });
</script>
<?php endif; ?>

<?php if (!empty($_GET['register_error'])): ?>
<script>
  window.addEventListener('DOMContentLoaded', () => {
    new bootstrap.Modal(document.getElementById('registerModal')).show();
  });
</script>
<?php endif; ?>

</body>
</html>
