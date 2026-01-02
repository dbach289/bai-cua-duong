<?php
// ex03 - calc_basic.php
// Mục tiêu: sử dụng toán tử số học và nối chuỗi

$a = 10;
$b = 3;

$sum = $a + $b;
$diff = $a - $b;
$prod = $a * $b;
$quot = $a / $b;   // thương (có phần thập phân)
$mod = $a % $b;    // chia lấy dư

// Tạo chuỗi thông báo bằng toán tử nối chuỗi (.) và .=
$message = "Phép tính với a = " . $a . " và b = " . $b . ". ";
$message .= "Tổng = $sum; Hiệu = $diff; Tích = $prod; Thương = $quot; Dư = $mod.";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ex03 - Toán tử và nối chuỗi</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 16px; line-height:1.5; }
        pre { background:#f6f8fa; padding:12px; border-radius:4px; }
    </style>
</head>
<body>
    <h1>Ex03 — Toán tử cơ bản và nối chuỗi</h1>

    <h2>Kết quả các phép toán</h2>
    <?php
    echo "<p>Tổng (a + b): $sum</p>";
    echo "<p>Hiệu (a - b): $diff</p>";
    echo "<p>Tích (a * b): $prod</p>";
    echo "<p>Thương (a / b): $quot</p>";
    echo "<p>Chia lấy dư (a % b): $mod</p>";

    echo "<h2>Chuỗi thông báo (nối bằng . và .=)</h2>";
    echo "<p>" . $message . "</p>";
    ?>

    <h2>So sánh</h2>
    <?php
    // So sánh 2 kiểu: == (so sánh giá trị, bỏ qua kiểu), === (so sánh giá trị và kiểu)
    $cmp1 = ("5" == 5);   // true vì "5" được chuyển sang số 5 và bằng 5
    $cmp2 = ("5" === 5);  // false vì kiểu khác (string vs int)

    echo "<p>\"5\" == 5 : " . ($cmp1 ? 'true' : 'false') . "</p>";
    echo "<p>\"5\" === 5 : " . ($cmp2 ? 'true' : 'false') . "</p>";

    // Giải thích ngắn (comment):
    // Dòng trên: "5" == 5 trả về true vì == chỉ so sánh giá trị với type juggling.
    // "5" === 5 trả về false vì === yêu cầu cả giá trị và kiểu phải giống nhau.
    ?>

    <h2>Debug kết quả bằng var_dump()</h2>
    <pre>
<?php
var_dump($sum);
var_dump($diff);
var_dump($prod);
var_dump($quot);
var_dump($mod);
var_dump($cmp1);
var_dump($cmp2);
?>
    </pre>
</body>
</html>


