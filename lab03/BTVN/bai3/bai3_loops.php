<?php
// Bài 3: Vòng lặp (đã tách vào BTVN/bai3)
// A) In bảng cửu chương 1..9 bằng HTML (dùng for lồng nhau)
// B) Tính tổng chữ số của n (dùng while)
// C) In các số lẻ từ 1..N (dùng continue để bỏ chẵn; dùng break để dừng khi vượt 15)

$rawN = isset($_REQUEST['n']) ? trim($_REQUEST['n']) : '';
$n = null;
$errors = [];
$sumDigits = null;
$oddList = [];

if ($rawN === '') {
    $errors[] = 'Vui lòng nhập tham số n (qua form hoặc ?n=...).';
} else {
    if (!is_numeric($rawN) || (float)$rawN != intval($rawN)) {
        $errors[] = 'Tham số n phải là số nguyên.';
    } else {
        $n = intval($rawN);
        if ($n < 0) {
            $errors[] = 'Tham số n phải là số nguyên không âm.';
        } else {
            // B) Tính tổng chữ số của n bằng while
            $temp = abs($n);
            $sumDigits = 0;
            if ($temp === 0) {
                $sumDigits = 0;
            } else {
                while ($temp > 0) {
                    $sumDigits += $temp % 10;
                    $temp = intdiv($temp, 10);
                }
            }

            // C) In các số lẻ từ 1..N, dùng continue để bỏ số chẵn và break khi vượt 15
            for ($i = 1; $i <= $n; $i++) {
                if ($i > 15) {
                    break;
                }
                if ($i % 2 == 0) {
                    continue;
                }
                $oddList[] = $i;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <title>Bài 3 - Vòng lặp</title>
    <style>
        .tables { display: flex; flex-wrap: wrap; gap: 10px; }
        .table-box { border: 1px solid #ccc; padding: 8px; width: 180px; }
        .table-box h4 { margin: 0 0 6px 0; }
        .table-box ul { margin: 0; padding-left: 18px; }
    </style>
</head>
<body>
    <h1>Bài 3 — Vòng lặp</h1>

    <form method="get" action="">
        <label for="n">Nhập n (số nguyên không âm): </label>
        <input type="text" id="n" name="n" value="<?php echo htmlspecialchars($rawN, ENT_QUOTES, 'UTF-8'); ?>" />
        <button type="submit">Chạy</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $err) { echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . "<br>"; } ?>
        </div>
    <?php endif; ?>

    <?php if ($n !== null): ?>
        <h2>Bảng cửu chương 1..9</h2>
        <div class="tables">
            <?php for ($i = 1; $i <= 9; $i++): ?>
                <div class="table-box">
                    <h4><?php echo "Bảng $i"; ?></h4>
                    <!-- Hiển thị bảng cửu chương dạng bảng HTML với tiêu đề cột -->
                    <table border="1" cellpadding="4" cellspacing="0">
                        <thead>
                            <tr>
                                <th>&times;</th>
                                <?php for ($j = 1; $j <= 10; $j++): ?>
                                    <th><?php echo $j; ?></th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?php echo $i; ?></th>
                                <?php for ($j = 1; $j <= 10; $j++): ?>
                                    <td><?php echo $i * $j; ?></td>
                                <?php endfor; ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php endfor; ?>
        </div>

        <h2>Tổng chữ số của <?php echo $n; ?></h2>
        <p><?php echo "Tổng các chữ số của $n là " . $sumDigits . "."; ?></p>

        <h2>Các số lẻ từ 1 đến <?php echo $n; ?> (dừng khi >15)</h2>
        <?php if (empty($oddList)): ?>
            <p>Không có số lẻ nào (hoặc các số lẻ đều lớn hơn 15).</p>
        <?php else: ?>
            <p><?php echo implode(', ', $oddList); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <p>Test nhanh bằng URL:</p>
    <ul>
        <li><a href="?n=25">?n=25</a></li>
        <li><a href="?n=12345">?n=12345 (tổng chữ số)</a></li>
        <li><a href="?n=5">?n=5</a></li>
    </ul>

    <p><a href="../../BTTL/">Về trang chính Lab</a></p>
</body>
</html>


