
<?php

require_once APP_ROOT . '/app/libs/DBConnection.php';
require_once APP_ROOT . '/app/models/Category.php';

class CategoryService
{
    private $conn;

    public function __construct()
    {
        // Tạo kết nối database
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    // Lấy tất cả thể loại sách
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categorys ORDER BY name ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $categories = [];

        while ($row = $stmt->fetch()) {
            // Chuyển từng dòng dữ liệu thành đối tượng Category
            $category = new Category(
                $row['id'],
                $row['name'],
                $row['description']
            );

            $categories[] = $category;
        }

        return $categories;
    }

    // Lấy một thể loại theo mã
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categorys WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Category(
            $row['id'],
            $row['name'],
            $row['description']
        );
    }
}

?>
