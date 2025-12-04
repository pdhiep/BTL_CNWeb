<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Course.php';

class AdminController
{
    private function requireAdmin()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $roleNum = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;
        if (!isset($_SESSION['user_id']) || $roleNum !== 2) {
            $_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    private function ensureAdminAccount()
    {
        // create a default admin account if none exists (use with caution)
        $pdo = db();
        $stmt = $pdo->query('SELECT COUNT(*) FROM users WHERE role = 2');
        $count = $stmt->fetchColumn();
        if (intval($count) === 0) {
            $pw = password_hash('admin123', PASSWORD_DEFAULT);
            User::create('Administrator', 'admin@local', $pw, 2, 'admin');
        }
    }

    public function dashboard()
    {
        $this->requireAdmin();

        $pdo = db();
        $stats = [];
        $stats['total_users'] = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
        $stats['total_courses'] = $pdo->query('SELECT COUNT(*) FROM courses')->fetchColumn();
        $stats['total_enrollments'] = $pdo->query('SELECT COUNT(*) FROM enrollments')->fetchColumn();
        // revenue: sum of course price * enrollments where possible
        try {
            $stats['revenue'] = $pdo->query('SELECT SUM(c.price) FROM enrollments e JOIN courses c ON e.course_id = c.id')->fetchColumn();
        } catch (Exception $e) {
            $stats['revenue'] = 0;
        }

        // pending courses (if column exists)
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM courses WHERE is_approved = 0");
            $stats['pending_courses'] = $stmt->fetchColumn();
        } catch (Exception $e) {
            $stats['pending_courses'] = 0;
        }

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function users()
    {
        $this->requireAdmin();
        // ensure there's an admin account
        $this->ensureAdminAccount();

        $users = User::getAll();
        require __DIR__ . '/../views/admin/users/manage.php';
    }

    public function activate()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) { header('Location: index.php?controller=admin&action=users'); exit; }
        $ok = User::setActive($id, true);
        if ($ok) {
            $_SESSION['flash'] = 'Kích hoạt người dùng thành công.';
        } else {
            $_SESSION['flash'] = 'Không thể kích hoạt (cột is_active có thể không tồn tại).';
        }
        header('Location: index.php?controller=admin&action=users');
        exit;
    }

    public function deactivate()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) { header('Location: index.php?controller=admin&action=users'); exit; }
        $ok = User::setActive($id, false);
        if ($ok) {
            $_SESSION['flash'] = 'Vô hiệu hóa người dùng thành công.';
        } else {
            $_SESSION['flash'] = 'Không thể vô hiệu hóa (cột is_active có thể không tồn tại).';
        }
        header('Location: index.php?controller=admin&action=users');
        exit;
    }

    public function categories()
    {
        $this->requireAdmin();
        $categories = Category::getAll();

        // If POST, create new category
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $desc = isset($_POST['description']) ? trim($_POST['description']) : null;
            if ($name !== '') {
                Category::create($name, $desc);
                header('Location: index.php?controller=admin&action=categories');
                exit;
            }
        }

        require __DIR__ . '/../views/admin/categories/list.php';
    }

    public function editCategory()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id <= 0) { header('Location: index.php?controller=admin&action=categories'); exit; }
        $category = Category::find($id);
        if (!$category) { header('Location: index.php?controller=admin&action=categories'); exit; }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $desc = isset($_POST['description']) ? trim($_POST['description']) : null;
            if ($name !== '') {
                Category::update($id, $name, $desc);
                header('Location: index.php?controller=admin&action=categories');
                exit;
            }
        }

        require __DIR__ . '/../views/admin/categories/edit.php';
    }

    public function deleteCategory()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            Category::delete($id);
        }
        header('Location: index.php?controller=admin&action=categories');
        exit;
    }

    public function pendingCourses()
    {
        $this->requireAdmin();
        $pdo = db();
        $courses = [];
        
        // Try to fetch pending courses (is_approved = 0)
        try {
            $stmt = $pdo->query('SELECT c.*, u.fullname as instructor_name FROM courses c LEFT JOIN users u ON c.instructor_id = u.id WHERE c.is_approved = 0 ORDER BY c.created_at DESC');
            $courses = $stmt->fetchAll();
        } catch (Exception $e) {
            // If is_approved column doesn't exist, show all courses
            $stmt = $pdo->query('SELECT c.*, u.fullname as instructor_name FROM courses c LEFT JOIN users u ON c.instructor_id = u.id ORDER BY c.created_at DESC');
            $courses = $stmt->fetchAll();
        }
        
        $message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        unset($_SESSION['flash']);
        require __DIR__ . '/../views/admin/courses/pending.php';
    }

    public function approveCourse()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $pdo = db();
            try {
                $stmt = $pdo->prepare('UPDATE courses SET is_approved = 1 WHERE id = :id');
                $stmt->execute(['id' => $id]);
                $_SESSION['flash'] = 'Duyệt khóa học thành công.';
            } catch (Exception $e) {
                $_SESSION['flash'] = 'Không thể duyệt khóa học (cột is_approved có thể không tồn tại).';
            }
        }
        header('Location: index.php?controller=admin&action=pendingCourses');
        exit;
    }

    public function rejectCourse()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if ($id > 0) {
            $pdo = db();
            try {
                $stmt = $pdo->prepare('DELETE FROM courses WHERE id = :id AND is_approved = 0');
                $stmt->execute(['id' => $id]);
                $_SESSION['flash'] = 'Từ chối khóa học thành công.';
            } catch (Exception $e) {
                $_SESSION['flash'] = 'Không thể từ chối khóa học.';
            }
        }
        header('Location: index.php?controller=admin&action=pendingCourses');
        exit;
    }
}
