<?php
// $role truyền từ controller: 'student', 'instructor', 'admin'
?>
<div class="app-layout">
    <aside class="sidebar">
        <h3>
            <?php
            if ($role === 'student') echo 'Học viên';
            elseif ($role === 'instructor') echo 'Giảng viên';
            else echo 'Quản trị';
            ?>
        </h3>
        <ul>
            <?php if ($role === 'student'): ?>
                <li><a href="<?php echo BASE_URL; ?>student/dashboard">Dashboard</a></li>
                <li><a href="<?php echo BASE_URL; ?>student/myCourses">Khóa học của tôi</a></li>
                <li><a href="<?php echo BASE_URL; ?>profile/settings">Hồ sơ cá nhân</a></li>
            <?php elseif ($role === 'instructor'): ?>
                <li><a href="<?php echo BASE_URL; ?>instructor/dashboard">Dashboard</a></li>
                <li><a href="<?php echo BASE_URL; ?>instructor/myCourses">Khóa học của tôi</a></li>
            <?php else: ?>
                <li><a href="<?php echo BASE_URL; ?>admin/dashboard">Dashboard</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/users">Người dùng</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/categories">Danh mục</a></li>
                <li><a href="<?php echo BASE_URL; ?>admin/reports">Thống kê</a></li>
            <?php endif; ?>
        </ul>
    </aside>
    <main class="app-content">
