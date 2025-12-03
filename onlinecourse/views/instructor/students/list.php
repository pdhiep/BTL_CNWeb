<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'instructor'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Học viên của khóa: <?php echo htmlspecialchars($course['title']); ?></span>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>Học viên</th>
            <th>Email</th>
            <th>Ngày đăng ký</th>
            <th>Trạng thái</th>
            <th>Tiến độ</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $st): ?>
            <tr>
                <td><?php echo htmlspecialchars($st['fullname']); ?></td>
                <td><?php echo htmlspecialchars($st['email']); ?></td>
                <td><?php echo htmlspecialchars($st['enrolled_date']); ?></td>
                <td><?php echo htmlspecialchars($st['status']); ?></td>
                <td><?php echo (int)$st['progress']; ?>%</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
