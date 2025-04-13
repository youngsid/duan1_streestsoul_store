<?php
// model/order.model.php
include_once __DIR__ . '/../config/db.php';

function insertOrder($name, $phone, $address, $cart, $shippingFee) {
    // Tạo đối tượng Database và kết nối
    $database = new Database();
    $conn = $database->conn;

    // Tính tổng giá trị đơn hàng
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    $grandTotal = $total + $shippingFee;

    // Insert đơn hàng vào bảng orders
    $sql = "INSERT INTO orders (customer_name, phone, address, total_price, shipping_fee, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    
    // Kiểm tra lỗi khi chuẩn bị câu lệnh SQL
    if ($stmt === false) {
        die('❌ Lỗi chuẩn bị câu lệnh SQL: ' . $conn->error);
    }

    // Bind các tham số vào câu lệnh SQL
    $stmt->bind_param("sssii", $name, $phone, $address, $grandTotal, $shippingFee);
    
    // Thực thi câu lệnh SQL
    if (!$stmt->execute()) {
        die('❌ Lỗi khi thực thi câu lệnh SQL: ' . $stmt->error);
    }

    // Lấy ID của đơn hàng vừa insert
    $order_id = $conn->insert_id;

    // Insert chi tiết đơn hàng vào bảng order_details
    $sqlDetail = "INSERT INTO order_details (order_id, product_id, product_name, quantity, price)
                  VALUES (?, ?, ?, ?, ?)";
    
    $stmtDetail = $conn->prepare($sqlDetail);

    // Kiểm tra lỗi khi chuẩn bị câu lệnh SQL chi tiết đơn hàng
    if ($stmtDetail === false) {
        die('❌ Lỗi chuẩn bị câu lệnh SQL chi tiết: ' . $conn->error);
    }

    // Duyệt qua giỏ hàng và insert chi tiết đơn hàng cho mỗi sản phẩm
    foreach ($cart as $item) {
        $stmtDetail->bind_param(
            "iisii",
            $order_id,
            $item['id'],
            $item['name'],
            $item['quantity'],
            $item['price']
        );
        
        // Thực thi câu lệnh chi tiết đơn hàng
        if (!$stmtDetail->execute()) {
            die('❌ Lỗi khi thực thi câu lệnh chi tiết đơn hàng: ' . $stmtDetail->error);
        }
    }

    // Trả về ID của đơn hàng vừa tạo
    return $order_id;
}
?>
