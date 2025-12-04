<?php
require_once __DIR__ . '/../config/Database.php';

class Material
{
	
	public static function getByLesson($lessonId)
	{
		$pdo = db();
		// select filename and file_path explicitly to match DB schema
		$stmt = $pdo->prepare('SELECT id, lesson_id, filename, file_path, file_type, uploaded_at FROM materials WHERE lesson_id = :lid ORDER BY uploaded_at ASC');
		$stmt->execute(['lid' => $lessonId]);
		return $stmt->fetchAll();
	}


	public static function find($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM materials WHERE id = :id LIMIT 1');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}


	public static function findWithContext($id)
	{
		$pdo = db();
		$stmt = $pdo->prepare('
			SELECT m.id, m.lesson_id, m.filename, m.file_path, m.file_type, m.uploaded_at,
			l.title as lesson_title, l.id as lesson_id, c.title as course_title, c.id as course_id
			FROM materials m
			LEFT JOIN lessons l ON m.lesson_id = l.id
			LEFT JOIN courses c ON l.course_id = c.id
			WHERE m.id = :id LIMIT 1
		');
		$stmt->execute(['id' => $id]);
		return $stmt->fetch();
	}

		public static function getCount($lessonId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM materials WHERE lesson_id = :lid');
		$stmt->execute(['lid' => $lessonId]);
		return $stmt->fetchColumn();
	}

		public static function create($lessonId, $filename, $filePath, $fileType = null, $uploadedBy = null)
		{
			$pdo = db();
			$stmt = $pdo->prepare('INSERT INTO materials (lesson_id, filename, file_path, file_type, uploaded_by, uploaded_at) VALUES (:lid, :filename, :file_path, :file_type, :uploaded_by, NOW())');
			return $stmt->execute([
				'lid' => $lessonId,
				'filename' => $filename,
				'file_path' => $filePath,
				'file_type' => $fileType,
				'uploaded_by' => $uploadedBy
			]);
		}
}