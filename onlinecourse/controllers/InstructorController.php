<?php
class InstructorController
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = new Course();
    }

    // GET: /instructor/dashboard
    public function dashboard()
    {
        // Tạm thời không có thống kê, chỉ là trang chào
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/dashboard.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // GET: /instructor/myCourses
    public function myCourses()
    {
        // SAU NÀY: $instructorId = $_SESSION['user']['id'];
        $instructorId = 1;

        $courses = $this->courseModel->getByInstructor($instructorId);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/my_courses.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // GET: /instructor/createCourse
    public function createCourse()
    {
        $course = null; // cho form reuse
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/course/create.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // POST: /instructor/storeCourse
    public function storeCourse()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        // SAU NÀY: $instructorId = $_SESSION['user']['id'];
        $instructorId = 1;

        $data = [
            'title'          => trim($_POST['title'] ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'category_id'    => $_POST['category_id'] ?? null,
            'price'          => $_POST['price'] ?? 0,
            'duration_weeks' => $_POST['duration_weeks'] ?? 0,
            'level'          => $_POST['level'] ?? 'Beginner',
            // Upload image sẽ làm ở nhiệm vụ 4, tạm để rỗng
            'image'          => '',
            'instructor_id'  => $instructorId,
        ];

        $this->courseModel->create($data);

        header('Location: ' . BASE_URL . 'instructor/myCourses');
        exit;
    }

    // GET: /instructor/editCourse/{id}
    public function editCourse($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/course/edit.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // POST: /instructor/updateCourse/{id}
    public function updateCourse($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $course = $this->courseModel->find($id);
        if (!$course) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $data = [
            'title'          => trim($_POST['title'] ?? ''),
            'description'    => trim($_POST['description'] ?? ''),
            'category_id'    => $_POST['category_id'] ?? null,
            'price'          => $_POST['price'] ?? 0,
            'duration_weeks' => $_POST['duration_weeks'] ?? 0,
            'level'          => $_POST['level'] ?? 'Beginner',
            // tạm chưa cho phép sửa ảnh
            'image'          => $course['image'] ?? '',
        ];

        $this->courseModel->update($id, $data);

        header('Location: ' . BASE_URL . 'instructor/myCourses');
        exit;
    }

    // GET: /instructor/deleteCourse/{id}
    public function deleteCourse($id)
    {
        $this->courseModel->delete($id);
        header('Location: ' . BASE_URL . 'instructor/myCourses');
        exit;
    }

    // GET: /instructor/manageLessons/{courseId}
    public function manageLessons($courseId)
    {
        $courseModel = $this->courseModel;
        $lessonModel = new Lesson();

        $course  = $courseModel->find($courseId);
        if (!$course) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $lessons = $lessonModel->getByCourse($courseId);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/lessons/manage.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }
}
