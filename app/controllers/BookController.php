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

    // Xử lý thêm sách
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN);
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
            header('Location: ' . DOMAIN);
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
            header('Location: ' . DOMAIN);
            exit;
        }

        $categories = $categoryService->getAllCategories();

        include APP_ROOT . '/app/views/book/edit.php';
    }

    // Xử lý cập nhật sách
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN);
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
            header('Location: ' . DOMAIN);
            exit;
        }

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
            header('Location: ' . DOMAIN);
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
            $_SESSION['error'] = 'Không tìm thấy sách cần xóa.';
            header('Location: ' . DOMAIN);
            exit;
        }

        try {
            $bookService->deleteBook($id);

            $_SESSION['success'] = 'Xóa sách thành công.';

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Không thể xóa sách: ' . $e->getMessage();
        }

        header('Location: ' . DOMAIN);
        exit;
    }
}

?>