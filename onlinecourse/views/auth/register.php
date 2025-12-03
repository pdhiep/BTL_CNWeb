<div class="auth">
	<h2>Đăng ký</h2>
	<form method="post" action="index.php?action=register">
		<div>
			<label for="name">Họ tên</label>
			<input id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['old']['name'] ?? ''); ?>" required>
		</div>
		<div>
			<label for="email">Email</label>
			<input id="email" name="email" type="email" value="<?php echo htmlspecialchars($_SESSION['old']['email'] ?? ''); ?>" required>
		</div>
		<div>
			<label for="password">Mật khẩu</label>
			<input id="password" name="password" type="password" required>
		</div>
		<div>
			<label for="password_confirm">Xác nhận mật khẩu</label>
			<input id="password_confirm" name="password_confirm" type="password" required>
		</div>
		<div>
			<button type="submit">Đăng ký</button>
		</div>
	</form>
	<p>Đã có tài khoản? <a href="index.php?action=login">Đăng nhập</a></p>
</div>
<?php unset($_SESSION['old']); ?>
