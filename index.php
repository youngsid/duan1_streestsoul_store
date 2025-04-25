<?php
session_start();
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/controller/home.controller.php";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - StreetSoul Store</title>
    <link rel="stylesheet" href="public/style.css">
</head>
<body>


<?php include __DIR__ . "/view/client/home.php"; ?>

</body>
</html>
