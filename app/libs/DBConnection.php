
<?php

class DBConnection
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;

    public function __construct()
    {
        // Lấy thông tin từ file config.php
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;

        try {
            // Tạo kết nối PDO đến MySQL
            $sqlStr = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";

            $this->conn = new PDO(
                $sqlStr,
                $this->user,
                $this->pass
            );

            // Báo lỗi khi câu lệnh SQL gặp vấn đề
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            // Trả dữ liệu từ MySQL dưới dạng mảng kết hợp
            $this->conn->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

        } catch (PDOException $e) {
            // Hiển thị lỗi kết nối để dễ sửa khi đang phát triển
            die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    // Trả về đối tượng kết nối để Service sử dụng
    public function getConnection()
    {
        return $this->conn;
    }
}
