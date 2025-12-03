<?php
class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // GET: /BTTH2/onlinecourse/auth/login
    public function login()
    {
        $error = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/auth/login.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // POST: /BTTH2/onlinecourse/auth/doLogin
    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /BTTH2/onlinecourse/auth/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id'       => $user['id'],
                'fullname' => $user['fullname'],
                'role'     => $user['role'],
            ];

            // Điều hướng theo role
            if ($user['role'] == 1) {
                header('Location: /BTTH2/onlinecourse/instructor/dashboard');
            } elseif ($user['role'] == 2) {
                header('Location: /BTTH2/onlinecourse/admin/dashboard');
            } else {
                header('Location: /BTTH2/onlinecourse/student/dashboard');
            }
            exit;
        } else {
            $_SESSION['login_error'] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
            header('Location: /BTTH2/onlinecourse/auth/login');
            exit;
        }
    }

    // GET: /BTTH2/onlinecourse/auth/register
    public function register()
    {
        $error = $_SESSION['register_error'] ?? '';
        unset($_SESSION['register_error']);

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/auth/register.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    // POST: /BTTH2/onlinecourse/auth/doRegister
    public function doRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /BTTH2/onlinecourse/auth/register');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        // Validate rất đơn giản, bạn có thể thêm sau
        if ($password !== $confirm) {
            $_SESSION['register_error'] = 'Mật khẩu xác nhận không khớp!';
            header('Location: /BTTH2/onlinecourse/auth/register');
            exit;
        }

        if ($this->userModel->findByUsername($username)) {
            $_SESSION['register_error'] = 'Username đã tồn tại!';
            header('Location: /BTTH2/onlinecourse/auth/register');
            exit;
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['register_error'] = 'Email đã tồn tại!';
            header('Location: /BTTH2/onlinecourse/auth/register');
            exit;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $hash,
            'fullname' => $fullname,
            'role'     => 0, // mặc định học viên
        ];

        if ($this->userModel->create($data)) {
            // Sau khi đăng ký thành công → cho login luôn
            $_SESSION['login_success'] = 'Đăng ký thành công, hãy đăng nhập!';
            header('Location: /BTTH2/onlinecourse/auth/login');
            exit;
        } else {
            $_SESSION['register_error'] = 'Lỗi hệ thống, thử lại sau!';
            header('Location: /BTTH2/onlinecourse/auth/register');
            exit;
        }
    }

    // GET: /BTTH2/onlinecourse/auth/logout
    public function logout()
    {
        session_destroy();
        header('Location: /BTTH2/onlinecourse/');
        exit;
    }
}
