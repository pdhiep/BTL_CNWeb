<?php

class User
{
	private $conn;
	private $table = 'users';
	private $columns = [];

	public function __construct(PDO $db)
	{
		$this->conn = $db;
	}

	private function getColumns()
	{
		if (empty($this->columns)) {
			$stmt = $this->conn->query("SHOW COLUMNS FROM {$this->table}");
			$this->columns = array_map(static fn($row) => $row['Field'], $stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		return $this->columns;
	}

	public function columnExists($field)
	{
		return in_array($field, $this->getColumns(), true);
	}

	public function getNameColumn()
	{
		foreach (['name', 'full_name', 'username'] as $candidate) {
			if ($this->columnExists($candidate)) {
				return $candidate;
			}
		}
		return null;
	}

	public function create($name, $email, $passwordHash, $role = 'student')
	{
		$data = [];
		if ($this->columnExists('email')) {
			$data['email'] = $email;
		}
		if ($this->columnExists('password')) {
			$data['password'] = $passwordHash;
		}
		if ($this->columnExists('role')) {
			$data['role'] = $role;
		}
		$nameColumn = $this->getNameColumn();
		if ($nameColumn && $name !== '') {
			$data[$nameColumn] = $name;
		}

		if (empty($data['email']) || empty($data['password'])) {
			throw new RuntimeException('users table must contain email and password columns.');
		}

		$fields = array_keys($data);
		$placeholders = array_map(static fn($field) => ':' . $field, $fields);
		$params = [];
		foreach ($data as $field => $value) {
			$params[':' . $field] = $value;
		}

		$sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
		$stmt = $this->conn->prepare($sql);
		return $stmt->execute($params);
	}

	public function findByEmail($email)
	{
		$sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([':email' => $email]);
		return $stmt->fetch();
	}

	public function findById($id)
	{
		$sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([':id' => $id]);
		return $stmt->fetch();
	}

	public function update($id, $fields)
	{
		$sets = [];
		$params = [':id' => $id];
		foreach ($fields as $k => $v) {
			if (!$this->columnExists($k)) {
				continue;
			}
			$sets[] = "`$k` = :$k";
			$params[":$k"] = $v;
		}
		if (empty($sets)) {
			return false;
		}
		$sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = :id";
		$stmt = $this->conn->prepare($sql);
		return $stmt->execute($params);
	}

	public function all()
	{
		$selects = ['id'];
		$nameColumn = $this->getNameColumn();
		if ($nameColumn) {
			$selects[] = "$nameColumn AS name";
		} elseif ($this->columnExists('email')) {
			$selects[] = "email AS name";
		}
		if ($this->columnExists('email')) {
			$selects[] = 'email';
		}
		if ($this->columnExists('role')) {
			$selects[] = 'role';
		}
		if ($this->columnExists('created_at')) {
			$selects[] = 'created_at';
		}
		$sql = "SELECT " . implode(', ', $selects) . " FROM {$this->table} ORDER BY id DESC";
		$stmt = $this->conn->query($sql);
		return $stmt->fetchAll();
	}
}
