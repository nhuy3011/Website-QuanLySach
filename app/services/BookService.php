<?php

require_once APP_ROOT . '/app/libs/DBConnection.php';
require_once APP_ROOT . '/app/models/Book.php';

class BookService
{
    private $conn;

    public function __construct()
    {
        // Kết nối database
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách sách, tìm kiếm và lọc thể loại
    public function getAllBooks($keyword = '', $categoryId = '')
    {
        $sql = "SELECT books.*, categories.name AS category_name
                FROM books
                LEFT JOIN categories
                ON books.category_id = categories.id
                WHERE 1 = 1";

        $params = [];

        // Tìm kiếm theo tên sách hoặc tác giả
        if ($keyword !== '') {
            $sql .= " AND (
                        books.title LIKE :title
                        OR books.author LIKE :author
                    )";

            $params['title'] = '%' . $keyword . '%';
            $params['author'] = '%' . $keyword . '%';
        }

        // Lọc theo thể loại
        if ($categoryId !== '' && $categoryId !== null) {
            $sql .= " AND books.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        $sql .= " ORDER BY books.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // Lấy sách theo mã
    public function getBookById($id)
    {
        $sql = "SELECT * FROM books WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Book(
            $row['id'],
            $row['title'],
            $row['author'],
            $row['category_id'],
            $row['price'],
            $row['quantity'],
            $row['description']
        );
    }

    // Thêm sách
    public function addBook(Book $book)
    {
        $sql = "INSERT INTO books
                (title, author, category_id, price, quantity, description)
                VALUES
                (:title, :author, :category_id, :price, :quantity, :description)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'category_id' => $book->getCategoryId(),
            'price' => $book->getPrice(),
            'quantity' => $book->getQuantity(),
            'description' => $book->getDescription()
        ]);
    }

    // Cập nhật sách
    public function updateBook(Book $book)
    {
        $sql = "UPDATE books SET
                    title = :title,
                    author = :author,
                    category_id = :category_id,
                    price = :price,
                    quantity = :quantity,
                    description = :description
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'category_id' => $book->getCategoryId(),
            'price' => $book->getPrice(),
            'quantity' => $book->getQuantity(),
            'description' => $book->getDescription(),
            'id' => $book->getId()
        ]);
    }

    // Xóa sách
    public function deleteBook($id)
    {
        $sql = "DELETE FROM books WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    // Đếm tổng số đầu sách
    public function countBooks()
    {
        $sql = "SELECT COUNT(*) FROM books";

        return (int) $this->conn->query($sql)->fetchColumn();
    }

    // Tính tổng số quyển sách trong kho
    public function countTotalQuantity()
    {
        $sql = "SELECT COALESCE(SUM(quantity), 0) FROM books";

        return (int) $this->conn->query($sql)->fetchColumn();
    }

    // Đếm số đầu sách đã hết
    public function countOutOfStock()
    {
        $sql = "SELECT COUNT(*) FROM books WHERE quantity = 0";

        return (int) $this->conn->query($sql)->fetchColumn();
    }
}

?>