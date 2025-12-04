<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            $user = User::findByEmail($email);
            if (!$user) {
                $_SESSION['flash'] = 'Tài khoản không tồn tại.';
                header('Location: index.php?controller=auth&action=login');
                exit;
            }

            if (password_verify($password, $user['password'])) {
                // Login success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                $_SESSION['user_role'] = $user['role'];

                // Determine redirect: respect saved redirect, otherwise send to role dashboard
                if (isset($_SESSION['after_login_redirect'])) {
                    $redirect = $_SESSION['after_login_redirect'];
                    unset($_SESSION['after_login_redirect']);
                    header('Location: ' . $redirect);
                    exit;
                }

                // role stored as INT: 0 student, 1 instructor, 2 admin
                $roleNum = intval($user['role']);
                if ($roleNum === 0) {
                    header('Location: index.php?controller=student&action=dashboard');
                    exit;
                } elseif ($roleNum === 1) {
                    header('Location: index.php?controller=instructor&action=dashboard');
                    exit;
                } elseif ($roleNum === 2) {
                    header('Location: index.php?controller=admin&action=dashboard');
                    exit;
                } else {
                    header('Location: index.php');
                    exit;
                }
            } else {
                $_SESSION['flash'] = 'Email hoặc mật khẩu không đúng.';
                header('Location: index.php?controller=auth&action=login');
                exit;
            }
        }

        $message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        unset($_SESSION['flash']);
        require __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $role = isset($_POST['role']) ? $_POST['role'] : 'student';

            if ($fullname === '' || $email === '' || $password === '') {
                $_SESSION['flash'] = 'Vui lòng điền đầy đủ thông tin.';
                header('Location: index.php?controller=auth&action=register');
                exit;
            }

            if (User::findByEmail($email)) {
                $_SESSION['flash'] = 'Email đã được sử dụng.';
                header('Location: index.php?controller=auth&action=register');
                exit;
            }

            $avatarFilename = null;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $tmp = $_FILES['avatar']['tmp_name'];
                $orig = basename($_FILES['avatar']['name']);
                $ext = pathinfo($orig, PATHINFO_EXTENSION);
                $avatarFilename = 'avatar_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
                $dest = __DIR__ . '/../uploads/avatars/' . $avatarFilename;
                @move_uploaded_file($tmp, $dest);
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            // role from form is expected as INT (0 student, 1 instructor)
            $roleNum = intval($role);
            // username: use email if not provided
            $userId = User::create($fullname, $email, $passwordHash, $roleNum, $email);

            if ($userId) {
                // If registering as instructor (role 1) we recommend admin activation.
                // Since the DB schema provided has no `is_active` column, activation requires adding such a column.
                // For now, we will create instructor account with role=1 but active by default.

                // Auto-login for students (role 0). For instructor (1), also login but you may want admin activation.
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_name'] = $fullname;
                $_SESSION['user_role'] = $roleNum;

                if (isset($_SESSION['after_login_redirect'])) {
                    $redirect = $_SESSION['after_login_redirect'];
                    unset($_SESSION['after_login_redirect']);
                    header('Location: ' . $redirect);
                    exit;
                }

                if ($roleNum === 1) {
                    header('Location: index.php?controller=instructor&action=dashboard');
                    exit;
                }

                header('Location: index.php?controller=student&action=dashboard');
                exit;
            } else {
                $_SESSION['flash'] = 'Đăng ký thất bại, vui lòng thử lại.';
                header('Location: index.php?controller=auth&action=register');
                exit;
            }
        }

        $message = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
        unset($_SESSION['flash']);
        require __DIR__ . '/../views/auth/register.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
