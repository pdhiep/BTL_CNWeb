<h2>Quản lý bài học: <?php echo htmlspecialchars($course['title']); ?></h2>

<p>
    <a href="<?php echo BASE_URL . 'lesson/create/' . $course['id']; ?>">+ Thêm bài học mới</a> |
    <a href="<?php echo BASE_URL; ?>instructor/myCourses">← Quay lại danh sách khóa học</a>
</p>

<?php if (empty($lessons)): ?>
    <p>Khóa học chưa có bài học nào.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Thứ tự</th>
            <th>Tiêu đề</th>
            <th>Video URL</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($lessons as $lesson): ?>
            <tr>
                <td><?php echo htmlspecialchars($lesson['order']); ?></td>
                <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                <td><?php echo htmlspecialchars($lesson['video_url']); ?></td>
                <td>
                    <a href="<?php echo BASE_URL . 'lesson/edit/' . $lesson['id']; ?>">Sửa</a> |
                    <a href="<?php echo BASE_URL . 'lesson/delete/' . $lesson['id']; ?>"
                       onclick="return confirm('Xóa bài học này?');">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
