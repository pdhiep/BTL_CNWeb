<?php
class HomeController
{
    public function index()
    {
        $title = 'Trang chủ'; // ví dụ truyền biến sang view

        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/home/index.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }
}
