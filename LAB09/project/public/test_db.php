<?php
require '../app/core/Database.php';

$db = Database::getInstance();
$stmt = $db->query("SELECT COUNT(*) AS total FROM students");
$row = $stmt->fetch();

echo "Kết nối OK - Tổng sinh viên: " . $row['total'];
