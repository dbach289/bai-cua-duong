<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registrations.php');
    exit;
}
$token = $_POST['csrf_token'] ?? '';
if (!verify_csrf($token)) {
    set_flash('error', 'Yêu cầu không hợp lệ.');
    header('Location: registrations.php');
    exit;
}
$course_id = intval($_POST['course_id'] ?? 0);
$student = $_SESSION['user_student_code'] ?? null;
if (!$student) { header('Location: login.php'); exit; }

$grades = read_json(__DIR__ . '/../data/grades.json', []);
// Nếu đã có grade cho sv-course thì không cho hủy
foreach ($grades as $g) {
    if ($g['student_code'] === $student && intval($g['course_id']) === $course_id) {
        set_flash('error', 'Không thể hủy vì học phần đã có điểm.');
        header('Location: registrations.php');
        exit;
    }
}

$regs = read_json(__DIR__ . '/../data/registrations.json', []);
$new = [];
foreach ($regs as $r) {
    if (!($r['student_code'] === $student && intval($r['course_id']) === $course_id)) {
        $new[] = $r;
    }
}
write_json(__DIR__ . '/../data/registrations.json', $new);
set_flash('success', 'Đã hủy đăng ký.');
header('Location: registrations.php');
exit;


