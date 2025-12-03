<section class="auth-card">
	<h1>Đăng nhập</h1>
	<form method="post" action="index.php?controller=auth&action=login" class="auth-form">
		<label class="form-control">
			<span>Email</span>
			<input type="email" name="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required>
		</label>
		<label class="form-control">
			<span>Mật khẩu</span>
			<input type="password" name="password" required>
		</label>
		<button type="submit" class="btn primary">Đăng nhập</button>
	</form>
	<p class="auth-link">Chưa có tài khoản?
		<a href="index.php?controller=auth&action=register">Đăng ký ngay</a>
	</p>
</section>
