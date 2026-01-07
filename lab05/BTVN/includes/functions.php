<?php
// Các hàm chung: khởi session, auth, flash, csrf

// Khởi session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Trả về array user demo (không dùng CSDL). Password được hash khi file được include.
function get_demo_users() {
    // Lưu ý: password_hash được dùng để tránh lưu mật khẩu rõ ràng.
    return [
        'admin' => [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT), // mật khẩu: admin123
            'name' => 'Quản trị',
            'role' => 'admin',
        ],
        'student' => [
            'username' => 'student',
            'email' => 'student@example.com',
            'password' => password_hash('student123', PASSWORD_DEFAULT), // mật khẩu: student123
            'name' => 'Học Sinh',
            'role' => 'user',
        ],
    ];
}

// Tìm user theo username hoặc email (trả về mảng user hoặc null)
function find_user(string $identifier) {
    $users = get_demo_users();
    // chuẩn hóa để so sánh không phân biệt hoa thường
    $idLower = mb_strtolower(trim($identifier));

    // Nếu identifier là key trực tiếp (username) - so sánh không phân biệt hoa thường
    foreach ($users as $key => $u) {
        if (mb_strtolower($key) === $idLower) return $u;
    }

    // Ngược lại tìm theo trường username hoặc email (người dùng có thể nhập email)
    foreach ($users as $u) {
        if (isset($u['username']) && mb_strtolower($u['username']) === $idLower) return $u;
        if (isset($u['email']) && mb_strtolower($u['email']) === $idLower) return $u;
    }
    return null;
}

// Kiểm tra đã đăng nhập chưa
function is_logged_in(): bool {
    return isset($_SESSION['user_username']);
}

// Bảo vệ trang: chuyển về login nếu chưa đăng nhập
function require_login() {
    if (!is_logged_in()) {
        // lưu flash để optional (không bắt buộc)
        set_flash('error', 'Bạn cần đăng nhập để truy cập trang này.');
        // redirect tới trang login của bài 1
        header('Location: bai1_login.php');
        exit;
    }
}

// Flash helpers: lưu thông báo tạm trong session (hiển thị 1 lần)
function set_flash(string $type, string $message) {
    $_SESSION['_flash'] = ['type' => $type, 'message' => $message];
}

function get_flash() {
    if (isset($_SESSION['_flash'])) {
        $flash = $_SESSION['_flash'];
        unset($_SESSION['_flash']);
        return $flash;
    }
    return null;
}

// CSRF token: tạo + kiểm tra
function csrf_token(): string {
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['_csrf_token'];
}

function verify_csrf(string $token): bool {
    return isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], $token);
}

// Xóa session và cookie remember_username
function do_logout() {
    // xóa session data
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    // xóa cookie remember_username nếu có
    setcookie('remember_username', '', time() - 3600, '/');
}

// Hàm escape HTML
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


// ---------------------------
// JSON helpers (cho Bài 2)
// ---------------------------
// Đọc file JSON trả về mảng (hoặc giá trị mặc định nếu file không tồn tại)
function read_json(string $path, $default = []) {
    if (!file_exists($path)) return $default;
    $txt = file_get_contents($path);
    $data = json_decode($txt, true);
    return is_array($data) ? $data : $default;
}

// Ghi mảng dữ liệu vào file JSON (pretty)
function write_json(string $path, $data): bool {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    $txt = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return (bool)file_put_contents($path, $txt);
}

// Tìm student theo mã (student_code) trong data/students.json
function find_student_by_code(string $code) {
    $students = read_json(__DIR__ . '/../data/students.json', []);
    $codeLower = mb_strtolower(trim($code));
    foreach ($students as $stu) {
        if (isset($stu['student_code']) && mb_strtolower($stu['student_code']) === $codeLower) return $stu;
    }
    return null;
}


