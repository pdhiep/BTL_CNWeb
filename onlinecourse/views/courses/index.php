<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
	<h1>Danh sách khóa học</h1>

	<form method="get" action="index.php">
		<input type="hidden" name="controller" value="course">
		<input type="hidden" name="action" value="index">
		<input type="text" name="q" placeholder="Tìm kiếm khóa học..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
		<button type="submit">Tìm</button>
	</form>

	<?php if (empty($courses)): ?>
		<p>Không có khóa học nào.</p>
	<?php else: ?>
		<ul>
		<?php
			$enrolledIds = isset($enrolledIds) ? $enrolledIds : [];
			foreach ($courses as $c):
				$already = in_array($c['id'], $enrolledIds);
		?>
			<li>
				<h3><?php echo htmlspecialchars($c['title']); ?></h3>
				<p><?php echo nl2br(htmlspecialchars(substr($c['description'], 0, 300))); ?><?php echo strlen($c['description'])>300 ? '...' : ''; ?></p>
				<p>
					<a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>">Xem chi tiết</a>
				</p>
				<?php if ($already): ?>
					<button disabled style="opacity:0.6">Đã đăng ký</button>
				<?php else: ?>
					<form method="post" action="index.php?controller=course&action=enroll" style="display:inline-block;">
						<input type="hidden" name="course_id" value="<?php echo $c['id']; ?>">
						<button type="submit">Đăng ký</button>
					</form>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

