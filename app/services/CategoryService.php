
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
        $sql = "SELECT * FROM categories ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $categories = [];

        while ($row = $stmt->fetch()) {
            $categories[] = new Category(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['created_at']
            );
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

    // Thêm thể loại
    public function addCategory(Category $category)
    {
        $sql = "INSERT INTO categories (name, description)
                VALUES (:name, :description)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'name' => $category->getName(),
            'description' => $category->getDescription()
        ]);
    }

    // Cập nhật thể loại
    public function updateCategory(Category $category)
    {
        $sql = "UPDATE categories
                SET name = :name,
                    description = :description
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'id' => $category->getId()
        ]);
    }

    // Đếm số sách thuộc một thể loại
    public function countBooksByCategory($id)
    {
        $sql = "SELECT COUNT(*) FROM books WHERE category_id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return (int) $stmt->fetchColumn();
    }

    // Xóa thể loại
    public function deleteCategory($id)
    {
        // Chỉ xóa thể loại khi không còn sách thuộc thể loại đó
        if ($this->countBooksByCategory($id) > 0) {
            return false;
        }

        $sql = "DELETE FROM categories WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}

?>
