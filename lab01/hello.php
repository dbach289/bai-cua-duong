<?php
// Thiết timezone (vẫn dùng Asia/Ho_Chi_Minh) nhưng hiển thị khu vực là Hà Nội
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hello PHP</title>
</head>
<body>
<?php
echo '<h1>Hello PHP – IT3220</h1>';
echo '<p><strong>Khu vực:</strong> Hà Nội</p>';
echo '<p>Thời gian hiện tại: ' . date('Y-m-d H:i:s') . '</p>';
?>
<p><a href="info.php">Xem info.php</a></p>
</body>
</html>


