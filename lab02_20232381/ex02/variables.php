<?php
// ex02 - variables.php
// Mục tiêu: khai báo biến, hằng, in và debug kiểu dữ liệu

$fullName = "Bạch Hoàng Dương"; // string
$age = 20;                     // int
$gpa = 3.5;                    // float
$isActive = true;              // bool

// Khai báo hằng SCHOOL (sử dụng define)
define('SCHOOL', 'ĐẠI HỌC CÔNG NGHỆ ĐÔNG Á');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ex02 - Biến, hằng, kiểu dữ liệu</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; padding: 16px; }
        pre { background:#f6f8fa; padding:12px; border-radius:4px; }
    </style>
</head>
<body>
    <h1>Ex02 — Biến, hằng, kiểu dữ liệu và debug</h1>

    <h2>In ra bằng echo / print</h2>
    <?php
    // In bằng echo
    echo "<p>Full name (echo): $fullName</p>";
    echo "<p>GPA (echo): $gpa</p>";

    // In bằng print
    print "<p>Age (print): $age</p>";
    print "<p>Is active (print): " . ($isActive ? 'true' : 'false') . "</p>";

    // In hằng
    echo "<p>School (constant SCHOOL): " . SCHOOL . "</p>";
    ?>

    <h2>Debug bằng var_dump()</h2>
    <pre>
<?php
var_dump($fullName);
var_dump($age);
var_dump($gpa);
var_dump($isActive);
var_dump(SCHOOL);
?>
    </pre>

    <h2>Thử nội suy chuỗi</h2>
    <?php
    // Nháy kép: biến được nội suy (được thay bởi giá trị)
    echo "<p>Nháy kép: Tuoi: $age</p>";

    // Nháy đơn: chuỗi nguyên, biến không được nội suy
    echo '<p>Nháy đơn: Tuoi: $age</p>';

    // Nhận xét ngắn:
    // Khi dùng nháy kép ("") PHP sẽ thay biến bằng giá trị của nó; nháy đơn ('') in nguyên chuỗi.
    ?>
</body>
</html>


