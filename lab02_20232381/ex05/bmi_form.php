<?php
// ex05 - bmi_form.php
// Form GET: họ tên, chiều cao (m), cân nặng (kg); validate, tính BMI và phân loại

// Hàm phân loại BMI
function classify_bmi($bmi) {
    if ($bmi < 18.5) return 'Gầy';
    if ($bmi < 25) return 'Bình thường';
    if ($bmi < 30) return 'Thừa cân';
    return 'Béo phì';
}

// Lấy dữ liệu an toàn và kiểm tra submit
$name = isset($_GET['name']) ? trim($_GET['name']) : '';
$height_raw = isset($_GET['height']) ? $_GET['height'] : '';
$weight_raw = isset($_GET['weight']) ? $_GET['weight'] : '';

$errors = [];
$bmi = null;
$classification = '';

if ($name !== '' || $height_raw !== '' || $weight_raw !== '') {
    // Người dùng đã cố gắng submit ít nhất một trường — validate tất cả
    if ($name === '') {
        $errors[] = 'Họ tên không được để trống.';
    }
    if ($height_raw === '' || !is_numeric($height_raw) || floatval($height_raw) <= 0) {
        $errors[] = 'Chiều cao phải là số dương (có thể nhập bằng cm hoặc m).';
    }
    if ($weight_raw === '' || !is_numeric($weight_raw) || floatval($weight_raw) <= 0) {
        $errors[] = 'Cân nặng phải là số dương (kg).';
    }

    if (empty($errors)) {
        $height_input = floatval($height_raw);
        // Nếu người dùng nhập bằng cm (ví dụ 170), giả sử > 3 thì coi là cm và chuyển về mét
        if ($height_input > 3) {
            $height = $height_input / 100.0;
        } else {
            $height = $height_input;
        }
        $weight = floatval($weight_raw);
        $bmi = $weight / ($height * $height);
        $bmi = round($bmi, 2);
        $classification = classify_bmi($bmi);
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ex05 - BMI Form</title>
    <style>
        body { font-family: Arial, sans-serif; padding:16px; line-height:1.5; }
        form { max-width:480px; }
        label { display:block; margin-top:8px; }
        input[type="text"], input[type="number"] { width:100%; padding:8px; box-sizing:border-box; }
        .error { color:#b00020; }
        .result { background:#eef6ff; padding:12px; border-radius:6px; margin-top:12px; }
    </style>
</head>
<body>
    <h1>Ex05 — Tính BMI (GET)</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <p><strong>Lỗi:</strong></p>
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="get" action="">
        <label for="name">Họ tên:</label>
        <input id="name" name="name" type="text" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="height">Chiều cao (nhập bằng cm hoặc m, ví dụ 170 hoặc 1.70):</label>
        <input id="height" name="height" type="number" step="0.01" min="0" value="<?php echo htmlspecialchars($height_raw, ENT_QUOTES, 'UTF-8'); ?>">

        <label for="weight">Cân nặng (kg):</label>
        <input id="weight" name="weight" type="number" step="0.1" min="0" value="<?php echo htmlspecialchars($weight_raw, ENT_QUOTES, 'UTF-8'); ?>">

        <div style="margin-top:12px;">
            <button type="submit">Tính BMI</button>
        </div>
    </form>

    <?php if ($bmi !== null): ?>
        <div class="result">
            <p><strong><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <p>BMI: <strong><?php echo $bmi; ?></strong></p>
            <p>Phân loại: <strong><?php echo htmlspecialchars($classification, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        </div>
    <?php elseif ($name !== '' || $height_raw !== '' || $weight_raw !== ''): ?>
        <!-- Người dùng đã submit nhưng có lỗi: lỗi đã hiển thị ở trên -->
    <?php else: ?>
        <p>Nhập thông tin rồi nhấn <em>Tính BMI</em>.</p>
    <?php endif; ?>

</body>
</html>


