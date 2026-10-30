<?php

require_once APP_ROOT . '/app/services/BookService.php';
require_once APP_ROOT . '/app/services/CategoryService.php';

class HomeController
{
    public function index()
    {
        // Nhận từ khóa tìm kiếm
        $keyword = trim($_GET['keyword'] ?? '');

        // Nhận mã thể loại
        $categoryId = $_GET['category_id'] ?? '';

        // Khởi tạo Service
        $bookService = new BookService();
        $categoryService = new CategoryService();

        // Lấy danh sách sách
        $books = $bookService->getAllBooks(
            $keyword,
            $categoryId
        );

        // Lấy danh sách thể loại
        $categories = $categoryService->getAllCategories();

        // Thống kê kho sách
        $totalBooks = $bookService->countBooks();
        $totalQuantity = $bookService->countTotalQuantity();
        $outOfStock = $bookService->countOutOfStock();

        // Hiển thị giao diện
        include APP_ROOT . '/app/views/home/index.php';
    }
}

?>