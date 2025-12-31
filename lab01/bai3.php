<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bài 3 — GET vs POST</title>
	<style> body{font-family:Arial,Helvetica,sans-serif;max-width:800px;margin:12px;} code{background:#f5f5f5;padding:2px 4px;border-radius:3px;} </style>
</head>
<body>
	<h1>Bài 3 — GET vs POST</h1>
	<p><strong>Mục tiêu:</strong> Thực hành đọc tham số GET và xử lý form POST với kiểm tra cơ bản.</p>

	<h2>Files</h2>
	<ul>
		<li><a href="get_demo.php">get_demo.php</a> — đọc <code>name</code> và <code>age</code> từ URL (GET).</li>
		<li><a href="register.php">register.php</a> — form POST (họ tên, email, giới tính, sở thích) với validation.</li>
	</ul>

	<h2>Cách kiểm tra</h2>
	<ul>
		<li>GET: <code>http://localhost/lab01/get_demo.php?name=An&age=20</code></li>
		<li>POST: mở <code>http://localhost/lab01/register.php</code>, điền form, Submit.</li>
	</ul>

	<p><a href="lab01.php">Về trang chính</a></p>
</body>
</html>


