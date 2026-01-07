<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

$student = $_SESSION['user_student_code'] ?? null;
$regs = read_json(__DIR__ . '/../data/registrations.json', []);
$courses = read_json(__DIR__ . '/../data/courses.json', []);

// lọc registrations của student
$my = array_filter($regs, function($r) use ($student) {
    return isset($r['student_code']) && $r['student_code'] === $student;
});

include __DIR__ . '/../includes/header.php';
?>

<section class="page">
    <div class="card">
        <div class="page-header">
            <h2>Các học phần đã đăng ký</h2>
            <a class="btn" href="courses.php">Đăng ký học phần</a>
        </div>

        <?php if (empty($my)): ?>
            <p>Bạn chưa đăng ký học phần nào.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead><tr><th>Học phần</th><th>Thời gian đăng ký</th><th>Hủy</th></tr></thead>
                <tbody>
                <?php foreach ($my as $r): 
                    $cid = intval($r['course_id']);
                    $course = null;
                    foreach ($courses as $c) if ($c['id']===$cid) { $course=$c; break; }
                ?>
                    <tr>
                        <td><?php echo e($course['code'] ?? ''); ?> - <?php echo e($course['title'] ?? ''); ?></td>
                        <td><?php echo e($r['registered_at'] ?? ''); ?></td>
                        <td>
                            <form method="post" action="unregister.php" style="display:inline">
                                <input type="hidden" name="course_id" value="<?php echo $cid; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <button class="btn" type="submit">Hủy</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


