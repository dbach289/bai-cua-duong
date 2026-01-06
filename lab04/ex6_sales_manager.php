<?php
require_once 'Product.php';

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$sample = "P001-Rice Cooker-120-2;P002-Kettle-45-1;P003-Blender-80-3";
$input = isset($_POST['data']) ? $_POST['data'] : $sample;
$minPriceRaw = isset($_POST['minPrice']) ? trim($_POST['minPrice']) : '';
$minPrice = is_numeric($minPriceRaw) ? (float)$minPriceRaw : null;
$sortAmountDesc = isset($_POST['sort_amount_desc']);
$error = '';
$products = [];

$__SALES_COMMENT = <<<'TXT'
/*
HƯỚNG DẪN SỬ DỤNG ex6_sales_manager.php
- Định dạng input (textarea): ProductID-Name-Price-Qty;...
  Ví dụ: P001-Rice Cooker-120-2;P002-Kettle-45-1
- Để thay đổi mẫu mặc định, chỉnh biến $sample.
- Sau khi Parse:
  * Parse từng record, bỏ qua record sai định dạng hoặc price/qty không numeric.
  * Áp dụng filter minPrice (nếu nhập) để giữ sản phẩm có price >= minPrice.
  * Nếu tick Sort Amount giảm dần, sắp xếp theo amount = price * qty.
  * Hiển thị bảng STT|ID|Name|Price|Qty|Amount; qty<=0 sẽ gắn "(Invalid qty)".
  * Hiển thị thống kê tổng tiền, amount lớn nhất, avg price.
- Mở rộng:
  * Lưu các record invalid vào $skipped để show.
  * Thêm export CSV/JSON hoặc lưu kết quả vào session/file.
*/
TXT;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['parse'])) {
    $raw = trim($input);
    if ($raw === '') {
        $error = 'Vui lòng nhập dữ liệu.';
    } else {
        // Parse input into Product records. Expected format per record:
        // ProductID-Name-Price-Qty
        // Example: P001-Rice Cooker-120-2
        // If a record fails validation (non-numeric price/qty or wrong fields),
        // it is currently ignored. To track invalid records, create $skipped = []
        // before this loop and push invalid $rec into it.
        $recs = array_filter(array_map('trim', explode(';', $raw)), function($r){ return $r !== ''; });
        foreach ($recs as $rec) {
            $parts = explode('-', $rec, 4);
            if (count($parts) !== 4) continue;
            list($id, $name, $priceStr, $qtyStr) = $parts;
            $id = trim($id); $name = trim($name); $priceStr = trim($priceStr); $qtyStr = trim($qtyStr);
            if ($id === '' || $name === '' || $priceStr === '' || $qtyStr === '') continue;
            if (!is_numeric($priceStr) || !is_numeric($qtyStr)) continue;
            $price = (float)$priceStr;
            $qty = (int)$qtyStr;
            $products[] = new Product($id, $name, $price, $qty);
        }
        if (count($products) === 0) $error = 'Không có product hợp lệ sau khi parse.';
        // apply minPrice filter
        if ($minPrice !== null && count($products) > 0) {
            $products = array_values(array_filter($products, function($p) use ($minPrice) {
                return $p->getPrice() >= $minPrice;
            }));
            if (count($products) === 0) $error = 'Không có product nào >= minPrice.';
        }
        // sort by amount desc if chosen
        if ($sortAmountDesc && count($products) > 0) {
            usort($products, function($a, $b) {
                return $b->amount() <=> $a->amount();
            });
        }
    }
}

// stats
$totalMoney = 0.0;
$maxAmount = null;
$avgPrice = null;
if (count($products) > 0) {
    $amounts = array_map(function($p){ return $p->amount(); }, $products);
    $totalMoney = array_sum($amounts);
    $maxAmount = max($amounts);
    $prices = array_map(function($p){ return $p->getPrice(); }, $products);
    $avgPrice = array_sum($prices) / count($prices);
}

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ex6B — Sales Manager</title>
    <style>
        body{font-family:Arial,sans-serif;padding:16px}
        textarea{width:100%;height:100px}
        table{border-collapse:collapse;width:100%;margin-top:12px}
        th,td{border:1px solid #ccc;padding:8px;text-align:left}
        th{background:#f4f4f4}
        .error{color:red}
    </style>
</head>
<body>
    <h2>Sales Manager</h2>
    <form method="post">
        <label>Data (ProductID-Name-Price-Qty; ...)</label>
        <textarea name="data"><?php echo h($input); ?></textarea>
        <div style="margin-top:8px">
            <label>minPrice: <input type="text" name="minPrice" value="<?php echo h($minPriceRaw); ?>" /></label>
            <label style="margin-left:12px"><input type="checkbox" name="sort_amount_desc" <?php echo $sortAmountDesc ? 'checked' : ''; ?>/> Sort Amount giảm dần</label>
            <button type="submit" name="parse" style="margin-left:12px">Parse & Show</button>
        </div>
    </form>

    <?php if ($error !== ''): ?><p class="error"><?php echo h($error); ?></p><?php endif; ?>

    <?php if (count($products) > 0): ?>
        <table>
            <thead>
                <tr><th>STT</th><th>ID</th><th>Name</th><th>Price</th><th>Qty</th><th>Amount</th></tr>
            </thead>
            <tbody>
            <?php foreach ($products as $i => $p): ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo h($p->getId()); ?></td>
                    <td><?php echo h($p->getName()); ?></td>
                    <td><?php echo number_format($p->getPrice(), 2); ?></td>
                    <td>
                        <?php echo (int)$p->getQty();
                              if ($p->getQty() <= 0) echo ' <strong>(Invalid qty)</strong>'; ?>
                    </td>
                    <td><?php echo number_format($p->amount(), 2); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            Tổng tiền: <strong><?php echo number_format($totalMoney, 2); ?></strong>,
            Amount lớn nhất: <strong><?php echo $maxAmount !== null ? number_format($maxAmount, 2) : 'N/A'; ?></strong>,
            Avg price: <strong><?php echo $avgPrice !== null ? number_format($avgPrice, 2) : 'N/A'; ?></strong>
        </p>
    <?php endif; ?>
</body>
</html>


