<h2>Chỉnh sửa bài học cho khóa: <?php echo htmlspecialchars($course['title']); ?></h2>

<form method="post" action="<?php echo BASE_URL . 'lesson/update/' . $lesson['id']; ?>">
    <div>
        <label>Tiêu đề bài học:</label><br>
        <input type="text" name="title" required
               value="<?php echo htmlspecialchars($lesson['title']); ?>">
    </div>

    <div>
        <label>Nội dung:</label><br>
        <textarea name="content" rows="6"><?php echo htmlspecialchars($lesson['content']); ?></textarea>
    </div>

    <div>
        <label>Video URL:</label><br>
        <input type="text" name="video_url"
               value="<?php echo htmlspecialchars($lesson['video_url']); ?>">
    </div>

    <div>
        <label>Thứ tự hiển thị:</label><br>
        <input type="number" name="order"
               value="<?php echo htmlspecialchars($lesson['order']); ?>">
    </div>

    <button type="submit">Cập nhật</button>
    <a href="<?php echo BASE_URL . 'instructor/manageLessons/' . $course['id']; ?>">Hủy</a>
</form>
