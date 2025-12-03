<?php
require_once __DIR__ . '/config/Database.php';

try {
    $conn = Database::getConnection();
    echo "Kết nối database thành công!";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
