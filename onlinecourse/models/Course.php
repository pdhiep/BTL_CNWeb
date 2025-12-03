<?php
require_once __DIR__ . '/../config/Database.php';

class Course
{
	// Get all courses with optional search and category filter
	public static function getAll($search = null, $categoryId = null)
	{
		$pdo = db();
		$sql = 'SELECT id, title, description, category_id, instructor_id, created_at, price, level, image FROM courses WHERE 1=1';
		$params = [];

		if ($search && trim($search) !== '') {
			$sql .= ' AND (title LIKE :q OR description LIKE :q)';
			$params['q'] = '%' . trim($search) . '%';
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

	// Find single course with full details
	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM courses WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	// Get course details with instructor info
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

	// Get count of enrolled students
	public static function getEnrolledCount($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM enrollments WHERE course_id = :cid AND status = "active"');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchColumn();
	}

	// Get courses by category
	public static function getByCategory($categoryId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM courses WHERE category_id = :cat_id ORDER BY created_at DESC');
		$stmt->execute(['cat_id' => $categoryId]);
		return $stmt->fetchAll();
	}
}

