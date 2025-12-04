<?php
require_once __DIR__ . '/../config/Database.php';

class Course
{
	public static function getAll($search = null, $categoryId = null)
	{
		$pdo = db();
		$sql = 'SELECT id, title, description, category_id, instructor_id, created_at, price, level, image FROM courses WHERE 1=1';
		$params = [];

		if ($search && trim($search) !== '') {
			// Use two distinct placeholders because some PDO drivers don't allow the same named
			// parameter to be used multiple times in one statement.
			$sql .= ' AND (title LIKE :q1 OR description LIKE :q2)';
			$q = '%' . trim($search) . '%';
			$params['q1'] = $q;
			$params['q2'] = $q;
		}

		if ($categoryId && $categoryId > 0) {
			$sql .= ' AND category_id = :cat_id';
			$params['cat_id'] = $categoryId;
		}

		$sql .= ' ORDER BY created_at DESC';

		$stmt = $pdo->prepare($sql);
		$stmt->execute($params);
		return $stmt->fetchAll();
	}
	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM courses WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public static function findWithInstructor($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('
			SELECT c.*, u.fullname as instructor_name, u.email as instructor_email
			FROM courses c
			LEFT JOIN users u ON c.instructor_id = u.id
			WHERE c.id = :id LIMIT 1
		');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	
	public static function getEnrolledCount($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM enrollments WHERE course_id = :cid AND status = "active"');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchColumn();
	}


	public static function getByCategory($categoryId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM courses WHERE category_id = :cat_id ORDER BY created_at DESC');
		$stmt->execute(['cat_id' => $categoryId]);
		return $stmt->fetchAll();
	}

	public static function getByInstructor($instructorId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM courses WHERE instructor_id = :iid ORDER BY created_at DESC');
		$stmt->execute(['iid' => $instructorId]);
		return $stmt->fetchAll();
	}

	public static function create($title, $description, $instructorId, $categoryId = null, $price = 0.00, $level = null, $image = null)
	{
		$pdo = db();
		// Try to include is_approved column if it exists in DB (approval workflow)
		try {
			// Attempt insert with is_approved default 0 (pending)
			$stmt = $pdo->prepare('INSERT INTO courses (title, description, instructor_id, category_id, price, level, image, is_approved, created_at) VALUES (:title, :description, :instructor_id, :category_id, :price, :level, :image, 0, NOW())');
			return $stmt->execute([
				'title' => $title,
				'description' => $description,
				'instructor_id' => $instructorId,
				'category_id' => $categoryId,
				'price' => $price,
				'level' => $level,
				'image' => $image
			]);
		} catch (Exception $e) {
			// fallback if is_approved column doesn't exist
			$stmt = $pdo->prepare('INSERT INTO courses (title, description, instructor_id, category_id, price, level, image, created_at) VALUES (:title, :description, :instructor_id, :category_id, :price, :level, :image, NOW())');
			return $stmt->execute([
				'title' => $title,
				'description' => $description,
				'instructor_id' => $instructorId,
				'category_id' => $categoryId,
				'price' => $price,
				'level' => $level,
				'image' => $image
			]);
		}
	}

	public static function updateCourse($id, $title, $description, $categoryId = null, $price = 0.00, $level = null, $image = null)
	{
		$pdo = db();
		$stmt = $pdo->prepare('UPDATE courses SET title = :title, description = :description, category_id = :category_id, price = :price, level = :level, image = :image WHERE id = :id');
		return $stmt->execute([
			'title' => $title,
			'description' => $description,
			'category_id' => $categoryId,
			'price' => $price,
			'level' => $level,
			'image' => $image,
			'id' => $id
		]);
	}

	public static function deleteCourse($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('DELETE FROM courses WHERE id = :id');
		return $stmt->execute(['id' => $id]);
	}
}

