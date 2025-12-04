<?php
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';

class InstructorController
{
    private function requireInstructor()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $roleNum = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;
        if (!isset($_SESSION['user_id']) || !in_array($roleNum, [1, 2])) {
            $_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireInstructor();
        $instructorId = intval($_SESSION['user_id']);
        $courses = Course::getByInstructor($instructorId);

        // get total students per instructor
        $totalEnrolled = 0;
        foreach ($courses as $c) {
            $totalEnrolled += Enrollment::getEnrolledCount($c['id']);
        }

        require __DIR__ . '/../views/instructor/dashboard.php';
    }

    public function my_courses()
    {
        $this->requireInstructor();
        $instructorId = intval($_SESSION['user_id']);
        $courses = Course::getByInstructor($instructorId);
        require __DIR__ . '/../views/instructor/my_courses.php';
    }

    public function students()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
        if ($courseId <= 0) {
            echo 'ID khóa học không hợp lệ';
            exit;
        }

        $course = Course::find($courseId);
        if (!$course) {
            echo 'Không tìm thấy khóa học';
            exit;
        }

        // Ownership check: only owner instructor or admin can view students
        $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
        $userRole = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;
        if ($userRole !== 2 && intval($course['instructor_id']) !== $userId) {
            echo 'Bạn không có quyền xem danh sách học viên cho khóa học này.';
            exit;
        }

        $students = Enrollment::getStudentsByCourse($courseId);
        require __DIR__ . '/../views/instructor/students/list.php';
    }

    public function manage()
    {
        $this->requireInstructor();
        $instructorId = intval($_SESSION['user_id']);
        $courses = Course::getByInstructor($instructorId);
        require __DIR__ . '/../views/instructor/course/manage.php';
    }

    // Create course (form + submit)
    public function createCourse()
    {
        $this->requireInstructor();
        $instructorId = intval($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $categoryVal = intval($_POST['category_id'] ?? 0);
            $category = ($categoryVal > 0) ? $categoryVal : null;  // Convert 0 to NULL for foreign key
            $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.00;
            $level = isset($_POST['level']) ? $_POST['level'] : null;

            if ($title === '') {
                $_SESSION['flash'] = 'Tiêu đề không được để trống.';
                header('Location: index.php?controller=instructor&action=createCourse');
                exit;
            }

            $ok = Course::create($title, $description, $instructorId, $category, $price, $level, null);
            if ($ok) {
                $_SESSION['flash'] = 'Tạo khóa học thành công.';
                header('Location: index.php?controller=instructor&action=manage');
                exit;
            } else {
                $_SESSION['flash'] = 'Lỗi khi tạo khóa học.';
            }
        }

        require __DIR__ . '/../views/instructor/course/create.php';
    }

    public function editCourse()
    {
        $this->requireInstructor();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            echo 'ID khóa học không hợp lệ';
            exit;
        }

        $course = Course::find($id);
        if (!$course) {
            echo 'Không tìm thấy khóa học';
            exit;
        }

        // Ownership check: only owner instructor or admin can edit
        $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
        $userRole = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;
        if ($userRole !== 2 && intval($course['instructor_id']) !== $userId) {
            echo 'Bạn không có quyền chỉnh sửa khóa học này.';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $categoryVal = intval($_POST['category_id'] ?? 0);
            $category = ($categoryVal > 0) ? $categoryVal : null;  // Convert 0 to NULL for foreign key
            $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.00;
            $level = isset($_POST['level']) ? $_POST['level'] : null;

            if ($title === '') {
                $_SESSION['flash'] = 'Tiêu đề không được để trống.';
                header('Location: index.php?controller=instructor&action=editCourse&id=' . $id);
                exit;
            }

            $ok = Course::updateCourse($id, $title, $description, $category, $price, $level, null);
            if ($ok) {
                $_SESSION['flash'] = 'Cập nhật khóa học thành công.';
                header('Location: index.php?controller=instructor&action=manage');
                exit;
            } else {
                $_SESSION['flash'] = 'Lỗi khi cập nhật khóa học.';
            }
        }

        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    public function deleteCourse()
    {
        $this->requireInstructor();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) {
            echo 'ID khóa học không hợp lệ';
            exit;
        }

        $course = Course::find($id);
        if (!$course) {
            echo 'Không tìm thấy khóa học';
            exit;
        }

        // Ownership check: only owner instructor or admin can delete
        $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
        $userRole = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;
        if ($userRole !== 2 && intval($course['instructor_id']) !== $userId) {
            echo 'Bạn không có quyền xóa khóa học này.';
            exit;
        }

        $ok = Course::deleteCourse($id);
        if ($ok) {
            $_SESSION['flash'] = 'Xóa khóa học thành công.';
        } else {
            $_SESSION['flash'] = 'Lỗi khi xóa khóa học.';
        }

        header('Location: index.php?controller=instructor&action=manage');
        exit;
    }
}
