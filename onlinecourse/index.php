<?php
session_start();

require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/controllers/AuthController.php';

$db = (new Database())->getConnection();
$auth = new AuthController($db);

$action = $_GET['action'] ?? '';
switch ($action) {
	case 'register':
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$auth->register();
		} else {
			$auth->showRegister();
		}
		break;
	case 'login':
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$auth->login();
		} else {
			$auth->showLogin();
		}
		break;
	case 'logout':
		$auth->logout();
		break;
	case 'profile':
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$auth->updateProfile();
		} else {
			$auth->profile();
		}
		break;
	default:
		// Simple homepage
		include __DIR__ . '/views/layouts/header.php';
		echo '<div class="container">';
		if (!empty($_SESSION['user'])) {
			echo '<h2>Xin chào, ' . htmlspecialchars($_SESSION['user']['name']) . '</h2>';
			echo '<p><a href="index.php?action=profile">Quản lý tài khoản</a> | <a href="index.php?action=logout">Đăng xuất</a></p>';
		} else {
			echo '<h2>Chào mừng tới OnlineCourse (phần demo)</h2>';
			echo '<p><a href="index.php?action=login">Đăng nhập</a> | <a href="index.php?action=register">Đăng ký</a></p>';
		}
		echo '</div>';
		include __DIR__ . '/views/layouts/footer.php';
		break;
}
