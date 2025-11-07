<?php
require_once 'config.php';

// Lấy filters từ URL
$brand_filter = isset($_GET['brand']) ? clean_input($_GET['brand']) : '';
$price_filter = isset($_GET['price']) ? clean_input($_GET['price']) : '';
$year_filter = isset($_GET['year']) ? clean_input($_GET['year']) : '';
$fuel_filter = isset($_GET['fuel']) ? clean_input($_GET['fuel']) : '';
$search = isset($_GET['search']) ? clean_input($_GET['search']) : '';

// Build SQL query với filters
$sql = "SELECT * FROM cars WHERE status = 'available'";
$conditions = [];

if ($brand_filter) {
    $conditions[] = "brand = '$brand_filter'";
}

if ($price_filter) {
    switch($price_filter) {
        case 'under_2b':
            $conditions[] = "price < 2000000000";
            break;
        case '2b_3b':
            $conditions[] = "price BETWEEN 2000000000 AND 3000000000";
            break;
        case '3b_5b':
            $conditions[] = "price BETWEEN 3000000000 AND 5000000000";
            break;
        case 'over_5b':
            $conditions[] = "price > 5000000000";
            break;
    }
}

if ($year_filter) {
    $conditions[] = "year >= $year_filter";
}

if ($fuel_filter) {
    $conditions[] = "fuel_type = '$fuel_filter'";
}

if ($search) {
    $conditions[] = "(name LIKE '%$search%' OR brand LIKE '%$search%' OR model LIKE '%$search%')";
}

if (count($conditions) > 0) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY created_at DESC";
$result = $conn->query($sql);

// Lấy danh sách brands
$brands_sql = "SELECT DISTINCT brand FROM cars ORDER BY brand";
$brands_result = $conn->query($brands_sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách xe - Premium Cars</title>
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
        
        /* Filter Section */
        .filter-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 40px;
        }
        
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .filter-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }
        
        .clear-filters {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 20px;
            border: 2px solid #667eea;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .clear-filters:hover {
            background: #667eea;
            color: white;
        }
        
        .search-box {
            margin-bottom: 25px;
        }
        
        .search-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        
        .filter-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .filter-select {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .filter-select:hover {
            border-color: #667eea;
        }
        
        .apply-filter-btn {
            grid-column: 1 / -1;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .apply-filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Results Header */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            color: white;
        }
        
        .results-count {
            font-size: 20px;
            font-weight: 600;
        }
        
        /* Cars Grid */
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 30px;
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
        
        .no-results {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .no-results-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .no-results h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .no-results p {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
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
            .page-header h1 {
                font-size: 32px;
            }
            
            .cars-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .results-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
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
            <h1>Bộ sưu tập xe cao cấp</h1>
            <p>Khám phá và lựa chọn chiếc xe phù hợp với bạn</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h2 class="filter-title">🔍 Tìm kiếm & Lọc</h2>
                <?php if($brand_filter || $price_filter || $year_filter || $fuel_filter || $search): ?>
                    <a href="cars.php" class="clear-filters">✖ Xóa bộ lọc</a>
                <?php endif; ?>
            </div>
            
            <form method="GET" action="cars.php">
                <div class="search-box">
                    <input type="text" name="search" class="search-input" 
                           placeholder="🔍 Tìm kiếm xe theo tên, hãng, model..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Hãng xe</label>
                        <select name="brand" class="filter-select">
                            <option value="">Tất cả hãng</option>
                            <?php while($brand = $brands_result->fetch_assoc()): ?>
                                <option value="<?php echo $brand['brand']; ?>" 
                                        <?php echo $brand_filter == $brand['brand'] ? 'selected' : ''; ?>>
                                    <?php echo $brand['brand']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Mức giá</label>
                        <select name="price" class="filter-select">
                            <option value="">Tất cả mức giá</option>
                            <option value="under_2b" <?php echo $price_filter == 'under_2b' ? 'selected' : ''; ?>>
                                Dưới 2 tỷ
                            </option>
                            <option value="2b_3b" <?php echo $price_filter == '2b_3b' ? 'selected' : ''; ?>>
                                2 - 3 tỷ
                            </option>
                            <option value="3b_5b" <?php echo $price_filter == '3b_5b' ? 'selected' : ''; ?>>
                                3 - 5 tỷ
                            </option>
                            <option value="over_5b" <?php echo $price_filter == 'over_5b' ? 'selected' : ''; ?>>
                                Trên 5 tỷ
                            </option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Năm sản xuất</label>
                        <select name="year" class="filter-select">
                            <option value="">Tất cả năm</option>
                            <option value="2024" <?php echo $year_filter == '2024' ? 'selected' : ''; ?>>2024 trở lên</option>
                            <option value="2023" <?php echo $year_filter == '2023' ? 'selected' : ''; ?>>2023 trở lên</option>
                            <option value="2022" <?php echo $year_filter == '2022' ? 'selected' : ''; ?>>2022 trở lên</option>
                            <option value="2021" <?php echo $year_filter == '2021' ? 'selected' : ''; ?>>2021 trở lên</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Nhiên liệu</label>
                        <select name="fuel" class="filter-select">
                            <option value="">Tất cả loại</option>
                            <option value="Xăng" <?php echo $fuel_filter == 'Xăng' ? 'selected' : ''; ?>>Xăng</option>
                            <option value="Dầu" <?php echo $fuel_filter == 'Dầu' ? 'selected' : ''; ?>>Dầu Diesel</option>
                            <option value="Hybrid" <?php echo $fuel_filter == 'Hybrid' ? 'selected' : ''; ?>>Hybrid</option>
                            <option value="Điện" <?php echo $fuel_filter == 'Điện' ? 'selected' : ''; ?>>Điện</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="apply-filter-btn">🔍 Áp dụng bộ lọc</button>
                </div>
            </form>
        </div>

        <!-- Results -->
        <div class="results-header">
            <div class="results-count">
                Tìm thấy <strong><?php echo $result->num_rows; ?></strong> xe
            </div>
        </div>

        <?php if($result->num_rows > 0): ?>
        <div class="cars-grid">
            <?php while($car = $result->fetch_assoc()): ?>
            <div class="car-card">
                <img src="<?php echo $car['image_url']; ?>" alt="<?php echo $car['name']; ?>" class="car-image">
                <div class="car-info">
                    <div class="car-brand"><?php echo $car['brand']; ?></div>
                    <h3 class="car-name"><?php echo $car['name']; ?></h3>
                    
                    <div class="car-specs">
                        <div class="spec-item">📅 Năm: <?php echo $car['year']; ?></div>
                        <div class="spec-item">⚡ <?php echo $car['transmission']; ?></div>
                        <div class="spec-item">👥 <?php echo $car['seats']; ?> chỗ</div>
                        <div class="spec-item">⛽ <?php echo $car['fuel_type']; ?></div>
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
        <?php else: ?>
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h3>Không tìm thấy xe phù hợp</h3>
            <p>Vui lòng thử lại với các tiêu chí tìm kiếm khác</p>
            <a href="cars.php" class="btn btn-primary">Xem tất cả xe</a>
        </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2024 Premium Cars Showroom. Tất cả các quyền được bảo lưu.</p>
    </footer>
</body>
</html>