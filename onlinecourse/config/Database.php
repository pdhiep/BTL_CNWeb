<?php
class Database
{
    // GIỐNG HỆT file config.inc.php của phpMyAdmin
    private static $host = '127.0.0.1';   // như config.inc.php
    private static $db_name = 'onlinecourse';
    private static $username = 'root';    // như config.inc.php
    private static $password = '';        // như config.inc.php
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            try {
                // KHÔNG ghi port -> dùng mặc định 3306 (đang chạy OK với phpMyAdmin)
                $dsn = 'mysql:host=' . self::$host .
                       ';dbname=' . self::$db_name .
                       ';charset=utf8mb4';

                self::$conn = new PDO($dsn, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
