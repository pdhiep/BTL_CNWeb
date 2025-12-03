<!doctype html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trang học trực tuyến</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<style>
		body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:0}
		.site-header{background:#007bff;color:#fff;padding:12px}
		.site-header a{color:#fff;margin-right:12px;text-decoration:none}
		.container{padding:16px}
	</style>
</head>
<body>
<header class="site-header">
	<div class="container">
		<a href="index.php" style="font-weight:bold;color:#fff;">Trang học trực tuyến</a>
		<nav style="display:inline-block;margin-left:20px">
			<a href="index.php?controller=course&action=index">Khóa học</a>
		</nav>
		<div style="float:right">
			<?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
			<?php if (isset($_SESSION['user_id'])): ?>
				<span>Xin chào, <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Học viên'; ?></span>
				<a href="index.php?controller=auth&action=logout">Đăng xuất</a>
			<?php else: ?>
				<a href="index.php?controller=auth&action=login">Đăng nhập</a>
				<a href="index.php?controller=auth&action=register">Đăng ký</a>
			<?php endif; ?>
		</div>
	</div>
</header>

