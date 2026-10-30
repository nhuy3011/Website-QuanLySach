
<?php
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Lấy thông báo
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

unset($_SESSION['success'], $_SESSION['error']);

$keyword = $_GET['keyword'] ?? '';
$categoryId = $_GET['category_id'] ?? '';
$books = $books ?? []; // Ensure $books is defined as an empty array if not set
$totalQuantity = $totalQuantity ?? 0; // Ensure $totalQuantity is defined as 0 if not set
$totalBooks = $totalBooks ?? 0; // Ensure $totalBooks is defined as 0 if not set
$outOfStock = $outOfStock ?? 0; // Ensure $outOfStock is defined as 0 if not set
$categories = $categories ?? []; // Ensure $categories is defined as an empty array if not set
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý sách thư viện</title>

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

        .stat-card, .main-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }

        .table th {
            white-space: nowrap;
            background-color: #f0f3f7;
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
                Theo dõi và quản lý thông tin sách trong thư viện.
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

    <!-- Tìm kiếm và lọc -->
    <div class="card main-card mb-4">
        <div class="card-body">

            <form method="GET" action="<?= e(DOMAIN) ?>"
                  class="row g-3 align-items-end">

                <input type="hidden" name="controller" value="home">

                <div class="col-md-6">
                    <label class="form-label">Tìm kiếm sách</label>

                    <input type="text"
                           name="keyword"
                           class="form-control"
                           placeholder="Nhập tên sách hoặc tác giả..."
                           value="<?= e($keyword) ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Thể loại</label>

                    <select name="category_id" class="form-select">
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

    <!-- Bảng danh sách sách -->
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
                            <th class="ps-3">Mã sách</th>
                            <th>Tên sách</th>
                            <th>Tác giả</th>
                            <th>Thể loại</th>
                            <th>Giá sách</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($books)): ?>

                            <tr>
                                <td colspan="8"
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
                                        <strong>
                                            <?= e($book['title']) ?>
                                        </strong>

                                        <?php if (!empty($book['description'])): ?>
                                            <div class="small text-secondary">
                                                <?= e($book['description']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= e($book['author']) ?></td>

                                    <td>
                                        <?php if ($book['category_name']): ?>
                                            <span class="badge text-bg-info">
                                                <?= e($book['category_name']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-secondary">
                                                Chưa phân loại
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= number_format((float) $book['price'], 0, ',', '.') ?> đ
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
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= e(DOMAIN) ?>?controller=book&action=delete&id=<?= (int) $book['id'] ?>"
                                           class="btn btn-sm btn-outline-danger">
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
            Thống kê tính trên toàn bộ kho sách.
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
