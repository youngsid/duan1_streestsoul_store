<!-- Tuan Nhi - Xy ly don hang -->
<?php
include_once "/config/db.php";

class Order {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function getAllOrders() {
        $query = "SELECT * FROM orders";
        return $this->db->conn->query($query);
    }

    public function updateOrderStatus($orderId, $status) {
        $query = "UPDATE orders SET status = '$status' WHERE id = $orderId";
        return $this->db->conn->query($query);
    }
}
?>
