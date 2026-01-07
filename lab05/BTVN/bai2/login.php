<?php
// Bài 2 - Student Portal: login
require_once __DIR__ . '/../includes/functions.php';
// Nếu đã login -> profile
if (isset($_SESSION['user_student_code'])) {
    header('Location: profile.php');
    exit;
}
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Thiết kế lại form đăng nhập đẹp, dùng các class sẵn có để thống nhất giao diện -->
    <section class="auth-page" aria-labelledby="login-heading">
        <div class="auth-card" role="region" aria-label="Form đăng nhập" style="max-width:520px;margin:20px auto;">
            <div class="auth-brand">
                <div class="logo" aria-hidden="true"></div>
                <div>
                    <h1 id="login-heading">Student Portal</h1>
                    <p class="lead">Đăng nhập để xem thông tin sinh viên</p>
                </div>
            </div>

            <?php if ($error): ?>
                <div class="alert">Tên đăng nhập hoặc mật khẩu không đúng.</div>
            <?php endif; ?>

            <form class="form" method="post" action="process_login.php" novalidate>
                <label>
                    <span>Student code</span>
                    <input type="text" name="student_code" required placeholder="ví dụ: sv01">
                </label>

                <label>
                    <span>Mật khẩu</span>
                    <input type="password" name="password" required placeholder="Mật khẩu của bạn">
                </label>

                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <div style="margin-top:12px;">
                    <button class="btn primary full" type="submit">Đăng nhập</button>
                </div>
            </form>

            <!-- Hiển thị tài khoản demo dưới form -->
            <div class="preview-demo" style="margin-top:12px;text-align:center;">
                <div style="font-weight:600;margin-bottom:6px;">Tài khoản demo (dùng để test):</div>
                <div>sv01 &nbsp;/&nbsp; <strong>sv01pass</strong> &nbsp;<span style="color:#64748b">(role: student)</span></div>
                <div>sv02 &nbsp;/&nbsp; <strong>sv02pass</strong> &nbsp;<span style="color:#64748b">(role: student)</span></div>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


