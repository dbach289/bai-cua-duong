<?php
// Dashboard (Bài 1) - nằm trong thư mục bai1/
require_once __DIR__ . '/../includes/functions.php';
require_login(); // nếu chưa đăng nhập sẽ redirect về login.php
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

    <section class="page">
        <div class="card">
            <div class="page-header">
                <div>
                    <h2>Xin chào, <?php echo e($_SESSION['user_name']); ?></h2>
                    <p class="muted">Bạn đang đăng nhập với <strong><?php echo e($_SESSION['user_username']); ?></strong></p>
                </div>
                <div>
                    <a class="btn" href="products.php">Sản phẩm</a>
                </div>
            </div>

            <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                <div class="card admin-panel" style="margin-top:8px;">
                    <h3>Admin Panel</h3>
                    <p>Chỉ user role = admin mới thấy mục này.</p>
                </div>
            <?php endif; ?>

            <?php
                // Tính số item trong giỏ từ session cart
                $cartCount = 0;
                if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $it) {
                        $cartCount += intval($it['qty'] ?? 0);
                    }
                }
            ?>
            <div class="stats-grid" style="margin-top:12px;">
                <div class="stat-card">
                    <h4>Sản phẩm</h4>
                    <p><?php echo count($products ?? []); ?></p>
                </div>
                <div class="stat-card">
                    <h4>Items in Cart</h4>
                    <p><?php echo $cartCount; ?></p>
                </div>
                <div class="stat-card">
                    <h4>Quyền</h4>
                    <p><?php echo e($_SESSION['user_role']); ?></p>
                </div>
            </div>

            <div style="margin-top:12px;">
                <a class="btn" href="products.php">Xem sản phẩm</a>
                <a class="btn" href="cart.php">Xem giỏ hàng</a>
            </div>
        </div>
    </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


