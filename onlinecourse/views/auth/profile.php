<div class="auth">
    <h2>Quản lý tài khoản</h2>
    <form method="post" action="index.php?action=profile">
        <?php if (!empty($nameField)) : ?>
        <div>
            <label for="name">Họ tên</label>
            <input id="name" name="name" value="<?php echo htmlspecialchars($user[$nameField] ?? ''); ?>" required>
        </div>
        <?php else : ?>
        <p>Hệ thống hiện tại chưa lưu họ tên người dùng. Bạn vẫn có thể đổi mật khẩu.</p>
        <?php endif; ?>
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" disabled>
        </div>
        <div>
            <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
            <input id="password" name="password" type="password">
        </div>
        <div>
            <button type="submit">Cập nhật</button>
        </div>
    </form>
</div>
