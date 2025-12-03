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
		.site-header a:hover{text-decoration:underline}
		.container{padding:16px}
		.nav-links{display:inline-block;margin-left:20px}
		.user-section{float:right;display:flex;gap:15px;align-items:center}
		@media (max-width: 768px) {
			.site-header {padding: 8px}
			.nav-links {margin-left: 10px; font-size: 13px}
			.nav-links a {margin-right: 8px}
			.user-section {gap: 8px; font-size: 13px}
		}
	</style>
</head>
<body>
<header class="site-header">
	<div class="container">
		<a href="index.php" style="font-weight:bold;color:#fff;font-size:18px;">📚 Trang học trực tuyến</a>
		<nav class="nav-links">
			<a href="index.php?controller=course&action=index">Khóa học</a>
			<?php if (isset($_SESSION['user_id'])): ?>
				<a href="index.php?controller=student&action=dashboard">Dashboard</a>
				<a href="index.php?controller=student&action=myCourses">Khóa học của tôi</a>
			<?php endif; ?>
		</nav>
		<div class="user-section">
			<?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
			<?php if (isset($_SESSION['user_id'])): ?>
				<span>👤 <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Học viên'; ?></span>
				<a href="index.php?controller=auth&action=logout">Đăng xuất</a>
			<?php else: ?>
				<a href="index.php?controller=auth&action=login">Đăng nhập</a>
				<a href="index.php?controller=auth&action=register">Đăng ký</a>
			<?php endif; ?>
		</div>
	</div>
</header>

