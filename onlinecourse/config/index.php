<?php
session_start();

require_once __DIR__ . '/config/Database.php';

// Autoload Controller & Model
spl_autoload_register(function ($class) {
    $controllerPath = __DIR__ . '/controllers/' . $class . '.php';
    $modelPath      = __DIR__ . '/models/' . $class . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    } elseif (file_exists($modelPath)) {
        require_once $modelPath;
    }
});

// Lấy url dạng controller/action/param1/param2...
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

// Nếu không có gì → HomeController@index
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) . 'Controller' : 'HomeController';
$actionName     = $urlParts[1] ?? 'index';
$params         = array_slice($urlParts, 2);

// Nếu controller không tồn tại → HomeController
if (!class_exists($controllerName)) {
    $controllerName = 'HomeController';
}

// Tạo instance
$controller = new $controllerName();

// Nếu action không tồn tại → index
if (!method_exists($controller, $actionName)) {
    $actionName = 'index';
}

// Gọi action với params
call_user_func_array([$controller, $actionName], $params);
