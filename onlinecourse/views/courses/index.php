<?php include __DIR__ . '/../layouts/header.php'; ?>

<div style="display:flex;gap:24px;">
    <aside style="width:260px;">
        <div class="card">
            <div class="card-title" style="margin-bottom:10px;">Bộ lọc</div>
            <form method="get" action="<?php echo BASE_URL; ?>courses">
                <label>Từ khóa</label>
                <input type="text" name="q" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">

                <label>Danh mục</label>
                <select name="category_id">
                    <option value="">-- Tất cả --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"
                            <?php if (!empty($_GET['category_id']) && $_GET['category_id'] == $cat['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Level</label>
                <select name="level">
                    <option value="">-- Tất cả --</option>
                    <option>Beginner</option>
                    <option>Intermediate</option>
                    <option>Advanced</option>
                </select>

                <label>Giá tối đa (VNĐ)</label>
                <input type="number" name="max_price" min="0" step="10000">

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </form>
        </div>
    </aside>

    <section style="flex:1;">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Danh sách khóa học</span>
                <span><?php echo count($courses); ?> khóa học</span>
            </div>
            <div class="grid-3">
                <?php foreach ($courses as $course): ?>
                    <div class="course-card">
                        <img src="<?php echo BASE_URL . ($course['image'] ?: 'assets/img/course-placeholder.jpg'); ?>" alt="">
                        <div class="course-card-body">
                            <div class="course-card-title">
                                <?php echo htmlspecialchars($course['title']); ?>
                            </div>
                            <div class="course-card-meta">
                                <?php echo htmlspecialchars($course['level']); ?> •
                                <?php echo htmlspecialchars($course['duration_weeks']); ?> tuần
                            </div>
                            <p style="font-size:13px;color:#777;max-height:40px;overflow:hidden;">
                                <?php echo htmlspecialchars(substr($course['description'],0,80)); ?>...
                            </p>
                        </div>
                        <div class="course-card-footer">
                            <span><?php echo number_format($course['price'],0,',','.'); ?>đ</span>
                            <a href="<?php echo BASE_URL . 'courses/detail/' . $course['id']; ?>" class="btn btn-sm btn-outline">
                                Xem
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
