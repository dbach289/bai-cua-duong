<?php
// File: BTVN/bai4_functions.php
// Bài 4 - Thư viện hàm cho Lab03
// Chứa các hàm bắt buộc của Bài 4: max2, min2, isPrime, factorial, gcd

/**
 * Trả về giá trị lớn hơn trong hai số $a và $b
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function max2($a, $b) {
    // Dùng toán tử ternary để so sánh và trả kết quả
    return ($a > $b) ? $a : $b;
}

/**
 * Trả về giá trị nhỏ hơn trong hai số $a và $b
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function min2($a, $b) {
    // Tương tự max2 nhưng kiểm tra theo chiều ngược lại
    return ($a < $b) ? $a : $b;
}

/**
 * Kiểm tra số nguyên dương n có phải số nguyên tố không.
 * Sử dụng tối ưu: loại 2,3 và kiểm tra dần theo bước 6 (6k ± 1).
 * @param mixed $n
 * @return bool
 */
function isPrime($n) {
    $n = (int)$n; // Ép kiểu về số nguyên
    if ($n <= 1) {
        return false; // 0 và 1 không phải số nguyên tố
    }
    if ($n <= 3) {
        return true; // 2 và 3 là nguyên tố
    }
    // Loại các bội của 2 hoặc 3
    if ($n % 2 == 0 || $n % 3 == 0) {
        return false;
    }
    // Kiểm tra các ước dạng 6k ± 1: duyệt i = 5, 11, 17, ...
    for ($i = 5; $i * $i <= $n; $i += 6) {
        // Kiểm tra i và i+2 (tức 6k-1 và 6k+1)
        if ($n % $i == 0 || $n % ($i + 2) == 0) {
            return false; // tìm thấy ước -> không phải nguyên tố
        }
    }
    return true; // không tìm ước -> là số nguyên tố
}

/**
 * Tính giai thừa n! theo vòng lặp.
 * Nếu n < 0 trả về null (không định nghĩa giai thừa âm).
 * @param mixed $n
 * @return int|null
 */
function factorial($n) {
    $n = (int)$n; // Ép kiểu về số nguyên
    if ($n < 0) {
        return null; // không định nghĩa giai thừa cho số âm
    }
    $result = 1;
    // Nhân dồn từ 2 tới n
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i;
    }
    return $result;
}

/**
 * Tính Ước chung lớn nhất (gcd) của hai số nguyên a và b bằng thuật toán Euclid.
 * Trả về giá trị không âm.
 * Quy ước: gcd(0,0) = 0
 * @param mixed $a
 * @param mixed $b
 * @return int
 */
function gcd($a, $b) {
    // Ép về số nguyên và lấy giá trị tuyệt đối để xử lý số âm
    $a = abs((int)$a);
    $b = abs((int)$b);
    // Nếu cả hai đều 0, quy ước trả 0
    if ($a === 0 && $b === 0) {
        return 0;
    }
    // Euclid: lặp cho đến khi phần dư b = 0
    while ($b !== 0) {
        $t = $b;
        $b = $a % $b; // phần dư của a chia b
        $a = $t;      // gán a = giá trị cũ của b
    }
    return $a; // khi b = 0 thì a là gcd
}

// Ví dụ sử dụng (bỏ comment khi muốn chạy):
// echo max2(3,5); // 5
// echo min2(3,5); // 3
// var_export(isPrime(17)); // true
// var_export(factorial(6)); // 720
// echo gcd(12,18); // 6


