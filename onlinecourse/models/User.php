<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';

class User
{
	private PDO $connection;
	private string $table = 'users';
	private array $columns = [];

	public function __construct()
	{
		$this->connection = Database::getConnection();
	}

	private function loadColumns(): array
	{
		if (!empty($this->columns)) {
			return $this->columns;
		}

		$stmt = $this->connection->query("SHOW COLUMNS FROM {$this->table}");
		$this->columns = array_map(static function (array $row): string {
			return $row['Field'];
		}, $stmt->fetchAll(PDO::FETCH_ASSOC));

		return $this->columns;
	}

	private function hasColumn(string $column): bool
	{
		return in_array($column, $this->loadColumns(), true);
	}

	public function getNameColumn(): ?string
	{
		foreach (['name', 'full_name', 'fullname', 'username'] as $candidate) {
			if ($this->hasColumn($candidate)) {
				return $candidate;
			}
		}

		return null;
	}

	public function create(string $name, string $email, string $passwordHash, string $role = 'student'): bool
	{
		$data = [];
		$nameColumn = $this->getNameColumn();

		if ($nameColumn !== null && $name !== '') {
			$data[$nameColumn] = $name;
		}
		if ($this->hasColumn('email')) {
			$data['email'] = $email;
		}
		if ($this->hasColumn('password')) {
			$data['password'] = $passwordHash;
		}
		if ($this->hasColumn('role')) {
			$data['role'] = $role;
		}

		if (!isset($data['email'], $data['password'])) {
			throw new RuntimeException('Bảng users phải có cột email và password.');
		}

		$fields = array_keys($data);
		$placeholders = array_map(static fn(string $field): string => ':' . $field, $fields);
		$params = [];
		foreach ($data as $field => $value) {
			$params[':' . $field] = $value;
		}

		$sql = sprintf(
			'INSERT INTO %s (%s) VALUES (%s)',
			$this->table,
			implode(', ', $fields),
			implode(', ', $placeholders)
		);

		$stmt = $this->connection->prepare($sql);
		return $stmt->execute($params);
	}

	public function findByEmail(string $email): ?array
	{
		if (!$this->hasColumn('email')) {
			return null;
		}

		$sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([':email' => $email]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result ?: null;
	}

	public function findById(int $id): ?array
	{
		$sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([':id' => $id]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		return $result ?: null;
	}

	public function update(int $id, array $fields): bool
	{
		$sets = [];
		$params = [':id' => $id];

		foreach ($fields as $column => $value) {
			if (!$this->hasColumn($column)) {
				continue;
			}
			$sets[] = sprintf('`%s` = :%s', $column, $column);
			$params[':' . $column] = $value;
		}

		if (empty($sets)) {
			return false;
		}

		$sql = sprintf('UPDATE %s SET %s WHERE id = :id', $this->table, implode(', ', $sets));
		$stmt = $this->connection->prepare($sql);

		return $stmt->execute($params);
	}

	public function all(): array
	{
		$columns = ['id'];
		$nameColumn = $this->getNameColumn();
		if ($nameColumn !== null) {
			$columns[] = sprintf('%s AS name', $nameColumn);
		}
		if ($this->hasColumn('email')) {
			$columns[] = 'email';
		}
		if ($this->hasColumn('role')) {
			$columns[] = 'role';
		}
		if ($this->hasColumn('created_at')) {
			$columns[] = 'created_at';
		}

		$sql = sprintf('SELECT %s FROM %s ORDER BY id DESC', implode(', ', $columns), $this->table);
		return $this->connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}
}
