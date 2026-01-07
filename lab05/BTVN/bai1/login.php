<?php
// Trang đăng nhập (Bài 1) - nằm trong thư mục bai1/
// - Form gửi POST tới process_login.php (nằm cùng thư mục)
// - Có CSRF token, remember username bằng cookie (7 ngày)
require_once __DIR__ . '/../includes/functions.php';

// Nếu đã đăng nhập -> chuyển về dashboard bài 1
if (is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

// Nếu có cookie remember_username thì gợi ý username
$remembered = isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : '';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Giao diện form đăng nhập đẹp hơn -->
    <section class="auth-page" aria-labelledby="login-heading">
        <div class="auth-card" role="region" aria-label="Form đăng nhập">

            <!-- Tiêu đề + logo -->
            <div class="auth-brand">
                <div aria-hidden="true" class="logo"></div>
                <div>
                    <h1 id="login-heading">Ứng dụng Lab</h1>
                    <p class="lead">Đăng nhập để tiếp tục</p>
                </div>
            </div>

            <!-- Form đăng nhập gửi POST tới process_login.php -->
            <form id="loginForm" class="form" method="post" action="process_login.php" novalidate>
                <label class="input-icon">
                    <span>Username / Email</span>
                    <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill="#0b1220" fill-opacity="0.6" d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-5 0-9 2.5-9 5v1h18v-1c0-2.5-4-5-9-5z"/>
                    </svg>
                    <?php
                        $prefill = isset($_GET['username']) ? $_GET['username'] : $remembered;
                    ?>
                    <input id="username" type="text" name="username" value="<?php echo e($prefill); ?>" required placeholder="you@example.com">
                </label>

                <label class="input-icon">
                    <span>Mật khẩu</span>
                    <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path fill="#0b1220" fill-opacity="0.6" d="M17 8V7a5 5 0 0 0-10 0v1H5v12h14V8h-2zm-8-1a3 3 0 0 1 6 0v1H9V7z"/>
                    </svg>
                    <div style="position:relative;">
                        <input id="password" type="password" name="password" required placeholder="Mật khẩu của bạn">
                        <button id="togglePwd" type="button" aria-label="Hiện/Ẩn mật khẩu" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;padding:6px;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#334155" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </label>

                <label class="checkbox">
                    <input type="checkbox" name="remember"> Ghi nhớ username (7 ngày)
                </label>

                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert" role="alert">Tên đăng nhập hoặc mật khẩu không đúng.</div>
                <?php endif; ?>

                <div style="margin-top:14px;">
                    <button class="btn primary full" type="submit">Đăng nhập</button>
                </div>

                <div class="preview-demo" aria-hidden="true">
                    <div style="font-weight:600;margin-bottom:6px;">Tài khoản demo (dùng để test):</div>
                    <div>admin &nbsp;/&nbsp; <strong>admin123</strong> &nbsp;<span style="color:#64748b">(role: admin)</span></div>
                    <div>student &nbsp;/&nbsp; <strong>student123</strong> &nbsp;<span style="color:#64748b">(role: user)</span></div>
                </div>
            </form>
        </div>
    </section>

<!-- JS nhỏ cho UX: show/hide password, validation client -->
<script>
document.addEventListener('DOMContentLoaded', function(){
    var pwd = document.getElementById('password');
    var toggle = document.getElementById('togglePwd');
    var uname = document.getElementById('username');
    if (uname) uname.focus();
    toggle && toggle.addEventListener('click', function(){
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
    });
    var form = document.getElementById('loginForm');
    form && form.addEventListener('submit', function(e){
        var ok = true;
        if (!uname.value.trim()) { uname.classList.add('input-error'); ok=false; }
        else uname.classList.remove('input-error');
        if (!pwd.value.trim()) { pwd.classList.add('input-error'); ok=false; }
        else pwd.classList.remove('input-error');
        if (!ok) e.preventDefault();
    });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>


