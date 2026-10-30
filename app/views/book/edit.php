
<?php
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

// Ensure $categories is defined and initialized
if (!isset($categories)) {
    // Example initialization, replace with actual logic
    $categories = []; // Assuming categories should be an array
}

// Ensure $book is defined and initialized
if (!isset($book)) {
    // Example initialization, replace with actual logic
    $book = new Book('', '', '', 0, 0, ''); // Replace with actual default values for the 6 arguments
}
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
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= e(DOMAIN) ?>">
            <i class="bi bi-book-half me-2"></i>QUẢN LÝ SÁCH THƯ VIỆN
        </a>
    </div>
</nav>

<div class="container py-4">

    <a href="<?= e(DOMAIN) ?>" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
    </a>

    <h3 class="fw-bold mt-3">Sửa thông tin sách</h3>

    <p class="text-secondary">
        Đang chỉnh sửa sách mã <?= (int) $book->getId() ?>.
    </p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form method="POST"
                  action="<?= e(DOMAIN) ?>?controller=book&action=update&id=<?= (int) $book->getId() ?>">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">
                            Tên sách <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="title"
                               class="form-control"
                               maxlength="200"
                               value="<?= e($book->getTitle()) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Tác giả <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="author"
                               class="form-control"
                               maxlength="150"
                               value="<?= e($book->getAuthor()) ?>"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Thể loại</label>

                        <select name="category_id" class="form-select">

                            <option value="">-- Chưa phân loại --</option>

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
                        <label class="form-label">Giá sách (VNĐ)</label>

                        <input type="number" name="price"
                               class="form-control"
                               min="0" max="999999999999"
                               step="1"
                               value="<?= e($book->getPrice()) ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Số lượng trong kho
                        </label>

                        <input type="number" name="quantity"
                               class="form-control"
                               min="0" step="1"
                               value="<?= (int) $book->getQuantity() ?>"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Mô tả sách</label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="4"><?= e($book->getDescription()) ?></textarea>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">

                    <a href="<?= e(DOMAIN) ?>"
                       class="btn btn-outline-secondary">
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
