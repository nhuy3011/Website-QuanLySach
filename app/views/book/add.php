
<?php

/** @var Category[] $categories */
// Tiêu đề trang
$pageTitle = 'Thêm sách';

// Đánh dấu menu đang được chọn
$activeMenu = 'book';

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề trang -->
<div class="mb-4">

    <h2 class="fw-bold mb-2">Thêm sách mới</h2>

    <p class="text-secondary mb-0">
        Nhập thông tin sách để thêm vào kho thư viện.
    </p>

</div>


<!-- Form thêm sách -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-4">
            <i class="bi bi-book text-primary me-2"></i>
            Thông tin sách
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


        <form action="<?= DOMAIN ?>?controller=book&action=store"
              method="POST">

            <div class="row">

                <!-- Tên sách -->
                <div class="col-md-6 mb-3">

                    <label for="title" class="form-label fw-semibold">
                        Tên sách <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           class="form-control"
                           id="title"
                           name="title"
                           maxlength="200"
                           placeholder="Nhập tên sách"
                           required>

                </div>


                <!-- Tác giả -->
                <div class="col-md-6 mb-3">

                    <label for="author" class="form-label fw-semibold">
                        Tác giả <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           class="form-control"
                           id="author"
                           name="author"
                           maxlength="150"
                           placeholder="Nhập tên tác giả"
                           required>

                </div>


                <!-- Thể loại -->
                <div class="col-md-6 mb-3">

                    <label for="category_id" class="form-label fw-semibold">
                        Thể loại <span class="text-danger">*</span>
                    </label>

                    <select class="form-select"
                            id="category_id"
                            name="category_id"
                            required>

                        <option value="">-- Chọn thể loại --</option>

                        <?php foreach ($categories as $category): ?>

                            <option value="<?= e($category->getId()) ?>">
                                <?= e($category->getName()) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>


                <!-- Giá sách -->
                <div class="col-md-6 mb-3">

                    <label for="price" class="form-label fw-semibold">
                        Giá sách (VNĐ)
                    </label>

                    <input type="number"
                           class="form-control"
                           id="price"
                           name="price"
                           min="0"
                           value="0"
                           placeholder="Nhập giá sách">

                </div>


                <!-- Số lượng -->
                <div class="col-md-6 mb-3">

                    <label for="quantity" class="form-label fw-semibold">
                        Số lượng <span class="text-danger">*</span>
                    </label>

                    <input type="number"
                           class="form-control"
                           id="quantity"
                           name="quantity"
                           min="0"
                           value="0"
                           required>

                </div>


                <!-- Mô tả -->
                <div class="col-12 mb-4">

                    <label for="description" class="form-label fw-semibold">
                        Mô tả sách
                    </label>

                    <textarea class="form-control"
                              id="description"
                              name="description"
                              rows="4"
                              placeholder="Nhập mô tả về nội dung sách..."></textarea>

                </div>

            </div>


            <!-- Nút thao tác -->
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-plus-circle me-1"></i>
                    Thêm sách

                </button>

                <a href="<?= DOMAIN ?>?controller=book"
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
