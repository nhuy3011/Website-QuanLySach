
<?php

require_once APP_ROOT . '/app/services/BookService.php';
require_once APP_ROOT . '/app/services/CategoryService.php';

class BookController
{
    // Hiển thị form thêm sách
    public function add()
    {
        $categoryService = new CategoryService();
        $categories = $categoryService->getAllCategories();

        include APP_ROOT . '/app/views/book/add.php';
    }

    // Xử lý dữ liệu khi thêm sách
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $publisher = trim($_POST['publisher'] ?? '');
        $publishYear = $_POST['publish_year'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $quantity = $_POST['quantity'] ?? '';

        // Kiểm tra dữ liệu bắt buộc
        if (
            $title === '' ||
            $author === '' ||
            $categoryId === '' ||
            $quantity === '' ||
            !ctype_digit((string) $categoryId) ||
            !ctype_digit((string) $quantity)
        ) {
            $_SESSION['error'] = 'Vui lòng nhập đúng các thông tin bắt buộc.';
            header('Location: ' . DOMAIN . '?controller=book&action=add');
            exit;
        }

        // Kiểm tra năm xuất bản
        if (
            $publishYear !== '' &&
            (!ctype_digit((string) $publishYear) ||
             (int) $publishYear < 1901 ||
             (int) $publishYear > 2155)
        ) {
            $_SESSION['error'] = 'Năm xuất bản không hợp lệ.';
            header('Location: ' . DOMAIN . '?controller=book&action=add');
            exit;
        }

        $bookService = new BookService();

        // Kiểm tra thể loại có tồn tại không
        $categoryService = new CategoryService();
        if (!$categoryService->getCategoryById((int) $categoryId)) {
            $_SESSION['error'] = 'Thể loại không tồn tại.';
            header('Location: ' . DOMAIN . '?controller=book&action=add');
            exit;
        }

        // Tạo đối tượng sách
        $book = new Book(
            null,
            $title,
            $author,
            $isbn,
            $publisher,
            $publishYear === '' ? null : (int) $publishYear,
            (int) $categoryId,
            (int) $quantity
        );

        try {
            $bookService->addBook($book);
            $_SESSION['success'] = 'Thêm sách thành công.';
            header('Location: ' . DOMAIN);
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể thêm sách. Kiểm tra ISBN có bị trùng không.';
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
            $_SESSION['error'] = 'Không tìm thấy sách cần sửa.';
            header('Location: ' . DOMAIN);
            exit;
        }

        $categories = $categoryService->getAllCategories();

        include APP_ROOT . '/app/views/book/edit.php';
    }

    // Cập nhật thông tin sách
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN);
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $isbn = trim($_POST['isbn'] ?? '');
        $publisher = trim($_POST['publisher'] ?? '');
        $publishYear = $_POST['publish_year'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $quantity = $_POST['quantity'] ?? '';

        if (
            $title === '' ||
            $author === '' ||
            $categoryId === '' ||
            $quantity === '' ||
            !ctype_digit((string) $categoryId) ||
            !ctype_digit((string) $quantity)
        ) {
            $_SESSION['error'] = 'Vui lòng nhập đúng các thông tin bắt buộc.';
            header('Location: ' . DOMAIN . '?controller=book&action=edit&id=' . (int) $id);
            exit;
        }

        if (
            $publishYear !== '' &&
            (!ctype_digit((string) $publishYear) ||
             (int) $publishYear < 1901 ||
             (int) $publishYear > 2155)
        ) {
            $_SESSION['error'] = 'Năm xuất bản không hợp lệ.';
            header('Location: ' . DOMAIN . '?controller=book&action=edit&id=' . (int) $id);
            exit;
        }

        $categoryService = new CategoryService();
        if (!$categoryService->getCategoryById((int) $categoryId)) {
            $_SESSION['error'] = 'Thể loại không tồn tại.';
            header('Location: ' . DOMAIN . '?controller=book&action=edit&id=' . (int) $id);
            exit;
        }

        $bookService = new BookService();

        // Kiểm tra sách có tồn tại trước khi cập nhật
        if (!$bookService->getBookById($id)) {
            $_SESSION['error'] = 'Không tìm thấy sách cần sửa.';
            header('Location: ' . DOMAIN);
            exit;
        }

        $book = new Book(
            (int) $id,
            $title,
            $author,
            $isbn,
            $publisher,
            $publishYear === '' ? null : (int) $publishYear,
            (int) $categoryId,
            (int) $quantity
        );

        try {
            $bookService->updateBook($book);
            $_SESSION['success'] = 'Cập nhật sách thành công.';
            header('Location: ' . DOMAIN);
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể cập nhật sách. Kiểm tra ISBN có bị trùng không.';
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
            header('Location: ' . DOMAIN);
            exit;
        }

        include APP_ROOT . '/app/views/book/delete.php';
    }

    // Thực hiện xóa sách
    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN);
            exit;
        }

        $bookService = new BookService();

        if (!$bookService->getBookById($id)) {
            $_SESSION['error'] = 'Sách không tồn tại.';
            header('Location: ' . DOMAIN);
            exit;
        }

        $bookService->deleteBook($id);

        $_SESSION['success'] = 'Xóa sách thành công.';
        header('Location: ' . DOMAIN);
        exit;
    }
}

?>
