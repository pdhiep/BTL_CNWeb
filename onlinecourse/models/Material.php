<?php
require_once __DIR__ . '/../config/Database.php';

class Material
{
	// Get all materials for a lesson
	public static function getByLesson($lessonId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM materials WHERE lesson_id = :lid ORDER BY uploaded_at ASC');
		$stmt->execute(['lid' => $lessonId]);
		return $stmt->fetchAll();
	}

	// Find single material
	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM materials WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	// Get material with lesson and course info
	public static function findWithContext($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('
			SELECT m.*, l.title as lesson_title, l.id as lesson_id, c.title as course_title, c.id as course_id
			FROM materials m
			LEFT JOIN lessons l ON m.lesson_id = l.id
			LEFT JOIN courses c ON l.course_id = c.id
			WHERE m.id = :id LIMIT 1
		');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	// Get count of materials in lesson
	public static function getCount($lessonId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM materials WHERE lesson_id = :lid');
		$stmt->execute(['lid' => $lessonId]);
		return $stmt->fetchColumn();
	}
}