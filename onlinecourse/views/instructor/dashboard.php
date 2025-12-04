<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container instructor-dashboard">
	<h1>Bảng Điều Khiển Giảng Viên</h1>
	<p>Xin chào, <strong><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Giảng viên'; ?></strong></p>

	<div class="stats-section">
		<div class="stat-card">
			<h3>Khóa học của tôi</h3>
			<p class="stat-value"><?php echo count($courses); ?></p>
			<a href="index.php?controller=instructor&action=my_courses">Xem chi tiết →</a>
		</div>
		<div class="stat-card">
			<h3>Tổng học viên</h3>
			<p class="stat-value"><?php echo $totalEnrolled; ?></p>
			<a href="index.php?controller=instructor&action=manage">Quản lý →</a>
		</div>
	</div>

	<div class="courses-section">
		<h2>Khóa học của bạn</h2>
		<?php if (!empty($courses)): ?>
			<div class="courses-list">
				<?php foreach ($courses as $c): ?>
					<div class="course-item">
						<div class="course-info">
							<h3><?php echo htmlspecialchars($c['title']); ?></h3>
							<p><?php echo htmlspecialchars(substr($c['description'] ?? '', 0, 100)); ?></p>
						</div>
						<div class="course-actions">
							<a href="index.php?controller=lesson&action=manage&course_id=<?php echo $c['id']; ?>" class="btn btn-small">Bài học</a>
							<a href="index.php?controller=instructor&action=students&course_id=<?php echo $c['id']; ?>" class="btn btn-small">Học viên</a>
							<a href="index.php?controller=instructor&action=editCourse&id=<?php echo $c['id']; ?>" class="btn btn-small">Sửa</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<p>Bạn chưa có khóa học nào. <a href="index.php?controller=instructor&action=createCourse">Tạo khóa học →</a></p>
		<?php endif; ?>
	</div>

	<div class="quick-actions">
		<h2>Thao tác nhanh</h2>
		<ul>
			<li><a href="index.php?controller=instructor&action=createCourse">➕ Tạo khóa học mới</a></li>
			<li><a href="index.php?controller=instructor&action=my_courses">📚 Quản lý khóa học</a></li>
			<li><a href="index.php?controller=course&action=index">🔍 Xem danh sách khóa học</a></li>
		</ul>
	</div>
</div>

<style>
	.instructor-dashboard {
		padding: 20px;
	}

	.stats-section {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 20px;
		margin: 30px 0;
	}

	.stat-card {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: white;
		padding: 25px;
		border-radius: 8px;
		text-align: center;
	}

	.stat-card h3 {
		margin: 0 0 10px 0;
		font-size: 14px;
		opacity: 0.9;
	}

	.stat-card .stat-value {
		font-size: 32px;
		font-weight: bold;
		margin: 15px 0;
	}

	.stat-card a {
		color: white;
		text-decoration: none;
		font-size: 13px;
		display: inline-block;
		background: rgba(255,255,255,0.2);
		padding: 6px 12px;
		border-radius: 4px;
		transition: background 0.3s;
	}

	.stat-card a:hover {
		background: rgba(255,255,255,0.3);
	}

	.courses-section {
		margin: 30px 0;
	}

	.courses-section h2 {
		margin-bottom: 20px;
	}

	.courses-list {
		display: flex;
		flex-direction: column;
		gap: 15px;
	}

	.course-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 20px;
		border: 1px solid #ddd;
		border-radius: 8px;
		background: white;
		transition: box-shadow 0.2s;
	}

	.course-item:hover {
		box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	}

	.course-info {
		flex: 1;
	}

	.course-info h3 {
		margin: 0 0 8px 0;
		color: #333;
	}

	.course-info p {
		margin: 0;
		color: #666;
		font-size: 13px;
	}

	.course-actions {
		display: flex;
		gap: 8px;
	}

	.btn-small {
		padding: 6px 12px;
		background: #667eea;
		color: white;
		text-decoration: none;
		border-radius: 4px;
		font-size: 12px;
		transition: background 0.3s;
		display: inline-block;
	}

	.btn-small:hover {
		background: #764ba2;
	}

	.quick-actions {
		background: #f9f9f9;
		padding: 20px;
		border-radius: 8px;
		margin-top: 30px;
	}

	.quick-actions ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.quick-actions li {
		margin: 8px 0;
	}

	.quick-actions a {
		color: #667eea;
		text-decoration: none;
		font-weight: 500;
	}

	.quick-actions a:hover {
		text-decoration: underline;
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
