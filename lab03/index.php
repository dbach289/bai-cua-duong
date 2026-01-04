<?php
// Trang chính của lab03 (Bài 5)
// Hiển thị menu / form để chọn action và gọi các hàm trong thư viện

require_once __DIR__ . '/BTTL/functions.php'; // load thư viện hàm (đã được đồng bộ)
require_once __DIR__ . '/BTVN/common/process.php'; // hàm xử lý action

$action = isset($_GET['action']) ? $_GET['action'] : '';
$output = '';

// Gọi hàm xử lý chung nếu có action
if ($action !== '') {
    $output = process_action_request($action);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <title>Lab03 - Trang chính</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 16px; }
        .menu { margin-bottom: 16px; }
        .result { background:#f6f6f6; padding:8px; border-radius:6px; }
    </style>
</head>
<body>
    <h1>Lab03 - Trang chính</h1>

    <div class="menu">
        <p>Menu nhanh (link) - các bài tách riêng:</p>
        <ul>
            <li><a href="BTVN/bai1/bai1_grade.php">Bài 1 — Phân loại điểm</a></li>
            <li><a href="BTVN/bai2/bai2_calc.php">Bài 2 — Máy tính mini</a></li>
            <li><a href="BTVN/bai3/bai3_loops.php">Bài 3 — Vòng lặp</a></li>
            <li><a href="BTVN/bai4_demo.php">Bài 4 — Demo thư viện hàm</a></li>
        </ul>
    </div>

    <div class="form">
        <p>Hoặc dùng form kiểm thử:</p>
        <?php require_once __DIR__ . '/BTVN/common/form.php'; ?>
    </div>

    <?php if ($action !== ''): ?>
        <h2>Kết quả</h2>
        <div class="result">
            <?php echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <p><a href="./BTVN/bai4_demo.php">Xem demo hàm (Bài 4)</a></p>
</body>
</html>


