<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container">
	<h2>Tạo bài học cho: <?php echo htmlspecialchars($course['title']); ?></h2>

	<?php if (!empty($message)): ?>
		<div style="color:red"><?php echo htmlspecialchars($message); ?></div>
	<?php endif; ?>

	<form method="post" action="index.php?controller=lesson&action=create&course_id=<?php echo $course['id']; ?>">
		<div>
			<label>Tiêu đề</label><br>
			<input type="text" name="title" required style="width:480px;padding:8px">
		</div>
		<div style="margin-top:8px">
			<label>Nội dung</label><br>
			<textarea name="content" rows="6" style="width:480px"></textarea>
		</div>
		<div style="margin-top:8px">
			<label>Thứ tự</label><br>
			<input type="number" name="order" value="0">
		</div>
		<div style="margin-top:12px">
			<button type="submit">Tạo</button>
			<a href="index.php?controller=lesson&action=manage&course_id=<?php echo $course['id']; ?>">Hủy</a>
		</div>
	</form>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
