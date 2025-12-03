<?php
class LessonController
{
    private $lessonModel;
    private $courseModel;

    public function __construct()
    {
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
    }

    // GET: /lesson/create/{courseId}
    public function create($courseId)
    {
        $course = $this->courseModel->find($courseId);
        if (!$course) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/lessons/create.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // POST: /lesson/store
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $courseId = $_POST['course_id'] ?? null;
        $course   = $this->courseModel->find($courseId);
        if (!$course) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $data = [
            'course_id' => $courseId,
            'title'     => trim($_POST['title'] ?? ''),
            'content'   => trim($_POST['content'] ?? ''),
            'video_url' => trim($_POST['video_url'] ?? ''),
            'order'     => $_POST['order'] ?? 1,
        ];

        $this->lessonModel->create($data);

        header('Location: ' . BASE_URL . 'instructor/manageLessons/' . $courseId);
        exit;
    }

    // GET: /lesson/edit/{id}
    public function edit($id)
    {
        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $course = $this->courseModel->find($lesson['course_id']);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/instructor/lessons/edit.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // POST: /lesson/update/{id}
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
            exit;
        }

        $courseId = $lesson['course_id'];

        $data = [
            'title'     => trim($_POST['title'] ?? ''),
            'content'   => trim($_POST['content'] ?? ''),
            'video_url' => trim($_POST['video_url'] ?? ''),
            'order'     => $_POST['order'] ?? 1,
        ];

        $this->lessonModel->update($id, $data);

        header('Location: ' . BASE_URL . 'instructor/manageLessons/' . $courseId);
        exit;
    }

    // GET: /lesson/delete/{id}
    public function delete($id)
    {
        $lesson = $this->lessonModel->find($id);
        if ($lesson) {
            $courseId = $lesson['course_id'];
            $this->lessonModel->delete($id);
            header('Location: ' . BASE_URL . 'instructor/manageLessons/' . $courseId);
        } else {
            header('Location: ' . BASE_URL . 'instructor/myCourses');
        }
        exit;
    }
}
