<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Upload tài liệu cho bài: <?php echo htmlspecialchars($lesson['title']); ?></span>
    </div>

    <form method="post" action="<?php echo BASE_URL; ?>instructor/materials/store" enctype="multipart/form-data">
        <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">

        <label>Chọn file</label>
        <input type="file" name="file" required>

        <p style="font-size:13px;color:#777;">
            Hỗ trợ: pdf, doc, ppt, pptx, zip, tối đa 5MB.
        </p>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="<?php echo BASE_URL . 'instructor/lessons/manage/' . $lesson['course_id']; ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>

    <hr style="margin:20px 0;">

    <h3>Tài liệu đã có</h3>
    <?php if (empty($materials)): ?>
        <p>Chưa có tài liệu.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($materials as $m): ?>
                <li>
                    <a href="<?php echo BASE_URL . $m['file_path']; ?>" target="_blank">
                        <?php echo htmlspecialchars($m['filename']); ?>
                    </a>
                    (<?php echo htmlspecialchars($m['file_type']); ?>)
                    <a href="<?php echo BASE_URL . 'instructor/materials/delete/' . $m['id']; ?>"
                       onclick="return confirm('Xóa tài liệu?');">Xóa</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
