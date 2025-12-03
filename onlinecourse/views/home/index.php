<section class="hero">
	<h1>Hệ thống khóa học trực tuyến</h1>
	<p>Đăng ký và quản lý khóa học của bạn mọi lúc mọi nơi.</p>
	<?php if (empty($_SESSION['user'])) : ?>
	<div class="hero-actions">
		<a class="btn primary" href="index.php?controller=auth&action=register">Bắt đầu ngay</a>
		<a class="btn" href="index.php?controller=auth&action=login">Đăng nhập</a>
	</div>
	<?php else : ?>
	<p>Xin chào <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'bạn'); ?>!<br>Tiếp tục học tập hoặc cập nhật tài khoản của bạn.</p>
	<a class="btn primary" href="index.php?controller=auth&action=profile">Quản lý tài khoản</a>
	<?php endif; ?>
</section>
