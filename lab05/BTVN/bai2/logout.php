<?php
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}
$token = $_POST['csrf_token'] ?? '';
if (!verify_csrf($token)) {
    set_flash('error', 'Yêu cầu không hợp lệ.');
    header('Location: profile.php');
    exit;
}
do_logout();
set_flash('success', 'Bạn đã đăng xuất.');
header('Location: login.php');
exit;


