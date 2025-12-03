<?php include __DIR__ . '/../../layouts/header.php'; ?>
<?php $role = 'admin'; include __DIR__ . '/../../layouts/sidebar.php'; ?>

<div class="card">
    <div class="card-header">
        <span class="card-title">Quản lý người dùng</span>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Role</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?php echo htmlspecialchars($u['fullname']); ?></td>
                <td><?php echo htmlspecialchars($u['email']); ?></td>
                <td>
                    <?php
                    if ($u['role'] == 0) echo 'Học viên';
                    elseif ($u['role'] == 1) echo 'Giảng viên';
                    else echo 'Quản trị';
                    ?>
                </td>
                <td><?php echo $u['status'] ? 'Active' : 'Disabled'; ?></td>
                <td>
                    <?php if ($u['status']): ?>
                        <a href="<?php echo BASE_URL . 'admin/users/deactivate/' . $u['id']; ?>"
                           class="btn btn-sm btn-secondary">Vô hiệu hóa</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL . 'admin/users/activate/' . $u['id']; ?>"
                           class="btn btn-sm btn-primary">Kích hoạt</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</main></div>
<?php include __DIR__ . '/../../layouts/footer.php'; ?>
