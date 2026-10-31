
<?php

// Tiêu đề trang
$pageTitle = 'Xóa thể loại';

// Đánh dấu menu đang được chọn
$activeMenu = 'category';

// Kiểm tra và khởi tạo biến $bookCount
$bookCount = $bookCount ?? 0;

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề trang -->
<div class="mb-4">

    <h2 class="fw-bold mb-2">Xóa thể loại sách</h2>

    <p class="text-secondary mb-0">
        Kiểm tra thông tin trước khi thực hiện xóa thể loại.
    </p>

</div>


<!-- Thông báo xác nhận xóa -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <div class="text-center mb-4">

            <i class="bi bi-exclamation-triangle text-danger"
               style="font-size: 55px;">
            </i>

            <h5 class="fw-bold mt-3">
                Bạn có chắc chắn muốn xóa thể loại này?
            </h5>

            <p class="text-secondary">
                Thao tác này sẽ không thể hoàn tác.
            </p>

        </div>


        <!-- Thông tin thể loại -->
        <div class="table-responsive">

            <table class="table table-bordered">

                <tr>
                    <th width="180">Mã thể loại</th>

                    <td>
                        <?= e($category->getId()) ?>
                    </td>
                </tr>

                <tr>
                    <th>Tên thể loại</th>

                    <td class="fw-semibold">
                        <?= e($category->getName()) ?>
                    </td>
                </tr>

                <tr>
                    <th>Mô tả</th>

                    <td>
                        <?= e($category->getDescription() ?? '') ?>
                    </td>
                </tr>

                <tr>
                    <th>Số sách thuộc thể loại</th>

                    <td>
                        <span class="badge bg-info text-dark">
                            <?= (int)$bookCount ?> sách
                        </span>
                    </td>
                </tr>

            </table>

        </div>


        <!-- Kiểm tra thể loại còn sách hay không -->
        <?php if ($bookCount > 0): ?>

            <div class="alert alert-warning">

                <i class="bi bi-exclamation-circle me-2"></i>

                Không thể xóa thể loại này vì vẫn còn
                <?= (int)$bookCount ?> sách thuộc thể loại.

                Bạn cần xử lý các sách thuộc thể loại trước.

            </div>

            <div class="text-end">

                <a href="<?= DOMAIN ?>?controller=category"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Quay lại

                </a>

            </div>

        <?php else: ?>

            <!-- Form xác nhận xóa -->
            <form action="<?= DOMAIN ?>?controller=category&action=destroy&id=<?= e($category->getId()) ?>"
                  method="POST">

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    Thể loại này hiện không có sách. Bạn có thể thực hiện xóa.

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= DOMAIN ?>?controller=category"
                       class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-left me-1"></i>
                        Hủy

                    </a>

                    <button type="submit" class="btn btn-danger">

                        <i class="bi bi-trash me-1"></i>
                        Xác nhận xóa

                    </button>

                </div>

            </form>

        <?php endif; ?>

    </div>

</div>


<?php

// Nạp giao diện cuối trang
include APP_ROOT . '/app/views/layouts/footer.php';

?>
