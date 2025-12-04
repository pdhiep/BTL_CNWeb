<?php require_once __DIR__ . '/layouts/header.php'; ?>

<div class="container">
	<div class="dashboard-header">
		<h1>👤 Hồ sơ của tôi</h1>
		<p>Quản lý thông tin cá nhân và avatar</p>
	</div>

	<?php if (!empty($_SESSION['flash'])): ?>
		<div class="alert alert-success">
			✓ <?php echo htmlspecialchars($_SESSION['flash']); ?>
		</div>
		<?php unset($_SESSION['flash']); ?>
	<?php endif; ?>

	<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; max-width: 1000px;">
		<!-- Avatar Upload Section -->
		<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
			<h2 style="margin-top: 0; margin-bottom: 24px; color: #333;">Ảnh đại diện</h2>

			<div class="avatar-container">
				<?php if (!empty($_SESSION['user_avatar'])): ?>
					<img src="assets/uploads/avatars/<?php echo htmlspecialchars($_SESSION['user_avatar']); ?>" 
						 alt="Avatar" class="avatar-image">
				<?php else: ?>
					<div class="avatar-image" style="display: flex; align-items: center; justify-content: center; background: #667eea; color: white; font-size: 48px;">
						👤
					</div>
				<?php endif; ?>

				<div class="avatar-upload">
					<button class="avatar-upload-btn" type="button" onclick="document.getElementById('avatar-file').click();">
						📸 Chọn ảnh
					</button>
					<input type="file" id="avatar-file" class="avatar-input" accept="image/*">
				</div>

				<form id="avatar-form" method="POST" action="index.php?controller=profile&action=uploadAvatar" 
					  enctype="multipart/form-data" style="width: 100%;">
					<input type="file" name="avatar" id="avatar-input" accept="image/*" style="display: none;">
					<div id="avatar-preview" style="margin-top: 16px;"></div>
					<button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 12px;">
						💾 Lưu ảnh đại diện
					</button>
				</form>

				<script>
					document.getElementById('avatar-file').addEventListener('change', function(e) {
						document.getElementById('avatar-input').files = this.files;
						const event = new Event('change', { bubbles: true });
						document.getElementById('avatar-input').dispatchEvent(event);
					});
				</script>
			</div>
		</div>

		<!-- User Information -->
		<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
			<h2 style="margin-top: 0; margin-bottom: 24px; color: #333;">Thông tin cá nhân</h2>

			<form method="POST" action="index.php?controller=profile&action=update">
				<div class="form-group">
					<label for="fullname">Họ và tên</label>
					<input type="text" id="fullname" name="fullname" 
						   value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>" 
						   required>
				</div>

				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" 
						   value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>" 
						   required readonly
						   style="background: #f5f5f5; cursor: not-allowed;">
				</div>

				<div class="form-group">
					<label for="phone">Số điện thoại</label>
					<input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại (tùy chọn)">
				</div>

				<div class="form-group">
					<label for="bio">Giới thiệu</label>
					<textarea id="bio" name="bio" placeholder="Viết một vài dòng về bản thân bạn..."></textarea>
				</div>

				<div style="display: flex; gap: 12px;">
					<button type="submit" class="btn btn-primary" style="flex: 1;">💾 Lưu thay đổi</button>
					<button type="reset" class="btn btn-secondary" style="flex: 1;">↺ Đặt lại</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Security Section -->
	<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 30px; max-width: 1000px;">
		<h2 style="margin-top: 0; margin-bottom: 24px; color: #333;">🔐 Bảo mật</h2>

		<form method="POST" action="index.php?controller=profile&action=changePassword">
			<div class="form-group">
				<label for="current-password">Mật khẩu hiện tại</label>
				<input type="password" id="current-password" name="current_password" required>
			</div>

			<div class="form-group">
				<label for="new-password">Mật khẩu mới</label>
				<input type="password" id="new-password" name="new_password" required minlength="6">
			</div>

			<div class="form-group">
				<label for="confirm-password">Xác nhận mật khẩu</label>
				<input type="password" id="confirm-password" name="confirm_password" required minlength="6">
			</div>

			<script>
				document.querySelector('form[action*="changePassword"]').addEventListener('submit', function(e) {
					const newPass = document.getElementById('new-password').value;
					const confirmPass = document.getElementById('confirm-password').value;
					
					if (newPass !== confirmPass) {
						e.preventDefault();
						alert('Mật khẩu xác nhận không khớp!');
					}
				});
			</script>

			<button type="submit" class="btn btn-primary">🔄 Đổi mật khẩu</button>
		</form>
	</div>

	<div style="margin-top: 40px; text-align: center;">
		<a href="index.php" class="btn btn-secondary" style="display: inline-block;">← Quay lại trang chủ</a>
	</div>
</div>

<style>
	.form-group {
		margin-bottom: 16px;
	}

	.form-group label {
		display: block;
		margin-bottom: 6px;
		font-weight: 500;
		color: #333;
	}

	.form-group input,
	.form-group textarea {
		width: 100%;
		padding: 12px;
		border: 1px solid #ddd;
		border-radius: 6px;
		font-size: 14px;
		font-family: inherit;
		transition: border-color 0.3s;
	}

	.form-group input:focus,
	.form-group textarea:focus {
		outline: none;
		border-color: #667eea;
		box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
	}

	.form-group textarea {
		resize: vertical;
		min-height: 100px;
	}

	@media (max-width: 768px) {
		div[style*="grid-template-columns: 1fr 1fr"] {
			grid-template-columns: 1fr !important;
		}
	}
</style>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
