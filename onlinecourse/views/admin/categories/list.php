<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
    <h2>Quản lý danh mục</h2>

    <h3>Thêm danh mục mới</h3>
    <form method="post">
        <div>
            <label for="name">Tên:</label>
            <input type="text" name="name" id="name" required />
        </div>
        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <button type="submit">Thêm</button>
        </div>
    </form>

    <h3>Danh sách danh mục</h3>
    <?php if (!empty($categories)): ?>
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr><th>ID</th><th>Tên</th><th>Mô tả</th><th>Hành động</th></tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $c): ?>
                <tr>
                    <td><?php echo intval($c['id']); ?></td>
                    <td><?php echo htmlspecialchars($c['name']); ?></td>
                    <td><?php echo htmlspecialchars($c['description']); ?></td>
                    <td>
                        <a href="index.php?controller=admin&action=editCategory&id=<?php echo $c['id']; ?>">Sửa</a>
                        <a href="index.php?controller=admin&action=deleteCategory&id=<?php echo $c['id']; ?>" onclick="return confirm('Xóa danh mục này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có danh mục nào.</p>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
