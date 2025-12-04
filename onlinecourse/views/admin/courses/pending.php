<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
    <h2>Khóa học chờ duyệt</h2>

    <?php if (!empty($message)): ?>
        <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!empty($courses)): ?>
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Giáo viên</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($courses as $c): ?>
                <tr>
                    <td><?php echo intval($c['id']); ?></td>
                    <td><?php echo htmlspecialchars($c['title']); ?></td>
                    <td><?php echo htmlspecialchars($c['instructor_name'] ?? 'Không xác định'); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($c['created_at'] ?? 'now')); ?></td>
                    <td>
                        <a href="index.php?controller=admin&action=approveCourse&id=<?php echo $c['id']; ?>">Duyệt</a>
                        <a href="index.php?controller=admin&action=rejectCourse&id=<?php echo $c['id']; ?>" onclick="return confirm('Từ chối khóa học này?');">Từ chối</a>
                        <a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>">Xem</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Không có khóa học chờ duyệt.</p>
    <?php endif; ?>

    <p><a href="index.php?controller=admin&action=dashboard">← Quay lại Dashboard</a></p>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>