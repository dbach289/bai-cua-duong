<?php
require_once __DIR__ . '/functions.php'; // Nhúng file chứa các hàm (max/min/prime/fact/gcd)

$action = isset($_GET['action']) ? $_GET['action'] : ''; // Lấy tham số action từ URL, nếu không có thì rỗng
$output = ''; // Biến chứa kết quả để hiển thị ở phần HTML

switch ($action) {
    case 'prime':
        // Lấy tham số thô để kiểm tra xem có phải số nguyên hay không
        $rawN = isset($_GET['n']) ? $_GET['n'] : '';
        if ($rawN === '') {
            $output = "Vui lòng cung cấp tham số n.";
            break;
        }
        if (!is_numeric($rawN) || (float)$rawN != intval($rawN)) {
            $output = "Tham số n phải là số nguyên.";
            break;
        }
        $n = intval($rawN);
        $output = isPrime($n) ? "$n là số nguyên tố" : "$n không phải số nguyên tố";
        break;
    case 'fact':
        $rawN = isset($_GET['n']) ? $_GET['n'] : '';
        if ($rawN === '') {
            $output = "Vui lòng cung cấp tham số n.";
            break;
        }
        if (!is_numeric($rawN) || (float)$rawN != intval($rawN)) {
            $output = "Tham số n phải là số nguyên.";
            break;
        }
        $n = intval($rawN);
        $fact = factorial($n);
        if ($fact === null) {
            $output = "Giai thừa không xác định cho số âm.";
        } else {
            $output = "Giai thừa của $n là $fact";
        }
        break;
    case 'gcd':
        $rawA = isset($_GET['a']) ? $_GET['a'] : '';
        $rawB = isset($_GET['b']) ? $_GET['b'] : '';
        if ($rawA === '' || $rawB === '') {
            $output = "Vui lòng cung cấp cả tham số a và b.";
            break;
        }
        if (!is_numeric($rawA) || (float)$rawA != intval($rawA) || !is_numeric($rawB) || (float)$rawB != intval($rawB)) {
            $output = "Tham số a và b phải là số nguyên.";
            break;
        }
        $a = intval($rawA);
        $b = intval($rawB);
        $g = gcd($a, $b);
        $output = "Ước chung lớn nhất của $a và $b là $g";
        break;
    case 'maxmin':
        $rawA = isset($_GET['a']) ? $_GET['a'] : '';
        $rawB = isset($_GET['b']) ? $_GET['b'] : '';
        if ($rawA === '' || $rawB === '') {
            $output = "Vui lòng cung cấp cả tham số a và b.";
            break;
        }
        if (!is_numeric($rawA) || (float)$rawA != intval($rawA) || !is_numeric($rawB) || (float)$rawB != intval($rawB)) {
            $output = "Tham số a và b phải là số nguyên.";
            break;
        }
        $a = intval($rawA);
        $b = intval($rawB);
        $output = "max($a, $b) = " . max2($a, $b) . "; min($a, $b) = " . min2($a, $b);
        break;
    default:
        // Không có action hợp lệ -> hiển thị menu (không cần làm gì ở đây)
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Bài Lab03 - Hàm</title> <!-- Tiêu đề trang (tiếng Việt) -->
</head>
<body>
    <h1>Bài Lab03 - Các hàm cơ bản</h1>
    <p>Menu:</p>
    <ul>
        <li><a href="?action=prime&n=17">Kiểm tra số nguyên tố (n=17)</a></li> <!-- Link test nhanh kiểm tra số nguyên tố -->
        <li><a href="?action=fact&n=6">Tính giai thừa (n=6)</a></li> <!-- Link test nhanh tính giai thừa -->
        <li><a href="?action=gcd&a=12&b=18">Tìm ƯCLN (a=12, b=18)</a></li> <!-- Link test nhanh gcd -->
        <li><a href="?action=maxmin&a=10&b=3">Tìm max / min (a=10, b=3)</a></li> <!-- Link test max/min -->
    </ul>

    <?php if ($action !== ''): ?> <!-- Nếu có action (đã gọi một phép toán) thì hiển thị kết quả -->
        <h2>Kết quả</h2>
        <p><?php echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); ?></p> <!-- In kết quả an toàn bằng htmlspecialchars -->
        <p><a href="./">Quay lại menu</a></p> <!-- Link quay lại menu chính -->
    <?php endif; ?>
</body>
</html>

