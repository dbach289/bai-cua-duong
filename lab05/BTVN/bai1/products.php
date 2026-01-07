<?php
// Trang danh sách sản phẩm (Bài 1) - nằm trong thư mục bai1/
// - Hiển thị danh sách sản phẩm giả lập
// - Xử lý POST khi người dùng thêm sản phẩm vào giỏ (lưu vào $_SESSION['cart'])
// Ghi chú: cart lưu mảng theo product_id => ['qty','title','price','img']
require_once __DIR__ . '/../includes/functions.php';
require_login(); // bảo vệ trang: chỉ cho phép truy cập khi đã đăng nhập

$products = [
    // Dùng ảnh local trong assets/images để chạy offline
    1 => ['id'=>1,'title'=>'Áo thun', 'price'=>250000, 'img' => '../assets/images/product1.jpg'],
    2 => ['id'=>2,'title'=>'Quần jean', 'price'=>450000, 'img' => '../assets/images/product3.jpg'],
    3 => ['id'=>3,'title'=>'Giày thể thao', 'price'=>800000, 'img' => '../assets/images/product2.jpg'],
];

// Nếu có POST -> thêm vào giỏ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf($token)) {
        set_flash('error', 'Yêu cầu không hợp lệ.');
        header('Location: products.php');
        exit;
    }
    $pid = intval($_POST['product_id'] ?? 0);
    $qty = max(1, intval($_POST['quantity'] ?? 1));
    if (!isset($products[$pid])) {
        set_flash('error', 'Sản phẩm không tồn tại.');
    } else {
        // Lưu thông tin chi tiết vào session cart: giữ cả title, price, img để cart hiển thị ảnh khi thêm
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (isset($_SESSION['cart'][$pid])) {
            // tăng số lượng
            $_SESSION['cart'][$pid]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$pid] = [
                'qty' => $qty,
                'title' => $products[$pid]['title'],
                'price' => $products[$pid]['price'],
                'img' => $products[$pid]['img'],
            ];
        }
        set_flash('success', 'Đã thêm vào giỏ.');
        // Nếu là AJAX request trả về JSON để client cập nhật badge + message
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            // tính cartCount
            $cartCount = 0;
            foreach ($_SESSION['cart'] as $it) { $cartCount += intval($it['qty']); }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => true, 'cartCount' => $cartCount, 'message' => 'Đã thêm vào giỏ.']);
            exit;
        }
    }
    header('Location: products.php');
    exit;
}

include __DIR__ . '/../includes/header.php';
?>

    <section class="page">
        <div class="card">
            <div class="page-header">
                <h2>Sản phẩm</h2>
                <?php
                    // Tính tổng số item trong giỏ từ session (mảng theo pid với 'qty')
                    $cartCount = 0;
                    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $it) {
                            $cartCount += intval($it['qty'] ?? 0);
                        }
                    }
                ?>
                <a class="btn" id="view-cart-btn" href="cart.php">Xem giỏ hàng (<?php echo $cartCount; ?>)</a>
            </div>

            <div class="product-list">
                <?php foreach ($products as $p): ?>
                    <div class="product">
                        <div class="product-card">
                            <div class="product-img" aria-hidden="true">
                                <img src="<?php echo e($p['img']); ?>" alt="<?php echo e($p['title']); ?>">
                            </div>
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <div class="title" style="flex:1;">
                                    <h4 style="margin:0;"><?php echo e($p['title']); ?></h4>
                                </div>
                                <div class="price" style="flex:1;text-align:right;"><?php echo number_format($p['price']); ?> VND</div>
                            </div>
                        </div>

                        <!-- Form thêm vào giỏ (AJAX) -->
                        <form method="post" class="inline-form ajax-add" action="products.php" style="display:flex;justify-content:space-between;align-items:center;">
                            <div style="display:flex;gap:8px;align-items:center;">
                                <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1" class="small-qty" aria-label="Số lượng">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            </div>
                            <div class="product-actions">
                                <button class="btn primary" type="submit">Thêm vào giỏ</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Container dự trữ cho thông báo (flash) để hiển thị bên dưới phần sản phẩm.
                 Có min-height để tránh nhảy layout khi flash xuất hiện/ẩn đi. -->
            <div id="page-flash" class="page-flash" aria-live="polite" style="min-height:48px;"></div>
        </div>
    </section>

<?php include __DIR__ . '/../includes/footer.php'; ?>


