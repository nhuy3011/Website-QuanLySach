
<?php

require_once APP_ROOT . '/app/libs/DBConnection.php';
require_once APP_ROOT . '/app/models/Book.php';

class BookService
{
    private $conn;

    public function __construct()
    {
        // Khởi tạo kết nối database
        $db = new DBConnection();
        $this->conn = $db->getConnection();
    }

    // Lấy danh sách sách, hỗ trợ tìm kiếm và lọc thể loại
    public function getAllBooks($keyword = '', $categoryId = '')
    {
        $sql = "SELECT books.*, categorys.name AS category_name
                FROM books
                INNER JOIN categorys
                    ON books.category_id = categorys.id
                WHERE 1 = 1";

        $params = [];

        // Tìm theo tên sách, tác giả hoặc mã ISBN
        if ($keyword !== '') {
            $sql .= " AND (
                books.title LIKE :title
                OR books.author LIKE :author
                OR books.isbn LIKE :isbn
            )";

            $params['title'] = '%' . $keyword . '%';
            $params['author'] = '%' . $keyword . '%';
            $params['isbn'] = '%' . $keyword . '%';
        }

        // Lọc theo thể loại
        if ($categoryId !== '' && $categoryId !== null) {
            $sql .= " AND books.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        // Sắp xếp sách theo mã giảm dần
        $sql .= " ORDER BY books.id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // Lấy một quyển sách theo mã
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
            $row['isbn'],
            $row['publisher'],
            $row['publish_year'],
            $row['category_id'],
            $row['quantity']
        );
    }

    // Thêm sách mới
    public function addBook(Book $book)
    {
        $sql = "INSERT INTO books
                (title, author, isbn, publisher, publish_year,
                 category_id, quantity)
                VALUES
                (:title, :author, :isbn, :publisher, :publish_year,
                 :category_id, :quantity)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'isbn' => $book->getIsbn() ?: null,
            'publisher' => $book->getPublisher() ?: null,
            'publish_year' => $book->getPublishYear() ?: null,
            'category_id' => $book->getCategoryId(),
            'quantity' => $book->getQuantity()
        ]);
    }

    // Cập nhật thông tin sách
    public function updateBook(Book $book)
    {
        $sql = "UPDATE books SET
                    title = :title,
                    author = :author,
                    isbn = :isbn,
                    publisher = :publisher,
                    publish_year = :publish_year,
                    category_id = :category_id,
                    quantity = :quantity
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'isbn' => $book->getIsbn() ?: null,
            'publisher' => $book->getPublisher() ?: null,
            'publish_year' => $book->getPublishYear() ?: null,
            'category_id' => $book->getCategoryId(),
            'quantity' => $book->getQuantity(),
            'id' => $book->getId()
        ]);
    }

    // Xóa sách theo mã
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

    // Tính tổng số quyển sách hiện có trong kho
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
