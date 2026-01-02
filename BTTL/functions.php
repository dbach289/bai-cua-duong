<?php

function max2($a, $b) {
    return ($a > $b) ? $a : $b; 
    // Trả về giá trị lớn hơn giữa $a và $b
}

function min2($a, $b) {
    // Trả về giá trị nhỏ hơn giữa $a và $b
    return ($a < $b) ? $a : $b; 
}

function isPrime($n) {
    $n = (int)$n; // Ép kiểu về số nguyên (nếu truyền chuỗi hoặc số thực)
    if ($n <= 1) {
        return false; // 0 và 1 không phải số nguyên tố
    }
    if ($n <= 3) {
        return true; // 2 và 3 là số nguyên tố
    }
    if ($n % 2 == 0 || $n % 3 == 0) {
        return false; // Loại các bội của 2 hoặc 3 ngay lập tức
    }
    // Kiểm tra các ước theo dạng 6k ± 1 (tăng i theo 6, kiểm tra i và i+2)
    for ($i = 5; $i * $i <= $n; $i += 6) {
        if ($n % $i == 0 || $n % ($i + 2) == 0) {
            return false; // Nếu chia hết thì không phải số nguyên tố
        }
    }
    return true; // Nếu không tìm ước nào -> là số nguyên tố
}

function factorial($n) {
    $n = (int)$n; // Ép kiểu về số nguyên
    if ($n < 0) {
        return null; // Giai thừa không định nghĩa cho số âm -> trả null
    }
    $result = 1; // Khởi tạo tích
    for ($i = 2; $i <= $n; $i++) {
        $result *= $i; // Nhân dồn từ 2 tới n để tính n!
    }
    return $result; // Trả về n!
}

function gcd($a, $b) {
    $a = abs((int)$a); // Dùng giá trị tuyệt đối và ép kiểu nguyên
    $b = abs((int)$b); // để xử lý số âm và kiểu không phải số nguyên
    if ($a === 0 && $b === 0) {
        return 0; // Quy ước: gcd(0,0) = 0 (có thể thay đổi nếu muốn)
    }
    // Thuật toán Euclid: lặp cho tới khi phần dư bằng 0
    while ($b !== 0) {
        $t = $b;       // lưu tạm b
        $b = $a % $b;  // gán b = a mod b (phần dư)
        $a = $t;       // gán lại a = giá trị cũ của b
    }
    return $a; // Khi b = 0, a là gcd
}

// Gợi ý sử dụng nhanh:
// max2(3,5) -> 5
// min2(3,5) -> 3
// isPrime(17) -> true
// factorial(6) -> 720
// gcd(12,18) -> 6

