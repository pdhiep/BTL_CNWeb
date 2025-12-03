<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment
{
	public static function isEnrolled($userId, $courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM enrollments WHERE user_id = :uid AND course_id = :cid');
		$stmt->execute(['uid' => $userId, 'cid' => $courseId]);
		return $stmt->fetchColumn() > 0;
	}

	public static function enroll($userId, $courseId)
	{
		$pdo = db();
		if (self::isEnrolled($userId, $courseId)) {
			return false; // already enrolled
		}
		$stmt = $pdo->prepare('INSERT INTO enrollments (user_id, course_id, enrolled_at) VALUES (:uid, :cid, NOW())');
		return $stmt->execute(['uid' => $userId, 'cid' => $courseId]);
	}

	public static function getEnrolledCourseIds($userId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT course_id FROM enrollments WHERE user_id = :uid');
		$stmt->execute(['uid' => $userId]);
		$rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $rows ?: [];
	}
}

