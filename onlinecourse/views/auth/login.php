<h2>Đăng nhập</h2>

<?php if (!empty($error)) : ?>
    <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="/BTTH2/onlinecourse/auth/doLogin">
    <div>
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Đăng nhập</button>
</form>

<p>Chưa có tài khoản? <a href="/BTTH2/onlinecourse/auth/register">Đăng ký</a></p>
