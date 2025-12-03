<section class="profile-card">
	<h1>Quản lý tài khoản</h1>
	<div class="profile-info">
		<div><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
		<div><strong>Vai trò:</strong> <?php echo htmlspecialchars($user['role'] ?? 'student'); ?></div>
	</div>
	<form method="post" action="index.php?controller=auth&action=profile" class="auth-form">
		<?php if (!empty($nameField)) : ?>
		<label class="form-control">
			<span>Họ và tên</span>
			<input type="text" name="name" value="<?php echo htmlspecialchars($user[$nameField] ?? ''); ?>">
		</label>
		<?php else : ?>
		<p class="help-text">Hệ thống hiện không lưu cột họ tên. Bạn vẫn có thể đổi mật khẩu.</p>
		<?php endif; ?>
		<label class="form-control">
			<span>Mật khẩu mới</span>
			<input type="password" name="password" placeholder="Để trống nếu không đổi">
		</label>
		<button type="submit" class="btn primary">Cập nhật</button>
	</form>
</section>
