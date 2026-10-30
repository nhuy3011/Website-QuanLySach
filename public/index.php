
<?php

// Khởi tạo session để lưu thông báo thành công hoặc lỗi
session_start();

// Nạp file cấu hình
require_once '../app/config/config.php';

// Nạp các Controller
require_once APP_ROOT . '/app/controllers/HomeController.php';
require_once APP_ROOT . '/app/controllers/BookController.php';

// Nhận controller từ URL, mặc định là home
$controller = $_GET['controller'] ?? 'home';

// Nhận action từ URL, mặc định là index
$action = $_GET['action'] ?? 'index';

// Nhận mã sách nếu có
$id = $_GET['id'] ?? null;

// Điều hướng Controller
switch ($controller) {

    // Trang chủ: danh sách và tìm kiếm sách
    case 'home':
        $homeController = new HomeController();

        if ($action === 'index') {
            $homeController->index();
        } else {
            http_response_code(404);
            echo "Không tìm thấy chức năng.";
        }
        break;

    // Các chức năng quản lý sách
    case 'book':
        $bookController = new BookController();

        switch ($action) {

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
                if ($id !== null && ctype_digit((string) $id)) {
                    $bookController->edit((int) $id);
                } else {
                    header('Location: ' . DOMAIN);
                    exit;
                }
                break;

            // Xử lý cập nhật sách
            case 'update':
                if ($id !== null && ctype_digit((string) $id)) {
                    $bookController->update((int) $id);
                } else {
                    header('Location: ' . DOMAIN);
                    exit;
                }
                break;

            // Hiển thị trang xác nhận xóa
            case 'delete':
                if ($id !== null && ctype_digit((string) $id)) {
                    $bookController->delete((int) $id);
                } else {
                    header('Location: ' . DOMAIN);
                    exit;
                }
                break;

            // Thực hiện xóa sách
            case 'destroy':
                if ($id !== null && ctype_digit((string) $id)) {
                    $bookController->destroy((int) $id);
                } else {
                    header('Location: ' . DOMAIN);
                    exit;
                }
                break;

            default:
                http_response_code(404);
                echo "Không tìm thấy chức năng quản lý sách.";
                break;
        }
        break;

    default:
        http_response_code(404);
        echo "Không tìm thấy trang yêu cầu.";
        break;
}

?>
