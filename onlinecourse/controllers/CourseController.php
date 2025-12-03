<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Lesson.php';

class CourseController
{
	// Display course listing with search and category filtering
	public function index()
	{
		$search = isset($_GET['q']) ? $_GET['q'] : null;
		$categoryId = isset($_GET['category']) ? intval($_GET['category']) : null;
		$courses = Course::getAll($search, $categoryId);
		$categories = Category::getAll();
		
		// Get enrolled course IDs if user is logged in
		$enrolledIds = [];
		if (isset($_SESSION['user_id'])) {
			$enrolledIds = Enrollment::getEnrolledCourseIds(intval($_SESSION['user_id']));
		}
		
		require __DIR__ . '/../views/courses/index.php';
	}

	// Display course detail page
	public function detail()
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$course = Course::findWithInstructor($id);
		
		if (!$course) {
			http_response_code(404);
			echo 'Không tìm thấy khóa học';
			exit;
		}

		// Get additional course info
		$enrolledCount = Enrollment::getEnrolledCount($id);
		$lessons = \Lesson::getByCourse($id);
		
		$message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
		unset($_SESSION['flash']);
		
		$isEnrolled = false;
		if (isset($_SESSION['user_id'])) {
			$isEnrolled = Enrollment::isEnrolled(intval($_SESSION['user_id']), $id);
		}
		
		require __DIR__ . '/../views/courses/detail.php';
	}

	// Handle course enrollment
	public function enroll()
	{
		if (!isset($_SESSION['user_id'])) {
			// Redirect to login if not authenticated
			$_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
			header('Location: index.php?controller=auth&action=login');
			exit;
		}

		$courseId = isset($_POST['course_id']) ? intval($_POST['course_id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
		$userId = intval($_SESSION['user_id']);

		if ($courseId <= 0) {
			$_SESSION['flash'] = 'Khóa học không hợp lệ.';
			header('Location: index.php?controller=course&action=index');
			exit;
		}

		// Check if course exists
		$course = Course::find($courseId);
		if (!$course) {
			$_SESSION['flash'] = 'Khóa học không tồn tại.';
			header('Location: index.php?controller=course&action=index');
			exit;
		}

		// Try to enroll
		$ok = Enrollment::enroll($userId, $courseId);
		if ($ok) {
			$_SESSION['flash'] = 'Đăng ký khóa học thành công.';
		} else {
			$_SESSION['flash'] = 'Bạn đã đăng ký khóa học này hoặc có lỗi xảy ra.';
		}
		
		header('Location: index.php?controller=course&action=detail&id=' . $courseId);
		exit;
	}
}

