<?php
// Demo sử dụng các hàm trong BTVN/bai4_functions.php
require_once __DIR__ . '/functions.php'; // wrapper sẽ load bai4_functions.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <title>Bài 4 - Demo hàm</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; padding: 16px; }
        .example { background:#f6f6f6; padding:10px; border-radius:6px; margin-bottom:8px; }
    </style>
</head>
<body>
    <h1>Bài 4 — Demo các hàm</h1>

    <h2>Ví dụ tĩnh</h2>
    <div class="example">
        <p><strong>max2(3,5)</strong> = <?php echo htmlspecialchars((string)max2(3,5), ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>min2(3,5)</strong> = <?php echo htmlspecialchars((string)min2(3,5), ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>isPrime(17)</strong> = <?php echo isPrime(17) ? 'true' : 'false'; ?></p>
        <p><strong>isPrime(18)</strong> = <?php echo isPrime(18) ? 'true' : 'false'; ?></p>
        <p><strong>factorial(6)</strong> = <?php echo htmlspecialchars((string)factorial(6), ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>factorial(-1)</strong> = <?php $f = factorial(-1); echo ($f === null) ? 'null' : htmlspecialchars((string)$f, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>gcd(12,18)</strong> = <?php echo htmlspecialchars((string)gcd(12,18), ENT_QUOTES, 'UTF-8'); ?></p>
    </div>

    <h2>Thử nhanh bằng URL</h2>
    <ul>
        <li><a href="?demo=prime&n=17">?demo=prime&n=17</a></li>
        <li><a href="?demo=fact&n=6">?demo=fact&n=6</a></li>
        <li><a href="?demo=gcd&a=12&b=18">?demo=gcd&a=12&b=18</a></li>
        <li><a href="?demo=maxmin&a=10&b=3">?demo=maxmin&a=10&b=3</a></li>
    </ul>

    <?php
    // Xử lý các demo động qua query string
    if (isset($_GET['demo'])) {
        $demo = $_GET['demo'];
        echo '<h2>Kết quả động</h2><div class="example">';
        switch ($demo) {
            case 'prime':
                $n = isset($_GET['n']) ? intval($_GET['n']) : 0;
                echo "<p>isPrime({$n}) = " . (isPrime($n) ? 'true' : 'false') . "</p>";
                break;
            case 'fact':
                $n = isset($_GET['n']) ? intval($_GET['n']) : 0;
                $res = factorial($n);
                echo "<p>factorial({$n}) = " . ($res === null ? 'null' : htmlspecialchars((string)$res, ENT_QUOTES, 'UTF-8')) . "</p>";
                break;
            case 'gcd':
                $a = isset($_GET['a']) ? intval($_GET['a']) : 0;
                $b = isset($_GET['b']) ? intval($_GET['b']) : 0;
                echo "<p>gcd({$a}, {$b}) = " . gcd($a,$b) . "</p>";
                break;
            case 'maxmin':
                $a = isset($_GET['a']) ? intval($_GET['a']) : 0;
                $b = isset($_GET['b']) ? intval($_GET['b']) : 0;
                echo "<p>max({$a},{$b}) = " . max2($a,$b) . "</p>";
                echo "<p>min({$a},{$b}) = " . min2($a,$b) . "</p>";
                break;
            default:
                echo "<p>Demo không hợp lệ.</p>";
                break;
        }
        echo '</div>';
    }
    ?>

    <p><a href="./">Quay lại</a></p>
</body>
</html>


