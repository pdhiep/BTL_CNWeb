<?php
require_once __DIR__ . '/../config/Database.php';

class Category
{

	public static function getAll()
	{
		$pdo = db();
		$stmt = $pdo->query('SELECT id, name, description FROM categories ORDER BY name ASC');
		return $stmt->fetchAll();
	}

	
	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM categories WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public static function getCourseCount($categoryId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM courses WHERE category_id = :cat_id');
		$stmt->execute(['cat_id' => $categoryId]);
		return $stmt->fetchColumn();
	}

	public static function create($name, $description = null)
	{
		$pdo = db();
		$stmt = $pdo->prepare('INSERT INTO categories (name, description) VALUES (:name, :description)');
		return $stmt->execute(['name' => $name, 'description' => $description]);
	}

	public static function update($id, $name, $description = null)
	{
		$pdo = db();
		$stmt = $pdo->prepare('UPDATE categories SET name = :name, description = :description WHERE id = :id');
		return $stmt->execute(['name' => $name, 'description' => $description, 'id' => $id]);
	}

	public static function delete($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('DELETE FROM categories WHERE id = :id');
		return $stmt->execute(['id' => $id]);
	}
}