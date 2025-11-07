<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $subject = clean_input($_POST['subject']);
    $message = clean_input($_POST['message']);
    
    $sql = "INSERT INTO contacts (name, email, phone, subject, message) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message')";
    
    if ($conn->query($sql)) {
        $success = 'Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.';
    } else {
        $error = 'Có lỗi xảy ra. Vui lòng thử lại!';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - Premium Cars</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
        }
        
        /* Header */
        header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-links {
            display: flex;
            gap: 35px;
            list-style: none;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-links a:hover {
            color: #667eea;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-outline {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }
        
        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
        }
        
        .page-header {
            text-align: center;
            color: white;
            margin-bottom: 50px;
        }
        
        .page-header h1 {
            font-size: 48px;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .page-header p {
            font-size: 18px;
            opacity: 0.95;
        }
        
        /* Contact Grid */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .contact-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .card-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .card-icon {
            font-size: 36px;
        }
        
        /* Contact Form */
        .form-group {
            margin-bottom: 22px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }
        
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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
        
        .success {
            background: #efe;
            color: #3c3;
            padding: 12px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #3c3;
        }
        
        /* Contact Info */
        .info-list {
            list-style: none;
        }
        
        .info-item {
            display: flex;
            gap: 20px;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-icon {
            font-size: 28px;
            min-width: 40px;
        }
        
        .info-content h3 {
            font-size: 16px;
            color: #667eea;
            margin-bottom: 5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-content p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }
        
        /* Maintenance Section */
        .maintenance-section {
            background: white;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 40px;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-header h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .section-header p {
            font-size: 16px;
            color: #666;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .service-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            border-color: #667eea;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }
        
        .service-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .service-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .service-desc {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }
        
        .service-price {
            font-size: 22px;
            font-weight: 700;
            color: #667eea;
            margin-top: 15px;
        }
        
        /* Maintenance Schedule */
        .schedule-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 18px;
            border-top: 1px solid #ecf0f1;
            color: #555;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .check-icon {
            color: #28a745;
            font-size: 20px;
        }
        
        /* Map Section */
        .map-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .map-container {
            width: 100%;
            height: 400px;
            border-radius: 15px;
            overflow: hidden;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #666;
        }
        
        /* Footer */
        footer {
            background: rgba(0,0,0,0.3);
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 80px;
        }
        
        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header h1 {
                font-size: 32px;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">🚗 Premium Cars</div>
            <ul class="nav-links">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="cars.php">Xe</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
                <?php if(isLoggedIn()): ?>
                    <li><a href="my-bookings.php">Lịch của tôi</a></li>
                    <li><a href="logout.php">Đăng xuất</a></li>
                <?php elseif(isAdmin()): ?>
                    <li><a href="admin/dashboard.php" class="btn btn-primary">Admin Panel</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn btn-outline">Đăng nhập</a></li>
                    <li><a href="register.php" class="btn btn-primary">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1>Liên hệ với chúng tôi</h1>
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
        </div>

        <!-- Contact Form & Info -->
        <div class="contact-grid">
            <div class="contact-card">
                <h2 class="card-title">
                    <span class="card-icon">📧</span>
                    Gửi tin nhắn
                </h2>
                
                <?php if($error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="name">Họ và tên *</label>
                        <input type="text" id="name" name="name" required placeholder="Nguyễn Văn A">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required placeholder="email@example.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" placeholder="0912345678">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Chủ đề</label>
                        <select id="subject" name="subject" required>
                            <option value="">Chọn chủ đề</option>
                            <option value="Tư vấn mua xe">Tư vấn mua xe</option>
                            <option value="Đặt lịch xem xe">Đặt lịch xem xe</option>
                            <option value="Bảo dưỡng">Dịch vụ bảo dưỡng</option>
                            <option value="Báo giá">Yêu cầu báo giá</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Nội dung *</label>
                        <textarea id="message" name="message" required 
                                  placeholder="Nhập nội dung liên hệ của bạn..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px;">
                        📨 Gửi liên hệ
                    </button>
                </form>
            </div>
            
            <div class="contact-card">
                <h2 class="card-title">
                    <span class="card-icon">📞</span>
                    Thông tin liên hệ
                </h2>
                
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-icon">📍</span>
                        <div class="info-content">
                            <h3>Địa chỉ showroom</h3>
                            <p>số 1 , phố xốm , hà đông , hà nội<br>
                            Thời gian: 8:00 - 20:00 (Tất cả các ngày)</p>
                        </div>
                    </li>
                    
                    <li class="info-item">
                        <span class="info-icon">📞</span>
                        <div class="info-content">
                            <h3>Hotline</h3>
                            <p>1900 12345 (Miễn phí)<br>
                            012345678</p>
                        </div>
                    </li>
                    
                    <li class="info-item">
                        <span class="info-icon">📧</span>
                        <div class="info-content">
                            <h3>Email</h3>
                            <p>info@premiumcars.vn<br>
                            support@premiumcars.vn</p>
                        </div>
                    </li>
                    
                    <li class="info-item">
                        <span class="info-icon">💬</span>
                        <div class="info-content">
                            <h3>Mạng xã hội</h3>
                            <p>Facebook: Nguyễn Xuân Thành<br>
                            Zalo: 0867743624</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Maintenance Services -->
        <div class="maintenance-section">
            <div class="section-header">
                <h2>🔧 Dịch vụ bảo dưỡng</h2>
                <p>Chăm sóc xe của bạn với dịch vụ chuyên nghiệp</p>
            </div>
            
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🛠️</div>
                    <h3 class="service-title">Bảo dưỡng định kỳ</h3>
                    <p class="service-desc">
                        Thay dầu máy, lọc gió, kiểm tra tổng quát hệ thống
                    </p>
                    <div class="service-price">Từ 1.500.000₫</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">🔩</div>
                    <h3 class="service-title">Sửa chữa chung</h3>
                    <p class="service-desc">
                        Sửa chữa, thay thế linh kiện theo yêu cầu
                    </p>
                    <div class="service-price">Báo giá chi tiết</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">🚗</div>
                    <h3 class="service-title">Rửa xe & đánh bóng</h3>
                    <p class="service-desc">
                        Vệ sinh nội thất, đánh bóng ngoại thất chuyên nghiệp
                    </p>
                    <div class="service-price">Từ 300.000₫</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">🔋</div>
                    <h3 class="service-title">Kiểm tra điện</h3>
                    <p class="service-desc">
                        Kiểm tra hệ thống điện, ắc quy, đèn chiếu sáng
                    </p>
                    <div class="service-price">Từ 500.000₫</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">❄️</div>
                    <h3 class="service-title">Bảo dưỡng điều hòa</h3>
                    <p class="service-desc">
                        Vệ sinh, nạp gas điều hòa, kiểm tra hệ thống làm lạnh
                    </p>
                    <div class="service-price">Từ 800.000₫</div>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">🛡️</div>
                    <h3 class="service-title">Phủ ceramic</h3>
                    <p class="service-desc">
                        Phủ ceramic bảo vệ bề mặt sơn xe lâu dài
                    </p>
                    <div class="service-price">Từ 5.000.000₫</div>
                </div>
            </div>
            
            <h3 style="text-align: center; font-size: 28px; margin: 40px 0 30px; color: #333;">
                📅 Lịch bảo dưỡng định kỳ
            </h3>
            
            <div class="schedule-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mốc km</th>
                            <th>Thay dầu máy</th>
                            <th>Lọc gió</th>
                            <th>Phanh</th>
                            <th>Lốp xe</th>
                            <th>Ắc quy</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>5.000 km</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td>Kiểm tra</td>
                            <td>Kiểm tra</td>
                            <td>Kiểm tra</td>
                        </tr>
                        <tr>
                            <td><strong>10.000 km</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td>Kiểm tra</td>
                            <td>Kiểm tra</td>
                        </tr>
                        <tr>
                            <td><strong>20.000 km</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td>Kiểm tra</td>
                        </tr>
                        <tr>
                            <td><strong>30.000 km</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>40.000 km</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section">
            <h2 class="card-title">
                <span class="card-icon">🗺️</span>
                Vị trí showroom
            </h2>
            <div class="map-container">
                📍 Bản đồ Google Maps sẽ được tích hợp tại đây
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Premium Cars Showroom. Tất cả các quyền được bảo lưu.</p>
    </footer>
</body>
</html>