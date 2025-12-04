<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container my-courses">
	<h1>Khóa học của tôi</h1>
	
	<div class="filter-tabs">
		<a href="index.php?controller=student&action=myCourses&filter=all" 
		   class="tab <?php echo ($filter === 'all') ? 'active' : ''; ?>">
			Tất cả (<?php echo count($enrolledCourses); ?>)
		</a>
		<a href="index.php?controller=student&action=myCourses&filter=active" 
		   class="tab <?php echo ($filter === 'active') ? 'active' : ''; ?>">
			Đang học (<?php echo count(array_filter($enrolledCourses, function($c) { return !$c['completed']; })); ?>)
		</a>
		<a href="index.php?controller=student&action=myCourses&filter=completed" 
		   class="tab <?php echo ($filter === 'completed') ? 'active' : ''; ?>">
			Hoàn thành (<?php echo count(array_filter($enrolledCourses, function($c) { return $c['completed']; })); ?>)
		</a>
	</div>

	<?php if (empty($enrolledCourses)): ?>
		<div class="empty-state">
			<h2>Bạn chưa đăng ký khóa học nào</h2>
			<p>Hãy khám phá các khóa học có sẵn và đăng ký những khóa học mà bạn quan tâm.</p>
			<a href="index.php?controller=course&action=index" class="btn btn-primary">Khám phá khóa học</a>
		</div>
	<?php else: ?>
		<div class="courses-list">
			<?php foreach ($enrolledCourses as $course): ?>
				<div class="course-item">
					<div class="course-info">
						<h3><?php echo htmlspecialchars($course['title']); ?></h3>
						
						<div class="course-meta">
							<?php
								$enrolledRaw = $course['enrolled_at'] ?? null;
								$enrolledDate = $enrolledRaw ? date('d/m/Y', strtotime($enrolledRaw)) : '';
							?>
							<span class="instructor">👨‍🏫 <?php echo htmlspecialchars($course['instructor_name'] ?? 'Không xác định'); ?></span>
							<?php if ($enrolledDate !== ''): ?>
								<span class="enrolled-date">📅 Đăng ký: <?php echo $enrolledDate; ?></span>
							<?php endif; ?>
						</div>
						
						<p class="course-description">
							<?php echo htmlspecialchars(substr($course['description'], 0, 200)); ?>
							<?php if (strlen($course['description']) > 200): ?>...<?php endif; ?>
						</p>
					</div>
					
					<div class="course-status">
						<?php if ($course['completed']): ?>
							<?php
								$completedRaw = $course['completed_at'] ?? null;
								if (!$completedRaw) {
									$completedRaw = $course['enrolled_at'] ?? null;
								}
								$completedDate = $completedRaw ? date('d/m/Y', strtotime($completedRaw)) : '';
							?>
							<div class="status-badge completed">
								<span>✓ Hoàn thành</span>
								<?php if ($completedDate !== ''): ?>
									<span class="date"><?php echo $completedDate; ?></span>
								<?php endif; ?>
							</div>
						<?php else: ?>
							<div class="status-badge active">Đang học</div>
						<?php endif; ?>
						
						<div class="course-actions">
							<a href="index.php?controller=student&action=courseProgress&id=<?php echo $course['id']; ?>" class="btn btn-primary">Xem tiến độ</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	
	<div class="back-to-dashboard">
		<a href="index.php?controller=student&action=dashboard">← Quay lại Dashboard</a>
	</div>
</div>

<style>
	.my-courses {
		padding: 20px;
	}

	.filter-tabs {
		display: flex;
		gap: 10px;
		margin: 20px 0;
		border-bottom: 2px solid #eee;
	}

	.filter-tabs .tab {
		padding: 10px 20px;
		text-decoration: none;
		color: #666;
		font-weight: 500;
		border-bottom: 3px solid transparent;
		transition: all 0.3s;
	}

	.filter-tabs .tab:hover {
		color: #667eea;
	}

	.filter-tabs .tab.active {
		color: #667eea;
		border-bottom-color: #667eea;
	}

	.empty-state {
		text-align: center;
		padding: 60px 20px;
		background: #f9f9f9;
		border-radius: 8px;
		margin: 30px 0;
	}

	.empty-state h2 {
		color: #333;
		margin: 0 0 10px 0;
	}

	.empty-state p {
		color: #666;
		margin: 0 0 20px 0;
	}

	.courses-list {
		margin: 30px 0;
	}

	.course-item {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		gap: 20px;
		padding: 20px;
		border: 1px solid #ddd;
		border-radius: 8px;
		margin-bottom: 15px;
		background: white;
		transition: box-shadow 0.2s;
	}

	.course-item:hover {
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	}

	.course-info {
		flex: 1;
	}

	.course-item h3 {
		margin: 0 0 10px 0;
		color: #333;
		font-size: 18px;
	}

	.course-meta {
		display: flex;
		gap: 15px;
		font-size: 13px;
		color: #666;
		margin-bottom: 10px;
	}

	.course-description {
		margin: 10px 0 0 0;
		color: #555;
		line-height: 1.5;
	}

	.course-status {
		display: flex;
		flex-direction: column;
		align-items: flex-end;
		gap: 10px;
		min-width: 150px;
	}

	.status-badge {
		padding: 8px 16px;
		border-radius: 20px;
		font-size: 13px;
		font-weight: bold;
		text-align: center;
		width: 100%;
	}

	.status-badge.active {
		background: #cfe2ff;
		color: #084298;
	}

	.status-badge.completed {
		background: #d4edda;
		color: #155724;
		display: flex;
		flex-direction: column;
		gap: 5px;
	}

	.status-badge .date {
		font-size: 11px;
		opacity: 0.9;
	}

	.course-actions {
		width: 100%;
	}

	.btn {
		display: block;
		padding: 8px 16px;
		background: #667eea;
		color: white;
		text-decoration: none;
		border-radius: 4px;
		font-size: 13px;
		text-align: center;
		transition: background 0.3s;
		width: 100%;
		box-sizing: border-box;
	}

	.btn:hover {
		background: #764ba2;
	}

	.back-to-dashboard {
		margin-top: 30px;
	}

	.back-to-dashboard a {
		color: #667eea;
		text-decoration: none;
		font-weight: 500;
	}

	.back-to-dashboard a:hover {
		text-decoration: underline;
	}

	@media (max-width: 768px) {
		.course-item {
			flex-direction: column;
		}

		.course-status {
			align-items: stretch;
		}

		.course-meta {
			flex-direction: column;
			gap: 5px;
		}
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
