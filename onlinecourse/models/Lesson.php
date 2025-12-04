<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson
{

	public static function getByCourse($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM lessons WHERE course_id = :cid ORDER BY `order` ASC');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchAll();
	}


	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM lessons WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public static function findWithCourse($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('
			SELECT l.*, c.title as course_title, c.id as course_id, c.instructor_id as instructor_id
			FROM lessons l
			LEFT JOIN courses c ON l.course_id = c.id
			WHERE l.id = :id LIMIT 1
		');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

	public static function getCourseCount($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM lessons WHERE course_id = :cid');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchColumn();
	}

	public static function create($courseId, $title, $content, $order = 0)
	{
		$pdo = db();
		$stmt = $pdo->prepare('INSERT INTO lessons (course_id, title, content, `order`, created_at) VALUES (:cid, :title, :content, :ord, NOW())');
		return $stmt->execute(['cid' => $courseId, 'title' => $title, 'content' => $content, 'ord' => $order]);
	}

	public static function update($id, $title, $content, $order = 0)
	{
		$pdo = db();
		$stmt = $pdo->prepare('UPDATE lessons SET title = :title, content = :content, `order` = :ord WHERE id = :id');
		return $stmt->execute(['title' => $title, 'content' => $content, 'ord' => $order, 'id' => $id]);
	}

	public static function delete($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('DELETE FROM lessons WHERE id = :id');
		return $stmt->execute(['id' => $id]);
	}
}