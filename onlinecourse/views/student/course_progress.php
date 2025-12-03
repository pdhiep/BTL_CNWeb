<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container course-progress">
	<div class="breadcrumb">
		<a href="index.php?controller=student&action=myCourses">Khóa học của tôi</a> / 
		<a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>">
			<?php echo htmlspecialchars($course['title']); ?>
		</a>
	</div>

	<h1><?php echo htmlspecialchars($course['title']); ?></h1>
	
	<div class="course-header">
		<div class="instructor-info">
			<p><strong>Giáo viên:</strong> <?php echo htmlspecialchars($course['instructor_name'] ?? 'Không xác định'); ?></p>
		</div>
	</div>

	<div class="progress-overview">
		<h2>Tiến độ học tập</h2>
		
		<div class="progress-stats">
			<div class="stat-item">
				<span class="stat-label">Tổng bài học</span>
				<span class="stat-value"><?php echo $progress['total']; ?></span>
			</div>
			
			<div class="stat-item">
				<span class="stat-label">Bài học hoàn thành</span>
				<span class="stat-value"><?php echo $progress['completed']; ?></span>
			</div>
			
			<div class="stat-item">
				<span class="stat-label">Tỷ lệ hoàn thành</span>
				<span class="stat-value"><?php echo $progress['percentage']; ?>%</span>
			</div>
		</div>

		<div class="progress-bar-container">
			<div class="progress-bar">
				<div class="progress-fill" style="width: <?php echo $progress['percentage']; ?>%"></div>
			</div>
			<p class="progress-text"><?php echo $progress['percentage']; ?>% hoàn thành</p>
		</div>
	</div>

	<h2>Danh sách bài học</h2>
	
	<?php if (empty($lessons)): ?>
		<p class="no-lessons">Khóa học này chưa có bài học nào.</p>
	<?php else: ?>
		<div class="lessons-list">
			<?php foreach ($lessons as $index => $lesson): ?>
				<div class="lesson-item">
					<div class="lesson-number">
						<?php echo $index + 1; ?>
					</div>
					
					<div class="lesson-info">
						<h3><?php echo htmlspecialchars($lesson['title'] ?? 'Bài học không có tiêu đề'); ?></h3>
						<p class="lesson-description">
							<?php echo htmlspecialchars(substr($lesson['description'] ?? '', 0, 150)); ?>
							<?php if (strlen($lesson['description'] ?? '') > 150): ?>...<?php endif; ?>
						</p>
					</div>
					
					<div class="lesson-actions">
						<a href="index.php?controller=student&action=viewLesson&id=<?php echo $lesson['id']; ?>" class="btn btn-primary">Xem bài học</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	
	<div class="course-actions">
		<h2>Thao tác khóa học</h2>
		<ul>
			<li>
				<a href="index.php?controller=course&action=detail&id=<?php echo $course['id']; ?>">
					Xem chi tiết khóa học
				</a>
			</li>
			<li>
				<a href="index.php?controller=student&action=myCourses">
					Quay lại danh sách khóa học
				</a>
			</li>
		</ul>
	</div>
</div>

<style>
	.course-progress {
		padding: 20px;
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
		background: #f9f9f9;
		padding: 15px;
		border-radius: 8px;
		margin-bottom: 30px;
	}

	.instructor-info p {
		margin: 5px 0;
		color: #555;
	}

	.progress-overview {
		background: white;
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 25px;
		margin-bottom: 30px;
	}

	.progress-overview h2 {
		margin-top: 0;
		margin-bottom: 20px;
	}

	.progress-stats {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
		gap: 15px;
		margin-bottom: 25px;
	}

	.stat-item {
		text-align: center;
		padding: 15px;
		background: #f5f5f5;
		border-radius: 8px;
	}

	.stat-label {
		display: block;
		font-size: 12px;
		color: #666;
		margin-bottom: 5px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.stat-value {
		display: block;
		font-size: 32px;
		font-weight: bold;
		color: #667eea;
	}

	.progress-bar-container {
		margin-top: 20px;
	}

	.progress-bar {
		height: 30px;
		background: #e9ecef;
		border-radius: 15px;
		overflow: hidden;
		margin-bottom: 10px;
	}

	.progress-fill {
		height: 100%;
		background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
		transition: width 0.3s ease;
		display: flex;
		align-items: center;
		justify-content: center;
		color: white;
		font-size: 12px;
		font-weight: bold;
	}

	.progress-text {
		text-align: center;
		color: #666;
		margin: 0;
		font-size: 13px;
	}

	.no-lessons {
		text-align: center;
		padding: 40px;
		background: #f9f9f9;
		border-radius: 8px;
		color: #666;
	}

	.lessons-list {
		margin-bottom: 30px;
	}

	.lesson-item {
		display: flex;
		gap: 20px;
		padding: 20px;
		border: 1px solid #ddd;
		border-radius: 8px;
		margin-bottom: 15px;
		background: white;
		align-items: flex-start;
		transition: box-shadow 0.2s;
	}

	.lesson-item:hover {
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	}

	.lesson-number {
		flex-shrink: 0;
		width: 40px;
		height: 40px;
		background: #667eea;
		color: white;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: bold;
		font-size: 18px;
	}

	.lesson-info {
		flex: 1;
	}

	.lesson-item h3 {
		margin: 0 0 8px 0;
		color: #333;
		font-size: 16px;
	}

	.lesson-description {
		margin: 0;
		color: #666;
		font-size: 14px;
		line-height: 1.4;
	}

	.lesson-actions {
		flex-shrink: 0;
	}

	.btn {
		display: inline-block;
		padding: 8px 16px;
		background: #667eea;
		color: white;
		text-decoration: none;
		border-radius: 4px;
		font-size: 13px;
		transition: background 0.3s;
		white-space: nowrap;
	}

	.btn:hover {
		background: #764ba2;
	}

	.course-actions {
		background: #f9f9f9;
		padding: 20px;
		border-radius: 8px;
	}

	.course-actions h2 {
		margin-top: 0;
	}

	.course-actions ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.course-actions li {
		margin: 8px 0;
	}

	.course-actions a {
		color: #667eea;
		text-decoration: none;
		font-weight: 500;
	}

	.course-actions a:hover {
		text-decoration: underline;
	}

	@media (max-width: 768px) {
		.lesson-item {
			flex-direction: column;
		}

		.lesson-number {
			align-self: flex-start;
		}

		.progress-stats {
			grid-template-columns: 1fr;
		}
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
