<?php
// Xử lý đăng nhập cho bài 1 (POST) - nằm trong bai1/
require_once __DIR__ . '/../includes/functions.php';

// Chỉ chấp nhận POST cho đăng nhập
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$csrf = $_POST['csrf_token'] ?? '';
if (!verify_csrf($csrf)) {
    set_flash('error', 'Yêu cầu không hợp lệ (CSRF).');
    header('Location: login.php');
    exit;
}

// Lấy dữ liệu từ form (username/email + password)
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = $_POST['password'] ?? '';

$user = find_user($username);
// Ghi log debug tạm thời để xem giá trị nhận được (bật khi cần)
$logLine = sprintf("[%s] POST username=%s, password_len=%d\n", date('c'), $username, strlen($password));
file_put_contents(__DIR__ . '/../data/log.txt', $logLine, FILE_APPEND);

if ($user) {
    $logLine = sprintf("[%s] Found user: username=%s, email=%s\n", date('c'), $user['username'] ?? '-', $user['email'] ?? '-');
    file_put_contents(__DIR__ . '/../data/log.txt', $logLine, FILE_APPEND);
    $verify = password_verify($password, $user['password']);
    $logLine = sprintf("[%s] password_verify => %s\n", date('c'), $verify ? 'true' : 'false');
    file_put_contents(__DIR__ . '/../data/log.txt', $logLine, FILE_APPEND);
} else {
    file_put_contents(__DIR__ . '/../data/log.txt', sprintf("[%s] User not found\n", date('c')), FILE_APPEND);
}

if ($user && password_verify($password, $user['password'])) {
    // Đăng nhập thành công: lưu thông tin vào session
    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    // Nếu tick "remember" -> lưu cookie remember_username trong 7 ngày
    if (isset($_POST['remember'])) {
        setcookie('remember_username', $user['username'], time() + 7*24*3600, '/');
    }

    set_flash('success', 'Đăng nhập thành công.');
    header('Location: dashboard.php');
    exit;
} else {
    // Đăng nhập thất bại: lưu flash và redirect kèm username để điền lại form
    set_flash('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    $qs = http_build_query(['error' => 1, 'username' => $username]);
    header('Location: login.php?' . $qs);
    exit;
}


