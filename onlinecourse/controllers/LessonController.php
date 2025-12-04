<?php
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';

class LessonController
{
	private function requireInstructor()
	{
		if (session_status() == PHP_SESSION_NONE) session_start();
		// roles stored as integers: 0 student, 1 instructor, 2 admin
		if (!isset($_SESSION['user_id']) || !in_array(intval($_SESSION['user_role']), [1, 2])) {
			$_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
			header('Location: index.php?controller=auth&action=login');
			exit;
		}
	}

	// Upload material for a lesson (GET = form, POST = process upload)
	public function upload()
	{
		$this->requireInstructor();
		$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;
		if ($lessonId <= 0) {
			echo 'Bài học không hợp lệ';
			exit;
		}

		$lesson = Lesson::findWithCourse($lessonId);
		if (!$lesson) {
			echo 'Không tìm thấy bài học';
			exit;
		}

		// Ownership check: only instructor who owns course or admin can upload
		$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
		$userRole = intval($_SESSION['user_role']);
		if ($userRole !== 2 && intval($lesson['instructor_id']) !== $userId) {
			echo 'Bạn không có quyền thực hiện thao tác này.';
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!isset($_FILES['material']) || $_FILES['material']['error'] !== UPLOAD_ERR_OK) {
				$_SESSION['flash'] = 'Vui lòng chọn tệp để tải lên.';
				header('Location: index.php?controller=lesson&action=upload&lesson_id=' . $lessonId);
				exit;
			}

			$file = $_FILES['material'];
			$orig = basename($file['name']);
			$ext = pathinfo($orig, PATHINFO_EXTENSION);
			$safeName = 'material_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

			$uploadDir = __DIR__ . '/../assets/uploads/materials/';
			if (!is_dir($uploadDir)) {
				@mkdir($uploadDir, 0755, true);
			}

			$dest = $uploadDir . $safeName;
			if (!move_uploaded_file($file['tmp_name'], $dest)) {
				$_SESSION['flash'] = 'Không thể lưu tệp lên máy chủ.';
				header('Location: index.php?controller=lesson&action=upload&lesson_id=' . $lessonId);
				exit;
			}

			// store metadata in DB: file_path relative to project root
			$relativePath = 'assets/uploads/materials/' . $safeName;
			$fileType = $file['type'];
			$uploadedBy = $userId;

			require_once __DIR__ . '/../models/Material.php';
			$ok = Material::create($lessonId, $orig, $relativePath, $fileType, $uploadedBy);
			if ($ok) {
				$_SESSION['flash'] = 'Tải tài liệu thành công.';
			} else {
				$_SESSION['flash'] = 'Lỗi khi lưu thông tin tài liệu.';
			}

			header('Location: index.php?controller=lesson&action=manage&course_id=' . $lesson['course_id']);
			exit;
		}

		$message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
		unset($_SESSION['flash']);
		require __DIR__ . '/../views/instructor/materials/upload.php';
	}

	// List/manage lessons for a course (instructor)
	public function manage()
	{
		$this->requireInstructor();
		$courseId = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
		if ($courseId <= 0) {
			echo 'Khóa học không hợp lệ';
			exit;
		}

		$course = Course::find($courseId);
		if (!$course) {
			echo 'Không tìm thấy khóa học';
			exit;
		}

		$lessons = Lesson::getByCourse($courseId);
		require __DIR__ . '/../views/instructor/lessons/manage.php';
	}

	public function create()
	{
		$this->requireInstructor();
		$courseId = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
		if ($courseId <= 0) {
			echo 'Khóa học không hợp lệ';
			exit;
		}

		$course = Course::find($courseId);
		if (!$course) {
			echo 'Không tìm thấy khóa học';
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$title = isset($_POST['title']) ? trim($_POST['title']) : '';
			$content = isset($_POST['content']) ? trim($_POST['content']) : '';
			$order = isset($_POST['order']) ? intval($_POST['order']) : 0;

			if ($title === '') {
				$_SESSION['flash'] = 'Tiêu đề bài học không được để trống.';
				header('Location: index.php?controller=lesson&action=create&course_id=' . $courseId);
				exit;
			}

			$ok = Lesson::create($courseId, $title, $content, $order);
			if ($ok) {
				$_SESSION['flash'] = 'Tạo bài học thành công.';
				header('Location: index.php?controller=lesson&action=manage&course_id=' . $courseId);
				exit;
			} else {
				$_SESSION['flash'] = 'Lỗi khi tạo bài học.';
			}
		}

		$message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
		unset($_SESSION['flash']);
		require __DIR__ . '/../views/instructor/lessons/create.php';
	}

	public function edit()
	{
		$this->requireInstructor();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if ($id <= 0) {
			echo 'ID bài học không hợp lệ';
			exit;
		}

		$lesson = Lesson::find($id);
		if (!$lesson) {
			echo 'Không tìm thấy bài học';
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$title = isset($_POST['title']) ? trim($_POST['title']) : '';
			$content = isset($_POST['content']) ? trim($_POST['content']) : '';
			$order = isset($_POST['order']) ? intval($_POST['order']) : 0;

			if ($title === '') {
				$_SESSION['flash'] = 'Tiêu đề bài học không được để trống.';
				header('Location: index.php?controller=lesson&action=edit&id=' . $id);
				exit;
			}

			$ok = Lesson::update($id, $title, $content, $order);
			if ($ok) {
				$_SESSION['flash'] = 'Cập nhật bài học thành công.';
				header('Location: index.php?controller=lesson&action=manage&course_id=' . $lesson['course_id']);
				exit;
			} else {
				$_SESSION['flash'] = 'Lỗi khi cập nhật bài học.';
			}
		}

		$message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
		unset($_SESSION['flash']);
		require __DIR__ . '/../views/instructor/lessons/edit.php';
	}

	public function delete()
	{
		$this->requireInstructor();
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if ($id <= 0) {
			echo 'ID bài học không hợp lệ';
			exit;
		}

		$lesson = Lesson::find($id);
		if (!$lesson) {
			echo 'Không tìm thấy bài học';
			exit;
		}

		$ok = Lesson::delete($id);
		if ($ok) {
			$_SESSION['flash'] = 'Xóa bài học thành công.';
		} else {
			$_SESSION['flash'] = 'Lỗi khi xóa bài học.';
		}

		header('Location: index.php?controller=lesson&action=manage&course_id=' . $lesson['course_id']);
		exit;
	}
}

