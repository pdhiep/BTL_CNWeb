<h2>Chỉnh sửa khóa học</h2>

<?php if (!$course): ?>
    <p>Khóa học không tồn tại.</p>
<?php else: ?>
<form method="post" action="<?php echo BASE_URL . 'instructor/updateCourse/' . $course['id']; ?>">
    <div>
        <label>Tiêu đề khóa học:</label><br>
        <input type="text" name="title" required
               value="<?php echo htmlspecialchars($course['title']); ?>">
    </div>

    <div>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5"><?php echo htmlspecialchars($course['description']); ?></textarea>
    </div>

    <div>
        <label>Danh mục (ID):</label><br>
        <input type="number" name="category_id"
               value="<?php echo htmlspecialchars($course['category_id']); ?>">
    </div>

    <div>
        <label>Giá (VNĐ):</label><br>
        <input type="number" name="price"
               value="<?php echo htmlspecialchars($course['price']); ?>">
    </div>

    <div>
        <label>Thời lượng (tuần):</label><br>
        <input type="number" name="duration_weeks"
               value="<?php echo htmlspecialchars($course['duration_weeks']); ?>">
    </div>

    <div>
        <label>Cấp độ:</label><br>
        <select name="level">
            <option value="Beginner"     <?php if ($course['level']=='Beginner') echo 'selected'; ?>>Beginner</option>
            <option value="Intermediate" <?php if ($course['level']=='Intermediate') echo 'selected'; ?>>Intermediate</option>
            <option value="Advanced"     <?php if ($course['level']=='Advanced') echo 'selected'; ?>>Advanced</option>
        </select>
    </div>

    <button type="submit">Cập nhật</button>
    <a href="<?php echo BASE_URL; ?>instructor/myCourses">Hủy</a>
</form>
<?php endif; ?>
