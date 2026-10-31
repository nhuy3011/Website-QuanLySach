
<?php

// Ensure $category is initialized
if (!isset($category)) {
    // Example initialization, replace with actual logic
    $category = new Category('defaultName', 'defaultDescription'); // Replace with actual default values
}

// Tiêu đề trang
$pageTitle = 'Sửa thể loại';

// Đánh dấu menu đang được chọn
$activeMenu = 'category';

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề trang -->
<div class="mb-4">

    <h2 class="fw-bold mb-2">Sửa thể loại sách</h2>

    <p class="text-secondary mb-0">
        Cập nhật thông tin thể loại sách trong hệ thống.
    </p>

</div>


<!-- Form sửa thể loại -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-4">
            <i class="bi bi-pencil-square text-primary me-2"></i>
            Thông tin thể loại
        </h5>


        <!-- Hiển thị thông báo lỗi -->
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


        <!-- Form cập nhật thể loại -->
        <form action="<?= DOMAIN ?>?controller=category&action=update&id=<?= e($category->getId()) ?>"
              method="POST">

            <!-- Mã thể loại -->
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Mã thể loại
                </label>

                <input type="text"
                       class="form-control"
                       value="<?= e($category->getId()) ?>"
                       disabled>

            </div>


            <!-- Tên thể loại -->
            <div class="mb-3">

                <label for="name" class="form-label fw-semibold">
                    Tên thể loại <span class="text-danger">*</span>
                </label>

                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       value="<?= e($category->getName()) ?>"
                       maxlength="100"
                       required>

            </div>


            <!-- Mô tả -->
            <div class="mb-4">

                <label for="description" class="form-label fw-semibold">
                    Mô tả
                </label>

                <textarea class="form-control"
                          id="description"
                          name="description"
                          rows="4"
                          maxlength="255"><?= e($category->getDescription() ?? '') ?></textarea>

            </div>


            <!-- Nút thao tác -->
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-save me-1"></i>
                    Lưu thay đổi

                </button>

                <a href="<?= DOMAIN ?>?controller=category"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Quay lại

                </a>

            </div>

        </form>

    </div>

</div>


<?php

// Nạp giao diện cuối trang
include APP_ROOT . '/app/views/layouts/footer.php';

?>
