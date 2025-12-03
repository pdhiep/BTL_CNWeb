<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $role = 'student'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Khóa học của tôi</span>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Khóa học</th>
            <th>Trạng thái</th>
            <th>Tiến độ</th>
            <th>Ngày đăng ký</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($enrollments as $enroll): ?>
            <tr>
                <td><?php echo htmlspecialchars($enroll['course_title']); ?></td>
                <td><?php echo htmlspecialchars($enroll['status']); ?></td>
                <td><?php echo (int)$enroll['progress']; ?>%</td>
                <td><?php echo htmlspecialchars($enroll['enrolled_date']); ?></td>
                <td>
                    <a class="btn btn-sm btn-primary"
                       href="<?php echo BASE_URL . 'student/course/' . $enroll['course_id']; ?>">
                        <?php echo $enroll['status'] === 'completed' ? 'Xem lại' : 'Tiếp tục học'; ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
