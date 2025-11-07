<?php
require_once '../config.php';

if (!isAdmin()) {
    redirect('login.php');
}

// Thống kê
$stats = [];
$stats['total_cars'] = $conn->query("SELECT COUNT(*) as count FROM cars")->fetch_assoc()['count'];
$stats['total_users'] = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$stats['total_bookings'] = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$stats['pending_bookings'] = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status='pending'")->fetch_assoc()['count'];
$stats['total_contacts'] = $conn->query("SELECT COUNT(*) as count FROM contacts WHERE status='new'")->fetch_assoc()['count'];

// Lấy booking gần đây
$recent_bookings = $conn->query("SELECT b.*, u.fullname, u.email, c.name as car_name 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN cars c ON b.car_id = c.id 
    ORDER BY b.created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Premium Cars</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
        }
        
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 30px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-logo {
            text-align: center;
            font-size: 32px;
            margin-bottom: 10px;
        }
        
        .sidebar-title {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 40px;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 15px 30px;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            border-left-color: white;
            color: white;
        }
        
        .admin-user {
            padding: 20px 30px;
            border-top: 1px solid rgba(255,255,255,0.2);
            margin-top: 40px;
        }
        
        .admin-user-name {
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .logout-btn {
            display: block;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 40px;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        h1 {
            font-size: 32px;
            color: #2c3e50;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }
        
        .stat-icon {
            font-size: 42px;
            margin-bottom: 15px;
        }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
            font-weight: 500;
        }
        
        /* Recent Bookings */
        .section-title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
        }
        
        .bookings-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #f8f9fa;
            padding: 18px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
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
        
        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="sidebar">
            <div class="sidebar-logo">👨‍💼</div>
            <div class="sidebar-title">Admin Panel</div>
            
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
                <li><a href="manage-cars.php">🚗 Quản lý xe</a></li>
                <li><a href="manage-bookings.php">📅 Quản lý đặt lịch</a></li>
                <li><a href="manage-users.php">👥 Khách hàng</a></li>
                <li><a href="manage-contacts.php">📧 Liên hệ</a></li>
                <li><a href="../index.php">🏠 Về trang chủ</a></li>
            </ul>
            
            <div class="admin-user">
                <div class="admin-user-name">Admin: <?php echo $_SESSION['admin_username']; ?></div>
                <a href="../logout.php" class="logout-btn">Đăng xuất</a>
            </div>
        </aside>
        
        <main class="main-content">
            <div class="top-bar">
                <h1>Dashboard</h1>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🚗</div>
                    <div class="stat-value"><?php echo $stats['total_cars']; ?></div>
                    <div class="stat-label">Tổng số xe</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value"><?php echo $stats['total_users']; ?></div>
                    <div class="stat-label">Khách hàng</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-value"><?php echo $stats['total_bookings']; ?></div>
                    <div class="stat-label">Tổng đặt lịch</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">⏳</div>
                    <div class="stat-value"><?php echo $stats['pending_bookings']; ?></div>
                    <div class="stat-label">Chờ xử lý</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">📧</div>
                    <div class="stat-value"><?php echo $stats['total_contacts']; ?></div>
                    <div class="stat-label">Liên hệ mới</div>
                </div>
            </div>
            
            <h2 class="section-title">Đặt lịch gần đây</h2>
            <div class="bookings-table">
                <table>
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Xe</th>
                            <th>Ngày hẹn</th>
                            <th>Giờ</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($booking = $recent_bookings->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <strong><?php echo $booking['fullname']; ?></strong><br>
                                <small><?php echo $booking['email']; ?></small>
                            </td>
                            <td><?php echo $booking['car_name']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($booking['booking_date'])); ?></td>
                            <td><?php echo date('H:i', strtotime($booking['booking_time'])); ?></td>
                            <td>
                                <?php
                                $status_class = 'status-' . $booking['status'];
                                $status_text = [
                                    'pending' => 'Chờ xử lý',
                                    'confirmed' => 'Đã xác nhận',
                                    'cancelled' => 'Đã hủy'
                                ];
                                ?>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_text[$booking['status']]; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>