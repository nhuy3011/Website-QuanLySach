
<?php
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

// Ensure $book is defined or passed to the view
if (!isset($book)) {
    throw new Exception('The variable $book is not defined.');
}

// Ensure $categories is defined or passed to the view
$categories = $categories ?? [];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin sách</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        body { background: #f4f6f9; }
        .form-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.06);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= e(DOMAIN) ?>">
            <i class="bi bi-book-half me-2"></i>QUẢN LÝ SÁCH THƯ VIỆN
        </a>
    </div>
</nav>

<div class="container py-4">

    <div class="mb-4">
        <a href="<?= e(DOMAIN) ?>" class="text-decoration-none">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>
        <h3 class="fw-bold mt-3">Sửa thông tin sách</h3>
        <p class="text-secondary">
            Đang chỉnh sửa sách mã <?= (int) $book->getId() ?>.
        </p>
    </div>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="card form-card">
        <div class="card-body p-4">

            <form method="POST"
                  action="<?= e(DOMAIN) ?>?controller=book&action=update&id=<?= (int) $book->getId() ?>">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="title" class="form-label">
                            Tên sách <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control"
                               id="title" name="title"
                               maxlength="255"
                               value="<?= e($book->getTitle()) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="author" class="form-label">
                            Tác giả <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control"
                               id="author" name="author"
                               maxlength="150"
                               value="<?= e($book->getAuthor()) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="isbn" class="form-label">Mã ISBN</label>
                        <input type="text" class="form-control"
                               id="isbn" name="isbn" maxlength="30"
                               value="<?= e($book->getIsbn()) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="publisher" class="form-label">
                            Nhà xuất bản
                        </label>
                        <input type="text" class="form-control"
                               id="publisher" name="publisher"
                               maxlength="150"
                               value="<?= e($book->getPublisher()) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="publish_year" class="form-label">
                            Năm xuất bản
                        </label>
                        <input type="number" class="form-control"
                               id="publish_year" name="publish_year"
                               min="1901" max="2155"
                               value="<?= e($book->getPublishYear()) ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label">
                            Thể loại <span class="text-danger">*</span>
                        </label>

                        <select class="form-select"
                                id="category_id" name="category_id" required>
                            <option value="">-- Chọn thể loại --</option>

                            <?php foreach ($categories as $category): ?>
                                <option
                                    value="<?= (int) $category->getId() ?>"
                                    <?= (string) $book->getCategoryId() ===
                                        (string) $category->getId()
                                        ? 'selected' : '' ?>>

                                    <?= e($category->getName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="quantity" class="form-label">
                            Số lượng trong kho
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" class="form-control"
                               id="quantity" name="quantity"
                               min="0" step="1"
                               value="<?= (int) $book->getQuantity() ?>"
                               required>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= e(DOMAIN) ?>"
                       class="btn btn-outline-secondary">
                        Hủy
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Cập nhật
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
