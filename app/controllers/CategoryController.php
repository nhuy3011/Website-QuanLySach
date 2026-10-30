
<?php

require_once APP_ROOT . '/app/services/CategoryService.php';

class CategoryController
{
    // Hiển thị danh sách thể loại
    public function index()
    {
        $categoryService = new CategoryService();

        // Lấy tất cả thể loại
        $categories = $categoryService->getAllCategories();

        // Hiển thị giao diện
        include APP_ROOT . '/app/views/category/index.php';
    }

    // Hiển thị form thêm thể loại
    public function add()
    {
        include APP_ROOT . '/app/views/category/add.php';
    }

    // Xử lý thêm thể loại
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN . '?controller=category');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        // Kiểm tra tên thể loại
        if ($name === '' || mb_strlen($name) > 100) {
            $_SESSION['error'] = 'Tên thể loại không được để trống và tối đa 100 ký tự.';
            header('Location: ' . DOMAIN . '?controller=category&action=add');
            exit;
        }

        $category = new Category(
            null,
            $name,
            $description
        );

        try {
            $categoryService = new CategoryService();
            $categoryService->addCategory($category);

            $_SESSION['success'] = 'Thêm thể loại thành công.';
            header('Location: ' . DOMAIN . '?controller=category');
            exit;

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Tên thể loại đã tồn tại hoặc không thể thêm.';
            header('Location: ' . DOMAIN . '?controller=category&action=add');
            exit;
        }
    }

    // Hiển thị form sửa thể loại
    public function edit($id)
    {
        $categoryService = new CategoryService();

        $category = $categoryService->getCategoryById($id);

        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy thể loại.';
            header('Location: ' . DOMAIN . '?controller=category');
            exit;
        }

        include APP_ROOT . '/app/views/category/edit.php';
    }

    // Xử lý cập nhật thể loại
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN . '?controller=category');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name === '' || mb_strlen($name) > 100) {
            $_SESSION['error'] = 'Tên thể loại không hợp lệ.';
            header('Location: ' . DOMAIN . '?controller=category&action=edit&id=' . (int)$id);
            exit;
        }

        $categoryService = new CategoryService();

        $category = $categoryService->getCategoryById($id);

        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy thể loại.';
            header('Location: ' . DOMAIN . '?controller=category');
            exit;
        }

        // Cập nhật thông tin
        $category->setName($name);
        $category->setDescription($description);

        try {
            $categoryService->updateCategory($category);

            $_SESSION['success'] = 'Cập nhật thể loại thành công.';
            header('Location: ' . DOMAIN . '?controller=category');
            exit;

        } catch (PDOException $e) {
            $_SESSION['error'] = 'Tên thể loại đã tồn tại hoặc không thể cập nhật.';
            header('Location: ' . DOMAIN . '?controller=category&action=edit&id=' . (int)$id);
            exit;
        }
    }

    // Hiển thị trang xác nhận xóa
    public function delete($id)
    {
        $categoryService = new CategoryService();

        $category = $categoryService->getCategoryById($id);

        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy thể loại.';
            header('Location: ' . DOMAIN . '?controller=category');
            exit;
        }

        // Đếm số sách thuộc thể loại
        $bookCount = $categoryService->countBooksByCategory($id);

        include APP_ROOT . '/app/views/category/delete.php';
    }

    // Xử lý xóa thể loại
    public function destroy($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . DOMAIN . '?controller=category');
            exit;
        }

        $categoryService = new CategoryService();

        if (!$categoryService->getCategoryById($id)) {
            $_SESSION['error'] = 'Không tìm thấy thể loại.';
        } elseif ($categoryService->countBooksByCategory($id) > 0) {
            $_SESSION['error'] = 'Không thể xóa vì thể loại vẫn còn sách.';
        } else {
            try {
                $categoryService->deleteCategory($id);
                $_SESSION['success'] = 'Xóa thể loại thành công.';
            } catch (PDOException $e) {
                $_SESSION['error'] = 'Không thể xóa thể loại.';
            }
        }

        header('Location: ' . DOMAIN . '?controller=category');
        exit;
    }
}

?>
