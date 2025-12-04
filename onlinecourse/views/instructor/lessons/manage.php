<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
	<h2>Quản lý bài học cho: <?php echo htmlspecialchars($course['title']); ?></h2>

	<?php if (!empty($lessons)): ?>
		<ul>
			<?php foreach ($lessons as $l): ?>
				<li>
					<strong><?php echo htmlspecialchars($l['title']); ?></strong>
					<a href="index.php?controller=lesson&action=edit&id=<?php echo $l['id']; ?>">Sửa</a>
					<a href="index.php?controller=lesson&action=delete&id=<?php echo $l['id']; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<p>Chưa có bài học nào.</p>
	<?php endif; ?>

	<p><a href="index.php?controller=lesson&action=create&course_id=<?php echo $course['id']; ?>">Tạo bài học mới</a></p>
	<p><a href="index.php?controller=instructor&action=manage">Quay lại quản lý khoá học</a></p>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>

