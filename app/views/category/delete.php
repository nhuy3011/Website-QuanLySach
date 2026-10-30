
<?php
function e($value)
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

// Ensure $category and $bookCount are defined before rendering the view
$category = $category ?? null;
$bookCount = $bookCount ?? 0;

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Xóa thể loại</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card border-0 shadow-sm mx-auto"
         style="max-width: 600px;">

        <div class="card-body p-4">

            <h3 class="fw-bold text-danger mb-3">
                <i class="bi bi-exclamation-triangle"></i>
                Xác nhận xóa thể loại
            </h3>

            <p>Bạn có chắc chắn muốn xóa thể loại này không?</p>

            <div class="bg-light rounded p-3 mb-3">

            <p>
                <strong>Mã thể loại:</strong>
                <?= $category ? (int)$category->getId() : 'N/A' ?>
                </p>

                <p>
                    <strong>Tên thể loại:</strong>
                    <?= $category ? e($category->getName()) : 'N/A' ?>
                </p>

                <p class="mb-0">
                    <strong>Số sách thuộc thể loại:</strong>
                    <?= (int)$bookCount ?>
                </p>

            </div>

            <?php if ($bookCount > 0): ?>

                <div class="alert alert-warning">
                    Không thể xóa thể loại này vì vẫn còn
                    <?= (int)$bookCount ?> sách đang thuộc thể loại.

                    Hãy chuyển các sách sang thể loại khác trước.
                </div>

                <div class="text-end">
                    <a href="<?= e(DOMAIN) ?>?controller=category"
                       class="btn btn-secondary">
                        Quay lại
                    </a>
                </div>

            <?php else: ?>

                <div class="alert alert-danger">
                    Sau khi xóa, thể loại sẽ không còn trong hệ thống.
                </div>

                <form method="POST"
                      action="<?= e(DOMAIN) ?>?controller=category&action=destroy&id=<?= (int)$category->getId() ?>">

                    <div class="d-flex justify-content-end gap-2">

                        <a href="<?= e(DOMAIN) ?>?controller=category"
                           class="btn btn-secondary">
                            Hủy
                        </a>

                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                            Xác nhận xóa
                        </button>

                    </div>

                </form>

            <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>
