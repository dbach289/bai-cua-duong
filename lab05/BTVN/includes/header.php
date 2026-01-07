<?php
// Header chung: include CSS, nav, hiển thị flash
// Mọi trang khác include file này để giữ layout đồng nhất.
require_once __DIR__ . '/functions.php';
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Shop Demo - Bài 1</title>
    <!-- Dùng đường dẫn tương đối từ các trang trong thư mục bai1/ -->
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <!-- Logo / Brand -->
            <?php
                // Xác định xem trang hiện tại có nằm trong /bai2/ không để hiển thị header phù hợp
                $script = $_SERVER['SCRIPT_NAME'] ?? '';
                $is_bai2 = (strpos($script, '/bai2/') !== false);
                $brandText = $is_bai2 ? 'Student Portal' : 'Shop Demo - Bài 1';
            ?>
            <a class="brand" href="dashboard.php"><?php echo e($brandText); ?></a>

            <!-- Navigation: hiển thị tùy trạng thái đăng nhập; khác nhau cho bai1 và bai2 -->
            <nav class="nav" aria-label="Primary">
                <?php
                    // Kiểm tra đăng nhập tuỳ loại app:
                    // - Student Portal: xem session 'user_student_code'
                    // - Shop Demo: xem session 'user_username'
                    $logged_bai2 = isset($_SESSION['user_student_code']);
                    $logged_shop = isset($_SESSION['user_username']);
                ?>
                <?php if ($is_bai2 && $logged_bai2): ?>
                    <!-- Nav cho Student Portal khi student đã login -->
                    <a href="profile.php">Profile</a>
                    <a href="courses.php">Courses</a>
                    <a href="registrations.php">Registrations</a>
                    <a href="grades.php">Grades</a>
                    <form class="inline-form" method="post" action="logout.php" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <button class="link-button" type="submit" style="margin-left:8px;">Logout</button>
                    </form>
                <?php elseif (!$is_bai2 && $logged_shop): ?>
                    <!-- Nav cho Shop Demo khi shop user đã login -->
                    <a href="products.php">Products</a>
                    <?php
                        // Tính tổng số item trong giỏ: cart lưu theo pid => ['qty'=>..]
                        $cartCount = 0;
                        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $it) {
                                $cartCount += intval($it['qty'] ?? 0);
                            }
                        }
                    ?>
                    <a id="cart-link" href="cart.php" style="display:inline-flex;align-items:center;gap:8px;">
                        <span class="cart-icon" aria-hidden="true">Cart</span>
                        <span id="cart-count"><?php echo $cartCount; ?></span>
                    </a>
                    <form class="inline-form" method="post" action="logout.php" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <button class="link-button" type="submit" style="margin-left:8px;">Logout</button>
                    </form>
                <?php else: ?>
                    <!-- Nếu chưa login, chỉ show link Login -->
                    <?php if ($is_bai2): ?>
                        <a href="login.php">Login</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Hiển thị flash message (success / error) nếu có -->
    <?php if ($flash): ?>
        <div class="flash <?php echo e($flash['type']); ?>"><?php echo e($flash['message']); ?></div>
    <?php endif; ?>

    <main class="container">


