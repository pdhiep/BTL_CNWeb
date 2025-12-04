<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
    <h2>Sửa danh mục</h2>

    <?php if (!empty($category)): ?>
        <form method="post">
            <div>
                <label for="name">Tên:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($category['name']); ?>" required />
            </div>
            <div>
                <label for="description">Mô tả:</label>
                <textarea name="description" id="description"><?php echo htmlspecialchars($category['description']); ?></textarea>
            </div>
            <div>
                <button type="submit">Lưu</button>
                <a href="index.php?controller=admin&action=categories">Hủy</a>
            </div>
        </form>
    <?php else: ?>
        <p>Danh mục không tồn tại.</p>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
