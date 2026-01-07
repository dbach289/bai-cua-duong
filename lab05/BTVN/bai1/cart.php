<?php
// Trang giỏ hàng (Bài 1) - nằm trong bai1/
// - Hiển thị những item đã lưu trong $_SESSION['cart']
// - Cho phép cập nhật số lượng hoặc xóa toàn bộ (POST + CSRF)
require_once __DIR__ . '/../includes/functions.php';
require_login(); // bảo vệ trang: chỉ user đã đăng nhập mới xem được

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        set_flash('error', 'Yêu cầu không hợp lệ.');
        header('Location: cart.php');
        exit;
    }
    if (isset($_POST['update'])) {
        $quantities = $_POST['qty'] ?? [];
        foreach ($quantities as $pid => $q) {
            $pid = intval($pid);
            $q = max(0, intval($q));
            if ($q === 0) {
                unset($_SESSION['cart'][$pid]);
            } else {
                // giữ metadata, chỉ cập nhật qty
                if (isset($_SESSION['cart'][$pid]) && is_array($_SESSION['cart'][$pid])) {
                    $_SESSION['cart'][$pid]['qty'] = $q;
                } else {
                    // nếu không có metadata, tạo entry cơ bản (phòng trường hợp)
                    $_SESSION['cart'][$pid] = ['qty' => $q, 'title' => 'Sản phẩm ' . $pid, 'price' => 0, 'img' => ''];
                }
            }
        }
        set_flash('success', 'Cập nhật giỏ hàng thành công.');
    }
    if (isset($_POST['clear'])) {
        unset($_SESSION['cart']);
        set_flash('success', 'Đã xóa toàn bộ giỏ hàng.');
    }
    header('Location: cart.php');
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

    <section class="page">
        <div class="card">
            <div class="page-header">
                <h2>Giỏ hàng</h2>
                <a class="btn" href="products.php">Tiếp tục mua sắm</a>
            </div>

            <?php $cart = $_SESSION['cart'] ?? []; ?>
            <?php if (empty($cart)): ?>
                <p>Giỏ hàng trống. <a href="products.php">Mua sắm ngay</a></p>
            <?php else: ?>
                <form method="post" action="cart.php">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <table class="cart-table">
                        <thead><tr><th>Sản phẩm</th><th>Đơn giá</th><th style="width:140px">Số lượng</th><th>Thành tiền</th></tr></thead>
                        <tbody>
                        <?php $total = 0; foreach ($cart as $pid => $item):
                            // $item is an array with keys: qty, title, price, img
                            $qty = intval($item['qty'] ?? 0);
                            $pTitle = $item['title'] ?? ('Sản phẩm ' . $pid);
                            $pPrice = $item['price'] ?? 0;
                            $pImg = $item['img'] ?? '';
                            $line = $pPrice * $qty;
                            $total += $line;
                        ?>
                            <tr>
                                <td style="display:flex;gap:12px;align-items:center;">
                                    <div class="cart-thumb" aria-hidden="true">
                                        <?php if ($pImg): ?>
                                            <img src="<?php echo e($pImg); ?>" alt="<?php echo e($pTitle); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:6px;">
                                        <?php else: ?>
                                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="3" width="18" height="14" rx="2"></rect>
                                                <path d="M8 21h8"></path>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <div><?php echo e($pTitle); ?></div>
                                </td>
                                <td><?php echo number_format($pPrice); ?> VND</td>
                                <td><input type="number" name="qty[<?php echo $pid; ?>]" value="<?php echo $qty; ?>" min="0" class="cart-qty" aria-label="Số lượng"></td>
                                <td><?php echo number_format($line); ?> VND</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="summary">Tổng: <strong><?php echo number_format($total); ?> VND</strong></div>
                    <div class="cart-actions" style="margin-top:12px;">
                        <button class="btn" type="submit" name="update">Cập nhật</button>
                        <button class="btn" type="submit" name="clear" onclick="return confirm('Xóa toàn bộ giỏ hàng?')">Xóa toàn bộ</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


