<?php
declare(strict_types=1);

session_start();

const ROOT_PATH = __DIR__;
const CONTROLLERS_PATH = ROOT_PATH . '/controllers';
const MODELS_PATH = ROOT_PATH . '/models';
const CORE_PATH = ROOT_PATH . '/core';

require_once ROOT_PATH . '/config/Database.php';

spl_autoload_register(function (string $class): void {
	$candidatePaths = [
		CONTROLLERS_PATH . '/' . $class . '.php',
		MODELS_PATH . '/' . $class . '.php',
		CORE_PATH . '/' . $class . '.php',
	];

	foreach ($candidatePaths as $path) {
		if (file_exists($path)) {
			require_once $path;
			return;
		}
	}
});

$controllerParam = isset($_GET['controller']) ? sanitize($_GET['controller']) : 'home';
$actionParam = isset($_GET['action']) ? sanitize($_GET['action']) : 'index';

$controllerClass = ucfirst($controllerParam) . 'Controller';
$actionMethod = $actionParam;

if (!class_exists($controllerClass)) {
	http_response_code(404);
	echo 'Controller not found.';
	exit;
}

$controller = new $controllerClass();

if (!method_exists($controller, $actionMethod)) {
	http_response_code(404);
	echo 'Action not found.';
	exit;
}

$params = $_REQUEST;
$controller->{$actionMethod}($params);

function sanitize(string $value): string
{
	return preg_replace('/[^a-zA-Z0-9_]/', '', strtolower($value));
}
