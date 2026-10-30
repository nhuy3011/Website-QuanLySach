<?php

require_once APP_ROOT . '/app/libs/DBConnection.php';
require_once APP_ROOT . '/app/models/Category.php';

class CategoryService
{
    private $conn;

    public function __construct()
    {
        // Khởi tạo kết nối database
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    // Lấy tất cả thể loại
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $categories = [];

        while ($row = $stmt->fetch()) {
            $category = new Category(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['created_at']
            );

            $categories[] = $category;
        }

        return $categories;
    }

    // Lấy thể loại theo mã
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Category(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['created_at']
        );
    }
}

?>