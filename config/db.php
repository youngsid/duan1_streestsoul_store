<?php
class Database {
    private $host = "localhost";
    private $user = "root";  
    private $pass = "";  
    private $dbname = "streestsoul_store999";  
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Lỗi kết nối database: " . $this->conn->connect_error);
        }
    }
}
?>
