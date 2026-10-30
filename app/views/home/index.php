
<?php
// Hàm chuyển dữ liệu thành HTML an toàn khi hiển thị
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Lấy thông báo từ session rồi xóa để không hiện lại khi tải trang
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$keyword = $_GET['keyword'] ?? '';
$categoryId = $_GET['category_id'] ?? '';

// Fetch categories from the database or define a default value
$categories = $categories ?? [];

// Define $totalBooks with a default value or fetch it from the database
$totalBooks = $totalBooks ?? 0;
$totalQuantity = $totalQuantity ?? 0; // Define $totalQuantity with a default value
$outOfStock = $outOfStock ?? 0; // Define $outOfStock with a default value
$books = $books ?? []; // Define $books with a default value
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý sách thư viện</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .main-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table th {
            white-space: nowrap;
            background-color: #f0f3f7;
        }

        .book-title {
            font-weight: 600;
        }
    </style>
</head>

<body>

<!-- Thanh điều hướng -->
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="<?= e(DOMAIN) ?>">
            <i class="bi bi-book-half me-2"></i>
            QUẢN LÝ SÁCH THƯ VIỆN
        </a>

        <span class="text-white">
            <i class="bi bi-person-workspace me-1"></i>
            Hệ thống dành cho thủ thư
        </span>
    </div>
</nav>

<div class="container-fluid px-4 py-4">

    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">Quản lý kho sách</h3>
            <p class="text-secondary mb-0">
                Theo dõi, tìm kiếm và cập nhật thông tin sách trong thư viện.
            </p>
        </div>

        <a href="<?= e(DOMAIN) ?>?controller=book&action=add"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Thêm sách mới
        </a>
    </div>

    <!-- Thông báo -->
    <?php if ($success !== ''): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= e($success) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= e($error) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Thống kê -->
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-1">Tổng đầu sách</p>
                        <h3 class="fw-bold mb-0"><?= (int) $totalBooks ?></h3>
                    </div>
                    <i class="bi bi-journal-bookmark text-primary fs-1"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-1">Tổng số quyển trong kho</p>
                        <h3 class="fw-bold mb-0"><?= (int) $totalQuantity ?></h3>
                    </div>
                    <i class="bi bi-box-seam text-success fs-1"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-secondary mb-1">Đầu sách đã hết</p>
                        <h3 class="fw-bold mb-0"><?= (int) $outOfStock ?></h3>
                    </div>
                    <i class="bi bi-exclamation-circle text-danger fs-1"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- Khu vực tìm kiếm và lọc -->
    <div class="card main-card mb-4">
        <div class="card-body">
            <form method="GET" action="<?= e(DOMAIN) ?>"
                  class="row g-3 align-items-end">

                <input type="hidden" name="controller" value="home">
                <input type="hidden" name="action" value="index">

                <div class="col-md-6">
                    <label for="keyword" class="form-label">
                        Tìm kiếm sách
                    </label>

                    <input type="text"
                           class="form-control"
                           id="keyword"
                           name="keyword"
                           placeholder="Nhập tên sách, tác giả hoặc ISBN..."
                           value="<?= e($keyword) ?>">
                </div>

                <div class="col-md-4">
                    <label for="category_id" class="form-label">
                        Phân loại thể loại
                    </label>

                    <select class="form-select"
                            id="category_id"
                            name="category_id">

                        <option value="">Tất cả thể loại</option>

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

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search me-1"></i>Tìm
                    </button>

                    <a href="<?= e(DOMAIN) ?>"
                       class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Danh sách sách -->
    <div class="card main-card">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-list-ul me-2"></i>
                Danh sách sách trong kho
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="ps-3">Mã</th>
                            <th>Tên sách</th>
                            <th>Tác giả</th>
                            <th>Thể loại</th>
                            <th>Nhà xuất bản</th>
                            <th>Năm XB</th>
                            <th class="text-center">Số lượng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($books)): ?>

                            <tr>
                                <td colspan="9"
                                    class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Không tìm thấy sách phù hợp.
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($books as $book): ?>

                                <tr>
                                    <td class="ps-3">
                                        <?= (int) $book['id'] ?>
                                    </td>

                                    <td>
                                        <span class="book-title">
                                            <?= e($book['title']) ?>
                                        </span>

                                        <?php if (!empty($book['isbn'])): ?>
                                            <div class="small text-secondary">
                                                ISBN: <?= e($book['isbn']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= e($book['author']) ?></td>

                                    <td>
                                        <span class="badge text-bg-info">
                                            <?= e($book['category_name']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= e($book['publisher'] ?: '—') ?>
                                    </td>

                                    <td>
                                        <?= e($book['publish_year'] ?: '—') ?>
                                    </td>

                                    <td class="text-center fw-bold">
                                        <?= (int) $book['quantity'] ?>
                                    </td>

                                    <td>
                                        <?php if ((int) $book['quantity'] > 0): ?>
                                            <span class="badge text-bg-success">
                                                Còn sách
                                            </span>
                                        <?php else: ?>
                                            <span class="badge text-bg-danger">
                                                Hết sách
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center text-nowrap">
                                        <a href="<?= e(DOMAIN) ?>?controller=book&action=edit&id=<?= (int) $book['id'] ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Sửa sách">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= e(DOMAIN) ?>?controller=book&action=delete&id=<?= (int) $book['id'] ?>"
                                           class="btn btn-sm btn-outline-danger"
                                           title="Xóa sách">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>
            </div>
        </div>

        <div class="card-footer bg-white text-secondary small">
            Hiển thị <?= count($books) ?> kết quả.
            Số liệu thống kê phía trên tính trên toàn bộ kho sách.
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
