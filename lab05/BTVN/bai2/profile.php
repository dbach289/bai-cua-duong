<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();
// hiển thị profile của sv đang login
$student_code = $_SESSION['user_student_code'] ?? null;
$students = read_json(__DIR__ . '/../data/students.json', []);
$student = null;
foreach ($students as $s) if (isset($s['student_code']) && $s['student_code'] === $student_code) { $student = $s; break; }
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<section class="page">
    <div class="card">
        <h2>Thông tin sinh viên</h2>
        <?php if ($student): ?>
            <p><strong>Mã SV:</strong> <?php echo e($student['student_code']); ?></p>
            <p><strong>Họ tên:</strong> <?php echo e($student['name']); ?></p>
            <p><strong>Lớp:</strong> <?php echo e($student['class'] ?? ''); ?></p>
            <p><strong>Email:</strong> <?php echo e($student['email'] ?? ''); ?></p>
            <p><a class="btn" href="grades.php">Xem điểm</a> <a class="btn" href="courses.php">Đăng ký học phần</a></p>
        <?php else: ?>
            <p>Không tìm thấy thông tin sinh viên.</p>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


