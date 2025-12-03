<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Tạo khóa học mới</span>
    </div>

    <form method="post" action="<?php echo BASE_URL; ?>instructor/course/store" enctype="multipart/form-data">
        <label>Tiêu đề</label>
        <input type="text" name="title" required>

        <label>Mô tả</label>
        <textarea name="description" rows="4" required></textarea>

        <label>Danh mục</label>
        <select name="category_id" required>
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <label>Giá (VNĐ)</label>
        <input type="number" name="price" min="0" step="10000" required>

        <label>Thời lượng (tuần)</label>
        <input type="number" name="duration_weeks" min="1" required>

        <label>Level</label>
        <select name="level" required>
            <option>Beginner</option>
            <option>Intermediate</option>
            <option>Advanced</option>
        </select>

        <label>Ảnh khóa học</label>
        <input type="file" name="image" accept="image/*">

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="<?php echo BASE_URL; ?>instructor/myCourses" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
