<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Bài học của khóa: <?php echo htmlspecialchars($course['title']); ?></span>
        <a class="btn btn-primary btn-sm"
           href="<?php echo BASE_URL . 'instructor/lessons/create/' . $course['id']; ?>">+ Thêm bài học</a>
    </div>

    <?php if (empty($lessons)): ?>
        <p>Chưa có bài học nào.</p>
    <?php else: ?>
        <table class="table">
            <thead>
            <tr>
                <th>Thứ tự</th>
                <th>Tiêu đề</th>
                <th>Video URL</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?php echo (int)$lesson['order']; ?></td>
                    <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                    <td><?php echo htmlspecialchars($lesson['video_url']); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . 'instructor/lessons/edit/' . $lesson['id']; ?>"
                           class="btn btn-sm btn-outline">Sửa</a>
                        <a href="<?php echo BASE_URL . 'instructor/materials/upload/' . $lesson['id']; ?>"
                           class="btn btn-sm btn-primary">Tài liệu</a>
                        <a href="<?php echo BASE_URL . 'instructor/lessons/delete/' . $lesson['id']; ?>"
                           onclick="return confirm('Xóa bài học?');"
                           class="btn btn-sm btn-secondary">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
