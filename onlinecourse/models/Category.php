<?php
require_once __DIR__ . '/../config/Database.php';

class Category
{
	// Get all categories
	public static function getAll()
	{
		$pdo = db();
		$stmt = $pdo->query('SELECT id, name, description FROM categories ORDER BY name ASC');
		return $stmt->fetchAll();
	}

	// Find single category
	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM categories WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	// Get count of courses in category
	public static function getCourseCount($categoryId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM courses WHERE category_id = :cat_id');
		$stmt->execute(['cat_id' => $categoryId]);
		return $stmt->fetchColumn();
	}
}