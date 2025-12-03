<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'admin'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Thống kê hệ thống</span>
    </div>

    <div class="grid-3">
        <div class="card">
            <div class="card-title">Enrollments tháng này</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['enrollments_month']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Người dùng mới</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['new_users_month']; ?></p>
        </div>
        <div class="card">
            <div class="card-title">Khóa học mới</div>
            <p style="font-size:24px;margin-top:8px;"><?php echo (int)$stats['new_courses_month']; ?></p>
        </div>
    </div>

    <p style="margin-top:20px;color:#777;">
        (Bạn có thể chèn biểu đồ bằng thư viện JS sau – hiện tại dùng số liệu dạng text để demo.)
    </p>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
