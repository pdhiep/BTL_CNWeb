<?php
class Course
{
    private $conn;
    private $table = 'courses';

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // Lấy tất cả khóa học của 1 giảng viên
    public function getByInstructor($instructorId)
    {
        $sql = "SELECT c.*, cat.name AS category_name
                FROM {$this->table} c
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.instructor_id = :instructor_id
                ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':instructor_id', $instructorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết 1 khóa học
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo mới khóa học
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table}
                (title, description, instructor_id, category_id, price, duration_weeks, level, image)
                VALUES
                (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image)";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':title'          => $data['title'],
            ':description'    => $data['description'],
            ':instructor_id'  => $data['instructor_id'],
            ':category_id'    => $data['category_id'],
            ':price'          => $data['price'],
            ':duration_weeks' => $data['duration_weeks'],
            ':level'          => $data['level'],
            ':image'          => $data['image'],
        ]);

        return $this->conn->lastInsertId();
    }

    // Cập nhật khóa học
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table}
                SET title = :title,
                    description = :description,
                    category_id = :category_id,
                    price = :price,
                    duration_weeks = :duration_weeks,
                    level = :level,
                    image = :image
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id'             => $id,
            ':title'          => $data['title'],
            ':description'    => $data['description'],
            ':category_id'    => $data['category_id'],
            ':price'          => $data['price'],
            ':duration_weeks' => $data['duration_weeks'],
            ':level'          => $data['level'],
            ':image'          => $data['image'],
        ]);
    }

    // Xóa khóa học
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
