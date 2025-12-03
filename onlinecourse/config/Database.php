<?php
class Database
{
	private $host = '127.0.0.1';
	private $dbName = 'onlinecourse';
	private $username = 'root';
	private $password = '';
	private $conn;

	public function getConnection()
	{
		if ($this->conn) {
			return $this->conn;
		}

		try {
			$dsn = "mysql:host={$this->host};dbname={$this->dbName};charset=utf8mb4";
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => false,
			];
			$this->conn = new PDO($dsn, $this->username, $this->password, $options);
			return $this->conn;
		} catch (PDOException $e) {
			// In production, avoid echoing DB errors. For development show message.
			die('Database connection failed: ' . $e->getMessage());
		}
	}
}
