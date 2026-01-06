<?php
// Mảng điểm mẫu
$scores = [8.5, 7.0, 9.25, 6.5, 8.0, 5.75];

// GHI CHÚ (HƯỚNG DẪN)
// - Nếu muốn thay bằng input động, bạn có thể thay $scores bằng dữ liệu từ $_POST hoặc $_GET.
// - Ví dụ: $scores = array_map('floatval', explode(',', $_POST['scores']));
// - Để thay đổi ngưỡng "điểm cao" (hiện là 8.0), chỉnh giá trị trong hàm array_filter bên dưới.
// - number_format(..., 2) được dùng để hiển thị 2 chữ số thập phân khi render HTML.

// Số lượng phần tử
$count = count($scores);

// Tính trung bình (tránh chia cho 0)
$average = $count > 0 ? array_sum($scores) / $count : 0;

// Đếm số điểm >= 8.0 và liệt kê các điểm đó
$highScores = array_filter($scores, function ($v) {
    return $v >= 8.0;
});
$highCount = count($highScores);

// Tìm max và min (nếu có phần tử)
$maxScore = $count > 0 ? max($scores) : null;
$minScore = $count > 0 ? min($scores) : null;

// Sắp xếp tăng/giảm, không làm mất mảng gốc
$asc = $scores;
sort($asc, SORT_NUMERIC);
$desc = $scores;
rsort($desc, SORT_NUMERIC);

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bài 2 — Mảng điểm</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .box { background:#f9f9f9; padding:12px; border-radius:6px; margin-bottom:12px; }
        code.inline { background:#eee; padding:2px 6px; border-radius:4px; }
    </style>
</head>
<body>
    <h2>Bài 2 (Cơ bản – Trung bình) — Mảng điểm: thống kê + sắp xếp</h2>

    <div class="box">
        <strong>Mảng điểm gốc:</strong>
        <pre><?php echo '[' . implode(', ', array_map(function($v){ return number_format($v, 2); }, $scores)) . ']'; ?></pre>
    </div>

    <div class="box">
        <strong>1. Số phần tử:</strong> <?php echo $count; ?><br>
        <strong>2. Điểm trung bình:</strong> <?php echo number_format($average, 2); ?>
    </div>

    <div class="box">
        <strong>3. Số điểm >= 8.0:</strong> <?php echo $highCount; ?>
        <?php if ($highCount > 0): ?>
            <br><strong>Các điểm >= 8.0:</strong>
            <ul>
            <?php foreach ($highScores as $s): ?>
                <li><?php echo number_format($s, 2); ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <div class="box">
        <strong>4. Max:</strong> <?php echo $maxScore !== null ? number_format($maxScore, 2) : 'N/A'; ?><br>
        <strong>   Min:</strong> <?php echo $minScore !== null ? number_format($minScore, 2) : 'N/A'; ?>
    </div>

    <div class="box">
        <strong>5. Sắp xếp (không làm mất mảng gốc):</strong>
        <p><strong>Tăng dần:</strong> <?php echo '[' . implode(', ', array_map(function($v){ return number_format($v, 2); }, $asc)) . ']'; ?></p>
        <p><strong>Giảm dần:</strong> <?php echo '[' . implode(', ', array_map(function($v){ return number_format($v, 2); }, $desc)) . ']'; ?></p>
    </div>

</body>
</html>


