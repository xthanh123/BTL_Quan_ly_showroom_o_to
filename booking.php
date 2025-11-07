<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';
$car_id = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;

// Lấy thông tin xe
$car_sql = "SELECT * FROM cars WHERE id = $car_id";
$car_result = $conn->query($car_sql);

if ($car_result->num_rows == 0) {
    redirect('cars.php');
}

$car = $car_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $booking_date = clean_input($_POST['booking_date']);
    $booking_time = clean_input($_POST['booking_time']);
    $message = clean_input($_POST['message']);
    
    $sql = "INSERT INTO bookings (user_id, car_id, booking_date, booking_time, message) 
            VALUES ($user_id, $car_id, '$booking_date', '$booking_time', '$message')";
    
    if ($conn->query($sql)) {
        $success = 'Đặt lịch thành công! Chúng tôi sẽ liên hệ với bạn sớm.';
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
    <title>Đặt lịch xem xe - <?php echo $car['name']; ?></title>
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
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .booking-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        
        .booking-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        
        .booking-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .booking-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
        }
        
        .car-info-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
        }
        
        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        
        .car-name {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        
        .car-price {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .car-specs {
            display: grid;
            gap: 12px;
        }
        
        .spec-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .spec-label {
            color: #666;
            font-weight: 500;
        }
        
        .spec-value {
            color: #333;
            font-weight: 600;
        }
        
        .form-section h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 25px;
        }
        
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
        
        input[type="date"],
        input[type="time"],
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
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
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
        
        .back-link {
            display: inline-block;
            margin: 20px 40px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .booking-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <div class="booking-header">
            <h1>Đặt lịch xem xe</h1>
            <p>Chọn thời gian phù hợp để trải nghiệm xe tại showroom</p>
        </div>
        
        <a href="index.php" class="back-link">← Quay lại</a>
        
        <div class="booking-content">
            <div class="car-info-section">
                <img src="<?php echo $car['image_url']; ?>" alt="<?php echo $car['name']; ?>" class="car-image">
                <div class="car-name"><?php echo $car['name']; ?></div>
                <div class="car-price"><?php echo format_vnd($car['price']); ?></div>
                
                <div class="car-specs">
                    <div class="spec-item">
                        <span class="spec-label">Thương hiệu</span>
                        <span class="spec-value"><?php echo $car['brand']; ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Năm sản xuất</span>
                        <span class="spec-value"><?php echo $car['year']; ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Hộp số</span>
                        <span class="spec-value"><?php echo $car['transmission']; ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Nhiên liệu</span>
                        <span class="spec-value"><?php echo $car['fuel_type']; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h2>Thông tin đặt lịch</h2>
                
                <?php if($error): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if($success): ?>
                    <div class="success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="booking_date">Ngày xem xe *</label>
                        <input type="date" id="booking_date" name="booking_date" 
                               min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="booking_time">Giờ xem xe *</label>
                        <input type="time" id="booking_time" name="booking_time" 
                               min="08:00" max="18:00" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Ghi chú (không bắt buộc)</label>
                        <textarea id="message" name="message" 
                                  placeholder="Nhập yêu cầu đặc biệt hoặc câu hỏi của bạn..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn">Xác nhận đặt lịch</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>