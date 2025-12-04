<?php
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
	private function requireLogin()
	{
		if (session_status() == PHP_SESSION_NONE) session_start();
		if (!isset($_SESSION['user_id'])) {
			header('Location: index.php?controller=auth&action=login');
			exit;
		}
	}

	public function index()
	{
		$this->requireLogin();
		require __DIR__ . '/../views/profile.php';
	}

	public function uploadAvatar()
	{
		$this->requireLogin();

		if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['avatar'])) {
			$_SESSION['flash'] = 'Lỗi khi tải lên ảnh đại diện';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		$file = $_FILES['avatar'];
		$userId = intval($_SESSION['user_id']);

		// Validate file
		$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
		if (!in_array($file['type'], $allowedTypes)) {
			$_SESSION['flash'] = 'Chỉ hỗ trợ các tệp hình ảnh (JPG, PNG, GIF, WebP)';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		$maxSize = 5 * 1024 * 1024; // 5MB
		if ($file['size'] > $maxSize) {
			$_SESSION['flash'] = 'Kích thước ảnh không được vượt quá 5MB';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		// Create directory if not exists
		$uploadDir = __DIR__ . '/../assets/uploads/avatars/';
		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0755, true);
		}

		// Generate unique filename
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$filename = 'avatar_' . $userId . '_' . time() . '.' . $ext;
		$filepath = $uploadDir . $filename;

		// Move uploaded file
		if (move_uploaded_file($file['tmp_name'], $filepath)) {
			// Update user avatar in database
			$user = User::find($userId);
			if ($user) {
				// Delete old avatar if exists
				if (!empty($user['avatar']) && file_exists($uploadDir . $user['avatar'])) {
					unlink($uploadDir . $user['avatar']);
				}

				// Update database
				$pdo = db();
				$stmt = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
				$stmt->execute(['avatar' => $filename, 'id' => $userId]);

				// Update session
				$_SESSION['user_avatar'] = $filename;
				$_SESSION['flash'] = 'Tải lên ảnh đại diện thành công!';
			}
		} else {
			$_SESSION['flash'] = 'Lỗi khi tải lên tệp';
		}

		header('Location: index.php?controller=profile&action=index');
		exit;
	}

	public function update()
	{
		$this->requireLogin();

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		$userId = intval($_SESSION['user_id']);
		$fullname = trim($_POST['fullname'] ?? '');
		$phone = trim($_POST['phone'] ?? '');
		$bio = trim($_POST['bio'] ?? '');

		if (empty($fullname)) {
			$_SESSION['flash'] = 'Vui lòng nhập tên đầy đủ';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		$pdo = db();
		$stmt = $pdo->prepare('UPDATE users SET fullname = :fullname, phone = :phone, bio = :bio WHERE id = :id');
		$ok = $stmt->execute([
			'fullname' => $fullname,
			'phone' => $phone,
			'bio' => $bio,
			'id' => $userId
		]);

		if ($ok) {
			$_SESSION['user_name'] = $fullname;
			$_SESSION['flash'] = 'Cập nhật thông tin thành công!';
		} else {
			$_SESSION['flash'] = 'Lỗi khi cập nhật thông tin';
		}

		header('Location: index.php?controller=profile&action=index');
		exit;
	}

	public function changePassword()
	{
		$this->requireLogin();

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		$userId = intval($_SESSION['user_id']);
		$currentPassword = $_POST['current_password'] ?? '';
		$newPassword = $_POST['new_password'] ?? '';
		$confirmPassword = $_POST['confirm_password'] ?? '';

		// Validate
		if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
			$_SESSION['flash'] = 'Vui lòng điền đầy đủ tất cả các trường';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		if ($newPassword !== $confirmPassword) {
			$_SESSION['flash'] = 'Mật khẩu xác nhận không khớp';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		if (strlen($newPassword) < 6) {
			$_SESSION['flash'] = 'Mật khẩu phải có ít nhất 6 ký tự';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		// Verify current password
		$user = User::find($userId);
		if (!$user || !password_verify($currentPassword, $user['password'])) {
			$_SESSION['flash'] = 'Mật khẩu hiện tại không đúng';
			header('Location: index.php?controller=profile&action=index');
			exit;
		}

		// Update password
		$pdo = db();
		$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
		$stmt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
		$ok = $stmt->execute([
			'password' => $hashedPassword,
			'id' => $userId
		]);

		if ($ok) {
			$_SESSION['flash'] = 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại.';
			header('Location: index.php?controller=auth&action=logout');
		} else {
			$_SESSION['flash'] = 'Lỗi khi đổi mật khẩu';
			header('Location: index.php?controller=profile&action=index');
		}

		exit;
	}
}
