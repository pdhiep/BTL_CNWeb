<?php include __DIR__ . '/../layouts/header.php'; ?>
<?php $role = 'student'; include __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Tổng quan học viên</span>
    </div>
    <div class="grid-3">
        <div class="card">
            <div class="card-title">Đang học</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['active']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Đã hoàn thành</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['completed']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Tổng số khóa</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['total']; ?></p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Tiến độ tổng</span>
    </div>
    <p style="margin-bottom:8px;">Hoàn thành khoảng <?php echo (int)$stats['progress_percent']; ?>%</p>
    <div class="progress-wrapper">
        <div class="progress-inner" style="width:<?php echo (int)$stats['progress_percent']; ?>%;"></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Khóa học đang học dở</span>
    </div>
    <?php if (empty($activeCourses)): ?>
        <p>Bạn chưa đăng ký khóa học nào.</p>
    <?php else: ?>
        <div class="grid-3">
            <?php foreach ($activeCourses as $course): ?>
                <div class="course-card">
                    <img src="<?php echo BASE_URL . ($course['image'] ?: 'assets/img/course-placeholder.jpg'); ?>">
                    <div class="course-card-body">
                        <div class="course-card-title"><?php echo htmlspecialchars($course['title']); ?></div>
                        <div class="course-card-meta">
                            Tiến độ: <?php echo (int)$course['progress']; ?>%
                        </div>
                    </div>
                    <div class="course-card-footer">
                        <a class="btn btn-sm btn-primary"
                           href="<?php echo BASE_URL . 'student/course/' . $course['id']; ?>">
                            Tiếp tục học
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</main></div> <!-- đóng sidebar layout -->
<?php include __DIR__ . '/../layouts/footer.php'; ?>
