<?php require_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container">
	<div class="dashboard-header">
		<h1>📚 Tải lên tài liệu</h1>
		<p><?php echo !empty($lesson) ? 'Bài: ' . htmlspecialchars($lesson['title'] ?? '') : 'Quản lý tài liệu khóa học'; ?></p>
	</div>

	<?php if (!empty($_SESSION['flash'])): ?>
		<div class="alert alert-success">
			✓ <?php echo htmlspecialchars($_SESSION['flash']); ?>
		</div>
		<?php unset($_SESSION['flash']); ?>
	<?php endif; ?>

	<?php if (!empty($message)): ?>
		<div class="alert alert-success">
			✓ <?php echo htmlspecialchars($message); ?>
		</div>
	<?php endif; ?>

	<div style="max-width: 800px;">
		<!-- Upload Form -->
		<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 30px;">
			<h2 style="margin-top: 0; margin-bottom: 24px; color: #333;">📤 Tải lên tài liệu mới</h2>

			<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="material-title">Tên tài liệu</label>
					<input type="text" id="material-title" name="title" placeholder="VD: Slide bài học, Tài liệu ôn tập" required>
				</div>

				<div class="form-group">
					<label for="material-description">Mô tả (tùy chọn)</label>
					<textarea id="material-description" name="description" placeholder="Mô tả chi tiết về tài liệu..."></textarea>
				</div>

				<div class="form-group">
					<label>📎 Chọn tài liệu</label>
					<div class="upload-area" onclick="document.getElementById('material-file').click();">
						<div class="icon">📁</div>
						<p style="font-weight: 500;">Nhấp để chọn tệp hoặc kéo thả tại đây</p>
						<p style="font-size: 12px; color: #999;">Hỗ trợ: PDF, Word, Excel, PowerPoint, Image (Tối đa 50MB)</p>
					</div>
					<input type="file" id="material-file" name="material" class="upload-input" 
						   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.zip" required>
				</div>

				<div id="material-preview"></div>

				<div style="display: flex; gap: 12px;">
					<button type="submit" class="btn btn-primary" style="flex: 1; padding: 14px;">💾 Tải lên</button>
					<button type="reset" class="btn btn-secondary" style="flex: 1; padding: 14px;">↺ Đặt lại</button>
				</div>
			</form>

			<script>
				document.getElementById('material-file').addEventListener('change', function() {
					const preview = document.getElementById('material-preview');
					if (this.files.length === 0) {
						preview.innerHTML = '';
						return;
					}

					const file = this.files[0];
					const maxSize = 50 * 1024 * 1024;

					if (file.size > maxSize) {
						alert('Tệp quá lớn. Tối đa 50MB');
						this.value = '';
						preview.innerHTML = '';
						return;
					}

					preview.innerHTML = `
						<div style="margin-top: 16px; padding: 12px; background: #f8f9fa; border-radius: 6px; border: 1px solid #ddd;">
							<p style="margin: 0; font-weight: 500; color: #333;">📄 ${file.name}</p>
							<p style="margin: 4px 0 0 0; color: #999; font-size: 12px;">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
						</div>
					`;
				});
			</script>
		</div>

		<div style="text-align: center;">
			<?php if (!empty($lesson)): ?>
				<a href="index.php?controller=lesson&action=manage&course_id=<?php echo intval($lesson['course_id']); ?>" class="btn btn-secondary" style="display: inline-block;">
					← Quay lại danh sách bài học
				</a>
			<?php else: ?>
				<a href="index.php?controller=instructor&action=dashboard" class="btn btn-secondary" style="display: inline-block;">
					← Quay lại Dashboard
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>

<style>
	.form-group {
		margin-bottom: 20px;
	}

	.form-group label {
		display: block;
		margin-bottom: 8px;
		font-weight: 500;
		color: #333;
	}

	.form-group input[type="text"],
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
		min-height: 80px;
	}
</style>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
