
<?php
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Ensure $book is defined or passed to the view
if (!isset($book)) {
    die('Error: Book data is not available.');
}
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

    <div class="card border-0 shadow-sm mx-auto"
         style="max-width: 650px;">

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

                <p>
                    <strong>Mã sách:</strong>
                    <?= (int) $book->getId() ?>
                </p>

                <p>
                    <strong>Tên sách:</strong>
                    <?= e($book->getTitle()) ?>
                </p>

                <p>
                    <strong>Tác giả:</strong>
                    <?= e($book->getAuthor()) ?>
                </p>

                <p>
                    <strong>Giá sách:</strong>
                    <?= number_format((float) $book->getPrice(), 0, ',', '.') ?> đ
                </p>

                <p class="mb-0">
                    <strong>Số lượng:</strong>
                    <?= (int) $book->getQuantity() ?>
                </p>

            </div>

            <div class="alert alert-warning">
                Sau khi xác nhận, thông tin sách sẽ bị xóa khỏi database.
                Thao tác này không thể tự động hoàn tác.
            </div>

            <form method="POST"
                  action="<?= e(DOMAIN) ?>?controller=book&action=destroy&id=<?= (int) $book->getId() ?>">

                <div class="d-flex justify-content-center gap-2">

                    <a href="<?= e(DOMAIN) ?>"
                       class="btn btn-outline-secondary">
                        Hủy
                    </a>

                    <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Bạn chắc chắn muốn xóa sách này?')">

                        <i class="bi bi-trash me-1"></i>
                        Xác nhận xóa

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
