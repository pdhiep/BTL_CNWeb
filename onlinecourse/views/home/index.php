<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="card">
    <div style="display:flex;align-items:center;gap:40px;">
        <div style="flex:1;">
            <h1 style="font-size:32px;margin-bottom:10px;">Học mọi lúc, mọi nơi</h1>
            <p style="font-size:16px;color:#555;margin-bottom:16px;">
                Nền tảng khóa học online giúp bạn nâng cao kỹ năng nhanh chóng.
            </p>
            <a href="<?php echo BASE_URL; ?>courses" class="btn btn-primary">Xem tất cả khóa học</a>
        </div>
        <div style="flex:1; text-align:center;">
            <div style="width:280px;height:200px;background:#e3f2fd;border-radius:16px;margin:0 auto;"></div>
            <p style="margin-top:8px;color:#777;">(Minh họa banner)</p>
        </div>
    </div>
</section>

<section class="card">
    <div class="card-header">
        <span class="card-title">Danh mục nổi bật</span>
    </div>
    <div class="grid-4">
        <div class="course-card-body" style="background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <strong>Lập trình Web</strong><br><span>HTML, CSS, JS, PHP...</span>
        </div>
        <div class="course-card-body" style="background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <strong>Data / AI</strong><br><span>Python, Machine Learning</span>
        </div>
        <div class="course-card-body" style="background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <strong>Thiết kế</strong><br><span>UI/UX, Graphic Design</span>
        </div>
        <div class="course-card-body" style="background:#fff;border-radius:10px;box-shadow:0 2px 6px rgba(0,0,0,0.05);">
            <strong>Kinh doanh</strong><br><span>Marketing, Quản trị</span>
        </div>
    </div>
</section>

<section class="card">
    <div class="card-header">
        <span class="card-title">Khóa học mới nhất</span>
        <a href="<?php echo BASE_URL; ?>courses">Xem tất cả</a>
    </div>
    <div class="grid-3">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <img src="<?php echo BASE_URL . ($course['image'] ?: 'assets/img/course-placeholder.jpg'); ?>" alt="course">
                    <div class="course-card-body">
                        <div class="course-card-title"><?php echo htmlspecialchars($course['title']); ?></div>
                        <div class="course-card-meta">
                            <?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?>
                        </div>
                        <p style="font-size:13px;color:#777;max-height:40px;overflow:hidden;">
                            <?php echo htmlspecialchars(substr($course['description'],0,80)); ?>...
                        </p>
                    </div>
                    <div class="course-card-footer">
                        <span>
                            <?php echo number_format($course['price'],0,',','.'); ?>đ
                        </span>
                        <a href="<?php echo BASE_URL . 'courses/detail/' . $course['id']; ?>" class="btn btn-sm btn-outline">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Chưa có khóa học.</p>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
