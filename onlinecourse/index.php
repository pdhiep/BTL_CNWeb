<?php
// Simple front controller / router
session_start();

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'course';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

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
