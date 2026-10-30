<?php

session_start();

require_once '../app/config/config.php';

require_once APP_ROOT . '/app/libs/DBConnection.php';

require_once APP_ROOT . '/app/models/Book.php';
require_once APP_ROOT . '/app/models/Category.php';

require_once APP_ROOT . '/app/services/BookService.php';
require_once APP_ROOT . '/app/services/CategoryService.php';

require_once APP_ROOT . '/app/controllers/HomeController.php';
require_once APP_ROOT . '/app/controllers/BookController.php';
require_once APP_ROOT . '/app/controllers/CategoryController.php';

// Lấy controller từ URL
$controller = $_GET['controller'] ?? 'home';

// Lấy action từ URL
$action = $_GET['action'] ?? 'index';

// Lấy mã sách hoặc mã thể loại
$id = $_GET['id'] ?? null;

// Điều hướng controller
switch ($controller) {

    // Trang quản lý sách
    case 'home':
        $homeController = new HomeController();
        $homeController->index();
        break;

    // Chức năng sách
    case 'book':
        $bookController = new BookController();

        switch ($action) {
            case 'add':
                $bookController->add();
                break;

            case 'store':
                $bookController->store();
                break;

            case 'edit':
                $bookController->edit($id);
                break;

            case 'update':
                $bookController->update($id);
                break;

            case 'delete':
                $bookController->delete($id);
                break;

            case 'destroy':
                $bookController->destroy($id);
                break;

            default:
                header('Location: ' . DOMAIN);
                exit;
        }
        break;

    // Chức năng thể loại
    case 'category':
        $categoryController = new CategoryController();

        switch ($action) {
            case 'index':
                $categoryController->index();
                break;

            case 'add':
                $categoryController->add();
                break;

            case 'store':
                $categoryController->store();
                break;

            case 'edit':
                $categoryController->edit($id);
                break;

            case 'update':
                $categoryController->update($id);
                break;

            case 'delete':
                $categoryController->delete($id);
                break;

            case 'destroy':
                $categoryController->destroy($id);
                break;

            default:
                header('Location: ' . DOMAIN . '?controller=category');
                exit;
        }
        break;

    default:
        header('Location: ' . DOMAIN);
        exit;
}

?>