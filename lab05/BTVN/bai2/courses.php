<?php
require_once __DIR__ . '/../includes/functions.php';
require_login();

$courses = read_json(__DIR__ . '/../data/courses.json', []);

// handle POST? register handled in register.php to keep single-responsibility

include __DIR__ . '/../includes/header.php';
?>

<section class="page">
    <div class="card">
        <div class="page-header">
            <h2>Danh mục học phần</h2>
            <a class="btn" href="registrations.php">Học phần đã đăng ký</a>
        </div>

        <div class="product-list">
            <?php foreach ($courses as $c): ?>
                <div class="product">
                    <div class="product-card">
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <div style="flex:1;">
                                <h4><?php echo e($c['code']); ?> - <?php echo e($c['title']); ?></h4>
                                <div class="muted">Số tín chỉ: <?php echo e($c['credits']); ?></div>
                            </div>
                            <div style="text-align:right;flex:0 0 180px;">
                                <form method="post" action="register.php" class="inline-form">
                                    <input type="hidden" name="course_id" value="<?php echo intval($c['id']); ?>">
                                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                    <button class="btn primary" type="submit">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


