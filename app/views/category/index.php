
<?php

// Tiêu đề trang
$pageTitle = 'Quản lý thể loại';

// Đánh dấu menu đang được chọn
$activeMenu = 'category';

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề và nút thêm thể loại -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="fw-bold mb-2">Quản lý thể loại</h2>

        <p class="text-secondary mb-0">
            Quản lý các thể loại sách trong thư viện.
        </p>
    </div>

    <a href="<?= DOMAIN ?>?controller=category&action=add"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Thêm thể loại

    </a>

</div>


<!-- Thông báo thành công -->
<?php if (isset($_SESSION['success'])): ?>

    <div class="alert alert-success alert-dismissible fade show">

        <?= e($_SESSION['success']) ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<!-- Thông báo lỗi -->
<?php if (isset($_SESSION['error'])): ?>

    <div class="alert alert-danger alert-dismissible fade show">

        <?= e($_SESSION['error']) ?>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>


<?php
// Ensure $categories is defined as an empty array if not already set
$categories = $categories ?? [];
?>

<!-- Bảng danh sách thể loại -->
<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="fw-bold mb-0">
                <i class="bi bi-tags text-primary me-2"></i>
                Danh sách thể loại
            </h5>

            <span class="text-secondary">
                Tổng số: <?= count($categories) ?> thể loại
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>
                        <th width="80">Mã</th>
                        <th>Tên thể loại</th>
                        <th>Mô tả</th>
                        <th width="180" class="text-center">Thao tác</th>
                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($categories)): ?>

                        <?php foreach ($categories as $category): ?>

                            <tr>

                                <!-- Mã thể loại -->
                                <td>
                                    <?= e($category->getId()) ?>
                                </td>

                                <!-- Tên thể loại -->
                                <td class="fw-semibold">
                                    <?= e($category->getName()) ?>
                                </td>

                                <!-- Mô tả -->
                                <td>
                                    <?= e($category->getDescription() ?? '') ?>
                                </td>

                                <!-- Các nút thao tác -->
                                <td class="text-center">

                                    <!-- Nút sửa -->
                                    <a href="<?= DOMAIN ?>?controller=category&action=edit&id=<?= e($category->getId()) ?>"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Sửa">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <!-- Nút xóa -->
                                    <a href="<?= DOMAIN ?>?controller=category&action=delete&id=<?= e($category->getId()) ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       title="Xóa">

                                        <i class="bi bi-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="4" class="text-center py-4 text-secondary">

                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                Chưa có thể loại sách nào.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<?php

// Nạp giao diện cuối trang
include APP_ROOT . '/app/views/layouts/footer.php';

?>
