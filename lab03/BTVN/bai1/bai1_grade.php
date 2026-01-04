<?php
// Bài 1: Phân loại điểm (đã tách vào thư mục BTVN/bai1)
// File: BTVN/bai1/bai1_grade.php
// Nhận tham số 'score' bằng GET hoặc POST; kiểm tra hợp lệ 0 <= score <= 10
// Nếu hợp lệ: phân loại theo: Giỏi (>=8.5), Khá (>=7.0), Trung bình (>=5.0), Yếu (<5.0)
// Hiển thị kết quả theo mẫu: "Điểm: X - Xếp loại: ..."

$rawScore = isset($_REQUEST['score']) ? trim($_REQUEST['score']) : '';
$score = null;
$message = '';

if ($rawScore === '') {
    // Không có tham số -> hiển thị form và hướng dẫn
    $message = 'Vui lòng nhập điểm (qua form hoặc truyền ?score=...).';
} else {
    // Có tham số -> kiểm tra có phải số không và có thỏa điều kiện 0..10 không
    if (!is_numeric($rawScore)) {
        $message = 'Tham số score phải là một số.';
    } else {
        // Ép về float để chấp nhận điểm thập phân như 8.2
        $score = (float)$rawScore;
        if ($score < 0 || $score > 10) {
            $message = 'Điểm không hợp lệ. Điểm phải nằm trong khoảng 0 đến 10.';
            $score = null;
        } else {
            // Phân loại sử dụng if/elseif/else
            if ($score >= 8.5) {
                $rank = 'Giỏi';
            } elseif ($score >= 7.0) {
                $rank = 'Khá';
            } elseif ($score >= 5.0) {
                $rank = 'Trung bình';
            } else {
                $rank = 'Yếu';
            }
            $message = "Điểm: {$score} - Xếp loại: {$rank}";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <title>Bài 1 - Phân loại điểm</title>
</head>
<body>
    <h1>Bài 1 — Phân loại điểm</h1>

    <!-- Form để nhập điểm (POST) -->
    <form method="post" action="">
        <label for="score">Nhập điểm (0 - 10): </label>
        <input type="text" id="score" name="score" value="<?php echo htmlspecialchars($rawScore, ENT_QUOTES, 'UTF-8'); ?>" />
        <button type="submit">Gửi</button>
    </form>

    <p>
        <!-- Hiển thị hướng dẫn / kết quả -->
        <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>Test nhanh bằng URL (GET):</p>
    <ul>
        <li><a href="?score=8.2">?score=8.2</a></li>
        <li><a href="?score=12">?score=12 (không hợp lệ)</a></li>
        <li><a href="?score=4.5">?score=4.5</a></li>
    </ul>

    <p><a href="../../BTTL/">Về trang chính Lab</a></p>
</body>
</html>


