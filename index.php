<?php
$page = $_GET['page'] ?? 'home';

// Đường dẫn thư mục chứa các file client
$client_path = 'view/client/';

switch ($page) {
  case 'home':
    include $client_path . 'home.php';
    break;
  case 'cart':
    include $client_path . 'cart.php';
    break;
  case 'products':
    include $client_path . 'products.php';
    break;
  case 'productDetail':
    include $client_path . 'productDetail.php';
    break;
  case 'login':
    include $client_path . 'login.php';
    break;
  case 'register':
    include $client_path . 'register.php';
    break;
  case 'order':
    include $client_path . 'order.php';
    break;
  case 'orderUser':
    include $client_path . 'orderUser.php';
    break;
  default:
    echo "<h2>404 - Trang không tồn tại!</h2>";
    break;
}
?>
