<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<div class="container course-form">
    <h1>Sửa khóa học</h1>

    <?php if (!empty($message)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if (!empty($course)): ?>
        <form method="post" action="index.php?controller=instructor&action=editCourse&id=<?php echo $course['id']; ?>" class="form">
            <div class="form-group">
                <label for="title">Tiêu đề <span class="required">*</span></label>
                <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($course['title']); ?>">
            </div>

            <div class="form-group">
                <label for="description">Mô tả <span class="required">*</span></label>
                <textarea id="description" name="description" required rows="6"><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id">
                    <option value="">-- Chọn danh mục --</option>
                    <!-- Danh mục sẽ được load từ DB nếu cần -->
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Giá (VNĐ)</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($course['price']); ?>" min="0">
                </div>

                <div class="form-group">
                    <label for="level">Trình độ</label>
                    <select id="level" name="level">
                        <option value="">-- Chọn trình độ --</option>
                        <option value="beginner" <?php echo ($course['level'] === 'beginner') ? 'selected' : ''; ?>>Beginner</option>
                        <option value="intermediate" <?php echo ($course['level'] === 'intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                        <option value="advanced" <?php echo ($course['level'] === 'advanced') ? 'selected' : ''; ?>>Advanced</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <a href="index.php?controller=instructor&action=manage" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    <?php else: ?>
        <p>Khóa học không tồn tại.</p>
    <?php endif; ?>
</div>

<style>
    .course-form {
        padding: 20px;
        max-width: 600px;
    }

    .form {
        background: white;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .required {
        color: red;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #764ba2;
    }

    .btn-secondary {
        background: #f0f0f0;
        color: #333;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .alert-error {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 20px;
    }
</style>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
