<?php
// Hello PHP page for Bài 1 (ex01) - copy placed under lab02_20232381 per assignment
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello PHP</title>
</head>
<body>
    <?php
    // Thay các giá trị sau bằng thông tin của bạn
    $ho_ten = "Bạch Hoàng Dương";
    $mssv = "20232381";
    $lop = "DCCNTT14.2";

    echo "<h1>Hello PHP!</h1>";
    echo "<p><strong>Họ tên:</strong> " . htmlspecialchars($ho_ten, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p><strong>MSSV:</strong> " . htmlspecialchars($mssv, ENT_QUOTES, 'UTF-8') . " - <strong>Lớp:</strong> " . htmlspecialchars($lop, ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p><strong>Ngày giờ hiện tại:</strong> " . date('Y-m-d H:i:s') . "</p>";
    ?>
</body>
</html>


