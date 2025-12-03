<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson
{
	// Get all lessons for a course
	public static function getByCourse($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM lessons WHERE course_id = :cid ORDER BY `order` ASC');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchAll();
	}

	// Find single lesson
	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM lessons WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	// Get lesson with course info
	public static function findWithCourse($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('
			SELECT l.*, c.title as course_title, c.id as course_id
			FROM lessons l
			LEFT JOIN courses c ON l.course_id = c.id
			WHERE l.id = :id LIMIT 1
		');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	// Get count of lessons in course
	public static function getCourseCount($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM lessons WHERE course_id = :cid');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchColumn();
	}
}