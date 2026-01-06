<?php
require_once 'Student.php';

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$__COMMENT = <<<'TXT'
/*
HƯỚNG DẪN SỬ DỤNG ex5_student_manager.php
- Form POST có textarea nhập chuỗi theo định dạng:
  SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5
- Mẫu mặc định có trong biến $sample; để thay đổi mẫu, chỉnh $sample.
- Sau khi nhấn "Parse & Show": script sẽ
  1) Parse từng record, bỏ qua record sai định dạng (không crash).
  2) Áp dụng threshold (nếu nhập) để lọc GPA >= threshold.
  3) Có thể sort giảm dần theo GPA nếu tick checkbox.
  4) Hiển thị bảng và thống kê avg/max/min + số lượng theo xếp loại.
- Mở rộng nhanh:
  * Lưu record hợp lệ vào $_SESSION['last_parsed'] để edit/xoá sau.
  * Lưu record bị bỏ qua vào $skipped để show cho người dùng.
  * Thêm Export CSV/JSON sau khi parse thành công.
*/
TXT;

$error = '';
$parsedStudents = [];
// NOTE FOR STUDENTS / MAINTAINERS:
// - Input format (textarea): "SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5"
// - To change the default sample data, edit $sample below.
// - To collect skipped/invalid records instead of silently ignoring them,
//   declare $skipped = [] here and push invalid $rec inside the parse loop.
// - To persist results between requests, you can save $parsedStudents to
//   $_SESSION['last_parsed'] after successful parsing (remember to call session_start()).

// Giá trị mặc định mẫu
$sample = "SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5;SV004-Dung-3.8";
$inputData = isset($_POST['data']) ? $_POST['data'] : $sample;
$thresholdRaw = isset($_POST['threshold']) ? trim($_POST['threshold']) : '';
$threshold = is_numeric($thresholdRaw) ? (float)$thresholdRaw : null;
$sortDesc = isset($_POST['sort_desc']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['parse'])) {
    $raw = trim($inputData);
    if ($raw === '') {
        $error = 'Vui lòng nhập dữ liệu vào textarea.';
    } else {
        // Split input into records by ';' then normalize whitespace
        // Example: "SV001-An-3.2;SV002-Binh-2.6"
        $records = array_filter(array_map('trim', explode(';', $raw)), function($r){ return $r !== ''; });
        foreach ($records as $rec) {
            $fields = explode('-', $rec, 3);
            if (count($fields) !== 3) {
                // bỏ qua record sai định dạng
                continue;
            }
            list($id, $name, $gpaStr) = $fields;
            $id = trim($id);
            $name = trim($name);
            $gpaStr = trim($gpaStr);
            if ($id === '' || $name === '' || $gpaStr === '') continue;
            if (!is_numeric($gpaStr)) continue;
            $gpa = (float)$gpaStr;
            $parsedStudents[] = new Student($id, $name, $gpa);
        }

        if (count($parsedStudents) === 0) {
            $error = 'Không có record hợp lệ sau khi parse.';
        } else {
            // Áp dụng filter theo threshold nếu có
            // If threshold is provided (numeric), filter students with GPA >= threshold.
            // You can change the comparison operator here to use strict thresholds.
            if ($threshold !== null) {
                $parsedStudents = array_filter($parsedStudents, function($s) use ($threshold) {
                    return $s->getGpa() >= $threshold;
                });
                $parsedStudents = array_values($parsedStudents);
            }

            // Nếu sau filter rỗng thì thông báo
            if (count($parsedStudents) === 0) {
                $error = 'Không có sinh viên thỏa điều kiện (sau khi áp dụng threshold).';
            } else {
                // Sort theo GPA giảm dần nếu được chọn
                // To sort ascending instead, invert the comparison or use <=> swapping.
                if ($sortDesc) {
                    usort($parsedStudents, function($a, $b) {
                        return $b->getGpa() <=> $a->getGpa();
                    });
                }
            }
        }
    }
}

// Nếu có danh sách để hiển thị thì tính stats
$avgGpa = 0;
$maxGpa = null;
$minGpa = null;
$rankCounts = ['Giỏi' => 0, 'Khá' => 0, 'Trung bình' => 0];
if (count($parsedStudents) > 0) {
    $gpas = array_map(function($s) { return $s->getGpa(); }, $parsedStudents);
    $avgGpa = array_sum($gpas) / count($gpas);
    $maxGpa = max($gpas);
    $minGpa = min($gpas);
    $rankCounts = array_reduce($parsedStudents, function($carry, $s) {
        $r = $s->rank();
        if (!isset($carry[$r])) $carry[$r] = 0;
        $carry[$r]++;
        return $carry;
    }, ['Giỏi' => 0, 'Khá' => 0, 'Trung bình' => 0]);
}

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ex5 — Student Manager (POST)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        textarea { width: 100%; height: 120px; }
        table { border-collapse: collapse; width: 100%; margin-top:16px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
        .error { color: red; font-weight: bold; }
        .controls { margin-bottom: 12px; }
    </style>
</head>
<body>
    <h2>Bài 5 — Student Manager (POST)</h2>

    <form method="post">
        <label>Nhập dữ liệu (format: SV001-An-3.2;SV002-Binh-2.6;...)</label>
        <textarea name="data"><?php echo h($inputData); ?></textarea>
        <div class="controls">
            <label>Threshold (lọc GPA >=): <input type="text" name="threshold" value="<?php echo h($thresholdRaw); ?>" /></label>
            <label style="margin-left:12px;"><input type="checkbox" name="sort_desc" <?php echo $sortDesc ? 'checked' : ''; ?>/> Sort GPA giảm dần</label>
            <button type="submit" name="parse" style="margin-left:12px;">Parse & Show</button>
        </div>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error"><?php echo h($error); ?></p>
    <?php endif; ?>

    <?php if (count($parsedStudents) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>GPA</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($parsedStudents as $i => $s): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo h($s->getId()); ?></td>
                    <td><?php echo h($s->getName()); ?></td>
                    <td><?php echo number_format($s->getGpa(), 2); ?></td>
                    <td><?php echo h($s->rank()); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <p>
            GPA trung bình: <strong><?php echo number_format($avgGpa, 2); ?></strong>,
            Max: <strong><?php echo $maxGpa !== null ? number_format($maxGpa, 2) : 'N/A'; ?></strong>,
            Min: <strong><?php echo $minGpa !== null ? number_format($minGpa, 2) : 'N/A'; ?></strong>
        </p>
        <p>
            Thống kê xếp loại: Giỏi: <?php echo (int)$rankCounts['Giỏi']; ?>,
            Khá: <?php echo (int)$rankCounts['Khá']; ?>,
            Trung bình: <?php echo (int)$rankCounts['Trung bình']; ?>.
        </p>
    <?php endif; ?>

</body>
</html>


