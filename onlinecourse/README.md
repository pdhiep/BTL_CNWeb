**Hướng dẫn nhanh (Tiếng Việt)**

- Nếu bạn đã tạo sẵn cơ sở dữ liệu và bảng trong phpMyAdmin, không cần tạo lại — chỉ cần đảm bảo thông tin kết nối (host, database, user, password) đúng.

- File kết nối: `config/Database.php` — file này chỉ mở kết nối PDO tới cơ sở dữ liệu, không tạo/bắt đầu database.

- Bảng cần có (nếu bạn chưa có): `users`, `courses`, `enrollments`.

- Mở trình duyệt tới `index.php` để xem danh sách khóa học. Các chức năng chính:
  - Danh sách & tìm kiếm: `?controller=course&action=index`
  - Xem chi tiết: `?controller=course&action=detail&id={id}`
  - Đăng ký: gửi POST tới `?controller=course&action=enroll` (yêu cầu người dùng đã đăng nhập, `$_SESSION['user_id']` phải được thiết lập)

- Ghi chú: giao diện và thông báo đã được chuyển sang tiếng Việt.

---

Hướng dẫn import bằng phpMyAdmin (dành cho môi trường phát triển):

1. Mở phpMyAdmin (ví dụ: `http://localhost/phpmyadmin`).
2. Chọn database bạn đã tạo cho project (ví dụ `onlinecourse`).
3. Chọn tab `Import`.
4. Ở phần `File to import`, nhấn `Choose File` và chọn file `db/seed.sql` trong thư mục project (`onlinecourse/db/seed.sql`).
5. Nhấn `Go` để bắt đầu import. File này sẽ chèn một user test, hai course mẫu và một bản ghi enroll để test nhanh.

Lưu ý:
- File `db/seed.sql` chỉ dùng cho môi trường phát triển. Mật khẩu trong file là `password` (dạng plain text) cho mục đích test — không dùng trên môi trường production.
- Nếu database của bạn đã có dữ liệu trùng ID, hãy kiểm tra trước hoặc xóa các bản ghi trùng để tránh lỗi khóa chính.

Nếu bạn muốn, tôi có thể:
- Tạo một trang nhỏ `AuthController` + form đăng nhập để bạn test chức năng đăng ký và đăng nhập end-to-end.
- Hoặc tạo script PHP để seed dữ liệu bằng PDO thay vì import SQL thô.

Chọn một tùy chọn để tôi tiếp tục.
