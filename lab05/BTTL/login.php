<?php
session_start();

// Nếu đã đăng nhập -> chuyển tới dashboard
if (isset($_SESSION['user_email'])) {
    header('Location: dashboard.php');
    exit;
}

$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="brand">
                <span class="brand-logo" aria-hidden="true">
                    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                        <defs>
                            <linearGradient id="g" x1="0" x2="1">
                                <stop offset="0" stop-color="#6c8cff"/>
                                <stop offset="1" stop-color="#8fe0ff"/>
                            </linearGradient>
                            <linearGradient id="g2" x1="0" x2="1">
                                <stop offset="0" stop-color="#3b82f6"/>
                                <stop offset="1" stop-color="#6366f1"/>
                            </linearGradient>
                        </defs>

                        <g>
                            <circle cx="34" cy="50" r="22" fill="url(#g)"/>
                            <circle cx="66" cy="50" r="18" fill="url(#g2)" opacity="0.95"/>
                            <circle cx="50" cy="34" r="10" fill="#ffffff" opacity="0.12"/>
                            <path d="M30 70 C42 80,58 80,70 70" stroke="#fff" stroke-opacity="0.08" stroke-width="4" fill="none" stroke-linecap="round"/>
                        </g>
                    </svg>
                </span>
                <h1>Ứng dụng Lab</h1>
            </div>

            <?php if ($error): ?>
                <div class="alert">Thông tin đăng nhập không đúng. Vui lòng thử lại.</div>
            <?php endif; ?>

            <form class="login-form" method="post" action="process_login.php" novalidate>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input id="password" type="password" name="password" placeholder="Mật khẩu của bạn" required>
                </div>

                <button class="btn" type="submit">Đăng nhập</button>
            </form>

            <div class="hint">Demo: <strong>user@example.com</strong> / <strong>secret</strong></div>
        </div>
    </div>
</body>
</html>
