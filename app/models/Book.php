<?php
class Book {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Lấy tất cả sách
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM books");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tìm kiếm sách theo tên
    public function search($keyword) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE title LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lọc sách theo thể loại
    public function filterByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE category_id = :id");
        $stmt->execute(['id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>