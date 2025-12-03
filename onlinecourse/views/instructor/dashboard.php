<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Tổng quan giảng viên</span>
        <a class="btn btn-primary btn-sm" href="<?php echo BASE_URL; ?>instructor/course/create">+ Tạo khóa học</a>
    </div>
    <div class="grid-3">
        <div class="card">
            <div class="card-title">Khóa học</div>
            <p style="font-size:26px;margin-top:8px;"><?php echo (int)$stats['courses']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Học viên</div>
            <p style="font-size:26px;margin-top:8px;"><?php echo (int)$stats['students']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Enrollment mới</div>
            <p style="font-size:26px;margin-top:8px;"><?php echo (int)$stats['new_enrollments']; ?></p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Khóa học của tôi</span>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Khóa học</th>
            <th>Danh mục</th>
            <th>Học viên</th>
            <th>Trạng thái</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?php echo htmlspecialchars($course['title']); ?></td>
                <td><?php echo htmlspecialchars($course['category_name']); ?></td>
                <td><?php echo (int)$course['student_count']; ?></td>
                <td><?php echo htmlspecialchars($course['status'] ?? 'active'); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
