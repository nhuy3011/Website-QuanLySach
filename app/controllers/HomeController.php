
<?php

require_once APP_ROOT . '/app/services/BookService.php';
require_once APP_ROOT . '/app/services/CategoryService.php';

class HomeController
{
    // Hiển thị trang quản lý sách
    public function index()
    {
        // Nhận từ khóa tìm kiếm trên URL
        $keyword = trim($_GET['keyword'] ?? '');

        // Nhận mã thể loại được chọn
        $categoryId = $_GET['category_id'] ?? '';

        // Khởi tạo các Service
        $bookService = new BookService();
        $categoryService = new CategoryService();

        // Lấy danh sách sách theo từ khóa và thể loại
        $books = $bookService->getAllBooks(
            $keyword,
            $categoryId
        );

        // Lấy danh sách thể loại cho bộ lọc
        $categories = $categoryService->getAllCategories();

        // Lấy số liệu thống kê kho sách
        $totalBooks = $bookService->countBooks();
        $totalQuantity = $bookService->countTotalQuantity();
        $outOfStock = $bookService->countOutOfStock();

        // Hiển thị giao diện trang chủ
        include APP_ROOT . '/app/views/home/index.php';
    }
}

?>
