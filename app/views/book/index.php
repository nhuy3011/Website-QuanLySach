
<?php
// Tiêu đề trang
$pageTitle = 'Quản lý sách';

// Đánh dấu menu Quản lý sách đang được chọn
$activeMenu = 'book';

// Đảm bảo các biến luôn tồn tại
$books = $books ?? [];
$categories = $categories ?? [];
$keyword = $keyword ?? '';
$categoryId = $categoryId ?? '';

// Lấy thông báo từ Session
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

// Xóa thông báo sau khi lấy
unset($_SESSION['success']);
unset($_SESSION['error']);

// Gọi layout header chung
include APP_ROOT . '/app/views/layouts/header.php';
?>

<!-- TIÊU ĐỀ TRANG -->
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h2 class="fw-bold mb-2">
            Quản lý kho sách
        </h2>

        <p class="text-secondary mb-0">
            Theo dõi và quản lý thông tin sách trong thư viện.
        </p>
    </div>

    <!-- Nút thêm sách -->
    <a href="<?= e(DOMAIN) ?>?controller=book&action=add"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Thêm sách mới

    </a>

</div>

<!-- THÔNG BÁO THÀNH CÔNG -->
<?php if ($success !== ''): ?>
    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle me-2"></i>
        <?= e($success) ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>
<?php endif; ?>

<!-- THÔNG BÁO LỖI -->
<?php if ($error !== ''): ?>
    <div class="alert alert-danger alert-dismissible fade show">

        <i class="bi bi-exclamation-circle me-2"></i>
        <?= e($error) ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>
<?php endif; ?>

<!-- KHU VỰC TÌM KIẾM VÀ LỌC -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-body p-4">

        <form method="GET" action="<?= e(DOMAIN) ?>">

            <!-- Xác định controller -->
            <input type="hidden"
                   name="controller"
                   value="book">

            <div class="row g-3 align-items-end">

                <!-- Tìm kiếm theo tên sách hoặc tác giả -->
                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Tìm kiếm sách
                    </label>

                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Nhập tên sách hoặc tác giả..."
                           value="<?= e($keyword) ?>">

                </div>

                <!-- Lọc theo thể loại -->
                <div class="col-md-4">

                    <label class="form-label fw-semibold">
                        Thể loại
                    </label>

                    <select name="category_id" class="form-select">

                        <option value="">
                            Tất cả thể loại
                        </option>

                        <?php foreach ($categories as $category): ?>

                            <option
                                value="<?= (int) $category->getId() ?>"
                                <?= (string) $categoryId ===
                                    (string) $category->getId()
                                    ? 'selected' : '' ?>>

                                <?= e($category->getName()) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <!-- Nút tìm kiếm và làm mới -->
                <div class="col-md-2 d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary flex-grow-1">

                        <i class="bi bi-search"></i>
                        Tìm

                    </button>

                    <a href="<?= e(DOMAIN) ?>?controller=book"
                       class="btn btn-outline-secondary"
                       title="Làm mới">

                        <i class="bi bi-arrow-counterclockwise"></i>

                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- DANH SÁCH SÁCH -->
<div class="card border-0 shadow-sm">

    <!-- Tiêu đề bảng -->
    <div class="card-header bg-white py-3">

        <h5 class="fw-bold mb-0">

            <i class="bi bi-list-ul text-primary me-2"></i>
            Danh sách sách trong kho

        </h5>

    </div>

    <!-- Bảng dữ liệu -->
    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th class="px-3">Mã sách</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Thể loại</th>
                    <th>Giá sách</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Thao tác</th>
                </tr>

            </thead>

            <tbody>

                <?php if (empty($books)): ?>

                    <!-- Không có sách phù hợp -->
                    <tr>
                        <td colspan="8"
                            class="text-center text-secondary py-5">

                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                            Không tìm thấy sách nào.

                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($books as $book): ?>

                        <tr>

                            <!-- Mã sách -->
                            <td class="px-3">
                                <?= (int) $book['id'] ?>
                            </td>

                            <!-- Tên sách và mô tả -->
                            <td>

                                <div class="fw-bold">
                                    <?= e($book['title']) ?>
                                </div>

                                <?php if (!empty($book['description'])): ?>

                                    <small class="text-secondary">
                                        <?= e($book['description']) ?>
                                    </small>

                                <?php endif; ?>

                            </td>

                            <!-- Tác giả -->
                            <td>
                                <?= e($book['author']) ?>
                            </td>

                            <!-- Thể loại -->
                            <td>

                                <?php if (!empty($book['category_name'])): ?>

                                    <span class="badge bg-info text-dark">
                                        <?= e($book['category_name']) ?>
                                    </span>

                                <?php else: ?>

                                    <span class="text-secondary">
                                        Chưa phân loại
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Giá sách -->
                            <td>
                                <?= number_format((float) $book['price'], 0, ',', '.') ?> đ
                            </td>

                            <!-- Số lượng -->
                            <td class="text-center fw-bold">
                                <?= (int) $book['quantity'] ?>
                            </td>

                            <!-- Trạng thái sách -->
                            <td class="text-center">

                                <?php if ((int) $book['quantity'] <= 0): ?>

                                    <span class="badge bg-danger">
                                        Hết sách
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-success">
                                        Còn sách
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- Các nút thao tác -->
                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Nút sửa -->
                                    <a href="<?= e(DOMAIN) ?>?controller=book&action=edit&id=<?= (int) $book['id'] ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Sửa sách">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <!-- Nút xóa -->
                                    <a href="<?= e(DOMAIN) ?>?controller=book&action=delete&id=<?= (int) $book['id'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Xóa sách">

                                        <i class="bi bi-trash"></i>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <!-- Chân bảng -->
    <div class="card-footer bg-white text-secondary">

        Hiển thị <?= count($books) ?> kết quả.

    </div>

</div>

<?php
// Gọi layout footer chung
include APP_ROOT . '/app/views/layouts/footer.php';
?>
