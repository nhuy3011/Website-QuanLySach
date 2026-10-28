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
        $this->host = DB_HOST;
        $this->dbname = DB_NAME;
        $this->user = DB_USER;
        $this->pass = DB_PASS;

        try {
            $sqlStr = "mysql:host=$this->host;dbname=$this->dbname";
            $this->conn = new PDO($sqlStr, $this->user, $this->pass);
        } catch (PDOException $e) {
            $this->conn = null;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

// Folder libs dc ví như bộ đồ nghề tiện ích phục vụ cho cả dự án
// tiêu biểu nhất là công cụ tạo kết nối CSDL PDO.