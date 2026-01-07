<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: courses.php');
    exit;
}
$token = $_POST['csrf_token'] ?? '';
if (!verify_csrf($token)) {
    set_flash('error', 'Yêu cầu không hợp lệ.');
    header('Location: courses.php');
    exit;
}
$course_id = intval($_POST['course_id'] ?? 0);
$student = $_SESSION['user_student_code'] ?? null;
if (!$student) {
    set_flash('error', 'Bạn chưa đăng nhập.');
    header('Location: login.php');
    exit;
}

$regs = read_json(__DIR__ . '/../data/registrations.json', []);
$grades = read_json(__DIR__ . '/../data/grades.json', []);

// không cho đăng ký trùng
foreach ($regs as $r) {
    if ($r['student_code'] === $student && intval($r['course_id']) === $course_id) {
        set_flash('error', 'Bạn đã đăng ký học phần này.');
        header('Location: courses.php');
        exit;
    }
}

// nếu đã có grade thì không cho đăng ký
foreach ($grades as $g) {
    if ($g['student_code'] === $student && intval($g['course_id']) === $course_id) {
        set_flash('error', 'Học phần đã có điểm, không thể đăng ký.');
        header('Location: courses.php');
        exit;
    }
}

$regs[] = ['student_code' => $student, 'course_id' => $course_id, 'registered_at' => date('c')];
write_json(__DIR__ . '/../data/registrations.json', $regs);
set_flash('success', 'Đăng ký thành công.');
header('Location: registrations.php');
exit;


