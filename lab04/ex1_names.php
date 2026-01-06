<?php
// Nhận input từ GET
$raw = isset($_GET['names']) ? $_GET['names'] : '';

// An toàn khi hiển thị chuỗi gốc
$escaped_raw = htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');

// Tách chuỗi bằng dấu phẩy, trim từng phần tử, loại phần tử rỗng
$parts = $raw === '' ? [] : explode(',', $raw);
$trimmedParts = array_map('trim', $parts);
$validNames = array_filter($trimmedParts, function ($v) {
    return $v !== '';
});
$validNames = array_values($validNames); // reset chỉ số
$count = count($validNames);
// GHI CHÚ (HƯỚNG DẪN)
// - Ví dụ sử dụng (trong trình duyệt): ex1_names.php?names=An,Binh, Chi, ,Dung
// - Nguồn dữ liệu: $_GET['names'] (chuỗi các tên cách nhau dấu phẩy).
// - Các bước xử lý hiện tại:
//     1) Nếu $_GET['names'] rỗng thì dùng mảng rỗng.
//     2) Dùng explode(',', $raw) để tách theo dấu phẩy.
//     3) Dùng array_map('trim', ...) để loại bỏ khoảng trắng hai đầu từng phần tử.
//     4) Dùng array_filter(...) để loại bỏ các phần tử rỗng.
//     5) Dùng array_values() để reset chỉ số mảng.
// - Lưu ý bảo mật: tất cả output chuỗi hiển thị ra HTML đều đã được escape
//   bằng htmlspecialchars(...) (xem ở phần render) để tránh XSS.
// - Mở rộng/tuỳ biến:
//     * Giữ các phần tử trùng lặp: loại bỏ bước loại trùng (không gọi array_unique).
//     * Loại bỏ tên chứa số: thêm kiểm tra trong array_filter (e.g. preg_match).
//     * Lưu kết quả vào $_SESSION để cho phép edit/xoá sau khi parse.
//     * Nếu muốn nhận dữ liệu từ POST thay vì GET thì đổi $_GET['names'] => $_POST['names'].
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Danh sách tên (ex1)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        pre.sample { background:#f4f4f4; padding:10px; border-radius:4px; }
    </style>
</head>
<body>
    <h2>Bài 1 (Cơ bản) — Chuỗi → Danh sách tên (GET)</h2>

    <p><strong>Chuỗi gốc:</strong> <?php echo $escaped_raw === '' ? '<em>(rỗng)</em>' : $escaped_raw; ?></p>

    <?php if ($count === 0): ?>
        <p><strong>Thông báo:</strong> Chưa có dữ liệu hợp lệ.</p>
    <?php else: ?>
        <p><strong>Số lượng tên hợp lệ:</strong> <?php echo $count; ?></p>
        <ol>
        <?php foreach ($validNames as $name): ?>
            <li><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></li>
        <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <h4>Dữ liệu mẫu</h4>
    <pre class="sample">?names=An,Binh, Chi, ,Dung</pre>

</body>
</html>


