<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Quản lý khóa học</span>
        <a class="btn btn-primary btn-sm" href="<?php echo BASE_URL; ?>instructor/course/create">+ Tạo khóa học</a>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Khóa học</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Học viên</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['title']); ?></td>
                <td><?php echo htmlspecialchars($course['category_name']); ?></td>
                <td><?php echo number_format($course['price'],0,',','.'); ?>đ</td>
                <td><?php echo (int)$course['student_count']; ?></td>
                <td>
                    <a href="<?php echo BASE_URL . 'instructor/course/edit/' . $course['id']; ?>" class="btn btn-sm btn-outline">Sửa</a>
                    <a href="<?php echo BASE_URL . 'instructor/lessons/manage/' . $course['id']; ?>" class="btn btn-sm btn-primary">Bài học</a>
                    <a href="<?php echo BASE_URL . 'instructor/students/' . $course['id']; ?>" class="btn btn-sm btn-outline">Học viên</a>
                    <a href="<?php echo BASE_URL . 'instructor/course/delete/' . $course['id']; ?>"
                       onclick="return confirm('Xóa khóa học này?');"
                       class="btn btn-sm btn-secondary">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
