<?php

session_start();

// Default routing behaviour:
// - If visitor is not authenticated, show auth login page as the landing page.
// - If authenticated and no route specified, redirect to role-specific dashboard.
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : null;
$actionName = isset($_GET['action']) ? $_GET['action'] : null;

if ($controllerName === null && $actionName === null) {
    if (!isset($_SESSION['user_id'])) {
        // default landing for unauthenticated visitors
        $controllerName = 'auth';
        $actionName = 'login';
    } else {
        // authenticated users land on their dashboard by role
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
    // keep provided route (or fall back to course:index)
    $controllerName = $controllerName ?? 'course';
    $actionName = $actionName ?? 'index';
}

// Define public routes that don't require authentication
// Format: 'controller' => ['action1','action2']
$publicRoutes = [
    'course' => ['index', 'detail', 'search'],
    'auth' => ['login', 'register'],
    // allow static home/index
    '' => ['index']
];

// Helper: check if current route is public
$isPublic = false;
if (isset($publicRoutes[$controllerName]) && in_array($actionName, $publicRoutes[$controllerName])) {
    $isPublic = true;
}

// If not public, require login
if (!$isPublic) {
    if (!isset($_SESSION['user_id'])) {
        // remember requested URL to redirect after login
        $_SESSION['after_login_redirect'] = $_SERVER['REQUEST_URI'];
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}

// Role-based access: restrict admin and instructor areas
// Session stores numeric role values (0 student, 1 instructor, 2 admin)
$roleNum = isset($_SESSION['user_role']) ? intval($_SESSION['user_role']) : -1;

// If accessing admin controllers, require admin role (2)
if (strtolower($controllerName) === 'admin' && $roleNum !== 2) {
    $_SESSION['flash'] = 'Bạn không có quyền truy cập trang quản trị.';
    header('Location: index.php');
    exit;
}

// If accessing instructor controllers, require instructor (1) or admin (2)
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
