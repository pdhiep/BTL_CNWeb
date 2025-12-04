<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
	<h2>Quản lý người dùng</h2>

	<?php $msg = isset($_SESSION['flash']) ? $_SESSION['flash'] : null; unset($_SESSION['flash']); ?>
	<?php if (!empty($msg)): ?>
		<div class="alert"><?php echo htmlspecialchars($msg); ?></div>
	<?php endif; ?>

	<?php if (!empty($users)): ?>
		<table style="width:100%;border-collapse:collapse">
			<thead>
				<tr><th>ID</th><th>Username</th><th>Fullname</th><th>Email</th><th>Role</th><th>Active</th><th>Hành động</th></tr>
			</thead>
			<tbody>
			<?php foreach ($users as $u): ?>
				<tr>
					<td><?php echo $u['id']; ?></td>
					<td><?php echo htmlspecialchars($u['username']); ?></td>
					<td><?php echo htmlspecialchars($u['fullname']); ?></td>
					<td><?php echo htmlspecialchars($u['email']); ?></td>
					<td><?php echo (intval($u['role']) === 2) ? 'Admin' : ((intval($u['role']) === 1) ? 'Instructor' : 'Student'); ?></td>
					<td><?php echo isset($u['is_active']) ? ($u['is_active'] ? 'Yes' : 'No') : 'N/A'; ?></td>
					<td>
						<a href="index.php?controller=admin&action=activate&id=<?php echo $u['id']; ?>">Kích hoạt</a>
						<a href="index.php?controller=admin&action=deactivate&id=<?php echo $u['id']; ?>">Vô hiệu</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<p>Không có người dùng.</p>
	<?php endif; ?>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
