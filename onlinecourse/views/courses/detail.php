<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="card" style="display:flex;gap:24px;">
    <div style="flex:2;">
        <img src="<?php echo BASE_URL . ($course['image'] ?: 'assets/img/course-placeholder.jpg'); ?>"
             style="width:100%;max-height:320px;object-fit:cover;border-radius:12px;margin-bottom:12px;">
        <h1 style="font-size:26px;margin-bottom:8px;">
            <?php echo htmlspecialchars($course['title']); ?>
        </h1>
        <p style="color:#555;margin-bottom:6px;">
            Giảng viên: <?php echo htmlspecialchars($course['instructor_name'] ?? 'Giảng viên'); ?>
        </p>
        <p style="color:#777;margin-bottom:16px;">
            Level: <?php echo htmlspecialchars($course['level']); ?> •
            Thời lượng: <?php echo (int)$course['duration_weeks']; ?> tuần
        </p>
        <p style="margin-bottom:20px;">
            <?php echo nl2br(htmlspecialchars($course['description'])); ?>
        </p>
    </div>

    <aside style="flex:1;">
        <div class="card">
            <div class="card-title" style="margin-bottom:8px;">Thông tin khóa học</div>
            <p style="font-size:18px;font-weight:bold;margin-bottom:8px;">
                <?php echo number_format($course['price'],0,',','.'); ?>đ
            </p>
            <p style="font-size:14px;color:#555;margin-bottom:12px;">
                Truy cập trọn đời vào toàn bộ nội dung khóa học.
            </p>
            <form method="post" action="<?php echo BASE_URL; ?>enrollment/enroll">
                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                <button type="submit" class="btn btn-primary" style="width:100%;">Đăng ký khóa học</button>
            </form>
        </div>
    </aside>
</section>

<section class="card">
    <div class="card-header">
        <span class="card-title">Nội dung khóa học</span>
    </div>
    <?php if (!empty($lessons)): ?>
        <ul style="list-style:none;">
            <?php foreach ($lessons as $lesson): ?>
                <li class="lesson-item" style="background:#fff;border:1px solid #eee;margin-bottom:6px;">
                    <strong>Bài <?php echo (int)$lesson['order']; ?>:</strong>
                    <?php echo htmlspecialchars($lesson['title']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Khóa học hiện chưa có bài học.</p>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
