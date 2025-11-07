<?php
// Cấu hình kết nối database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Thanhno2412@#'); // Mặc định XAMPP để trống
define('DB_NAME', 'car_showroom');

// Tạo kết nối
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Set charset UTF-8
$conn->set_charset("utf8mb4");

// Khởi động session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hàm kiểm tra đăng nhập
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Hàm kiểm tra admin
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

// Hàm redirect
function redirect($url) {
    header("Location: $url");
    exit();
}

// Hàm làm sạch input
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Hàm format tiền VND
function format_vnd($price) {
    return number_format($price, 0, ',', '.') . ' ₫';
}
?>