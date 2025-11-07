<?php
require_once 'config.php';

// Lấy danh sách xe
$sql = "SELECT * FROM cars WHERE status = 'available' ORDER BY created_at DESC LIMIT 6";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Showroom Ô Tô Cao Cấp</title>
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
            position: relative;
        }
        
        .nav-links a:hover {
            color: #667eea;
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #667eea;
            transition: width 0.3s;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .btn {
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }
        
        .btn-outline {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }
        
        .btn-outline:hover {
            background: #667eea;
            color: white;
        }
        
        /* Hero Section */
        .hero {
            max-width: 1400px;
            margin: 60px auto;
            padding: 80px 30px;
            text-align: center;
            color: white;
        }
        
        .hero h1 {
            font-size: 56px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .hero p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.95;
        }
        
        /* Cars Grid */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 30px;
        }
        
        .section-title {
            text-align: center;
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 50px;
            color: white;
        }
        
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .car-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: all 0.4s;
            cursor: pointer;
        }
        
        .car-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }
        
        .car-image {
            width: 100%;
            height: 260px;
            object-fit: cover;
        }
        
        .car-info {
            padding: 25px;
        }
        
        .car-brand {
            color: #667eea;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .car-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }
        
        .car-specs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin: 20px 0;
            padding: 20px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }
        
        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
        }
        
        .spec-icon {
            width: 18px;
            height: 18px;
            color: #667eea;
        }
        
        .car-price {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
            margin: 15px 0;
        }
        
        .car-actions {
            display: flex;
            gap: 10px;
        }
        
        .car-actions .btn {
            flex: 1;
            text-align: center;
            font-size: 14px;
            padding: 12px 20px;
        }
        
        /* Footer */
        footer {
            background: rgba(0,0,0,0.3);
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 80px;
        }
        
        .user-info {
            color: #667eea;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 36px;
            }
            
            .cars-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                flex-direction: column;
                gap: 15px;
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
                    <li><span class="user-info">Xin chào, <?php echo $_SESSION['user_name']; ?></span></li>
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

    <section class="hero">
        <h1>Showroom Ô Tô Cao Cấp</h1>
        <p>Khám phá bộ sưu tập xe sang trọng và hiện đại nhất</p>
        <a href="cars.php" class="btn btn-primary" style="font-size: 18px; padding: 15px 40px;">Xem tất cả xe</a>
    </section>

    <div class="container">
        <h2 class="section-title">Xe Mới Nhất</h2>
        <div class="cars-grid">
            <?php while($car = $result->fetch_assoc()): ?>
            <div class="car-card">
                <img src="<?php echo $car['image_url']; ?>" alt="<?php echo $car['name']; ?>" class="car-image">
                <div class="car-info">
                    <div class="car-brand"><?php echo $car['brand']; ?></div>
                    <h3 class="car-name"><?php echo $car['name']; ?></h3>
                    
                    <div class="car-specs">
                        <div class="spec-item">
                            <svg class="spec-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Năm: <?php echo $car['year']; ?>
                        </div>
                        <div class="spec-item">
                            <svg class="spec-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <?php echo $car['transmission']; ?>
                        </div>
                        <div class="spec-item">
                            <svg class="spec-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <?php echo $car['seats']; ?> chỗ
                        </div>
                        <div class="spec-item">
                            <svg class="spec-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            <?php echo $car['fuel_type']; ?>
                        </div>
                    </div>
                    
                    <div class="car-price"><?php echo format_vnd($car['price']); ?></div>
                    
                    <div class="car-actions">
                        <a href="car-detail.php?id=<?php echo $car['id']; ?>" class="btn btn-outline">Chi tiết</a>
                        <a href="booking.php?car_id=<?php echo $car['id']; ?>" class="btn btn-primary">Đặt lịch xem</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Premium Cars Showroom. Tất cả các quyền được bảo lưu.</p>
    </footer>
</body>
</html>