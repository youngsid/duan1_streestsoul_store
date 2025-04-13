<?php
session_start(); // Bắt đầu session

// Xóa tất cả session và đăng xuất người dùng
session_unset(); // Xóa tất cả các biến session
session_destroy(); // Hủy session

// Chuyển hướng về trang chủ hoặc trang đăng nhập
header("Location: /streestsoul_store1/index.php");
exit;
?>
    