<h2>Thêm bài học cho khóa: <?php echo htmlspecialchars($course['title']); ?></h2>

<form method="post" action="<?php echo BASE_URL; ?>lesson/store">
    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">

    <div>
        <label>Tiêu đề bài học:</label><br>
        <input type="text" name="title" required>
    </div>

    <div>
        <label>Nội dung:</label><br>
        <textarea name="content" rows="6"></textarea>
    </div>

    <div>
        <label>Video URL (YouTube, v.v.):</label><br>
        <input type="text" name="video_url">
    </div>

    <div>
        <label>Thứ tự hiển thị:</label><br>
        <input type="number" name="order" value="1">
    </div>

    <button type="submit">Lưu bài học</button>
    <a href="<?php echo BASE_URL . 'instructor/manageLessons/' . $course['id']; ?>">Hủy</a>
</form>
