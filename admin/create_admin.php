
<?php
require_once '../config.php';

// Tạo mật khẩu hash mới
$username = 'admin';
$password = 'admin123';
$email = 'admin@showroom.com';

// Tạo hash
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Xóa admin cũ
$conn->query("DELETE FROM admin WHERE username = '$username'");

// Thêm admin mới
$sql = "INSERT INTO admin (username, password, email) VALUES ('$username', '$password_hash', '$email')";

if ($conn->query($sql)) {
    echo "<h2 style='color: green;'>✅ Tạo tài khoản admin thành công!</h2>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    echo "<p><strong>Password Hash:</strong> $password_hash</p>";
    echo "<br><a href='login.php'>Đăng nhập ngay</a>";
    echo "<br><br><p style='color: red;'>⚠️ Xóa file này sau khi đăng nhập thành công!</p>";
} else {
    echo "<h2 style='color: red;'>❌ Lỗi: " . $conn->error . "</h2>";
}

// Hiển thị danh sách admin hiện có
echo "<hr><h3>Danh sách Admin trong database:</h3>";
$result = $conn->query("SELECT id, username, email, created_at FROM admin");
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Created At</th></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['created_at'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
