<?php
// File: BTVN/common/process.php
// Hàm xử lý hành động: validate tham số và trả chuỗi kết quả

require_once __DIR__ . '/../../BTTL/functions.php'; // đảm bảo hàm đã được load

function validate_int_param($key) {
    if (!isset($_REQUEST[$key]) || $_REQUEST[$key] === '') {
        return null;
    }
    $raw = $_REQUEST[$key];
    if (!is_numeric($raw) || (float)$raw != intval($raw)) {
        return null;
    }
    return intval($raw);
}

function process_action_request($action) {
    $output = '';
    switch ($action) {
        case 'prime':
            $n = validate_int_param('n');
            if ($n === null) {
                $output = 'Vui lòng cung cấp tham số n hợp lệ (số nguyên).';
            } else {
                $output = isPrime($n) ? "$n là số nguyên tố" : "$n không phải số nguyên tố";
            }
            break;
        case 'fact':
            $n = validate_int_param('n');
            if ($n === null) {
                $output = 'Vui lòng cung cấp tham số n hợp lệ (số nguyên).';
            } else {
                $fact = factorial($n);
                $output = ($fact === null) ? 'Giai thừa không xác định cho số âm.' : "Giai thừa của $n là $fact";
            }
            break;
        case 'gcd':
            $a = validate_int_param('a');
            $b = validate_int_param('b');
            if ($a === null || $b === null) {
                $output = 'Vui lòng cung cấp cả tham số a và b (số nguyên).';
            } else {
                $g = gcd($a, $b);
                $output = "Ước chung lớn nhất của $a và $b là $g";
            }
            break;
        case 'maxmin':
            // chấp nhận số thực ở đây
            if (!isset($_REQUEST['a']) || !isset($_REQUEST['b'])) {
                $output = 'Vui lòng cung cấp cả tham số a và b.';
            } elseif (!is_numeric($_REQUEST['a']) || !is_numeric($_REQUEST['b'])) {
                $output = 'Tham số a và b phải là số.';
            } else {
                $a = $_REQUEST['a'] + 0;
                $b = $_REQUEST['b'] + 0;
                $output = "max($a, $b) = " . max2($a, $b) . "; min($a, $b) = " . min2($a, $b);
            }
            break;
        default:
            $output = '';
            break;
    }
    return $output;
}


