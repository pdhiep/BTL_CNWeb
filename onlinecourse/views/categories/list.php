<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'admin'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Danh mục khóa học</span>
        <a class="btn btn-primary btn-sm" href="<?php echo BASE_URL; ?>admin/categories/create">+ Thêm danh mục</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?php echo htmlspecialchars($cat['name']); ?></td>
                <td><?php echo htmlspecialchars($cat['description']); ?></td>
                <td>
                    <a href="<?php echo BASE_URL . 'admin/categories/edit/' . $cat['id']; ?>" class="btn btn-sm btn-outline">Sửa</a>
                    <a href="<?php echo BASE_URL . 'admin/categories/delete/' . $cat['id']; ?>"
                       onclick="return confirm('Xóa danh mục?');"
                       class="btn btn-sm btn-secondary">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
