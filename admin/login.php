<?php
require_once '../config.php';

$error = '';
$debug = ''; // Để debug

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        // Debug: Hiển thị thông tin (CHỈ KHI TEST, xóa sau khi hoạt động)
        // $debug = "Hash trong DB: " . $admin['password'] . "<br>";
        // $debug .= "Password nhập: " . $password . "<br>";
        // $debug .= "Verify result: " . (password_verify($password, $admin['password']) ? 'TRUE' : 'FALSE');
        
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            redirect('dashboard.php');
        } else {
            $error = 'Mật khẩu không chính xác!';
        }
    } else {
        $error = 'Tài khoản admin không tồn tại!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Premium Cars</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .admin-login-container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            width: 100%;
            max-width: 450px;
            padding: 50px 40px;
        }
        
        .logo {
            text-align: center;
            font-size: 42px;
            margin-bottom: 10px;
        }
        
        h2 {
            text-align: center;
            color: #1e3c72;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 35px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }
        
        input:focus {
            outline: none;
            border-color: #1e3c72;
            box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.4);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #c33;
        }
        
        .debug {
            background: #fff3cd;
            color: #856404;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 12px;
            border-left: 4px solid #ffc107;
            font-family: monospace;
        }
        
        .back-home {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #1e3c72;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-home:hover {
            text-decoration: underline;
        }
        
        .admin-note {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #1976d2;
            border-left: 4px solid #2196f3;
        }
        
        .admin-note strong {
            display: block;
            margin-bottom: 5px;
        }
        
        .admin-note code {
            background: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: monospace;
            color: #d32f2f;
        }
        
        .helper-link {
            text-align: center;
            margin-top: 20px;
            padding: 12px;
            background: #fff3cd;
            border-radius: 8px;
        }
        
        .helper-link a {
            color: #d32f2f;
            font-weight: 600;
            text-decoration: none;
        }
        
        .helper-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="logo">👨‍💼</div>
        <h2>Admin Panel</h2>
        <p class="subtitle">Quản trị hệ thống showroom</p>
        
        <?php if($debug): ?>
            <div class="debug"><?php echo $debug; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" required placeholder="admin" value="admin">
            </div>
            
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required placeholder="admin123">
            </div>
            
            <button type="submit" class="btn">🔐 Đăng nhập Admin</button>
        </form>
        
        <div class="helper-link">
            ⚠️ Không đăng nhập được? 
            <a href="create_admin.php">Tạo lại tài khoản Admin</a>
        </div>
        
        <a href="../index.php" class="back-home">← Về trang chủ</a>
    </div>
</body>
</html>