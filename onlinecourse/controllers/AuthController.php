<?php
declare(strict_types=1);

class AuthController
{
	private User $users;

	public function __construct()
	{
		$this->users = new User();
	}

	public function login(array $params = []): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->handleLogin();
			return;
		}

		$this->render('auth/login', [
			'pageTitle' => 'Đăng nhập',
			'old' => $_SESSION['old'] ?? [],
		]);
	}

	public function register(array $params = []): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->handleRegister();
			return;
		}

		$this->render('auth/register', [
			'pageTitle' => 'Đăng ký tài khoản',
			'old' => $_SESSION['old'] ?? [],
			'nameField' => $this->users->getNameColumn(),
		]);
	}

	public function logout(array $params = []): void
	{
		unset($_SESSION['user']);
		session_regenerate_id(true);
		$this->redirect('home', 'index');
	}

	public function profile(array $params = []): void
	{
		$this->requireAuth();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$this->handleProfileUpdate();
			return;
		}

		$user = $this->users->findById((int) $_SESSION['user']['id']);
		if (!$user) {
			$this->flash('errors', ['Không tìm thấy tài khoản.']);
			$this->redirect('auth', 'logout');
			return;
		}

		$this->render('student/dashboard', [
			'pageTitle' => 'Quản lý tài khoản',
			'user' => $user,
			'nameField' => $this->users->getNameColumn(),
		]);
	}

	private function handleRegister(): void
	{
		$name = trim($_POST['name'] ?? '');
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';
		$confirm = $_POST['password_confirm'] ?? '';
		$nameColumn = $this->users->getNameColumn();

		$errors = [];
		if ($nameColumn !== null && $name === '') {
			$errors[] = 'Vui lòng nhập họ tên.';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Email không hợp lệ.';
		}
		if (strlen($password) < 6) {
			$errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
		}
		if ($password !== $confirm) {
			$errors[] = 'Xác nhận mật khẩu không khớp.';
		}
		if ($this->users->findByEmail($email)) {
			$errors[] = 'Email đã tồn tại trong hệ thống.';
		}

		if (!empty($errors)) {
			$this->flash('errors', $errors);
			$_SESSION['old'] = ['name' => $name, 'email' => $email];
			$this->redirect('auth', 'register');
			return;
		}

		$created = $this->users->create($name, $email, password_hash($password, PASSWORD_DEFAULT));

		if ($created) {
			$this->flash('success', ['Đăng ký thành công, hãy đăng nhập.']);
			unset($_SESSION['old']);
			$this->redirect('auth', 'login');
			return;
		}

		$this->flash('errors', ['Không thể tạo tài khoản, hãy thử lại.']);
		$_SESSION['old'] = ['name' => $name, 'email' => $email];
		$this->redirect('auth', 'register');
	}

	private function handleLogin(): void
	{
		$email = trim($_POST['email'] ?? '');
		$password = $_POST['password'] ?? '';
		$errors = [];

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors[] = 'Email không hợp lệ.';
		}
		if ($password === '') {
			$errors[] = 'Vui lòng nhập mật khẩu.';
		}

		$user = $this->users->findByEmail($email);
		if (!$user || !password_verify($password, $user['password'])) {
			$errors[] = 'Thông tin đăng nhập không đúng.';
		}

		if (!empty($errors)) {
			$this->flash('errors', $errors);
			$_SESSION['old'] = ['email' => $email];
			$this->redirect('auth', 'login');
			return;
		}

		$_SESSION['user'] = [
			'id' => $user['id'],
			'name' => $this->resolveDisplayName($user),
			'email' => $user['email'],
			'role' => $user['role'] ?? 'student',
		];

		unset($_SESSION['old']);
		$this->flash('success', ['Đăng nhập thành công.']);
		$this->redirect('home', 'index');
	}

	private function handleProfileUpdate(): void
	{
		$this->requireAuth();
		$userId = (int) $_SESSION['user']['id'];
		$nameField = $this->users->getNameColumn();
		$name = trim($_POST['name'] ?? '');
		$password = $_POST['password'] ?? '';
		$fields = [];

		if ($nameField !== null && $name !== '') {
			$fields[$nameField] = $name;
		}
		if ($password !== '') {
			if (strlen($password) < 6) {
				$this->flash('errors', ['Mật khẩu mới cần ít nhất 6 ký tự.']);
				$this->redirect('auth', 'profile');
				return;
			}
			$fields['password'] = password_hash($password, PASSWORD_DEFAULT);
		}

		if (empty($fields)) {
			$this->flash('errors', ['Không có dữ liệu để cập nhật.']);
			$this->redirect('auth', 'profile');
			return;
		}

		$updated = $this->users->update($userId, $fields);
		if ($updated && $nameField !== null && isset($fields[$nameField])) {
			$_SESSION['user']['name'] = $fields[$nameField];
		}

		$this->flash('success', $updated ? ['Cập nhật thông tin thành công.'] : ['Không thể cập nhật thông tin.']);
		$this->redirect('auth', 'profile');
	}

	private function resolveDisplayName(array $user): string
	{
		foreach (['name', 'full_name', 'fullname', 'username'] as $candidate) {
			if (!empty($user[$candidate])) {
				return (string) $user[$candidate];
			}
		}

		return $user['email'] ?? 'Người dùng';
	}

	private function render(string $view, array $data = []): void
	{
		extract($data, EXTR_SKIP);
		include ROOT_PATH . '/views/layouts/header.php';
		include ROOT_PATH . '/views/' . $view . '.php';
		include ROOT_PATH . '/views/layouts/footer.php';
		unset($_SESSION['old']);
	}

	private function redirect(string $controller, string $action): void
	{
		header('Location: index.php?controller=' . $controller . '&action=' . $action);
		exit;
	}

	private function flash(string $type, array $messages): void
	{
		$_SESSION['flash'][$type] = $messages;
	}

	private function requireAuth(): void
	{
		if (empty($_SESSION['user'])) {
			$this->flash('errors', ['Vui lòng đăng nhập trước.']);
			$this->redirect('auth', 'login');
		}
	}
}
