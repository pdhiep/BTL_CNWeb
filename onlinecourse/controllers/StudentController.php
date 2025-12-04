<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Material.php';

class StudentController
{
	
	private function requireLogin()
	{
		if (!isset($_SESSION['user_id'])) {
			$_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
			header('Location: index.php?controller=auth&action=login');
			exit;
		}
	}

	public function dashboard()
	{
		$this->requireLogin();
		$userId = intval($_SESSION['user_id']);
		
		$enrolledCourses = Enrollment::getEnrolledCourses($userId);
		
		$totalEnrolled = count($enrolledCourses);
		$completedCourses = array_sum(array_map(function($c) { return $c['completed'] ? 1 : 0; }, $enrolledCourses));
		
		require __DIR__ . '/../views/student/dashboard.php';
	}
	public function myCourses()
	{
		$this->requireLogin();
		$userId = intval($_SESSION['user_id']);
		
		$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all'; // all, active, completed
		$enrolledCourses = Enrollment::getEnrolledCourses($userId);
		if ($filter === 'active') {
			$enrolledCourses = array_filter($enrolledCourses, function($c) {
				return !$c['completed'];
			});
		} elseif ($filter === 'completed') {
			$enrolledCourses = array_filter($enrolledCourses, function($c) {
				return $c['completed'];
			});
		}
		
		require __DIR__ . '/../views/student/my_courses.php';
	}

	public function courseProgress()
	{
		$this->requireLogin();
		$userId = intval($_SESSION['user_id']);
		$courseId = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		if ($courseId <= 0) {
			http_response_code(400);
			echo 'ID khóa học không hợp lệ';
			exit;
		}
		if (!Enrollment::isEnrolled($userId, $courseId)) {
			http_response_code(403);
			echo 'Bạn chưa đăng ký khóa học này';
			exit;
		}

		$course = Course::find($courseId);
		if (!$course) {
			http_response_code(404);
			echo 'Không tìm thấy khóa học';
			exit;
		}

		$progress = Enrollment::getProgress($userId, $courseId);
		$lessons = Lesson::getByCourse($courseId);
		
		require __DIR__ . '/../views/student/course_progress.php';
	}

	public function viewLesson()
	{
		$this->requireLogin();
		$userId = intval($_SESSION['user_id']);
		$lessonId = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		if ($lessonId <= 0) {
			http_response_code(400);
			echo 'ID bài học không hợp lệ';
			exit;
		}
		$lesson = Lesson::findWithCourse($lessonId);
		if (!$lesson) {
			http_response_code(404);
			echo 'Không tìm thấy bài học';
			exit;
		}
		if (!Enrollment::isEnrolled($userId, $lesson['course_id'])) {
			http_response_code(403);
			echo 'Bạn chưa đăng ký khóa học này';
			exit;
		}

		$materials = Material::getByLesson($lessonId);
		
		require __DIR__ . '/../views/student/lesson_view.php';
	}

	public function downloadMaterial()
	{
		$this->requireLogin();
		$userId = intval($_SESSION['user_id']);
		$materialId = isset($_GET['id']) ? intval($_GET['id']) : 0;
		
		if ($materialId <= 0) {
			http_response_code(400);
			echo 'ID tài liệu không hợp lệ';
			exit;
		}

		$material = Material::findWithContext($materialId);
		if (!$material) {
			http_response_code(404);
			echo 'Không tìm thấy tài liệu';
			exit;
		}
		if (!Enrollment::isEnrolled($userId, $material['course_id'])) {
			http_response_code(403);
			echo 'Bạn chưa đăng ký khóa học này';
			exit;
		}

		$storedPath = isset($material['file_path']) && $material['file_path'] ? $material['file_path'] : null;
		$filename = isset($material['filename']) ? $material['filename'] : null;

		if ($storedPath) {
			if (preg_match('#^(?:/|[A-Za-z]:\\)#', $storedPath) || strpos($storedPath, 'uploads/') === 0) {
				$filePath = $storedPath;
			} else {
				$filePath = __DIR__ . '/../' . ltrim($storedPath, '/\\');
			}
		} elseif ($filename) {
			$filePath = __DIR__ . '/../uploads/' . $filename;
		} else {
			http_response_code(404);
			echo 'Tập tin không tìm thấy';
			exit;
		}

		if (!file_exists($filePath)) {
			http_response_code(404);
			echo 'Tập tin không tìm thấy';
			exit;
		}

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
		header('Content-Length: ' . filesize($filePath));
		readfile($filePath);
		exit;
	}
}
