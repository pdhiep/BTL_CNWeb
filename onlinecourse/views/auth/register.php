<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-wrapper">
    <div class="card auth-card">
        <h2 style="margin-bottom:16px;">Đăng nhập</h2>
        <?php if (!empty($error)): ?>
            <p style="color:#e53935;margin-bottom:10px;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post" action="<?php echo BASE_URL; ?>auth/login">
            <label>Email hoặc username</label>
            <input type="text" name="username" required>

            <label>Mật khẩu</label>
            <input type="password" name="password" required>

            <div style="font-size:13px;margin-bottom:10px;">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="font-weight:normal;">Ghi nhớ đăng nhập</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" style="width:100%;">Đăng nhập</button>
            </div>
        </form>

        <p style="font-size:13px;margin-top:12px;">
            Chưa có tài khoản?
            <a href="<?php echo BASE_URL; ?>auth/register">Đăng ký ngay</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
