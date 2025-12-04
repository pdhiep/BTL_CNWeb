<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment
{
	public static function isEnrolled($userId, $courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM enrollments WHERE student_id = :uid AND course_id = :cid');
		$stmt->execute(['uid' => $userId, 'cid' => $courseId]);
		return $stmt->fetchColumn() > 0;
	}

	public static function enroll($userId, $courseId)
	{
		$pdo = db();
		if (self::isEnrolled($userId, $courseId)) {
			return false; 
		}
		$stmt = $pdo->prepare('INSERT INTO enrollments (student_id, course_id, enrolled_date, status, progress) VALUES (:uid, :cid, NOW(), "active", 0)');
		return $stmt->execute(['uid' => $userId, 'cid' => $courseId]);
	}

	public static function getEnrolledCourseIds($userId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT course_id FROM enrollments WHERE student_id = :uid');
		$stmt->execute(['uid' => $userId]);
		$rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
		return $rows ?: [];
	}

	
	public static function getEnrolledCourses($userId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('
			SELECT c.*, e.enrolled_date, e.status as completed, u.fullname as instructor_name
			FROM enrollments e
			JOIN courses c ON e.course_id = c.id
			LEFT JOIN users u ON c.instructor_id = u.id
			WHERE e.student_id = :uid AND e.status != "dropped"
			ORDER BY e.enrolled_date DESC
		');
		$stmt->execute(['uid' => $userId]);
		return $stmt->fetchAll();
	}

	
	public static function getEnrollment($userId, $courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT * FROM enrollments WHERE student_id = :uid AND course_id = :cid LIMIT 1');
		$stmt->execute(['uid' => $userId, 'cid' => $courseId]);
		return $stmt->fetch();
	}


	public static function markCompleted($userId, $courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('UPDATE enrollments SET status = "completed" WHERE student_id = :uid AND course_id = :cid');
		return $stmt->execute(['uid' => $userId, 'cid' => $courseId]);
	}

	
	public static function getProgress($userId, $courseId)
	{
		$pdo = db();
	
		$totalStmt = $pdo->prepare('SELECT COUNT(*) FROM lessons WHERE course_id = :cid');
		$totalStmt->execute(['cid' => $courseId]);
		$totalLessons = $totalStmt->fetchColumn();

		if ($totalLessons == 0) {
			return ['completed' => 0, 'total' => 0, 'percentage' => 0];
		}


		$enrollStmt = $pdo->prepare('SELECT progress FROM enrollments WHERE student_id = :uid AND course_id = :cid');
		$enrollStmt->execute(['uid' => $userId, 'cid' => $courseId]);
		$enrollData = $enrollStmt->fetch();
		$completedLessons = $enrollData['progress'] ?? 0;

		$percentage = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

		return [
			'completed' => $completedLessons,
			'total' => $totalLessons,
			'percentage' => $percentage
		];
	}

	public static function getEnrolledCount($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM enrollments WHERE course_id = :cid');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchColumn();
	}

	public static function getStudentsByCourse($courseId)
	{
		$pdo = db();
		$stmt = $pdo->prepare('SELECT e.*, u.fullname, u.email, u.id as user_id FROM enrollments e JOIN users u ON e.student_id = u.id WHERE e.course_id = :cid ORDER BY e.enrolled_date DESC');
		$stmt->execute(['cid' => $courseId]);
		return $stmt->fetchAll();
	}
}

