<?php
// register.php
// Form demo dùng POST: họ tên (bắt buộc), email (bắt buộc), giới tính (radio), sở thích (checkbox)

// Hàm an toàn hiển thị
function e($str) {
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$errors = [];
$submitted = false;
$data = [
	'name' => '',
	'email' => '',
	'gender' => '',
	'hobbies' => [],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$submitted = true;
	$data['name'] = isset($_POST['name']) ? trim($_POST['name']) : '';
	$data['email'] = isset($_POST['email']) ? trim($_POST['email']) : '';
	$data['gender'] = isset($_POST['gender']) ? $_POST['gender'] : '';
	$data['hobbies'] = isset($_POST['hobbies']) && is_array($_POST['hobbies']) ? $_POST['hobbies'] : [];

	// Kiểm tra bắt buộc
	if ($data['name'] === '') {
		$errors[] = 'Họ tên là bắt buộc.';
	}
	if ($data['email'] === '') {
		$errors[] = 'Email là bắt buộc.';
	} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = 'Email không hợp lệ.';
	}
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register (POST demo)</title>
	<style>
		.error { color: red; }
		.result { background:#f5f5f5; padding:10px; border:1px solid #ddd; }
	</style>
</head>
<body>
	<h1>POST demo — Form đăng ký</h1>

	<?php if ($submitted && empty($errors)): ?>
		<h2> Dữ liệu đã gửi </h2>
		<div class="result">
			<ul>
				<li><strong>Họ tên:</strong> <?php echo e($data['name']); ?></li>
				<li><strong>Email:</strong> <?php echo e($data['email']); ?></li>
				<li><strong>Giới tính:</strong> <?php echo e($data['gender']); ?></li>
				<li><strong>Sở thích:</strong>
					<?php
					if (!empty($data['hobbies'])) {
						echo '<ul>';
						foreach ($data['hobbies'] as $h) {
							echo '<li>' . e($h) . '</li>';
						}
						echo '</ul>';
					} else {
						echo 'Không có';
					}
					?>
				</li>
			</ul>
		</div>
		<p><a href="register.php">Gửi lại</a> — <a href="lab01.php">Về bài 1</a></p>
	<?php else: ?>

		<?php if (!empty($errors)): ?>
			<div class="error">
				<p><strong>Phát hiện lỗi:</strong></p>
				<ul>
					<?php foreach ($errors as $err): ?>
						<li><?php echo e($err); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<form method="post" action="register.php">
			<p>
				<label>Họ tên (bắt buộc):<br>
				<input type="text" name="name" value="<?php echo e($data['name']); ?>" required></label>
			</p>
			<p>
				<label>Email (bắt buộc):<br>
				<input type="email" name="email" value="<?php echo e($data['email']); ?>" required></label>
			</p>
			<p>Giới tính:<br>
				<label><input type="radio" name="gender" value="Nam" <?php if($data['gender']==='Nam') echo 'checked'; ?>> Nam</label>
				<label><input type="radio" name="gender" value="Nữ" <?php if($data['gender']==='Nữ') echo 'checked'; ?>> Nữ</label>
				<label><input type="radio" name="gender" value="Khác" <?php if($data['gender']==='Khác') echo 'checked'; ?>> Khác</label>
			</p>
			<p>Sở thích (chọn 1 hoặc nhiều):<br>
				<label><input type="checkbox" name="hobbies[]" value="Thể thao" <?php if(in_array('Thể thao',$data['hobbies'])) echo 'checked'; ?>> Thể thao</label><br>
				<label><input type="checkbox" name="hobbies[]" value="Âm nhạc" <?php if(in_array('Âm nhạc',$data['hobbies'])) echo 'checked'; ?>> Âm nhạc</label><br>
				<label><input type="checkbox" name="hobbies[]" value="Đọc sách" <?php if(in_array('Đọc sách',$data['hobbies'])) echo 'checked'; ?>> Đọc sách</label><br>
			</p>
			<p><button type="submit">Submit</button></p>
		</form>

	<?php endif; ?>

</body>
</html>


