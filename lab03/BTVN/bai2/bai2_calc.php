<?php
// Bài 2: Máy tính mini (đã tách vào BTVN/bai2)
// Nhận a, b, op từ URL hoặc form (GET/POST). op ∈ {add, sub, mul, div}
// Dùng switch-case để xử lý; kiểm tra chia cho 0; hiển thị kết quả bằng chuỗi "a op b = result"

$rawA = isset($_REQUEST['a']) ? trim($_REQUEST['a']) : '';
$rawB = isset($_REQUEST['b']) ? trim($_REQUEST['b']) : '';
$op = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : '';
$message = '';

if ($rawA === '' || $rawB === '' || $op === '') {
    $message = 'Vui lòng nhập đầy đủ tham số a, b và op (qua form hoặc query string).';
} else {
    // Kiểm tra a và b có phải số không
    if (!is_numeric($rawA) || !is_numeric($rawB)) {
        $message = 'Tham số a và b phải là số.';
    } else {
        $a = (float)$rawA;
        $b = (float)$rawB;
        $result = null;
        $symbol = '';
        switch ($op) {
            case 'add':
                $result = $a + $b;
                $symbol = '+';
                break;
            case 'sub':
                $result = $a - $b;
                $symbol = '-';
                break;
            case 'mul':
                $result = $a * $b;
                $symbol = '*';
                break;
            case 'div':
                if ($b == 0.0) {
                    $message = 'Lỗi: Không chia được cho 0.';
                } else {
                    $result = $a / $b;
                    $symbol = '/';
                }
                break;
            default:
                $message = 'Phép toán không hợp lệ. Sử dụng op = add|sub|mul|div';
                break;
        }
        if ($message === '' && $result !== null) {
            // Hiển thị kết quả: giữ nguyên dạng số thập phân khi cần
            $message = "{$a} {$symbol} {$b} = {$result}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <title>Bài 2 - Máy tính mini</title>
</head>
<body>
    <h1>Bài 2 — Máy tính mini (switch-case)</h1>

    <form method="post" action="">
        <label for="a">a: </label>
        <input type="text" id="a" name="a" value="<?php echo htmlspecialchars($rawA, ENT_QUOTES, 'UTF-8'); ?>" />
        <label for="b"> b: </label>
        <input type="text" id="b" name="b" value="<?php echo htmlspecialchars($rawB, ENT_QUOTES, 'UTF-8'); ?>" />
        <label for="op"> Phép: </label>
        <select id="op" name="op">
            <option value="add" <?php echo ($op === 'add') ? 'selected' : ''; ?>>add (+)</option>
            <option value="sub" <?php echo ($op === 'sub') ? 'selected' : ''; ?>>sub (-)</option>
            <option value="mul" <?php echo ($op === 'mul') ? 'selected' : ''; ?>>mul (*)</option>
            <option value="div" <?php echo ($op === 'div') ? 'selected' : ''; ?>>div (/)</option>
        </select>
        <button type="submit">Tính</button>
    </form>

    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>

    <p>Test nhanh bằng URL:</p>
    <ul>
        <li><a href="?a=10&b=3&op=mul">?a=10&b=3&op=mul</a></li>
        <li><a href="?a=10&b=0&op=div">?a=10&b=0&op=div (chia 0)</a></li>
        <li><a href="?a=5&b=2&op=add">?a=5&b=2&op=add</a></li>
    </ul>

    <p><a href="../../BTTL/">Về trang chính Lab</a></p>
</body>
</html>


