<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container lesson-view">
	<div class="breadcrumb">
		<a href="index.php?controller=student&action=myCourses">Khóa học của tôi</a> / 
		<a href="index.php?controller=student&action=courseProgress&id=<?php echo $lesson['course_id']; ?>">
			<?php echo htmlspecialchars($lesson['course_title']); ?>
		</a>
	</div>

	<div class="lesson-header">
		<h1><?php echo htmlspecialchars($lesson['title']); ?></h1>
		<p class="lesson-date">Ngày cập nhật: <?php echo date('d/m/Y', strtotime($lesson['created_at'] ?? 'now')); ?></p>
	</div>

	<div class="lesson-content">
		<div class="lesson-description">
			<h2>Nội dung bài học</h2>
			<div class="content-text">
				<?php echo nl2br(htmlspecialchars($lesson['description'] ?? 'Chưa có nội dung')); ?>
			</div>
		</div>

		<?php if (!empty($materials)): ?>
			<div class="lesson-materials">
				<h2>Tài liệu học tập</h2>
				<p class="materials-intro">Dưới đây là các tài liệu hỗ trợ cho bài học này:</p>
				
				<div class="materials-list">
					<?php foreach ($materials as $material): ?>
						<div class="material-item">
							<div class="material-icon">
								<?php
									$ext = pathinfo($material['file_name'], PATHINFO_EXTENSION);
									if (in_array(strtolower($ext), ['pdf'])) {
										echo '📄';
									} elseif (in_array(strtolower($ext), ['doc', 'docx'])) {
										echo '📝';
									} elseif (in_array(strtolower($ext), ['xls', 'xlsx'])) {
										echo '📊';
									} elseif (in_array(strtolower($ext), ['zip', 'rar', '7z'])) {
										echo '📦';
									} else {
										echo '📎';
									}
								?>
							</div>
							
							<div class="material-info">
								<h4><?php echo htmlspecialchars($material['title']); ?></h4>
								<p class="material-desc"><?php echo htmlspecialchars($material['description'] ?? ''); ?></p>
								<p class="material-meta">
									<?php echo htmlspecialchars($material['file_name']); ?> • 
									<?php echo date('d/m/Y', strtotime($material['created_at'])); ?>
								</p>
							</div>
							
							<div class="material-action">
								<a href="index.php?controller=student&action=downloadMaterial&id=<?php echo $material['id']; ?>" class="btn btn-download">Tải xuống</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="lesson-footer">
			<div class="footer-actions">
				<a href="index.php?controller=student&action=courseProgress&id=<?php echo $lesson['course_id']; ?>" class="btn btn-back">← Quay lại danh sách bài học</a>
			</div>
		</div>
	</div>
</div>

<style>
	.lesson-view {
		padding: 20px;
		max-width: 1000px;
	}

	.breadcrumb {
		font-size: 13px;
		color: #666;
		margin-bottom: 20px;
	}

	.breadcrumb a {
		color: #667eea;
		text-decoration: none;
	}

	.breadcrumb a:hover {
		text-decoration: underline;
	}

	.lesson-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		padding: 30px;
		border-radius: 8px;
		margin-bottom: 30px;
	}

	.lesson-header h1 {
		margin: 0 0 10px 0;
		font-size: 32px;
	}

	.lesson-date {
		margin: 0;
		opacity: 0.9;
		font-size: 14px;
	}

	.lesson-content {
		background: white;
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 30px;
	}

	.lesson-description {
		margin-bottom: 40px;
	}

	.lesson-description h2 {
		margin-top: 0;
		margin-bottom: 20px;
		color: #333;
		font-size: 22px;
	}

	.content-text {
		color: #555;
		line-height: 1.8;
		font-size: 15px;
	}

	.lesson-materials {
		border-top: 2px solid #eee;
		padding-top: 30px;
	}

	.lesson-materials h2 {
		margin-top: 0;
		margin-bottom: 10px;
		color: #333;
		font-size: 22px;
	}

	.materials-intro {
		color: #666;
		margin: 0 0 20px 0;
	}

	.materials-list {
		display: flex;
		flex-direction: column;
		gap: 15px;
	}

	.material-item {
		display: flex;
		align-items: flex-start;
		gap: 20px;
		padding: 20px;
		border: 1px solid #ddd;
		border-radius: 8px;
		background: #f9f9f9;
		transition: background 0.2s, box-shadow 0.2s;
	}

	.material-item:hover {
		background: #f0f0f0;
		box-shadow: 0 2px 6px rgba(0,0,0,0.1);
	}

	.material-icon {
		font-size: 32px;
		flex-shrink: 0;
		min-width: 40px;
		text-align: center;
	}

	.material-info {
		flex: 1;
	}

	.material-info h4 {
		margin: 0 0 5px 0;
		color: #333;
		font-size: 16px;
	}

	.material-desc {
		margin: 5px 0;
		color: #666;
		font-size: 13px;
		line-height: 1.5;
	}

	.material-meta {
		margin: 8px 0 0 0;
		color: #999;
		font-size: 12px;
	}

	.material-action {
		flex-shrink: 0;
	}

	.btn {
		display: inline-block;
		padding: 8px 16px;
		border-radius: 4px;
		text-decoration: none;
		font-size: 13px;
		font-weight: 500;
		transition: all 0.3s;
		white-space: nowrap;
	}

	.btn-download {
		background: #28a745;
		color: white;
	}

	.btn-download:hover {
		background: #218838;
	}

	.btn-back {
		background: #667eea;
		color: white;
	}

	.btn-back:hover {
		background: #764ba2;
	}

	.lesson-footer {
		margin-top: 30px;
		padding-top: 20px;
		border-top: 2px solid #eee;
	}

	.footer-actions {
		display: flex;
		gap: 10px;
	}

	@media (max-width: 768px) {
		.lesson-view {
			padding: 10px;
		}

		.lesson-content {
			padding: 15px;
		}

		.lesson-header {
			padding: 20px;
		}

		.lesson-header h1 {
			font-size: 24px;
		}

		.material-item {
			flex-direction: column;
			gap: 10px;
		}

		.material-icon {
			text-align: left;
		}

		.material-action {
			width: 100%;
		}

		.btn {
			display: block;
			text-align: center;
		}
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
