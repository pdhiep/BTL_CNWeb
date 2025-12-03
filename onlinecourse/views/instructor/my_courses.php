<h2>Khóa học của tôi</h2>

<p>
    <a href="<?php echo BASE_URL; ?>instructor/createCourse">+ Tạo khóa học mới</a>
</p>

<?php if (empty($courses)): ?>
    <p>Bạn chưa có khóa học nào.</p>
<?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Tiêu đề</th>
            <th>Danh mục</th>
            <th>Cấp độ</th>
            <th>Giá</th>
            <th>Thời lượng (tuần)</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['title']); ?></td>
                <td><?php echo htmlspecialchars($course['category_name'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($course['level']); ?></td>
                <td><?php echo htmlspecialchars($course['price']); ?></td>
                <td><?php echo htmlspecialchars($course['duration_weeks']); ?></td>
                <td>
                    <a href="<?php echo BASE_URL . 'instructor/editCourse/' . $course['id']; ?>">Sửa</a> |
                    <a href="<?php echo BASE_URL . 'instructor/deleteCourse/' . $course['id']; ?>"
                       onclick="return confirm('Xóa khóa học này?');">Xóa</a> |
                    <a href="<?php echo BASE_URL . 'instructor/manageLessons/' . $course['id']; ?>">Bài học</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
