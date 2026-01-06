<?php
require_once 'Book.php';

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$sample = "B001-Intro to PHP-2;B002-Web Programming-5;B003-Database Basics-1;B004-Old Book-0";
$input = isset($_POST['data']) ? $_POST['data'] : $sample;
$q = isset($_POST['q']) ? trim($_POST['q']) : '';
$sortQtyDesc = isset($_POST['sort_qty_desc']);

$__LIB_COMMENT = <<<'TXT'
/*
HƯỚNG DẪN SỬ DỤNG ex6_library_manager.php
- Định dạng input (textarea): BookID-Title-Quantity;BookID-Title-Quantity;...
  Ví dụ: B001-Intro to PHP-2;B002-Web Programming-5
- Để thay đổi mẫu mặc định, chỉnh biến $sample ở dòng đầu.
- Xử lý sau khi nhấn Parse:
  * Parse từng record; bỏ qua record không đủ 3 trường hoặc qty không phải số.
  * Nếu nhập q (search), sẽ lọc theo Title không phân biệt hoa thường.
  * Nếu tick "Sort Qty giảm dần", sẽ sắp xếp bản sao theo qty giảm dần.
  * Hiển thị bảng STT|BookID|Title|Qty|Status và thống kê tổng đầu sách/tổng quyển/qty lớn nhất/số out-of-stock.
- Mở rộng:
  * Lưu các record bị bỏ qua vào $skipped để hiển thị chi tiết.
  * Thêm Export CSV/JSON hoặc lưu vào session/file.
*/
TXT;

$books = [];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['parse'])) {
    $raw = trim($input);
    if ($raw === '') {
        $error = 'Vui lòng nhập dữ liệu.';
    } else {
        // Parse input string into book records.
        // Format per record: BookID-Title-Quantity
        // Example record: B001-Intro to PHP-2
        // If you want to collect invalid/skipped records, declare $skipped = [] above
        // and push $rec into it whenever a validation fails instead of continue.
        $recs = array_filter(array_map('trim', explode(';', $raw)), function($r){ return $r !== ''; });
        foreach ($recs as $rec) {
            $parts = explode('-', $rec, 3);
            if (count($parts) !== 3) continue;
            list($id, $title, $qtyStr) = $parts;
            $id = trim($id); $title = trim($title); $qtyStr = trim($qtyStr);
            if ($id === '' || $title === '' || $qtyStr === '') continue;
            if (!is_numeric($qtyStr)) continue;
            $books[] = new Book($id, $title, (int)$qtyStr);
        }
        if (count($books) === 0) $error = 'Không có record hợp lệ sau khi parse.';
        // apply search q
        if ($q !== '' && count($books) > 0) {
            $books = array_values(array_filter($books, function($b) use ($q) {
                return stripos($b->getTitle(), $q) !== false;
            }));
            if (count($books) === 0) $error = 'Không tìm thấy sách theo từ khoá.';
        }
        // sort qty desc if chosen
        if ($sortQtyDesc && count($books) > 0) {
            usort($books, function($a, $b) {
                return $b->getQty() <=> $a->getQty();
            });
        }
    }
}

// stats
$totalTitles = count($books);
$totalCopies = array_sum(array_map(function($b){ return $b->getQty(); }, $books));
$maxQty = null;
$outOfStockCount = 0;
if ($totalTitles > 0) {
    $qtys = array_map(function($b){ return $b->getQty(); }, $books);
    $maxQty = max($qtys);
    $outOfStockCount = count(array_filter($books, function($b){ return $b->getQty() === 0; }));
}

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ex6A — Library Manager</title>
    <style>
        body{font-family:Arial,sans-serif;padding:16px;}
        textarea{width:100%;height:100px}
        table{border-collapse:collapse;width:100%;margin-top:12px}
        th,td{border:1px solid #ccc;padding:8px;text-align:left}
        th{background:#f4f4f4}
        .error{color:red}
    </style>
</head>
<body>
    <h2>Library Manager</h2>
    <form method="post">
        <label>Data (BookID-Title-Quantity; ...)</label>
        <textarea name="data"><?php echo h($input); ?></textarea>
        <div style="margin-top:8px">
            <label>Search Title (q): <input type="text" name="q" value="<?php echo h($q); ?>" /></label>
            <label style="margin-left:12px"><input type="checkbox" name="sort_qty_desc" <?php echo $sortQtyDesc ? 'checked' : ''; ?>/> Sort Qty giảm dần</label>
            <button type="submit" name="parse" style="margin-left:12px">Parse & Show</button>
        </div>
    </form>

    <?php if ($error !== ''): ?><p class="error"><?php echo h($error); ?></p><?php endif; ?>

    <?php if (count($books) > 0): ?>
        <table>
            <thead>
                <tr><th>STT</th><th>BookID</th><th>Title</th><th>Qty</th><th>Status</th></tr>
            </thead>
            <tbody>
            <?php foreach ($books as $i => $b): ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo h($b->getId()); ?></td>
                    <td><?php echo h($b->getTitle()); ?></td>
                    <td><?php echo (int)$b->getQty(); ?></td>
                    <td><?php echo $b->isAvailable() ? 'Available' : 'Out of stock'; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>
            Tổng đầu sách: <strong><?php echo $totalTitles; ?></strong>,
            Tổng số quyển: <strong><?php echo $totalCopies; ?></strong>,
            Số sách Out of stock: <strong><?php echo $outOfStockCount; ?></strong>,
            Số lượng lớn nhất (Qty): <strong><?php echo $maxQty !== null ? $maxQty : 'N/A'; ?></strong>
        </p>
    <?php endif; ?>
</body>
</html>


