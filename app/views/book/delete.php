
<?php
/** @var Book $book */
/** @var Category[] $categories */
// Tiêu đề trang
$pageTitle = 'Xóa sách';

// Đánh dấu menu đang được chọn
$activeMenu = 'book';

// Nạp giao diện đầu trang
include APP_ROOT . '/app/views/layouts/header.php';

?>

<!-- Tiêu đề trang -->
<div class="mb-4">

    <h2 class="fw-bold mb-2">Xóa sách</h2>

    <p class="text-secondary mb-0">
        Kiểm tra thông tin sách trước khi thực hiện xóa.
    </p>

</div>


<!-- Thông tin xác nhận xóa -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <div class="text-center mb-4">

            <i class="bi bi-exclamation-triangle text-danger"
               style="font-size: 55px;">
            </i>

            <h5 class="fw-bold mt-3">
                Bạn có chắc chắn muốn xóa sách này?
            </h5>

            <p class="text-secondary">
                Thao tác này sẽ không thể hoàn tác.
            </p>

        </div>


        <!-- Bảng thông tin sách -->
        <div class="table-responsive">

            <table class="table table-bordered">

                <tr>
                    <th width="180">Mã sách</th>
                    <td><?= e($book->getId()) ?></td>
                </tr>

                <tr>
                    <th>Tên sách</th>
                    <td class="fw-semibold"><?= e($book->getTitle()) ?></td>
                </tr>

                <tr>
                    <th>Tác giả</th>
                    <td><?= e($book->getAuthor()) ?></td>
                </tr>

                <tr>
                    <th>Thể loại</th>
                    <td><?= e($book->getTitle()) ?></td>
                </tr>

                <tr>
                    <th>Giá sách</th>
                    <td><?= number_format((float)$book->getPrice(), 0, ',', '.') ?> VNĐ</td>
                </tr>

                <tr>
                    <th>Số lượng</th>
                    <td><?= e($book->getQuantity()) ?></td>
                </tr>

            </table>

        </div>


        <!-- Form xác nhận xóa -->
        <form action="<?= DOMAIN ?>?controller=book&action=destroy&id=<?= e($book->getId()) ?>"
              method="POST">

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-circle me-2"></i>

                Bạn đang chuẩn bị xóa sách khỏi hệ thống.

            </div>

            <div class="d-flex justify-content-end gap-2">

                <a href="<?= DOMAIN ?>?controller=book"
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

    </div>

</div>


<?php

// Nạp giao diện cuối trang
include APP_ROOT . '/app/views/layouts/footer.php';

?>
