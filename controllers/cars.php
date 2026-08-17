<?php
/**
 * Controller for route: cars
 * Optimized for High-Ranking On-Page SEO (Keywords: Các Dòng Xe VinFast, Bảng Giá Xe VinFast 2026, Xe Điện VinFast)
 */

// Fetch SEO settings from database
$stmt = $db->query("SELECT * FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['key']] = $row['value'];
}

// On-Page SEO Meta Title & Meta Description Blueprint for 2026 (Perfect Length: 153 chars)
$siteTitle = "Bảng Giá Các Dòng Xe VinFast 2026 | Xe Ô Tô Điện Chính Hãng";
$siteDesc = "Bảng giá tất cả dòng xe ô tô điện VinFast 2026: VF 3, VF 5, VF 6, VF 7, VF 8, VF 9. Hỗ trợ trả góp 85%, ưu đãi độc quyền tại đại lý VinFast Tam Phong.";

// Query all cars
$stmtCars = $db->query("SELECT * FROM cars ORDER BY id ASC");
$cars = $stmtCars->fetchAll();

// Handle VIP Test Drive Form Submission
$successBookingMessage = '';
$errorBookingMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'book_test_drive') {
    $fullname = trim($_POST['fullname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $car_id = (int)($_POST['car_id'] ?? 0);
    $preferred_date = trim($_POST['preferred_date'] ?? '');
    
    if ($fullname && $phone && $car_id > 0) {
        try {
            $stmtInsert = $db->prepare("INSERT INTO leads (car_id, fullname, phone, email, preferred_date, test_drive_type, test_drive_address) VALUES (?, ?, ?, ?, ?, 'Tại Showroom', '')");
            $stmtInsert->execute([$car_id, $fullname, $phone, $email, $preferred_date]);
            
            // Fetch car name for detailed logging
            $stmtCar = $db->prepare("SELECT model_name FROM cars WHERE id = ?");
            $stmtCar->execute([$car_id]);
            $carModel = $stmtCar->fetchColumn() ?: 'Mẫu xe VinFast';
            
            // Trigger Telegram Notification
            try {
                $teleMsg = "<b>ĐĂNG KÝ LÁI THỬ XE (DANH SÁCH XE)</b>\n"
                         . "-----------------------------------\n"
                         . "Khách hàng: " . htmlspecialchars($fullname) . "\n"
                         . "Số điện thoại: " . htmlspecialchars($phone) . "\n"
                         . "Email: " . htmlspecialchars($email) . "\n"
                         . "Mẫu xe lái thử: " . htmlspecialchars($carModel) . "\n"
                         . "Ngày hẹn: " . htmlspecialchars($preferred_date) . "\n"
                         . "Hình thức: Tại Showroom\n"
                         . "Thời gian: " . date('d/m/Y H:i:s');
                send_telegram_notification($teleMsg);
            } catch (Exception $teleEx) {}

            // Log activity
            try {
                $stmtLog = $db->prepare("INSERT INTO activity_logs (user_id, username, action, detail) VALUES (NULL, 'Khách hàng', 'Đăng ký Lái thử', ?)");
                $stmtLog->execute(["Khách hàng: $fullname đăng ký lái thử $carModel (Lịch hẹn: $preferred_date)"]);
            } catch (Exception $logEx) {}
            
            $successBookingMessage = 'Chúc mừng! Yêu cầu đăng ký lái thử xe VIP của bạn đã được gửi thành công. Cố vấn VinFast sẽ liên hệ xác nhận trong vòng 15 phút.';
        } catch (Exception $e) {
            $errorBookingMessage = 'Hệ thống đang bận. Vui lòng liên hệ Hotline cứu hộ hoặc thử lại sau!';
        }
    } else {
        $errorBookingMessage = 'Vui lòng nhập đầy đủ Họ tên, Số điện thoại và chọn Dòng xe mong muốn!';
    }
}

$pageBodyClass = 'page-cars';

return get_defined_vars();