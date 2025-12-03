<?php
declare(strict_types=1);

class HomeController
{
	public function index(array $params = []): void
	{
		$pageTitle = 'Trang chủ';
		include ROOT_PATH . '/views/layouts/header.php';
		include ROOT_PATH . '/views/home/index.php';
		include ROOT_PATH . '/views/layouts/footer.php';
	}
}
