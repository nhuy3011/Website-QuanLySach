
<?php

function e($value)
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

// Initialize $categories as an empty array if not already defined
$categories = $categories ?? [];

unset($_SESSION['success'], $_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Quản lý thể loại</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<!-- Thanh điều hướng -->
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid px-4">

        <a class="navbar-brand fw-bold" href="<?= e(DOMAIN) ?>">
            <i class="bi bi-book-half me-2"></i>
            QUẢN LÝ SÁCH THƯ VIỆN
        </a>

        <div class="d-flex gap-2">

            <a href="<?= e(DOMAIN) ?>"
               class="btn btn-outline-light">
                <i class="bi bi-book me-1"></i>
                Quản lý sách
            </a>

            <a href="<?= e(DOMAIN) ?>?controller=category"
               class="btn btn-light text-primary">
                <i class="bi bi-tags me-1"></i>
                Quản lý thể loại
            </a>

        </div>

    </div>
</nav>

<div class="container py-4">

    <!-- Tiêu đề -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold">Quản lý thể loại sách</h3>

            <p class="text-secondary mb-0">
                Thêm, chỉnh sửa và quản lý các thể loại sách.
            </p>
        </div>

        <a href="<?= e(DOMAIN) ?>?controller=category&action=add"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>
            Thêm thể loại

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

    <!-- Danh sách thể loại -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-tags me-2"></i>
                Danh sách thể loại
            </h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Mã thể loại</th>
                            <th>Tên thể loại</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($categories)): ?>

                            <tr>
                                <td colspan="5"
                                    class="text-center py-4 text-secondary">
                                    Chưa có thể loại nào.
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($categories as $category): ?>

                                <tr>

                                    <td class="ps-3">
                                        <?= (int)$category->getId() ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= e($category->getName()) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= e($category->getDescription()) ?>
                                    </td>

                                    <td>
                                        <?= e($category->getCreatedAt()) ?>
                                    </td>

                                    <td class="text-center text-nowrap">

                                        <a href="<?= e(DOMAIN) ?>?controller=category&action=edit&id=<?= (int)$category->getId() ?>"
                                           class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <a href="<?= e(DOMAIN) ?>?controller=category&action=delete&id=<?= (int)$category->getId() ?>"
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

        <div class="card-footer bg-white text-secondary">
            Tổng số thể loại: <?= count($categories) ?>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
