<?php
// ex04 - calc_get.php
// Nhận tham số a, b, op qua $_GET, validate, ép kiểu, tính toán và in kết quả.

function usage() {
    $self = htmlspecialchars($_SERVER['PHP_SELF']);
    echo "<h2>Hướng dẫn sử dụng</h2>";
    echo "<p>Thiếu tham số. Vui lòng gọi theo mẫu:</p>";
    echo "<pre>http://localhost/.../lab02_20232381/ex04/calc_get.php?a=10&b=3&op=add</pre>";
    echo "<p>op có thể là: <strong>add</strong>, <strong>sub</strong>, <strong>mul</strong>, <strong>div</strong></p>";
    echo "<p>Ví dụ khác:</p>";
    echo "<ul>";
    echo "<li><code>?a=10&b=3&op=sub</code></li>";
    echo "<li><code>?a=10&b=3&op=mul</code></li>";
    echo "<li><code>?a=10&b=3&op=div</code> (kiểm tra chia cho 0)</li>";
    echo "</ul>";
}

function cast_numeric($s) {
    // Giữ nguyên dạng nếu là số nguyên, ngược lại dùng float
    if (!is_numeric($s)) return null;
    // Nếu là integer-like (không có dấu thập phân hoặc ký tự exponent), trả về int
    if (preg_match('/^-?\d+$/', $s)) {
        return intval($s);
    }
    return floatval($s);
}

$hasA = isset($_GET['a']);
$hasB = isset($_GET['b']);
$hasOp = isset($_GET['op']);

?><!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ex04 - Calc GET</title>
    <style>
        body { font-family: Arial, sans-serif; padding:16px; line-height:1.5; }
        pre { background:#f6f8fa; padding:12px; border-radius:4px; }
        .error { color: #b00020; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Ex04 — Máy tính dùng GET và validate</h1>

<?php
if (!($hasA && $hasB && $hasOp)) {
    usage();
    echo "</body></html>";
    exit;
}

$a_raw = $_GET['a'];
$b_raw = $_GET['b'];
$op = $_GET['op'];

// Kiểm tra numeric
if (!is_numeric($a_raw) || !is_numeric($b_raw)) {
    echo "<p class='error'>Lỗi: Tham số <code>a</code> và <code>b</code> phải là số.</p>";
    usage();
    echo "</body></html>";
    exit;
}

$a = cast_numeric($a_raw);
$b = cast_numeric($b_raw);

// Kiểm tra ép kiểu thành công
if ($a === null || $b === null) {
    echo "<p class='error'>Lỗi: Không thể ép tham số sang số.</p>";
    usage();
    echo "</body></html>";
    exit;
}

// Thực hiện phép tính
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
        // Kiểm tra chia cho 0
        if ($b == 0) {
            echo "<p class='error'>Lỗi: Không thể chia cho 0.</p>";
            echo "<p>URL mẫu:</p>";
            usage();
            echo "</body></html>";
            exit;
        }
        $result = $a / $b;
        $symbol = '/';
        break;
    default:
        echo "<p class='error'>Lỗi: giá trị <code>op</code> không hợp lệ. Dùng add, sub, mul hoặc div.</p>";
        usage();
        echo "</body></html>";
        exit;
}

// Chuẩn hóa hiển thị: nếu là số float mà thực chất là integer (ví dụ 5.0) thì hiển thị 5
function format_number_for_display($n) {
    if (is_float($n) && intval($n) == $n) return (string) intval($n);
    return (string) $n;
}

$a_display = format_number_for_display($a);
$b_display = format_number_for_display($b);
$res_display = format_number_for_display($result);

echo "<p>Kết quả: {$a_display} {$symbol} {$b_display} = {$res_display}.</p>";

// Debug nhỏ (var_dump) — bỏ comment nếu muốn xem kiểu
// echo '<pre>'; var_dump($a, $b, $result); echo '</pre>';

?>
</body>
</html>


