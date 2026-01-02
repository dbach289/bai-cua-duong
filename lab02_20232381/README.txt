Họ tên: BẠCH HOÀNG DƯƠNG
MSSV: 20232381
Lớp: DCCNTT14.2

Thư mục bài tập (trên máy của bạn nên đặt trong `htdocs`, ví dụ `C:\xampp\htdocs\lab02_20232381`):

- `lab02_20232381/`
  - `ex01/` (hello.php, info.php)
  - `ex02/` (variables.php)
  - `ex03/` (calc_basic.php)
  - `ex04/` (calc_get.php)
  - `ex05/` (bmi_form.php)
  - `README.txt`
  - `screenshots (ở trong file báo cáo lab02)

Hướng dẫn chạy nhanh:
1. Bật Apache trong XAMPP Control Panel.
2. Đặt folder `lab02_20232381` vào `C:\xampp\htdocs\` (hoặc tương đương trên máy).
3. Mở trình duyệt và truy cập các URL sau:
   - Bài 1:
     - `http://localhost/lab02_20232381/ex01/hello.php`
     - `http://localhost/lab02_20232381/ex01/info.php`
   - Bài 2:
     - `http://localhost/lab02_20232381/ex02/variables.php`
   - Bài 3:
     - `http://localhost/lab02_20232381/ex03/calc_basic.php`
   - Bài 4 (ví dụ):
     - `http://localhost/lab02_20232381/ex04/calc_get.php?a=10&b=3&op=add`
     - Các giá trị `op`: `add`, `sub`, `mul`, `div`
   - Bài 5:
     - `http://localhost/lab02_20232381/ex05/bmi_form.php`

Ghi chú / lỗi/khó khăn (nếu có):
- Nếu gặp lỗi 404: kiểm tra tên thư mục và file, đảm bảo file nằm trong `htdocs`.
- Nếu trang hiển thị mã PHP thô hoặc không chạy: kiểm tra Apache đã bật và PHP trong XAMPP hoạt động.
- Nếu gặp lỗi chia 0 (Bài 4): chương trình sẽ báo "Không thể chia cho 0." — sửa tham số `b`.
- Chiều cao trong form BMI (Bài 5) có thể nhập bằng cm (ví dụ 170) hoặc mét (ví dụ 1.70); chương trình tự chuẩn hóa.

Ảnh minh chứng:
Ở trong file báo cáo lab02


