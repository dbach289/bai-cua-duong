<?php
// Xử lý login cho Student Portal (Bài 2)
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}
$student_code = trim($_POST['student_code'] ?? '');
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$student = find_student_by_code($student_code);
// Ghi log tạm vào data/log_bai2.txt để debug (dev)
$debugLog = __DIR__ . '/../data/log_bai2.txt';
file_put_contents($debugLog, sprintf("[%s] login attempt student_code=%s, password_len=%d\n", date('c'), $student_code, strlen($password)), FILE_APPEND);
if ($student) {
    // Nếu password lưu dạng hash (bắt đầu bằng $), dùng password_verify, ngược lại so sánh plaintext
    $stored = $student['password'] ?? '';
    $ok = false;
    if (is_string($stored) && strlen($stored) > 0 && $stored[0] === '$') {
        $ok = password_verify($password, $stored);
    } else {
        $ok = ($password === $stored);
    }
    // Ghi log verify
    file_put_contents($debugLog, sprintf("[%s] student found, verify=%s\n", date('c'), $ok ? 'true' : 'false'), FILE_APPEND);
    if ($ok) {
        // Lưu session student
        $_SESSION['user_student_code'] = $student['student_code'];
        $_SESSION['user_name'] = $student['name'];
        set_flash('success', 'Đăng nhập thành công.');
        header('Location: profile.php');
        exit;
    }
}
set_flash('error', 'Sai thông tin đăng nhập.');
header('Location: login.php?error=1');
exit;


