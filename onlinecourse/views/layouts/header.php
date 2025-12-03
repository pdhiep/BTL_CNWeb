<!doctype html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>OnlineCourse</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
	<nav>
		<a href="index.php">Home</a>
	</nav>
	<div class="container">
		<?php
		if (!empty($_SESSION['flash_success'])) {
			echo '<div class="alert success">' . htmlspecialchars($_SESSION['flash_success']) . '</div>';
			unset($_SESSION['flash_success']);
		}
		if (!empty($_SESSION['flash_errors'])) {
			echo '<div class="alert error"><ul>';
			foreach ($_SESSION['flash_errors'] as $e) {
				echo '<li>' . htmlspecialchars($e) . '</li>';
			}
			echo '</ul></div>';
			unset($_SESSION['flash_errors']);
		}
		?>
	</div>
</header>
