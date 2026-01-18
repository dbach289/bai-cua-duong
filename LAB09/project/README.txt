Họ và tên: Đào Đức Anh
Mã sinh viên: 20230691
Lớp: DCCNTT.14.2

Cách chạy chương trình
Bước 1: Chuẩn bị source code

Giải nén thư mục project
Copy toàn bộ thư mục vào:
htdocs (nếu dùng XAMPP)
hoặc www (nếu dùng Laragon)
Ví dụ:
C:\xampp\htdocs\lab09_mvc

Bước 2: Import cơ sở dữ liệu
Mở trình duyệt truy cập http://localhost/phpmyadmin
Tạo database tên:
it3220_php
Import file:
database/it3220_php.sql

Bước 3: Cấu hình kết nối database
Mở file:
app/config/db.php
Kiểm tra lại thông tin:
'host' => 'localhost',
'dbname' => 'it3220_php',
'user' => 'root',
'pass' => '',
(Thay đổi nếu máy dùng mật khẩu MySQL khác)

Bước 4: Kiểm tra kết nối CSDL
Truy cập:
http://localhost/lab09_mvc/public/test_db.php
Nếu hiển thị:
Kết nối OK - Tổng sinh viên: ...
→ Kết nối thành công

Bước 5: Chạy chương trình
Truy cập trình duyệt:
http://localhost/lab09_mvc/public/index.php
Chương trình hiển thị trang Quản lý sinh viên với các chức năng:
Xem danh sách sinh viên
Thêm sinh viên (Ajax)
Xóa sinh viên (Ajax, có xác nhận)