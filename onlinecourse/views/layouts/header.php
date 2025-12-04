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
			<?php
				// session stores numeric roles: 0=student,1=instructor,2=admin
				$roleNum = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : 0;
				$r = ($roleNum === 0) ? 'student' : (($roleNum === 1) ? 'instructor' : (($roleNum === 2) ? 'admin' : 'student'));
			?>
			<?php if ($r !== 'instructor' && $r !== 'admin'): ?>
				<a href="index.php?controller=course&action=index">Khóa học</a>
			<?php endif; ?>
			<?php if (isset($_SESSION['user_id'])): ?>
				<?php if ($r === 'student'): ?>
					<a href="index.php?controller=student&action=dashboard">Dashboard</a>
					<a href="index.php?controller=student&action=myCourses">Khóa học của tôi</a>
				<?php elseif ($r === 'instructor'): ?>
					<a href="index.php?controller=instructor&action=dashboard">Giảng viên</a>
					<a href="index.php?controller=instructor&action=manage">Quản lý khóa học</a>
					<a href="index.php?controller=instructor&action=createCourse">Tạo khóa học</a>
				<?php elseif ($r === 'admin'): ?>
					<a href="index.php?controller=admin&action=dashboard">Quản trị</a>
					<a href="index.php?controller=admin&action=users">Quản lý người dùng</a>
					<a href="index.php?controller=admin&action=categories">Danh mục</a>
				<?php endif; ?>
			<?php endif; ?>
		</nav>
		<div class="user-section">
			<?php if (session_status() == PHP_SESSION_NONE) session_start(); ?>
			<?php if (isset($_SESSION['user_id'])): ?>
				<?php $roleNum = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : 0; 
					$roleLabel = ($roleNum === 2) ? 'Admin' : (($roleNum === 1) ? 'Giảng viên' : 'Học viên'); ?>
				<span>👤 <?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Người dùng'; ?> (<?php echo htmlspecialchars($roleLabel); ?>)</span>
				<a href="index.php?controller=profile&action=index">⚙️ Hồ sơ</a>
				<a href="index.php?controller=auth&action=logout">Đăng xuất</a>
			<?php else: ?>
				<a href="index.php?controller=auth&action=login">Đăng nhập</a>
				<a href="index.php?controller=auth&action=register">Đăng ký</a>
			<?php endif; ?>
		</div>
	</div>
</header>

