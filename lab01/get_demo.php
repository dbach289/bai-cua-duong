<?php
// get_demo.php
// Đọc tham số name và age từ query string và in ra câu chào.

// Lấy và kiểm tra tham số
$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$age = isset($_GET['age']) ? trim($_GET['age']) : '';

// Hàm tiện ích để an toàn hiển thị
function e($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GET Demo</title>
</head>
<body>
	<h1>GET demo</h1>

	<?php if ($name !== '' && $age !== ''): ?>
		<p><?php echo 'Xin chào ' . e($name) . ', tuổi: ' . e($age); ?></p>
	<?php else: ?>
		<p>Thiếu tham số. Vui lòng sử dụng URL mẫu sau:</p>
		<pre><code>get_demo.php?name=An&age=20</code></pre>
	<?php endif; ?>

	<p><a href="lab01.php">Về bài 1</a></p>
</body>
</html>


