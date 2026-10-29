<?php
class HomeController {
    private $bookService;

    public function __construct($bookService) {
        $this->bookService = $bookService;
    }

    public function index() {
        // Lấy tham số từ URL
        $keyword = $_GET['keyword'] ?? '';
        $categoryId = $_GET['category_id'] ?? '';

        // Xử lý logic tìm kiếm hoặc lọc
        if (!empty($keyword)) {
            $books = $this->bookService->search($keyword);
        } elseif (!empty($categoryId)) {
            $books = $this->bookService->filter($categoryId);
        } else {
            // Mặc định gọi getAll (thông qua search rỗng)
            $books = $this->bookService->search(''); 
        }

        // Gọi View và truyền mảng $books sang
        require_once 'views/home/index.php';
    }
}
?>