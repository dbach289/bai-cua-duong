<?php
require_once 'Student.php';

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Tạo danh sách ít nhất 5 sinh viên
$students = [
    new Student('SV001', 'Nguyễn Văn A', 3.45),
    new Student('SV002', 'Trần Thị B', 2.80),
    new Student('SV003', 'Lê Văn C', 1.95),
    new Student('SV004', 'Phạm Thị D', 3.20),
    new Student('SV005', 'Hoàng Văn E', 2.40),
];

// GHI CHÚ (HƯỚNG DẪN)
// - Class Student nằm trong Student.php; nó có các getter getId/getName/getGpa và method rank().
// - Để thêm/sửa sinh viên: chỉnh mảng $students ở đây. Ví dụ:
//     new Student('SV006', 'Nguyễn X', 3.10)
// - Để lấy GPA trung bình, mã dùng array_map để lấy gpa từng student rồi tính trung bình.
// - Nếu muốn sắp xếp danh sách theo GPA/Name, tạo một bản sao $copy = $students rồi dùng usort:
//     usort($copy, function($a,$b){ return $b->getGpa() <=> $a->getGpa(); });
// - Để lưu dữ liệu đã parse hoặc cho phép edit, lưu $students vào $_SESSION['students'] (gọi session_start() trước).

// Tính GPA trung bình lớp
$gpas = array_map(function($s) { return $s->getGpa(); }, $students);
$avgGpa = count($gpas) > 0 ? array_sum($gpas) / count($gpas) : 0;

// Thống kê số lượng theo rank
$rankCounts = array_reduce($students, function($carry, $s) {
    $r = $s->rank();
    if (!isset($carry[$r])) $carry[$r] = 0;
    $carry[$r]++;
    return $carry;
}, []);

// Chuẩn hoá các khóa để luôn có 3 loại
$rankCounts = array_merge(['Giỏi' => 0, 'Khá' => 0, 'Trung bình' => 0], $rankCounts);

?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bài 4 — Students OOP</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; max-width: 900px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f7f7f7; }
        tfoot td { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Bài 4 — OOP Student + render + thống kê xếp loại</h2>

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
        <?php foreach ($students as $i => $s): ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo h($s->getId()); ?></td>
                <td><?php echo h($s->getName()); ?></td>
                <td><?php echo number_format($s->getGpa(), 2); ?></td>
                <td><?php echo h($s->rank()); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">GPA trung bình lớp</td>
                <td colspan="2"><?php echo number_format($avgGpa, 2); ?></td>
            </tr>
            <tr>
                <td colspan="5">
                    Thống kê xếp loại:
                    Giỏi: <?php echo (int)$rankCounts['Giỏi']; ?>,
                    Khá: <?php echo (int)$rankCounts['Khá']; ?>,
                    Trung bình: <?php echo (int)$rankCounts['Trung bình']; ?>
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>


