<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?>Online Course Platform</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<?php $currentUser = $_SESSION['user'] ?? null; ?>
	<header class="app-header">
		<div class="branding">Online Course</div>
		<nav class="header-nav">
			<a href="index.php?controller=home&action=index">Trang chủ</a>
			<?php if ($currentUser) : ?>
			<a href="index.php?controller=auth&action=profile">Tài khoản</a>
			<a href="index.php?controller=auth&action=logout">Đăng xuất</a>
			<?php else : ?>
			<a href="index.php?controller=auth&action=login">Đăng nhập</a>
			<a href="index.php?controller=auth&action=register">Đăng ký</a>
			<?php endif; ?>
		</nav>
	</header>
	<?php if (!empty($_SESSION['flash'])) : ?>
	<section class="flash-container">
		<?php foreach ($_SESSION['flash'] as $type => $messages) : ?>
		<div class="alert <?php echo $type; ?>">
			<ul>
				<?php foreach ((array) $messages as $message) : ?>
				<li><?php echo htmlspecialchars($message); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endforeach; ?>
	</section>
	<?php unset($_SESSION['flash']); ?>
	<?php endif; ?>
	<main class="app-main">
