# OnlineCourse – Phần 1 (Đăng nhập/Đăng ký/Quản lý tài khoản)

## 1. Cấu trúc CSDL

Tạo database `onlinecourse` (hoặc cập nhật thông tin trong `config/Database.php`). Tối thiểu bảng `users` cần các cột sau:

```sql
CREATE TABLE `users` (
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(191) NULL,
	`email` VARCHAR(191) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL,
	`role` VARCHAR(50) NOT NULL DEFAULT 'student',
	`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Lưu ý: nếu hệ thống của bạn dùng tên cột khác (`full_name`, `username`, ...), mã nguồn sẽ tự động dò tìm và sử dụng cột đó.

## 2. Chạy dự án

1. Đặt source tại thư mục web server (ví dụ `htdocs/BTL_CNWeb/onlinecourse`).
2. Khởi động Apache + MySQL (XAMPP).
3. Truy cập `http://localhost/BTL_CNWeb/onlinecourse/index.php`.

## 3. Các chức năng chính

- `?controller=auth&action=register`: Form đăng ký với kiểm tra dữ liệu và mã hoá mật khẩu (`password_hash`).
- `?controller=auth&action=login`: Đăng nhập, lưu session, hiển thị thông báo lỗi/thành công.
- `?controller=auth&action=logout`: Huỷ session, chống session fixation bằng `session_regenerate_id`.
- `?controller=auth&action=profile`: Trang quản lý tài khoản (đổi tên, đổi mật khẩu) – chỉ truy cập khi đã đăng nhập.

## 4. Test thủ công gợi ý

1. Đăng ký tài khoản mới → nhận thông báo thành công → được chuyển tới trang đăng nhập.
2. Đăng nhập sai mật khẩu → nhìn thấy thông báo lỗi.
3. Đăng nhập đúng → header đổi thành “Tài khoản/Đăng xuất”, trang chủ hiển thị tên người dùng.
4. Truy cập trang quản lý tài khoản, thay đổi tên/mật khẩu → thông báo thành công và session cập nhật.
5. Đăng xuất → được chuyển về trang chủ, không thể truy cập `profile` khi chưa đăng nhập.

## 5. Tuỳ chỉnh thêm

- Thay đổi thông tin kết nối DB bằng biến môi trường `DB_HOST`, `DB_NAME`, ... hoặc sửa `DEFAULTS` trong `config/Database.php`.
- CSS cơ bản nằm ở `assets/css/style.css`, có thể mở rộng cho toàn bộ trang.
- Logic xử lý hiển thị thông báo dùng `$_SESSION['flash']` (xem `views/layouts/header.php`).
