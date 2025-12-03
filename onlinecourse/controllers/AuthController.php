<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
	private $db;
	private $userModel;

	public function __construct(PDO $db)
	{
		$this->db = $db;
		$this->userModel = new User($db);
	}

	private function resolveDisplayName(array $user)
	{
		foreach (['name', 'full_name', 'username'] as $field) {
			if (!empty($user[$field])) {
				return $user[$field];
			}
		}
		return $user['email'] ?? 'Người dùng';
	}

	public function showRegister()
	{
		include __DIR__ . '/../views/layouts/header.php';
		include __DIR__ . '/../views/auth/register.php';
		include __DIR__ . '/../views/layouts/footer.php';
	}

	public function register()
	{
		$name = trim($_POST['name'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';
		$password_confirm = $_POST['password_confirm'] ?? '';
		$nameColumn = $this->userModel->getNameColumn();

		$errors = [];
		if ($nameColumn && !$name) $errors[] = 'Tên không được để trống.';
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
		if (strlen($password) < 6) $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
		if ($password !== $password_confirm) $errors[] = 'Mật khẩu xác nhận không khớp.';

		if ($this->userModel->findByEmail($email)) {
			$errors[] = 'Email đã được đăng ký.';
		}

		if (!empty($errors)) {
			$_SESSION['flash_errors'] = $errors;
			$_SESSION['old'] = ['name' => $name, 'email' => $email];
			header('Location: index.php?action=register');
			exit;
		}

		$hash = password_hash($password, PASSWORD_DEFAULT);
		$created = $this->userModel->create($name, $email, $hash);
		if ($created) {
			$_SESSION['flash_success'] = 'Đăng ký thành công. Bạn có thể đăng nhập.';
			header('Location: index.php?action=login');
			exit;
		}

		$_SESSION['flash_errors'] = ['Đã có lỗi xảy ra, vui lòng thử lại.'];
		header('Location: index.php?action=register');
		exit;
	}

	public function showLogin()
	{
		include __DIR__ . '/../views/layouts/header.php';
		include __DIR__ . '/../views/auth/login.php';
		include __DIR__ . '/../views/layouts/footer.php';
	}

	public function login()
	{
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';

		$errors = [];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email không hợp lệ.';
		if (!$password) $errors[] = 'Mật khẩu không được để trống.';

		if (!empty($errors)) {
			$_SESSION['flash_errors'] = $errors;
			header('Location: index.php?action=login');
			exit;
		}

		$user = $this->userModel->findByEmail($email);
		if (!$user || !password_verify($password, $user['password'])) {
			$_SESSION['flash_errors'] = ['Email hoặc mật khẩu không đúng.'];
			header('Location: index.php?action=login');
			exit;
		}

		// Login success
		$_SESSION['user'] = [
			'id' => $user['id'],
			'name' => $this->resolveDisplayName($user),
			'email' => $user['email'],
			'role' => $user['role'] ?? 'student'
		];

		header('Location: index.php');
		exit;
	}

	public function logout()
	{
		unset($_SESSION['user']);
		session_regenerate_id(true);
		header('Location: index.php');
		exit;
	}

	public function profile()
	{
		if (empty($_SESSION['user'])) {
			header('Location: index.php?action=login');
			exit;
		}

		$user = $this->userModel->findById($_SESSION['user']['id']);
		$nameField = $this->userModel->getNameColumn();
		include __DIR__ . '/../views/layouts/header.php';
		include __DIR__ . '/../views/auth/profile.php';
		include __DIR__ . '/../views/layouts/footer.php';
	}

	public function updateProfile()
	{
		if (empty($_SESSION['user'])) {
			header('Location: index.php?action=login');
			exit;
		}

		$id = $_SESSION['user']['id'];
		$name = trim($_POST['name'] ?? '');
		$password = $_POST['password'] ?? '';
		$nameField = $this->userModel->getNameColumn();

		$fields = [];
		if ($nameField && $name) {
			$fields[$nameField] = $name;
		}
		if ($password) {
			if (strlen($password) < 6) {
				$_SESSION['flash_errors'] = ['Mật khẩu phải có ít nhất 6 ký tự.'];
				header('Location: index.php?action=profile');
				exit;
			}
			$fields['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		if (!empty($fields)) {
			$this->userModel->update($id, $fields);
			if ($nameField && isset($fields[$nameField])) {
				$_SESSION['user']['name'] = $fields[$nameField];
			}
			$_SESSION['flash_success'] = 'Cập nhật thông tin thành công.';
		}

		header('Location: index.php?action=profile');
		exit;
	}
}
