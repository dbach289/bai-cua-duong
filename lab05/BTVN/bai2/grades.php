<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();
$student = $_SESSION['user_student_code'] ?? null;
$grades = read_json(__DIR__ . '/../data/grades.json', []);
$courses = read_json(__DIR__ . '/../data/courses.json', []);
include __DIR__ . '/../includes/header.php';
?>

<section class="page">
    <div class="card">
        <h2>Điểm của tôi</h2>
        <?php
            $my = array_filter($grades, function($g) use ($student){ return $g['student_code'] === $student; });
            if (empty($my)) {
                echo '<p>Chưa có điểm nào.</p>';
            } else {
                echo '<table class="cart-table"><thead><tr><th>Môn</th><th>Điểm</th></tr></thead><tbody>';
                foreach ($my as $g) {
                    $cid = intval($g['course_id']);
                    $course = null;
                    foreach ($courses as $c) if ($c['id']===$cid) { $course=$c; break; }
                    echo '<tr><td>' . e($course['code'] ?? '') . ' - ' . e($course['title'] ?? '') . '</td><td>' . e($g['grade']) . '</td></tr>';
                }
                echo '</tbody></table>';
            }
        ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


