
<?php

session_start();

// Nạp file cấu hình
require_once '../app/config/config.php';

// Nạp kết nối cơ sở dữ liệu
require_once APP_ROOT . '/app/libs/DBConnection.php';

// Nạp Model
require_once APP_ROOT . '/app/models/Book.php';
require_once APP_ROOT . '/app/models/Category.php';

// Nạp Service
require_once APP_ROOT . '/app/services/BookService.php';
require_once APP_ROOT . '/app/services/CategoryService.php';

// Nạp Controller
require_once APP_ROOT . '/app/controllers/HomeController.php';
require_once APP_ROOT . '/app/controllers/BookController.php';
require_once APP_ROOT . '/app/controllers/CategoryController.php';

// Lấy controller từ URL
$controller = $_GET['controller'] ?? 'home';

// Lấy action từ URL
$action = $_GET['action'] ?? 'index';

// Lấy ID sách hoặc ID thể loại
$id = $_GET['id'] ?? null;


// ================= ĐIỀU HƯỚNG =================

switch ($controller) {

    // ================= TRANG TỔNG QUAN =================
    case 'home':

        $homeController = new HomeController();
        $homeController->index();

        break;


    // ================= QUẢN LÝ SÁCH =================
    case 'book':

        $bookController = new BookController();

        switch ($action) {

            // Hiển thị danh sách sách
            case 'index':
                $bookController->index();
                break;

            // Hiển thị form thêm sách
            case 'add':
                $bookController->add();
                break;

            // Xử lý thêm sách
            case 'store':
                $bookController->store();
                break;

            // Hiển thị form sửa sách
            case 'edit':
                $bookController->edit($id);
                break;

            // Xử lý cập nhật sách
            case 'update':
                $bookController->update($id);
                break;

            // Hiển thị trang xác nhận xóa
            case 'delete':
                $bookController->delete($id);
                break;

            // Thực hiện xóa sách
            case 'destroy':
                $bookController->destroy($id);
                break;

            // Mặc định hiển thị danh sách sách
            default:
                $bookController->index();
                break;
        }

        break;


    // ================= QUẢN LÝ THỂ LOẠI =================
    case 'category':

        $categoryController = new CategoryController();

        switch ($action) {

            // Hiển thị danh sách thể loại
            case 'index':
                $categoryController->index();
                break;

            // Hiển thị form thêm thể loại
            case 'add':
                $categoryController->add();
                break;

            // Xử lý thêm thể loại
            case 'store':
                $categoryController->store();
                break;

            // Hiển thị form sửa thể loại
            case 'edit':
                $categoryController->edit($id);
                break;

            // Xử lý cập nhật thể loại
            case 'update':
                $categoryController->update($id);
                break;

            // Hiển thị trang xác nhận xóa
            case 'delete':
                $categoryController->delete($id);
                break;

            // Thực hiện xóa thể loại
            case 'destroy':
                $categoryController->destroy($id);
                break;

            // Mặc định hiển thị danh sách thể loại
            default:
                $categoryController->index();
                break;
        }

        break;


    // ================= CONTROLLER KHÔNG HỢP LỆ =================
    default:

        header('Location: ' . DOMAIN);
        exit;
}

?>
