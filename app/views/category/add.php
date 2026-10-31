
<?php

// Tiêu đề trang
$pageTitle = 'Thêm thể loại';

// Đánh dấu menu đang được chọn
$activeMenu = 'category';

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề trang -->
<div class="mb-4">

    <h2 class="fw-bold mb-2">Thêm thể loại sách</h2>

    <p class="text-secondary mb-0">
        Nhập thông tin để thêm thể loại mới vào hệ thống.
    </p>

</div>


<!-- Form thêm thể loại -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-4">
            <i class="bi bi-tags text-primary me-2"></i>
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


        <form action="<?= DOMAIN ?>?controller=category&action=store"
              method="POST">

            <!-- Tên thể loại -->
            <div class="mb-3">

                <label for="name" class="form-label fw-semibold">
                    Tên thể loại <span class="text-danger">*</span>
                </label>

                <input type="text"
                       class="form-control"
                       id="name"
                       name="name"
                       maxlength="100"
                       placeholder="Ví dụ: Văn học, Khoa học, Lịch sử..."
                       required>

                <div class="form-text">
                    Tên thể loại không được để trống và tối đa 100 ký tự.
                </div>

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
                          maxlength="255"
                          placeholder="Nhập mô tả về thể loại sách..."></textarea>

            </div>


            <!-- Nút thao tác -->
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-plus-circle me-1"></i>
                    Thêm thể loại

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
