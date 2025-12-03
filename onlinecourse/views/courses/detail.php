<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
	<h1><?php echo htmlspecialchars($course['title']); ?></h1>

	<?php if (!empty($message)): ?>
		<p style="color:green"><?php echo htmlspecialchars($message); ?></p>
	<?php endif; ?>

	<div>
		<?php echo nl2br(htmlspecialchars($course['description'])); ?>
	</div>

	<?php
		$isEnrolled = isset($isEnrolled) ? $isEnrolled : false;
	?>
	<?php if ($isEnrolled): ?>
		<button disabled style="opacity:0.6">Bạn đã đăng ký</button>
	<?php else: ?>
		<form method="post" action="index.php?controller=course&action=enroll">
			<input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
			<button type="submit">Đăng ký khóa học</button>
		</form>
	<?php endif; ?>

	<p><a href="index.php?controller=course&action=index">Quay lại danh sách</a></p>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

