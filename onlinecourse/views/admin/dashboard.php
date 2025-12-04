<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container admin-dashboard">
    <h1>Bảng Điều Khiển Quản Trị</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Tổng người dùng</h3>
            <p class="stat-value"><?php echo htmlspecialchars($stats['total_users']); ?></p>
            <a href="index.php?controller=admin&action=users">Quản lý →</a>
        </div>
        <div class="stat-card">
            <h3>Tổng khóa học</h3>
            <p class="stat-value"><?php echo htmlspecialchars($stats['total_courses']); ?></p>
            <a href="index.php?controller=admin&action=pendingCourses">Duyệt →</a>
        </div>
        <div class="stat-card">
            <h3>Tổng đăng ký</h3>
            <p class="stat-value"><?php echo htmlspecialchars($stats['total_enrollments']); ?></p>
        </div>
        <div class="stat-card">
            <h3>Doanh thu ước tính</h3>
            <p class="stat-value"><?php echo htmlspecialchars($stats['revenue'] ?? 0); ?></p>
        </div>
    </div>

    <div class="alert-section">
        <?php if (intval($stats['pending_courses'] ?? 0) > 0): ?>
            <div class="alert alert-warning">
                <strong>Cảnh báo:</strong> Có <?php echo intval($stats['pending_courses']); ?> khóa học chờ duyệt. 
                <a href="index.php?controller=admin&action=pendingCourses">Xem danh sách →</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="admin-menu">
        <h2>Thao tác quản lý</h2>
        <div class="menu-grid">
            <div class="menu-item">
                <h3>👥 Người dùng</h3>
                <a href="index.php?controller=admin&action=users">Quản lý người dùng</a>
                <p>Kích hoạt, vô hiệu hoá, xem thông tin người dùng</p>
            </div>
            <div class="menu-item">
                <h3>📚 Danh mục</h3>
                <a href="index.php?controller=admin&action=categories">Quản lý danh mục</a>
                <p>Tạo, chỉnh sửa, xóa danh mục khóa học</p>
            </div>
            <div class="menu-item">
                <h3>✓ Duyệt khóa học</h3>
                <a href="index.php?controller=admin&action=pendingCourses">Khóa học chờ duyệt</a>
                <p>Duyệt hoặc từ chối các khóa học mới</p>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-dashboard {
        padding: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px;
        border-radius: 8px;
        text-align: center;
    }

    .stat-card h3 {
        margin: 0 0 10px 0;
        font-size: 14px;
        opacity: 0.9;
    }

    .stat-card .stat-value {
        font-size: 32px;
        font-weight: bold;
        margin: 15px 0;
    }

    .stat-card a {
        color: white;
        text-decoration: none;
        font-size: 13px;
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 6px 12px;
        border-radius: 4px;
        transition: background 0.3s;
    }

    .stat-card a:hover {
        background: rgba(255,255,255,0.3);
    }

    .alert-section {
        margin: 20px 0;
    }

    .alert {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .alert-warning {
        background: #fff3cd;
        border: 1px solid #ffc107;
        color: #856404;
    }

    .alert a {
        color: #856404;
        text-decoration: underline;
        font-weight: bold;
    }

    .admin-menu {
        margin-top: 40px;
    }

    .admin-menu h2 {
        margin-bottom: 20px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .menu-item {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 8px;
        background: white;
        transition: box-shadow 0.2s;
    }

    .menu-item:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .menu-item h3 {
        margin: 0 0 10px 0;
        color: #333;
    }

    .menu-item a {
        display: inline-block;
        background: #667eea;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 10px;
        transition: background 0.3s;
    }

    .menu-item a:hover {
        background: #764ba2;
    }

    .menu-item p {
        margin: 0;
        color: #666;
        font-size: 13px;
        line-height: 1.4;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
