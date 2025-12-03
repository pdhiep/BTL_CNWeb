<section class="auth-card">
	<h1>Đăng ký tài khoản</h1>
	<form method="post" action="index.php?controller=auth&action=register" class="auth-form">
		<?php if (!empty($nameField)) : ?>
		<label class="form-control">
			<span>Họ và tên</span>
			<input type="text" name="name" value="<?php echo htmlspecialchars($old['name'] ?? ''); ?>" required>
		</label>
		<?php endif; ?>
		<label class="form-control">
			<span>Email</span>
			<input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required>
		</label>
		<label class="form-control">
			<span>Mật khẩu</span>
			<input type="password" name="password" minlength="6" required>
		</label>
		<label class="form-control">
			<span>Nhập lại mật khẩu</span>
			<input type="password" name="password_confirm" minlength="6" required>
		</label>
		<button type="submit" class="btn primary">Tạo tài khoản</button>
	</form>
	<p class="auth-link">Đã có tài khoản?
		<a href="index.php?controller=auth&action=login">Đăng nhập</a>
	</p>
</section>
