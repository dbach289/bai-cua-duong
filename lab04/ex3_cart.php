<?php
// Helper to escape output
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Khai báo mảng products (name, price, qty)
$products = [
    ['name' => 'Bút',        'price' => 1.50,   'qty' => 10],
    ['name' => 'Sổ tay',     'price' => 3.25,   'qty' => 4],
    ['name' => 'Túi xách',   'price' => 45.99,  'qty' => 1],
    ['name' => 'Tai nghe',   'price' => 29.90,  'qty' => 2],
    ['name' => 'Chuột',      'price' => 15.00,  'qty' => 3],
];

// GHI CHÚ (HƯỚNG DẪN)
// - Nếu muốn thay dữ liệu: chỉnh mảng $products ở trên (mỗi phần tử gồm 'name','price','qty').
// - Để nhận dữ liệu từ form, thay bằng $products = $_POST['products'] sau khi parse.
// - Cột amount được thêm bằng array_map; nếu cần giữ mảng gốc, thao tác trên bản sao.
// - Tính tổng dùng array_reduce. Nếu muốn hiển thị chi tiết hơn (ví dụ tiền VAT),
//   thêm bước map để tính các cột bổ sung.
// - Để sắp xếp theo amount thay vì price, gọi usort trên bản sao với so sánh amount.

// Thêm cột amount = price * qty sử dụng array_map
$productsWithAmount = array_map(function($p) {
    $p['amount'] = $p['price'] * $p['qty'];
    return $p;
}, $products);

// Tính tổng đơn hàng bằng array_reduce
$totalAmount = array_reduce($productsWithAmount, function($carry, $item) {
    return $carry + $item['amount'];
}, 0.0);

// Tìm sản phẩm có amount lớn nhất
$maxProduct = array_reduce($productsWithAmount, function($carry, $item) {
    if ($carry === null || $item['amount'] > $carry['amount']) {
        return $item;
    }
    return $carry;
}, null);

// Sắp xếp theo price giảm dần trên một bản sao (không làm mất mảng gốc)
$byPriceDesc = $productsWithAmount;
usort($byPriceDesc, function($a, $b) {
    return $b['price'] <=> $a['price'];
});

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bài 3 — Giỏ hàng</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; max-width: 900px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        tfoot td { font-weight: bold; }
        .muted { color: #666; }
    </style>
</head>
<body>
    <h2>Bài 3 (Trung bình) — Giỏ hàng</h2>

    <h3>Danh sách sản phẩm (gốc)</h3>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($productsWithAmount as $i => $p): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo h($p['name']); ?></td>
                <td><?php echo number_format($p['price'], 2); ?></td>
                <td><?php echo (int)$p['qty']; ?></td>
                <td><?php echo number_format($p['amount'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Tổng đơn hàng</td>
                <td><?php echo number_format($totalAmount, 2); ?></td>
            </tr>
        </tfoot>
    </table>

    <h3 class="muted">Sản phẩm có amount lớn nhất</h3>
    <?php if ($maxProduct !== null): ?>
        <p>
            <strong><?php echo h($maxProduct['name']); ?></strong>
            — Price: <?php echo number_format($maxProduct['price'], 2); ?>
            , Qty: <?php echo (int)$maxProduct['qty']; ?>
            , Amount: <?php echo number_format($maxProduct['amount'], 2); ?>
        </p>
    <?php else: ?>
        <p>Không có sản phẩm.</p>
    <?php endif; ?>

    <h3>Danh sách sắp xếp theo Price giảm dần (bản sao)</h3>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($byPriceDesc as $i => $p): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo h($p['name']); ?></td>
                <td><?php echo number_format($p['price'], 2); ?></td>
                <td><?php echo (int)$p['qty']; ?></td>
                <td><?php echo number_format($p['amount'], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>


