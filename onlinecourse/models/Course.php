<?php
require_once __DIR__ . '/../config/Database.php';

class Course
{
	public static function getAll($search = null)
	{
		$pdo = db();
		if ($search && trim($search) !== '') {
			$q = '%' . trim($search) . '%';
			// Chỉ select các cột chắc chắn tồn tại để tránh lỗi "Unknown column"
			$stmt = $pdo->prepare('SELECT id, title, description FROM courses WHERE title LIKE :q OR description LIKE :q ORDER BY id DESC');
			$stmt->execute(['q' => $q]);
		} else {
			// Tương tự cho truy vấn không có điều kiện tìm kiếm
			$stmt = $pdo->query('SELECT id, title, description FROM courses ORDER BY id DESC');
		}
		return $stmt->fetchAll();
	}

	public static function find($id)
	{
		$pdo = db();
		// Tránh select cột không tồn tại
		$stmt = $pdo->prepare('SELECT id, title, description FROM courses WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}
}

