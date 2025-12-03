<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'admin'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title"><?php echo isset($category) ? 'Sửa' : 'Thêm'; ?> danh mục</span>
    </div>

    <form method="post"
          action="<?php echo isset($category)
              ? BASE_URL . 'admin/categories/update/' . $category['id']
              : BASE_URL . 'admin/categories/store'; ?>">
        <label>Tên danh mục</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>" required>

        <label>Mô tả</label>
        <textarea name="description" rows="3"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="<?php echo BASE_URL; ?>admin/categories" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
