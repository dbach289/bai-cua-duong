<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bài 4 — Quan sát HTTP bằng DevTools</title>
	<style> body{font-family:Arial,Helvetica,sans-serif;max-width:900px;margin:12px;} code{background:#f5f5f5;padding:2px 4px;border-radius:3px;} </style>
</head>
<body>
	<h1>Bài 4 — Quan sát HTTP bằng DevTools</h1>

	<p><strong>Mục tiêu:</strong> Đọc được request/response và status trong tab Network của DevTools.</p>

	<h2>Hướng dẫn thực hành (bước 1→4)</h2>
	<ol>
		<li>Mở Chrome/Edge → vào trang này → nhấn F12 → chọn tab <strong>Network</strong>.</li>
		<li>Tải lại (Reload) lần lượt các trang sau (click hoặc dán URL vào thanh địa chỉ):
			<ul>
				<li><a href="site/home.html" target="_blank">site/home.html</a></li>
				<li><a href="site/about.html" target="_blank">site/about.html</a></li>
				<li><a href="site/contact.html" target="_blank">site/contact.html</a></li>
				<li><a href="register.php" target="_blank">register.php</a></li>
			</ul>
		</li>
		<li>Với mỗi request, ghi lại (hoặc chụp ảnh):
			<ul>
				<li>Method (ví dụ GET hoặc POST)</li>
				<li>Status code (ví dụ 200)</li>
				<li>1–2 header tiêu biểu (ví dụ: Content-Type, Server hoặc Content-Length)</li>
			</ul>
		</li>
		<li>Tạo 1 lỗi 404: click link sau (file không tồn tại) để tạo request 404 và chụp status 404 tại tab <strong>Network</strong>:</li>
	</ol>

	<p><a href="abc_xyz.php" target="_blank">Mở file không tồn tại: abc_xyz.php (tạo 404)</a></p

	<p>
		<a href="lab01.php">Về mục lục lab01</a></p>
</body>
</html>


