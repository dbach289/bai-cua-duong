<?php
session_start();

// Dữ liệu mẫu (demo)
$valid_email = 'user@example.com';
$valid_password = 'secret';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($email === $valid_email && $password === $valid_password) {
    // Lưu thông tin phiên
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = 'Người Dùng';
    header('Location: dashboard.php');
    exit;
} else {
    // Sai thông tin -> trả về login với thông báo lỗi
    header('Location: login.php?error=1');
    exit;
}


