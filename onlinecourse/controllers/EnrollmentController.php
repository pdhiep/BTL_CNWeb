<?php
require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController
{
    public function enroll()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
            header('Location: index.php?controller=auth&action=login');
            exit;
        }

        // Prevent instructors and admins from enrolling in courses
        $userRole = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : 0;
        if ($userRole !== 0) {  // Only students (role 0) can enroll
            $_SESSION['flash'] = 'Chỉ học viên mới có thể đăng ký khóa học.';
            header('Location: index.php?controller=course&action=index');
            exit;
        }

        $userId = intval($_SESSION['user_id']);
        $courseId = isset($_POST['course_id']) ? intval($_POST['course_id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
        if ($courseId <= 0) {
            $_SESSION['flash'] = 'Khóa học không hợp lệ.';
            header('Location: index.php?controller=course&action=index');
            exit;
        }

        if (Enrollment::isEnrolled($userId, $courseId)) {
            $_SESSION['flash'] = 'Bạn đã đăng ký khóa học này.';
            header('Location: index.php?controller=course&action=detail&id=' . $courseId);
            exit;
        }

        $ok = Enrollment::enroll($userId, $courseId);
        if ($ok) {
            $_SESSION['flash'] = 'Đăng ký thành công.';
        } else {
            $_SESSION['flash'] = 'Đăng ký thất bại.';
        }
        header('Location: index.php?controller=course&action=detail&id=' . $courseId);
        exit;
    }

    public function updateProgress()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(403);
            echo 'Unauthorized';
            exit;
        }

        $userId = intval($_SESSION['user_id']);
        $courseId = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;
        $progress = isset($_POST['progress']) ? intval($_POST['progress']) : null;
        if ($courseId <= 0 || $progress === null) {
            http_response_code(400);
            echo 'Invalid parameters';
            exit;
        }

        $pdo = db();
        $stmt = $pdo->prepare('UPDATE enrollments SET progress = :progress WHERE student_id = :uid AND course_id = :cid');
        $stmt->execute(['progress' => $progress, 'uid' => $userId, 'cid' => $courseId]);
        echo json_encode(['ok' => true]);
        exit;
    }
}
