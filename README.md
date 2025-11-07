<h2 align="center">
    <a href="#">
    🚗 Hệ Thống Đặt Lịch Xem & Sửa Xe Ô Tô
    </a>
</h2>
<h2 align="center">
    Premium Cars – Car Booking & Repair Service System
</h2>

<div align="center">
    <img src="docs/logo/car.png" width="180" />
</div>

<div align="center">

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge\&logo=php\&logoColor=white)](#)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)](#)
[![HTML](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge\&logo=html5\&logoColor=white)](#)
[![CSS](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge\&logo=css3\&logoColor=white)](#)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge\&logo=javascript\&logoColor=black)](#)
[![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge\&logo=xampp\&logoColor=white)](#)

</div>

---

## 📖 1. Giới thiệu hệ thống

Hệ thống **Showroom Ô Tô Cao Cấp – Đặt lịch xem & sửa xe** được xây dựng nhằm hỗ trợ khách hàng:

✅ Xem danh sách xe mới nhất
✅ Xem chi tiết xe, giá, thông số kỹ thuật
✅ Đặt lịch đến showroom xem xe
✅ Đặt lịch sửa chữa/bảo dưỡng xe
✅ Theo dõi các lịch đã đặt

Với vai trò quản trị (**Admin**):

✅ Quản lý thông tin xe
✅ Quản lý người dùng
✅ Quản lý lịch xem xe & lịch sửa xe
✅ Thống kê dữ liệu

---

## 🔧 2. Công nghệ sử dụng

<div align="center">

### Ngôn ngữ & môi trường

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge\&logo=php\&logoColor=white)](#)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge\&logo=javascript\&logoColor=black)](#)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge\&logo=html5\&logoColor=white)](#)
[![CSS3](https://img.shields.io/badge/CSS-1572B6?style=for-the-badge\&logo=css3\&logoColor=white)](#)

### Server & Database

[![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge\&logo=apache\&logoColor=white)](#)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)](#)
[![XAMPP](https://img.shields.io/badge/XAMPP-FB7A24?style=for-the-badge\&logo=xampp\&logoColor=white)](#)

</div>

---

## 🚀 3. Hình ảnh giao diện 

> ✅ Trang đăng nhập / đăng ký
> ✅ Trang xem xe
> ✅ Trang chi tiết xe
> ✅ Đặt lịch xem xe
> ✅ Đặt lịch sửa xe
> ✅ Trang quản lý lịch của tôi
> ✅ Giao diện Admin

---

## ⚙️ 4. Cài đặt hệ thống

### ✅ 4.1. Tải và cài đặt môi trường

* XAMPP (Apache + MySQL)
* Visual Studio Code
* MySQL Workbench (tùy chọn)

### ✅ 4.2. Tải project

Giải nén source đặt vào:

```
C:/xampp/htdocs/car_showroom/
```

### ✅ 4.3. Tạo database

```sql
CREATE DATABASE showroom_db
   CHARACTER SET utf8mb4
   COLLATE utf8mb4_unicode_ci;
```

### ✅ 4.4. Cấu hình kết nối

Chỉnh file `config.php`:

```php
<?php
$host = "localhost";
$user = "root";
$password = "Thanhno2412@#";
$dbname = "showroom_db";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Không thể kết nối database: " . $conn->connect_error);
}
?>
```

### ✅ 4.5. Khởi chạy

Truy cập:

```
http://localhost/car_showroom/index.php
```

---

## 🔐 5. Tài khoản mặc định

| Tên đăng nhập  | Email                                     | Mật khẩu |
| ----- | ----------------------------------------- | -------- |
| Admin | [admin@gmail.com](mailto:admin@gmail.com) | 123456   |
| User  | [user@gmail.com](mailto:user@gmail.com)   | 123456   |

---

## ✅ 6. Chức năng chính

### 👤 Người dùng

✔ Đăng ký / đăng nhập
✔ Xem xe, xem chi tiết
✔ Đặt lịch xem xe & sửa xe
✔ Xem lịch đã đặt
✔ Cập nhật thông tin cá nhân

### 👑 Quản trị

✔ Quản lý xe
✔ Quản lý người dùng
✔ Duyệt / hủy lịch
✔ Thống kê dữ liệu

---

## 📂 7. Cấu trúc thư mục

```
/showroom
│── /admin
│── /images
│── /booking
│── car-detail.php
│── booking.php
│── book-repair.php
│── my-bookings.php
│── my-repair.php
│── login.php
│── register.php
│── config.php
│── index.php
```

---

## 🧑‍💻 8. Thành viên thực hiện

* Tên sinh viên: Nguyễn Xuân Thành
* Lớp: CNTT17-05
* GVHD: TS.Lê Tuấn Anh

---

## ❤️ 9. Lời cảm ơn

Cảm ơn thầy/cô đã hỗ trợ trong quá trình thực hiện đồ án. Hệ thống có thể mở rộng thêm như gửi email thông báo, thanh toán online, chatbot tư vấn…

