<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
    <h2>Danh sách học viên - <?php echo htmlspecialchars($course['title']); ?></h2>

    <?php if (!empty($students)): ?>
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr><th>Họ và tên</th><th>Email</th><th>Enrolled</th><th>Progress</th></tr>
            </thead>
            <tbody>
            <?php foreach ($students as $s): ?>
                <tr>
                    <td><?php echo htmlspecialchars($s['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($s['email']); ?></td>
                    <td><?php echo htmlspecialchars($s['enrolled_date']); ?></td>
                    <td><?php echo intval($s['progress']); ?>%</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có học viên nào đăng ký.</p>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
