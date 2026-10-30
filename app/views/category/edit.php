
<?php
function e($value)
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

// Ensure $category is defined
$category = $category ?? (object)[
    'getId' => fn() => 0,
    'getName' => fn() => '',
    'getDescription' => fn() => ''
];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa thể loại</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= e(DOMAIN) ?>">
            QUẢN LÝ SÁCH THƯ VIỆN
        </a>
    </div>
</nav>

<div class="container py-4">

    <a href="<?= e(DOMAIN) ?>?controller=category"
       class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
    </a>

    <h3 class="fw-bold mt-3">Sửa thể loại</h3>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm mt-3">

        <div class="card-body p-4">

            <form method="POST"
                  action="<?= e(DOMAIN) ?>?controller=category&action=update&id=<?= (int)$category->getId() ?>">

                <div class="mb-3">

                    <label class="form-label">
                        Tên thể loại <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           maxlength="100"
                           value="<?= e($category->getName()) ?>"
                           required>

                </div>

                <div class="mb-3">

                    <label class="form-label">Mô tả</label>

                    <textarea name="description"
                              class="form-control"
                              rows="4"
                              maxlength="255"><?= e($category->getDescription()) ?></textarea>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= e(DOMAIN) ?>?controller=category"
                       class="btn btn-secondary">
                        Hủy
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Cập nhật
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
