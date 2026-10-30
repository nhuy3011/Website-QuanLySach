
<?php
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';

// Assuming $book is passed to the view, initialize it here for demonstration
$book = $book ?? (object) [
    'getId' => fn() => 0,
    'getTitle' => fn() => 'Unknown Title',
    'getAuthor' => fn() => 'Unknown Author',
    'getQuantity' => fn() => 0,
];

unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận xóa sách</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= e(DOMAIN) ?>">
            <i class="bi bi-book-half me-2"></i>QUẢN LÝ SÁCH THƯ VIỆN
        </a>
    </div>
</nav>

<div class="container py-5">

    <?php if ($success !== ''): ?>
        <div class="alert alert-success"><?= e($success) ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm mx-auto" style="max-width: 650px;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <i class="bi bi-exclamation-triangle text-danger"
                   style="font-size: 3rem;"></i>

                <h3 class="fw-bold mt-3">Xác nhận xóa sách</h3>

                <p class="text-secondary">
                    Bạn có chắc chắn muốn xóa sách này khỏi kho không?
                </p>
            </div>

            <div class="bg-light rounded p-3 mb-4">
                <p class="mb-2">
                    <strong>Mã sách:</strong>
                    <?= (int) $book->getId() ?>
                </p>

                <p class="mb-2">
                    <strong>Tên sách:</strong>
                    <?= e($book->getTitle()) ?>
                </p>

                <p class="mb-2">
                    <strong>Tác giả:</strong>
                    <?= e($book->getAuthor()) ?>
                </p>

                <p class="mb-0">
                    <strong>Số lượng trong kho:</strong>
                    <?= (int) $book->getQuantity() ?>
                </p>
            </div>

            <div class="alert alert-warning">
                Thao tác xóa sẽ loại bỏ bản ghi sách khỏi database.
                Hãy kiểm tra kỹ trước khi xác nhận.
            </div>

            <form method="POST"
                  action="<?= e(DOMAIN) ?>?controller=book&action=destroy&id=<?= (int) $book->getId() ?>">

                <div class="d-flex justify-content-center gap-2">
                    <a href="<?= e(DOMAIN) ?>"
                       class="btn btn-outline-secondary">
                        Hủy, quay lại
                    </a>

                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Bạn chắc chắn muốn xóa sách này?')">
                        <i class="bi bi-trash me-1"></i> Xác nhận xóa
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>
