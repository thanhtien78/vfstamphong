<?php
/**
 * VinFast Premium CRM AJAX Lead Handler
 * Captures, sanitizes, and records customer leads from the global VIP popup.
 */
use App\Models\Lead;
use App\Models\Car;
use App\Core\Database;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $car_id = isset($_POST['car_id']) ? (int)$_POST['car_id'] : 0;
    $loc_name = isset($_POST['loc_name']) ? trim($_POST['loc_name']) : '';
    $loc_slug = isset($_POST['loc_slug']) ? trim($_POST['loc_slug']) : '';
    $website_url = isset($_POST['website_url']) ? trim($_POST['website_url']) : '';
    
    if (!empty($website_url)) {
        echo json_encode(['success' => true, 'message' => 'Đăng ký thành công! Chuyên viên cố vấn VinFast sẽ liên hệ tới quý khách trong vòng 15 phút.']);
        exit;
    }
    
    if (empty($fullname) || empty($phone) || $car_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng cung cấp đầy đủ thông tin bắt buộc!']);
        exit;
    }
    
    try {
        // Fetch car name via Model
        $carName = Car::getNameById($car_id);
        
        // Dynamic CRM Tagging based on location details
        if (!empty($loc_name)) {
            $notes = "[Đăng ký từ Vệ tinh pSEO] Khách hàng thuộc khu vực: $loc_name (Slug: $loc_slug). Dòng xe quan tâm: $carName";
        } else {
            $notes = "[Đăng ký từ VIP Popup] Khách hàng muốn nhận ưu đãi và tư vấn đặc quyền cho dòng xe: $carName";
        }
        
        // Save lead using Lead Model
        Lead::create([
            'car_id' => $car_id,
            'fullname' => $fullname,
            'phone' => $phone,
            'email' => '',
            'notes' => $notes,
            'status' => 'Chưa liên hệ'
        ]);
        
        // Trigger Telegram Notification
        try {
            $teleMsg = "<b>🔔 ĐĂNG KÝ NHẬN TƯ VẤN MỚI (VIP POPUP/pSEO)</b>\n"
                     . "-----------------------------------\n"
                     . "👤 <b>Khách hàng:</b> " . htmlspecialchars($fullname) . "\n"
                     . "📞 <b>Số điện thoại:</b> " . htmlspecialchars($phone) . "\n"
                     . "🚗 <b>Dòng xe quan tâm:</b> " . htmlspecialchars($carName) . "\n";
            if (!empty($loc_name)) {
                $teleMsg .= "📍 <b>Khu vực:</b> " . htmlspecialchars($loc_name) . " (" . htmlspecialchars($loc_slug) . ")\n";
            }
            $teleMsg .= "📝 <b>Ghi chú:</b> " . htmlspecialchars($notes) . "\n"
                      . "⏰ <b>Thời gian:</b> " . date('d/m/Y H:i:s');
            send_telegram_notification($teleMsg);
        } catch (Exception $teleEx) {}
        
        // Administrative activity log entry
        try {
            $db = Database::getConnection();
            if (!empty($loc_name)) {
                $stmtLog = $db->prepare("INSERT INTO activity_logs (user_id, username, action, detail) VALUES (NULL, 'Khách hàng', 'Đăng ký pSEO VIP', ?)");
                $stmtLog->execute(["Khách hàng: $fullname tại khu vực $loc_name đăng ký nhận báo giá dòng xe $carName"]);
            } else {
                $stmtLog = $db->prepare("INSERT INTO activity_logs (user_id, username, action, detail) VALUES (NULL, 'Khách hàng', 'Đăng ký VIP Popup', ?)");
                $stmtLog->execute(["Khách hàng: $fullname đăng ký nhận báo giá $carName qua VIP Popup"]);
            }
        } catch (Exception $logEx) {}
        
        echo json_encode(['success' => true, 'message' => 'Đăng ký thành công! Chuyên viên cố vấn VinFast sẽ liên hệ tới quý khách trong vòng 15 phút.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra trong hệ thống. Vui lòng liên hệ hotline hoặc thử lại sau!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ!']);
}
?>




