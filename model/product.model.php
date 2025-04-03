<!-- hai -->
<?php
include_once __DIR__ . "/../config/db.php";

class Product {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $result = $this->db->conn->query($query);
        
        $products = []; // Tạo mảng chứa sản phẩm
        while ($row = $result->fetch_assoc()) {
            $products[] = $row; // Lưu từng sản phẩm vào mảng
        }
        
        return $products; // Trả về toàn bộ danh sách sản phẩm
    }
    
    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = $id";
        return $this->db->conn->query($query)->fetch_assoc();
    }
}
?>
