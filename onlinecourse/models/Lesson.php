<?php
class Lesson
{
    private $conn;
    private $table = 'lessons';

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // Lấy tất cả bài học của 1 khóa
    public function getByCourse($courseId)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE course_id = :course_id
                ORDER BY `order` ASC, created_at ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy 1 bài học
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo bài học mới
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (course_id, title, content, video_url, `order`)
                VALUES
                (:course_id, :title, :content, :video_url, :order)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':course_id' => $data['course_id'],
            ':title'     => $data['title'],
            ':content'   => $data['content'],
            ':video_url' => $data['video_url'],
            ':order'     => $data['order'],
        ]);
    }

    // Cập nhật bài học
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET title = :title,
                    content = :content,
                    video_url = :video_url,
                    `order` = :order
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id'        => $id,
            ':title'     => $data['title'],
            ':content'   => $data['content'],
            ':video_url' => $data['video_url'],
            ':order'     => $data['order'],
        ]);
    }

    // Xóa bài học
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
