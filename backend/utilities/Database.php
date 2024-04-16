<?php
class Database {
    private $host = "192.168.0.22:3306";
    private $db_name = "doodle";
    private $username = "root";
    private $password = "ourpassword";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
        
    }
}
?>
