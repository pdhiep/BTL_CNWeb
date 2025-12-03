<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Sửa khóa học</span>
    </div>

    <form method="post" action="<?php echo BASE_URL . 'instructor/course/update/' . $course['id']; ?>" enctype="multipart/form-data">
        <label>Tiêu đề</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>

        <label>Mô tả</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($course['description']); ?></textarea>

        <!-- Category, price, duration, level giống create, chỉ thêm selected/value -->
        <!-- ... -->

        <label>Ảnh hiện tại</label><br>
        <?php if ($course['image']): ?>
            <img src="<?php echo BASE_URL . $course['image']; ?>" style="max-width:200px;margin-bottom:8px;">
        <?php else: ?>
            <p>Chưa có ảnh.</p>
        <?php endif; ?>
        <label>Chọn ảnh mới (nếu muốn)</label>
        <input type="file" name="image" accept="image/*">

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="<?php echo BASE_URL; ?>instructor/myCourses" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
