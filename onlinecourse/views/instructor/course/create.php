<h2>Tạo khóa học mới</h2>

<form method="post" action="<?php echo BASE_URL; ?>instructor/storeCourse">
    <div>
        <label>Tiêu đề khóa học:</label><br>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5"></textarea>
    </div>

    <div>
        <label>Danh mục (nhập ID tạm):</label><br>
        <input type="number" name="category_id">
        <small>Sau này admin sẽ quản lý danh mục.</small>
    </div>

    <div>
        <label>Giá (VNĐ):</label><br>
        <input type="number" name="price" value="0">
    </div>

    <div>
        <label>Thời lượng (tuần):</label><br>
        <input type="number" name="duration_weeks" value="4">
    </div>

    <div>
        <label>Cấp độ:</label><br>
        <select name="level">
            <option value="Beginner">Beginner</option>
            <option value="Intermediate">Intermediate</option>
            <option value="Advanced">Advanced</option>
        </select>
    </div>

    <!-- upload ảnh sẽ làm ở nhiệm vụ 4 -->

    <button type="submit">Lưu</button>
    <a href="<?php echo BASE_URL; ?>instructor/myCourses">Hủy</a>
</form>
