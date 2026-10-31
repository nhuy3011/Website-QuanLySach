
<?php
// Tiêu đề trang
$pageTitle = 'Tổng quan';

// Xác định menu đang được chọn
$activeMenu = 'home';

// Đảm bảo các biến thống kê luôn có giá trị
$totalBooks = $totalBooks ?? 0;
$totalQuantity = $totalQuantity ?? 0;
$outOfStock = $outOfStock ?? 0;

// Gọi layout header chung
include APP_ROOT . '/app/views/layouts/header.php';
?>

<!-- TIÊU ĐỀ TRANG -->
<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

    <div>
        <h2 class="fw-bold mb-2">
            Tổng quan thư viện
        </h2>

        <p class="text-secondary mb-0">
            Theo dõi tình hình sách trong kho thư viện.
        </p>
    </div>

    <a href="<?= e(DOMAIN) ?>?controller=book&action=add"
       class="btn btn-primary">

        <i class="bi bi-plus-circle me-1"></i>
        Thêm sách mới

    </a>

</div>

<!-- CÁC THẺ THỐNG KÊ -->
<div class="row g-4 mb-4">

    <!-- Tổng đầu sách -->
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-secondary mb-2">
                            Tổng đầu sách
                        </p>

                        <h2 class="fw-bold mb-0">
                            <?= number_format((int) $totalBooks) ?>
                        </h2>
                    </div>

                    <i class="bi bi-journal-bookmark text-primary"
                       style="font-size: 45px;"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Tổng số quyển trong kho -->
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-secondary mb-2">
                            Tổng số quyển trong kho
                        </p>

                        <h2 class="fw-bold mb-0">
                            <?= number_format((int) $totalQuantity) ?>
                        </h2>
                    </div>

                    <i class="bi bi-box-seam text-success"
                       style="font-size: 45px;"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Sách hết hàng -->
    <div class="col-md-4">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <p class="text-secondary mb-2">
                            Đầu sách đã hết
                        </p>

                        <h2 class="fw-bold mb-0 text-danger">
                            <?= number_format((int) $outOfStock) ?>
                        </h2>
                    </div>

                    <i class="bi bi-exclamation-circle text-danger"
                       style="font-size: 45px;"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- KHU VỰC GIỚI THIỆU CHỨC NĂNG -->
<div class="card border-0 shadow-sm">

    <div class="card-body p-4">

        <h5 class="fw-bold mb-3">
            <i class="bi bi-info-circle text-primary me-2"></i>
            Hệ thống quản lý sách thư viện
        </h5>

        <p class="text-secondary">
            Hệ thống hỗ trợ quản lý thông tin sách, thể loại sách
            và số lượng sách còn trong kho. Người quản lý có thể
            thêm mới, chỉnh sửa, xóa, tìm kiếm và phân loại sách
            một cách thuận tiện.
        </p>

        <hr>

        <div class="d-flex flex-wrap gap-2">

            <a href="<?= e(DOMAIN) ?>?controller=book"
               class="btn btn-primary">

                <i class="bi bi-book me-1"></i>
                Đi đến quản lý sách

            </a>

            <a href="<?= e(DOMAIN) ?>?controller=category"
               class="btn btn-outline-primary">

                <i class="bi bi-tags me-1"></i>
                Quản lý thể loại

            </a>

        </div>

    </div>

</div>

<?php
// Gọi layout footer chung
include APP_ROOT . '/app/views/layouts/footer.php';
?>
