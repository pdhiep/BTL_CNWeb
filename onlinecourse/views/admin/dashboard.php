<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $role = 'admin'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Dashboard quản trị</span>
    </div>
    <div class="grid-4">
        <div class="card">
            <div class="card-title">Người dùng</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['users']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Khóa học</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['courses']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Enrollments</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['enrollments']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Khóa chờ duyệt</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['pending_courses']; ?></p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Khóa học chờ phê duyệt</span>
    </div>
    <?php if (empty($pendingCourses)): ?>
        <p>Không có khóa học nào đang chờ duyệt.</p>
    <?php else: ?>
        <table class="table">
            <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Giảng viên</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pendingCourses as $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c['title']); ?></td>
                    <td><?php echo htmlspecialchars($c['instructor_name']); ?></td>
                    <td><?php echo htmlspecialchars($c['created_at']); ?></td>
                    <td>
                        <a href="<?php echo BASE_URL . 'admin/courses/approve/' . $c['id']; ?>"
                           class="btn btn-sm btn-primary">Duyệt</a>
                        <a href="<?php echo BASE_URL . 'admin/courses/reject/' . $c['id']; ?>"
                           class="btn btn-sm btn-secondary">Từ chối</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</main></div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
