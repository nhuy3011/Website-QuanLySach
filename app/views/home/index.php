<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Quản lý sách</title>
</head>
<body>
    <h2>Danh sách Sách</h2>
    
    <!-- Form Tìm kiếm và Lọc -->
    <form method="GET" action="index.php">
        <input type="text" name="keyword" placeholder="Tìm tên sách..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
        
        <select name="category_id">
            <option value="">Tất cả thể loại</option>
            <!-- Giả sử ID 1, 2, 3 là các thể loại có trong CSDL -->
            <option value="1" <?= (isset($_GET['category_id']) && $_GET['category_id'] == '1') ? 'selected' : '' ?>>Tiểu thuyết</option>
            <option value="2" <?= (isset($_GET['category_id']) && $_GET['category_id'] == '2') ? 'selected' : '' ?>>Khoa học</option>
        </select>
        
        <button type="submit">Tìm / Lọc</button>
    </form>

    <hr>

    <!-- Hiển thị danh sách sách -->
    <div class="book-list">
        <?php if (!empty($books)): ?>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li>
                        <strong><?= htmlspecialchars($book['title']) ?></strong> 
                        (Tác giả: <?= htmlspecialchars($book['author']) ?>) - 
                        Giá: <?= number_format($book['price']) ?> VNĐ
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Không tìm thấy sách nào phù hợp.</p>
        <?php endif; ?>
    </div>
</body>
</html>