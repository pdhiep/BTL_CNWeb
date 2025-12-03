<?php
class User
{
    private $conn;
    private $table = 'users';

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (username, email, password, fullname, role)
                VALUES (:username, :email, :password, :fullname, :role)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $data['password']); // đã hash sẵn
        $stmt->bindValue(':fullname', $data['fullname']);
        $stmt->bindValue(':role', $data['role'], PDO::PARAM_INT);

        return $stmt->execute();
    }
}
