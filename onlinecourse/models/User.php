<?php
require_once __DIR__ . '/../config/Database.php';

class User
{
    // Create a user aligned with the DB schema provided by you
    // DB columns: username, email, password, fullname, role (INT), created_at
    public static function create($fullname, $email, $passwordHash, $role = 0, $username = null)
    {
        $pdo = db();
        $username = $username ?? $email;
        $stmt = $pdo->prepare('INSERT INTO users (username, email, password, fullname, role, created_at) VALUES (:username, :email, :pw, :fullname, :role, NOW())');
        $ok = $stmt->execute([
            'username' => $username,
            'email' => $email,
            'pw' => $passwordHash,
            'fullname' => $fullname,
            'role' => intval($role)
        ]);

        if ($ok) {
            return $pdo->lastInsertId();
        }
        return false;
    }

    public static function findByEmail($email)
    {
        $pdo = db();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public static function find($id)
    {
        $pdo = db();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function setRole($id, $role)
    {
        $pdo = db();
        $stmt = $pdo->prepare('UPDATE users SET role = :role WHERE id = :id');
        return $stmt->execute(['role' => intval($role), 'id' => $id]);
    }

    public static function setActive($id, $active)
    {
        $pdo = db();
        try {
            $stmt = $pdo->prepare('UPDATE users SET is_active = :ia WHERE id = :id');
            return $stmt->execute(['ia' => $active ? 1 : 0, 'id' => $id]);
        } catch (Exception $e) {
            // If the column doesn't exist, return false so caller can handle it
            return false;
        }
    }

    public static function getAll()
    {
        $pdo = db();
        // Try to select is_active if column exists, otherwise fallback
        try {
            $stmt = $pdo->query('SELECT id, username, fullname, email, role, created_at, is_active FROM users ORDER BY created_at DESC');
            return $stmt->fetchAll();
        } catch (Exception $e) {
            $stmt = $pdo->query('SELECT id, username, fullname, email, role, created_at FROM users ORDER BY created_at DESC');
            return $stmt->fetchAll();
        }
    }
}
