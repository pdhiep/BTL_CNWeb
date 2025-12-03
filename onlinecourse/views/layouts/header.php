<?php
// giả sử BASE_URL đã define ở index.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Online Course</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
<header class="main-header">
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>">OnlineCourse</a>
    </div>
    <nav>
        <a href="<?php echo BASE_URL; ?>">Trang chủ</a>
        <a href="<?php echo BASE_URL; ?>courses">Khóa học</a>
        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] == 0): ?>
            <a href="<?php echo BASE_URL; ?>student/dashboard">Dashboard học viên</a>
        <?php elseif (!empty($_SESSION['user']) && $_SESSION['user']['role'] == 1): ?>
            <a href="<?php echo BASE_URL; ?>instructor/dashboard">Dashboard giảng viên</a>
        <?php elseif (!empty($_SESSION['user']) && $_SESSION['user']['role'] == 2): ?>
            <a href="<?php echo BASE_URL; ?>admin/dashboard">Admin</a>
        <?php endif; ?>

        <?php if (empty($_SESSION['user'])): ?>
            <a href="<?php echo BASE_URL; ?>auth/login">Đăng nhập</a>
            <a href="<?php echo BASE_URL; ?>auth/register">Đăng ký</a>
        <?php else: ?>
            <span style="margin-left:16px;">
                Xin chào,
                <?php echo htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']); ?>
            </span>
            <a href="<?php echo BASE_URL; ?>auth/logout">Đăng xuất</a>
        <?php endif; ?>
    </nav>
</header>
<div class="main-container">
