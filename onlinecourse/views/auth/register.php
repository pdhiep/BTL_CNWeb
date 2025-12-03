<h2>Đăng ký</h2>

<?php if (!empty($error)) : ?>
    <div style="color:red;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="post" action="/BTTH2/onlinecourse/auth/doRegister">
    <div>
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Họ tên:</label>
        <input type="text" name="fullname" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Nhập lại mật khẩu:</label>
        <input type="password" name="confirm_password" required>
    </div>
    <button type="submit">Đăng ký</button>
</form>

<p>Đã có tài khoản? <a href="/BTTH2/onlinecourse/auth/login">Đăng nhập</a></p>
