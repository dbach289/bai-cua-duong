Bài 1 - Shop Demo (BTVN)
========================

Mô tả
-----
Ứng dụng web mini "Shop Demo" triển khai các chức năng cơ bản:
- Đăng nhập (session + CSRF + remember username cookie)
- Dashboard (bảo vệ bằng session)
- Products (thêm vào giỏ bằng POST)
- Cart (mini cart lưu trong $_SESSION['cart'], hỗ trợ cập nhật/xóa)

Cấu trúc chính
----------------
 BTVN/
 ├─ includes/
 │  ├─ functions.php    # helper (auth, csrf, flash, logout, e())
 │  ├─ header.php
 │  └─ footer.php
 ├─ assets/
 │  └─ images/          # placeholder SVG cho sản phẩm
 ├─ bai1_login.php
 ├─ bai1_process_login.php
 ├─ bai1_dashboard.php
 ├─ bai1_products.php
 ├─ bai1_cart.php
 └─ style.css

Chạy project (Windows + XAMPP)
------------------------------
1. Bật Apache trong XAMPP.
2. Đảm bảo thư mục project nằm trong htdocs, ví dụ:
   C:\xampp\htdocs\labs\lab05\BTVN
3. Mở trình duyệt:
   http://localhost/labs/lab05/BTVN/bai1_login.php

Tài khoản demo (không dùng CSDL)
-------------------------------
- admin / admin123  (role = admin)
- student / student123 (role = user)

Ghi chú kỹ thuật
-----------------
- Form đăng nhập dùng POST và có CSRF token => kiểm tra token trên server.
- Mật khẩu demo lưu dưới dạng hash (password_hash) trong code demo.
- Giỏ hàng lưu trong $_SESSION['cart'] với cấu trúc:
  $_SESSION['cart'][PRODUCT_ID] = ['qty'=>..., 'title'=>..., 'price'=>..., 'img'=>...]
- Các thao tác thay đổi trạng thái (thêm giỏ, update cart, logout) đều dùng POST.
- Flash messages được hiển thị một lần (lưu trong session).

Muốn mở rộng
-------------
- Lưu users vào CSDL thay vì mã cứng.
- Lưu cart vào file JSON hoặc CSDL để persist giữa session.
- Thêm payment flow, quản lý sản phẩm, upload ảnh thực tế.



Bài 2 - Student Portal
---------------------
Thư mục: `BTVN/bai2/`
Các file chính:
- `login.php` (form login bằng `student_code` + `password`)
- `process_login.php` (xử lý POST login)
- `profile.php` (thông tin sinh viên)
- `courses.php` (danh mục học phần, có form POST đăng ký)
- `register.php` (xử lý đăng ký, POST)
- `registrations.php` (hiển thị học phần đã đăng ký)
- `unregister.php` (xử lý hủy đăng ký, POST)
- `grades.php` (hiển thị điểm cho sinh viên)
- `logout.php` (POST + CSRF logout)

File dữ liệu JSON (trong `BTVN/data/`):
- `students.json` - danh sách sinh viên (demo)
- `courses.json` - danh sách học phần
- `registrations.json` - đăng ký học phần
- `grades.json` - điểm (nếu có)

Chạy và test:
1. Mở `http://localhost/lab05/BTVN/bai2/login.php`
2. Test accounts (demo):
   - `sv01` / `sv01pass`
   - `sv02` / `sv02pass` (sv02 có điểm mẫu trong `grades.json`)
3. Sau login thử các chức năng: đăng ký, hủy (nếu chưa có điểm), xem điểm.



