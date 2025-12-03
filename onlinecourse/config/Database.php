<?php
declare(strict_types=1);

class Database
{
	private static ?PDO $connection = null;

	private const DEFAULTS = [
		'host' => 'localhost',
		'port' => '3306',
		'dbname' => 'onlinecourse',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8mb4',
	];

	public static function getConnection(): PDO
	{
		if (self::$connection instanceof PDO) {
			return self::$connection;
		}

		$config = [
			'host' => getenv('DB_HOST') ?: self::DEFAULTS['host'],
			'port' => getenv('DB_PORT') ?: self::DEFAULTS['port'],
			'dbname' => getenv('DB_NAME') ?: self::DEFAULTS['dbname'],
			'username' => getenv('DB_USER') ?: self::DEFAULTS['username'],
			'password' => getenv('DB_PASS') ?: self::DEFAULTS['password'],
			'charset' => getenv('DB_CHARSET') ?: self::DEFAULTS['charset'],
		];

		$dsn = sprintf(
			'mysql:host=%s;port=%s;dbname=%s;charset=%s',
			$config['host'],
			$config['port'],
			$config['dbname'],
			$config['charset']
		);

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		self::$connection = new PDO($dsn, $config['username'], $config['password'], $options);

		return self::$connection;
	}

	public static function disconnect(): void
	{
		self::$connection = null;
	}
}
