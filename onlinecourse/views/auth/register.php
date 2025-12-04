<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container">
    <h2>Đăng ký tài khoản</h2>

    <?php if (!empty($message)): ?>
        <div style="color:red;margin-bottom:12px"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?controller=auth&action=register" enctype="multipart/form-data">
        <div>
            <label for="fullname">Họ và tên</label><br>
            <input type="text" name="fullname" id="fullname" required style="width:360px;padding:8px">
        </div>
        <div style="margin-top:8px">
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required style="width:360px;padding:8px">
        </div>
        <div style="margin-top:8px">
            <label for="password">Mật khẩu</label><br>
            <input type="password" name="password" id="password" required style="width:360px;padding:8px">
        </div>
        <div style="margin-top:8px">
            <label for="role">Vai trò</label><br>
            <select name="role" id="role">
                <option value="0">Học viên</option>
                <option value="1">Giảng viên</option>
            </select>
        </div>
        <div style="margin-top:8px">
            <label for="avatar">Avatar (tùy chọn)</label><br>
            <input type="file" name="avatar" id="avatar" accept="image/*">
        </div>
        <div style="margin-top:12px">
            <button type="submit">Đăng ký</button>
            <a href="index.php?controller=auth&action=login" style="margin-left:12px">Đã có tài khoản?</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
