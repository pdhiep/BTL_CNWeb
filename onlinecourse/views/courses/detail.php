<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container course-detail">
	<div class="breadcrumb">
		<a href="index.php?controller=course&action=index">Danh sách khóa học</a> / 
		<span><?php echo htmlspecialchars($course['title']); ?></span>
	</div>

	<div class="course-header">
		<div class="header-content">
			<h1><?php echo htmlspecialchars($course['title']); ?></h1>
			
			<div class="course-meta">
				<span class="meta-item">
					<strong>Giáo viên:</strong> <?php echo htmlspecialchars($course['instructor_name'] ?? 'Không xác định'); ?>
				</span>
				<span class="meta-item">
					<strong>Học viên:</strong> <?php echo $enrolledCount; ?> người
				</span>
				<span class="meta-item">
					<strong>Bài học:</strong> <?php echo count($lessons); ?> bài
				</span>
			</div>
		</div>
	</div>

	<?php if (!empty($message)): ?>
		<div class="alert alert-success">
			✓ <?php echo htmlspecialchars($message); ?>
		</div>
	<?php endif; ?>

	<div class="course-content">
		<div class="main-content">
			<section class="description-section">
				<h2>Về khóa học</h2>
				<div class="description-text">
					<?php echo nl2br(htmlspecialchars($course['description'])); ?>
				</div>
			</section>

			<?php if (!empty($lessons)): ?>
				<section class="lessons-section">
					<h2>Danh sách bài học</h2>
					<div class="lessons-preview">
						<?php foreach (array_slice($lessons, 0, 5) as $index => $lesson): ?>
							<div class="lesson-preview">
								<span class="lesson-number"><?php echo $index + 1; ?></span>
								<span class="lesson-title"><?php echo htmlspecialchars($lesson['title'] ?? 'Bài học không có tiêu đề'); ?></span>
							</div>
						<?php endforeach; ?>
						<?php if (count($lessons) > 5): ?>
							<p class="more-lessons">... và <?php echo count($lessons) - 5; ?> bài học khác</p>
						<?php endif; ?>
					</div>
				</section>
			<?php endif; ?>
		</div>

		<div class="sidebar">
			<div class="enrollment-card">
				<?php if ($isEnrolled): ?>
					<div class="enrolled-status">
						<p>✓ Bạn đã đăng ký khóa học này</p>
						<a href="index.php?controller=student&action=courseProgress&id=<?php echo $course['id']; ?>" class="btn btn-primary btn-large">Xem tiến độ học tập</a>
					</div>
				<?php else: ?>
					<form method="post" action="index.php?controller=course&action=enroll">
						<input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
						<button type="submit" class="btn btn-primary btn-large">Đăng ký khóa học</button>
					</form>
					<p class="enroll-notice">Hãy đăng ký ngay để bắt đầu học tập</p>
				<?php endif; ?>
			</div>

			<div class="info-card">
				<h3>Thông tin khóa học</h3>
				<div class="info-grid">
					<div class="info-item">
						<span class="label">Trạng thái</span>
						<span class="value">Đang hoạt động</span>
					</div>
					<div class="info-item">
						<span class="label">Số học viên</span>
						<span class="value"><?php echo $enrolledCount; ?></span>
					</div>
					<div class="info-item">
						<span class="label">Số bài học</span>
						<span class="value"><?php echo count($lessons); ?></span>
					</div>
				</div>
			</div>

			<?php if (!empty($course['instructor_name'])): ?>
				<div class="instructor-card">
					<h3>Giáo viên</h3>
					<p class="instructor-name"><?php echo htmlspecialchars($course['instructor_name']); ?></p>
					<?php if (!empty($course['instructor_email'])): ?>
						<p class="instructor-email">📧 <?php echo htmlspecialchars($course['instructor_email']); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="course-actions">
		<a href="index.php?controller=course&action=index" class="btn btn-secondary">← Quay lại danh sách</a>
	</div>
</div>

<style>
	.course-detail {
		padding: 20px;
		max-width: 1200px;
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

	.course-header {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		padding: 40px;
		border-radius: 8px;
		margin-bottom: 30px;
	}

	.course-header h1 {
		margin: 0 0 20px 0;
		font-size: 36px;
	}

	.course-meta {
		display: flex;
		flex-wrap: wrap;
		gap: 30px;
		font-size: 15px;
	}

	.meta-item {
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.alert {
		padding: 15px;
		border-radius: 8px;
		margin-bottom: 20px;
		font-weight: 500;
	}

	.alert-success {
		background: #d4edda;
		color: #155724;
		border: 1px solid #c3e6cb;
	}

	.course-content {
		display: grid;
		grid-template-columns: 1fr 350px;
		gap: 30px;
		margin-bottom: 30px;
	}

	.main-content {
		background: white;
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 30px;
	}

	section {
		margin-bottom: 40px;
	}

	section h2 {
		margin: 0 0 20px 0;
		color: #333;
		font-size: 22px;
		border-bottom: 2px solid #eee;
		padding-bottom: 10px;
	}

	.description-text {
		color: #555;
		line-height: 1.8;
		font-size: 15px;
	}

	.lessons-preview {
		background: #f9f9f9;
		padding: 20px;
		border-radius: 8px;
	}

	.lesson-preview {
		display: flex;
		align-items: center;
		gap: 15px;
		padding: 12px 0;
		border-bottom: 1px solid #eee;
	}

	.lesson-preview:last-child {
		border-bottom: none;
	}

	.lesson-number {
		background: #667eea;
		color: white;
		width: 30px;
		height: 30px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
		font-size: 12px;
		flex-shrink: 0;
	}

	.lesson-title {
		color: #333;
		font-weight: 500;
	}

	.more-lessons {
		text-align: center;
		color: #999;
		font-style: italic;
		margin: 15px 0 0 0;
		padding-top: 15px;
		border-top: 1px solid #ddd;
	}

	.sidebar {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}

	.enrollment-card,
	.info-card,
	.instructor-card {
		background: white;
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 20px;
	}

	.enrolled-status {
		text-align: center;
	}

	.enrolled-status p {
		color: #155724;
		background: #d4edda;
		padding: 10px;
		border-radius: 4px;
		margin: 0 0 15px 0;
		font-weight: 500;
	}

	.btn {
		display: block;
		width: 100%;
		padding: 12px;
		text-align: center;
		text-decoration: none;
		border: none;
		border-radius: 4px;
		font-weight: 600;
		font-size: 15px;
		cursor: pointer;
		transition: all 0.3s;
		box-sizing: border-box;
	}

	.btn-primary {
		background: #667eea;
		color: white;
	}

	.btn-primary:hover {
		background: #764ba2;
	}

	.btn-secondary {
		background: #f0f0f0;
		color: #333;
	}

	.btn-secondary:hover {
		background: #e0e0e0;
	}

	.btn-large {
		padding: 14px 20px;
		font-size: 16px;
	}

	.enroll-notice {
		text-align: center;
		color: #666;
		font-size: 13px;
		margin: 10px 0 0 0;
	}

	.info-card h3,
	.instructor-card h3 {
		margin: 0 0 15px 0;
		color: #333;
		font-size: 16px;
	}

	.info-grid {
		display: flex;
		flex-direction: column;
		gap: 12px;
	}

	.info-item {
		display: flex;
		justify-content: space-between;
		padding: 10px 0;
		border-bottom: 1px solid #eee;
	}

	.info-item:last-child {
		border-bottom: none;
	}

	.info-item .label {
		color: #666;
		font-weight: 500;
		font-size: 13px;
	}

	.info-item .value {
		color: #333;
		font-weight: 600;
	}

	.instructor-name {
		font-weight: 600;
		color: #333;
		margin: 0 0 10px 0;
	}

	.instructor-email {
		color: #667eea;
		font-size: 13px;
		margin: 0;
	}

	.course-actions {
		margin-top: 30px;
	}

	@media (max-width: 1024px) {
		.course-content {
			grid-template-columns: 1fr;
		}

		.course-header {
			padding: 30px;
		}

		.course-header h1 {
			font-size: 28px;
		}

		.course-meta {
			flex-direction: column;
			gap: 10px;
		}
	}

	@media (max-width: 768px) {
		.course-detail {
			padding: 10px;
		}

		.course-header {
			padding: 20px;
		}

		.course-header h1 {
			font-size: 24px;
		}

		.main-content {
			padding: 20px;
		}

		section h2 {
			font-size: 18px;
		}

		.meta-item {
			flex-direction: column;
			gap: 3px;
		}
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

