<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Online Course</title>
    <link rel="stylesheet" href="/BTTH2/onlinecourse/assets/css/style.css">
</head>
<body>
<header>
    <h1>Online Course</h1>
    <nav>
        <a href="/BTTH2/onlinecourse/">Trang chủ</a>
        <a href="/BTTH2/onlinecourse/courses/index">Khóa học</a>

        <?php if (!empty($_SESSION['user'])): ?>
            <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['fullname']); ?></span>
            <a href="/BTTH2/onlinecourse/auth/logout">Đăng xuất</a>
        <?php else: ?>
            <a href="/BTTH2/onlinecourse/auth/login">Đăng nhập</a>
        <?php endif; ?>
    </nav>
</header>
<main>
