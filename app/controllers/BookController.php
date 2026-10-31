
<?php

require_once APP_ROOT . '/app/services/BookService.php';
require_once APP_ROOT . '/app/services/CategoryService.php';

class BookController
{
    // Hiển thị danh sách sách
    public function index()
    {
        // Nhận từ khóa tìm kiếm
        $keyword = trim($_GET['keyword'] ?? '');

        // Nhận mã thể loại
        $categoryId = $_GET['category_id'] ?? '';

        // Khởi tạo Service
        $bookService = new BookService();
        $categoryService = new CategoryService();

        // Lấy danh sách sách theo từ khóa và thể loại
        $books = $bookService->getAllBooks(
            $keyword,
            $categoryId
        );

        // Lấy danh sách thể loại để hiển thị bộ lọc
        $categories = $categoryService->getAllCategories();

        // Lấy thông tin thống kê
        $totalBooks = $bookService->countBooks();
        $totalQuantity = $bookService->countTotalQuantity();
        $outOfStock = $bookService->countOutOfStock();

        // Hiển thị giao diện quản lý sách
        include APP_ROOT . '/app/views/book/index.php';
    }

    // Hiển thị form thêm sách
    public function add()
    {
        $categoryService = new CategoryService();
        $categories = $categoryService->getAllCategories();

        include APP_ROOT . '/app/views/book/add.php';
    }

    // Xử lý thêm sách
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $categoryId = $_POST['category_id'] ?? '';
        $price = $_POST['price'] ?? '0';
        $quantity = $_POST['quantity'] ?? '0';
        $description = trim($_POST['description'] ?? '');

        // Kiểm tra thông tin bắt buộc
        if (
            $title === '' ||
            $author === '' ||
            !ctype_digit((string) $quantity) ||
            !is_numeric($price) ||
            (float) $price < 0 ||
            (float) $price > 999999999999
        ) {
            $_SESSION['error'] = 'Vui lòng kiểm tra lại thông tin sách.';
            header('Location: ' . DOMAIN . '?controller=book&action=add');
            exit;
        }

        // Kiểm tra thể loại nếu người dùng có chọn
        if ($categoryId !== '') {
            $categoryService = new CategoryService();

            if (
                !ctype_digit((string) $categoryId) ||
                !$categoryService->getCategoryById((int) $categoryId)
            ) {
                $_SESSION['error'] = 'Thể loại không hợp lệ.';
                header('Location: ' . DOMAIN . '?controller=book&action=add');
                exit;
            }
        }

        // Tạo đối tượng sách
        $book = new Book(
            null,
            $title,
            $author,
            $categoryId === '' ? null : (int) $categoryId,
            $price,
            (int) $quantity,
            $description
        );

        try {
            $bookService = new BookService();
            $bookService->addBook($book);

            $_SESSION['success'] = 'Thêm sách thành công.';

            // Chuyển về trang quản lý sách
            header('Location: ' . DOMAIN . '?controller=book');
            exit;

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể thêm sách: ' . $e->getMessage();

            header('Location: ' . DOMAIN . '?controller=book&action=add');
            exit;
        }
    }

    // Hiển thị form sửa sách
    public function edit($id)
    {
        $bookService = new BookService();
        $categoryService = new CategoryService();

        $book = $bookService->getBookById($id);

        if (!$book) {
            $_SESSION['error'] = 'Không tìm thấy sách.';
            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        $categories = $categoryService->getAllCategories();

        include APP_ROOT . '/app/views/book/edit.php';
    }

    // Xử lý cập nhật sách
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $categoryId = $_POST['category_id'] ?? '';
        $price = $_POST['price'] ?? '0';
        $quantity = $_POST['quantity'] ?? '0';
        $description = trim($_POST['description'] ?? '');

        // Kiểm tra dữ liệu
        if (
            $title === '' ||
            $author === '' ||
            !ctype_digit((string) $quantity) ||
            !is_numeric($price) ||
            (float) $price < 0 ||
            (float) $price > 999999999999
        ) {
            $_SESSION['error'] = 'Vui lòng kiểm tra lại thông tin sách.';

            header('Location: ' . DOMAIN . '?controller=book&action=edit&id=' . (int) $id);
            exit;
        }

        // Kiểm tra thể loại
        if ($categoryId !== '') {
            $categoryService = new CategoryService();

            if (
                !ctype_digit((string) $categoryId) ||
                !$categoryService->getCategoryById((int) $categoryId)
            ) {
                $_SESSION['error'] = 'Thể loại không hợp lệ.';

                header('Location: ' . DOMAIN . '?controller=book&action=edit&id=' . (int) $id);
                exit;
            }
        }

        $bookService = new BookService();

        if (!$bookService->getBookById($id)) {
            $_SESSION['error'] = 'Không tìm thấy sách cần sửa.';

            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        // Tạo đối tượng sách với thông tin mới
        $book = new Book(
            (int) $id,
            $title,
            $author,
            $categoryId === '' ? null : (int) $categoryId,
            $price,
            (int) $quantity,
            $description
        );

        try {
            $bookService->updateBook($book);

            $_SESSION['success'] = 'Cập nhật sách thành công.';

            // Chuyển về trang quản lý sách
            header('Location: ' . DOMAIN . '?controller=book');
            exit;

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể cập nhật sách: ' . $e->getMessage();

            header('Location: ' . DOMAIN . '?controller=book&action=edit&id=' . (int) $id);
            exit;
        }
    }

    // Hiển thị trang xác nhận xóa
    public function delete($id)
    {
        $bookService = new BookService();
        $book = $bookService->getBookById($id);

        if (!$book) {
            $_SESSION['error'] = 'Không tìm thấy sách cần xóa.';

            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        include APP_ROOT . '/app/views/book/delete.php';
    }

    // Thực hiện xóa sách
    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        $bookService = new BookService();

        if (!$bookService->getBookById($id)) {
            $_SESSION['error'] = 'Không tìm thấy sách cần xóa.';

            header('Location: ' . DOMAIN . '?controller=book');
            exit;
        }

        try {
            $bookService->deleteBook($id);

            $_SESSION['success'] = 'Xóa sách thành công.';

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể xóa sách: ' . $e->getMessage();
        }

        // Quay lại trang quản lý sách
        header('Location: ' . DOMAIN . '?controller=book');
        exit;
    }
}

?>
