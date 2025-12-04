<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container">
    <h2>Đăng nhập</h2>

    <?php if (!empty($message)): ?>
        <div style="color:red;margin-bottom:12px"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post" action="index.php?controller=auth&action=login">
        <div>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required style="width:320px;padding:8px">
        </div>
        <div style="margin-top:8px">
            <label for="password">Mật khẩu</label><br>
            <input type="password" name="password" id="password" required style="width:320px;padding:8px">
        </div>
        <div style="margin-top:12px">
            <button type="submit">Đăng nhập</button>
            <a href="index.php?controller=auth&action=register" style="margin-left:12px">Đăng ký</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
