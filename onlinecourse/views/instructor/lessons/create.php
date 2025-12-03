<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Thêm bài học cho khóa: <?php echo htmlspecialchars($course['title']); ?></span>
    </div>

    <form method="post" action="<?php echo BASE_URL . 'instructor/lessons/store/' . $course['id']; ?>">
        <label>Tiêu đề bài học</label>
        <input type="text" name="title" required>

        <label>Thứ tự</label>
        <input type="number" name="order" min="1" value="<?php echo (int)$nextOrder; ?>">

        <label>Video URL</label>
        <input type="text" name="video_url">

        <label>Nội dung</label>
        <textarea name="content" rows="5"></textarea>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="<?php echo BASE_URL . 'instructor/lessons/manage/' . $course['id']; ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
