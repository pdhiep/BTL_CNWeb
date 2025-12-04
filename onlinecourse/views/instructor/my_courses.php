<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container my-courses-instructor">
	<h1>Khóa học của tôi</h1>
	
	<div class="actions-bar">
		<a href="index.php?controller=instructor&action=createCourse" class="btn btn-primary">+ Tạo khóa học mới</a>
	</div>

	<?php if (!empty($courses)): ?>
		<table style="width:100%;border-collapse:collapse">
			<thead>
				<tr><th>Tiêu đề</th><th>Mô tả</th><th>Ngày tạo</th><th>Hành động</th></tr>
			</thead>
			<tbody>
			<?php foreach ($courses as $c): ?>
				<tr>
					<td><?php echo htmlspecialchars($c['title']); ?></td>
					<td><?php echo htmlspecialchars(substr($c['description'] ?? '', 0, 50)); ?>...</td>
					<td><?php echo date('d/m/Y', strtotime($c['created_at'])); ?></td>
					<td>
						<a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>">Xem</a>
						<a href="index.php?controller=lesson&action=manage&course_id=<?php echo $c['id']; ?>">Bài học</a>
						<a href="index.php?controller=instructor&action=students&course_id=<?php echo $c['id']; ?>">Học viên</a>
						<a href="index.php?controller=instructor&action=editCourse&id=<?php echo $c['id']; ?>">Sửa</a>
						<a href="index.php?controller=instructor&action=deleteCourse&id=<?php echo $c['id']; ?>" onclick="return confirm('Xóa khóa học này?');">Xóa</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<p>Bạn chưa tạo khóa học nào. <a href="index.php?controller=instructor&action=createCourse">Tạo ngay →</a></p>
	<?php endif; ?>
	
	<div class="back-link">
		<a href="index.php?controller=instructor&action=dashboard">← Quay lại Dashboard</a>
	</div>
</div>

<style>
	.my-courses-instructor {
		padding: 20px;
	}

	.actions-bar {
		margin: 20px 0;
	}

	.btn-primary {
		display: inline-block;
		background: #667eea;
		color: white;
		padding: 10px 20px;
		border-radius: 4px;
		text-decoration: none;
		font-weight: 500;
		transition: background 0.3s;
	}

	.btn-primary:hover {
		background: #764ba2;
	}

	table {
		margin: 20px 0;
		width: 100%;
		border-collapse: collapse;
	}

	table thead {
		background: #f5f5f5;
	}

	table th, table td {
		padding: 12px;
		text-align: left;
		border: 1px solid #ddd;
	}

	table a {
		color: #667eea;
		text-decoration: none;
		margin-right: 8px;
		font-size: 13px;
	}

	table a:hover {
		text-decoration: underline;
	}

	.back-link {
		margin-top: 20px;
	}

	.back-link a {
		color: #667eea;
		text-decoration: none;
		font-weight: 500;
	}

	.back-link a:hover {
		text-decoration: underline;
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
