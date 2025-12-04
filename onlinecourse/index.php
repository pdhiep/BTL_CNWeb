<?php

session_start();

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : null;
$actionName = isset($_GET['action']) ? $_GET['action'] : null;

if ($controllerName === null && $actionName === null) {
    if (!isset($_SESSION['user_id'])) {
    
        $controllerName = 'auth';
        $actionName = 'login';
    } else {
        $role = isset($_SESSION['user_role']) ? strtolower($_SESSION['user_role']) : 'student';
        if ($role === 'admin') {
            header('Location: index.php?controller=admin&action=dashboard');
            exit;
        } elseif ($role === 'instructor') {
            header('Location: index.php?controller=instructor&action=dashboard');
            exit;
        } else {
            header('Location: index.php?controller=student&action=dashboard');
            exit;
        }
    }
} else {
    
    $controllerName = $controllerName ?? 'course';
    $actionName = $actionName ?? 'index';
}


$publicRoutes = [
    'course' => ['index', 'detail', 'search'],
    'auth' => ['login', 'register'],
   
    '' => ['index']
];


$isPublic = false;
if (isset($publicRoutes[$controllerName]) && in_array($actionName, $publicRoutes[$controllerName])) {
    $isPublic = true;
}

if (!$isPublic) {
    if (!isset($_SESSION['user_id'])) {
        // remember requested URL to redirect after login
        $_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}


$roleNum = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;

if (strtolower($controllerName) === 'admin' && $roleNum !== 2) {
    $_SESSION['flash'] = 'Bạn không có quyền truy cập trang quản trị.';
    header('Location: index.php');
    exit;
}

if (strtolower($controllerName) === 'instructor' && !in_array($roleNum, [1, 2])) {
    $_SESSION['flash'] = 'Bạn cần là giảng viên để truy cập chức năng này.';
    header('Location: index.php');
    exit;
}

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = __DIR__ . '/controllers/' . $controllerClass . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerClass)) {
        $ctrl = new $controllerClass();
        if (method_exists($ctrl, $actionName)) {
            $ctrl->{$actionName}();
            exit;
        }
    }
}

http_response_code(404);
echo 'Trang không tìm thấy';
