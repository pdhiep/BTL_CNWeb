<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container student-dashboard">
	<h1>Dashboard Học Viên</h1>
	
	<div class="stats-grid">
		<div class="stat-card">
			<h3>Khóa học đã đăng ký</h3>
			<p class="stat-number"><?php echo $totalEnrolled; ?></p>
			<a href="index.php?controller=student&action=myCourses">Xem chi tiết</a>
		</div>
		
		<div class="stat-card">
			<h3>Khóa học hoàn thành</h3>
			<p class="stat-number"><?php echo $completedCourses; ?></p>
			<a href="index.php?controller=student&action=myCourses&filter=completed">Xem chi tiết</a>
		</div>
		
		<div class="stat-card">
			<h3>Khóa học đang học</h3>
			<p class="stat-number"><?php echo $totalEnrolled - $completedCourses; ?></p>
			<a href="index.php?controller=student&action=myCourses&filter=active">Xem chi tiết</a>
		</div>
	</div>

	<h2>Khóa học gần đây</h2>
	
	<?php if (empty($enrolledCourses)): ?>
		<p class="no-courses">Bạn chưa đăng ký khóa học nào. 
			<a href="index.php?controller=course&action=index">Khám phá khóa học</a>
		</p>
	<?php else: ?>
		<div class="courses-grid">
			<?php foreach (array_slice($enrolledCourses, 0, 3) as $course): ?>
				<div class="course-card">
					<h3><?php echo htmlspecialchars($course['title']); ?></h3>
					<p class="course-instructor">Giáo viên: <?php echo htmlspecialchars($course['instructor_name'] ?? 'Không xác định'); ?></p>
					<p class="course-date">Đăng ký: <?php echo date('d/m/Y', strtotime($course['enrolled_at'] ?? date('Y-m-d'))); ?></p>
					
					<?php if ($course['completed']): ?>
						<p class="status completed">✓ Đã hoàn thành</p>
					<?php else: ?>
						<p class="status active">Đang học</p>
					<?php endif; ?>
					
					<div class="actions">
						<a href="index.php?controller=student&action=courseProgress&id=<?php echo $course['id']; ?>" class="btn btn-primary">Xem tiến độ</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		
		<?php if ($totalEnrolled > 3): ?>
			<p class="more-courses"><a href="index.php?controller=student&action=myCourses">Xem tất cả khóa học »</a></p>
		<?php endif; ?>
	<?php endif; ?>
	
	<div class="actions-section">
		<h2>Thao tác nhanh</h2>
		<ul>
			<li><a href="index.php?controller=course&action=index">Tìm khóa học mới</a></li>
			<li><a href="index.php?controller=student&action=myCourses">Quản lý khóa học của tôi</a></li>
		</ul>
	</div>
</div>

<style>
	.student-dashboard {
		padding: 20px;
	}

	.stats-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
		gap: 20px;
		margin: 30px 0;
	}

	.stat-card {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		padding: 20px;
		border-radius: 8px;
		text-align: center;
		box-shadow: 0 4px 6px rgba(0,0,0,0.1);
	}

	.stat-card h3 {
		margin: 0 0 10px 0;
		font-size: 14px;
		opacity: 0.9;
	}

	.stat-card .stat-number {
		font-size: 36px;
		font-weight: bold;
		margin: 10px 0;
	}

	.stat-card a {
		color: white;
		text-decoration: none;
		font-size: 14px;
		padding: 8px 16px;
		background: rgba(255,255,255,0.2);
		border-radius: 4px;
		display: inline-block;
		margin-top: 10px;
		transition: background 0.3s;
	}

	.stat-card a:hover {
		background: rgba(255,255,255,0.3);
	}

	.courses-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
		gap: 20px;
		margin: 20px 0;
	}

	.course-card {
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 20px;
		background: white;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		transition: transform 0.2s, box-shadow 0.2s;
	}

	.course-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 4px 8px rgba(0,0,0,0.15);
	}

	.course-card h3 {
		margin: 0 0 10px 0;
		color: #333;
	}

	.course-instructor, .course-date {
		font-size: 13px;
		color: #666;
		margin: 5px 0;
	}

	.status {
		display: inline-block;
		padding: 6px 12px;
		border-radius: 20px;
		font-size: 12px;
		font-weight: bold;
		margin: 10px 0;
	}

	.status.completed {
		background: #d4edda;
		color: #155724;
	}

	.status.active {
		background: #cfe2ff;
		color: #084298;
	}

	.course-card .actions {
		margin-top: 15px;
	}

	.btn {
		display: inline-block;
		padding: 8px 16px;
		background: #667eea;
		color: white;
		text-decoration: none;
		border-radius: 4px;
		font-size: 14px;
		transition: background 0.3s;
	}

	.btn:hover {
		background: #764ba2;
	}

	.no-courses {
		background: #f0f0f0;
		padding: 20px;
		border-radius: 8px;
		text-align: center;
		margin: 20px 0;
	}

	.no-courses a {
		color: #667eea;
		text-decoration: none;
		font-weight: bold;
	}

	.more-courses {
		text-align: center;
		margin: 20px 0;
	}

	.more-courses a {
		color: #667eea;
		text-decoration: none;
		font-weight: bold;
	}

	.actions-section {
		margin-top: 40px;
		padding: 20px;
		background: #f9f9f9;
		border-radius: 8px;
	}

	.actions-section h2 {
		margin-top: 0;
	}

	.actions-section ul {
		list-style: none;
		padding: 0;
	}

	.actions-section li {
		padding: 8px 0;
	}

	.actions-section a {
		color: #667eea;
		text-decoration: none;
		font-weight: 500;
	}

	.actions-section a:hover {
		text-decoration: underline;
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
