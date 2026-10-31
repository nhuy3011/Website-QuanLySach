
<?php
/** @var Book $book */
/** @var Category[] $categories */
// Tiêu đề trang
$pageTitle = 'Sửa thông tin sách';

// Đánh dấu menu đang được chọn
$activeMenu = 'book';

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề trang -->
<div class="mb-4">

    <h2 class="fw-bold mb-2">Sửa thông tin sách</h2>

    <p class="text-secondary mb-0">
        Cập nhật thông tin sách trong thư viện.
    </p>

</div>


<!-- Form sửa sách -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-4">
            <i class="bi bi-pencil-square text-primary me-2"></i>
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


        <form action="<?= DOMAIN ?>?controller=book&action=update&id=<?= e($book->getId()) ?>"
              method="POST">

            <div class="row">

                <!-- Mã sách -->
                <div class="col-md-6 mb-3">

                    <label class="form-label fw-semibold">
                        Mã sách
                    </label>

                    <input type="text"
                           class="form-control"
                           value="<?= e($book->getId()) ?>"
                           disabled>

                </div>


                <!-- Tên sách -->
                <div class="col-md-6 mb-3">

                    <label for="title" class="form-label fw-semibold">
                        Tên sách <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           class="form-control"
                           id="title"
                           name="title"
                           value="<?= e($book->getTitle()) ?>"
                           maxlength="200"
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
                           value="<?= e($book->getAuthor()) ?>"
                           maxlength="150"
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

                            <option
                                value="<?= e($category->getId()) ?>"
                                <?= $category->getId() == $book->getCategoryId() ? 'selected' : '' ?>>

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
                           value="<?= e($book->getPrice()) ?>">

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
                           value="<?= e($book->getQuantity()) ?>"
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
                              rows="4"><?= e($book->getDescription() ?? '') ?></textarea>

                </div>

            </div>


            <!-- Nút thao tác -->
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-save me-1"></i>
                    Lưu thay đổi

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
