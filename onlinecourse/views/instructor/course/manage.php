<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
	<h2>Quản lý khóa học</h2>

	<?php if (!empty($courses)): ?>
		<ul>
			<?php foreach ($courses as $c): ?>
				<li>
					<?php echo htmlspecialchars($c['title']); ?>
					- <a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>">Xem</a>
					- <a href="index.php?controller=lesson&action=manage&course_id=<?php echo $c['id']; ?>">Bài học</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else: ?>
		<p>Không có khóa học để quản lý.</p>
	<?php endif; ?>

</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
