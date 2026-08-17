<?php
/**
 * Controller for route: car-detail
 */
use App\Models\Setting;
use App\Models\Car;
use App\Models\Lead;
use App\Core\Database;

// Fetch settings from database via Model
$settings = Setting::getAll();

// Validate car ID or slug parameter
$carId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$carSlug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$car = null;

if (!empty($carSlug)) {
    $car = Car::findBySlug($carSlug);
    
    // Automatic 301 Redirection to prevent broken links (SEO Redirection Plugin)
    if (!$car) {
        $db = Database::getConnection();
        $stmtRedir = $db->prepare("SELECT new_url FROM redirects WHERE old_url = ? LIMIT 1");
        $stmtRedir->execute([$carSlug]);
        $redir = $stmtRedir->fetch();
        if ($redir && !empty($redir['new_url'])) {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
            $queryParams = $_GET;
            unset($queryParams['slug']);
            $newQuery = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $basePath . "/xe-vinfast/" . urlencode($redir['new_url']) . $newQuery);
            exit;
        }
    }
}

if (!$car && $carId > 0) {
    $car = Car::find($carId);
}

if (!$car) {
    $basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    header('Location: ' . $basePath . '/dong-xe-vinfast');
    exit;
}

$carId = $car['id']; // Ensure carId is populated from the matched record

// Process ref_loc parameter for pSEO personalization
$refLoc = isset($_GET['ref_loc']) ? trim($_GET['ref_loc']) : '';
$refLocationName = '';
if (!empty($refLoc)) {
    require_once dirname(__DIR__) . '/includes/class-pseo-helper.php';
    $matchLoc = PSEO_Helper::findLocationOrProject($refLoc);
    if ($matchLoc) {
        $refLocationName = $matchLoc['display_name'];
    } else {
        $refLocationName = ucwords(str_replace('-', ' ', $refLoc));
    }
}

// Redirect raw GET access to clean URL
if ($car && !empty($car['slug']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    if (strpos($_SERVER['REQUEST_URI'] ?? '', 'car-detail.php') !== false) {
        $queryString = $_SERVER['QUERY_STRING'] ?? '';
        parse_str($queryString, $queryParams);
        unset($queryParams['id']); // Remove internal database id parameter
        $newQuery = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
        
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $basePath . "/xe-vinfast/" . $car['slug'] . $newQuery);
        exit;
    }
}


$successBooking = false;
$errorBooking = '';

// Handle Test Drive Booking Post Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'book_test_drive') {
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $preferredDate = isset($_POST['preferred_date']) ? trim($_POST['preferred_date']) : '';
    $testDriveType = isset($_POST['test_drive_type']) ? trim($_POST['test_drive_type']) : 'Tại Showroom';
    $testDriveAddress = isset($_POST['test_drive_address']) ? trim($_POST['test_drive_address']) : '';
    $websiteUrl = isset($_POST['website_url']) ? trim($_POST['website_url']) : '';
    
    if (!empty($websiteUrl)) {
        $successBooking = true;
    } elseif ($fullname && $phone) {
        $buildSheet = isset($_POST['vip_build_sheet']) ? trim($_POST['vip_build_sheet']) : '';
        $notes = "Đăng ký lái thử dòng xe " . $car['model_name'];
        if ($buildSheet) {
            $notes .= "\n" . $buildSheet;
        }
        if ($testDriveType === 'VIP tại nhà' && $testDriveAddress) {
            $notes .= "\n[Địa chỉ VIP giao xe]: " . $testDriveAddress;
        }

        try {
            // Save lead using Lead Model
            Lead::create([
                'car_id' => $carId,
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'preferred_date' => $preferredDate,
                'test_drive_type' => $testDriveType,
                'test_drive_address' => $testDriveAddress,
                'notes' => $notes
            ]);
            
            // Trigger Telegram Notification
            try {
                $teleMsg = "<b>🏎️ ĐĂNG KÝ LÁI THỬ XE (CHI TIẾT XE)</b>\n"
                         . "-----------------------------------\n"
                         . "👤 <b>Khách hàng:</b> " . htmlspecialchars($fullname) . "\n"
                         . "📞 <b>Số điện thoại:</b> " . htmlspecialchars($phone) . "\n"
                         . "📧 <b>Email:</b> " . htmlspecialchars($email) . "\n"
                         . "🚗 <b>Mẫu xe lái thử:</b> " . htmlspecialchars($car['model_name']) . "\n"
                         . "📅 <b>Ngày hẹn:</b> " . htmlspecialchars($preferredDate) . "\n"
                         . "📍 <b>Hình thức:</b> " . htmlspecialchars($testDriveType) . "\n";
                if ($testDriveType === 'VIP tại nhà' && $testDriveAddress) {
                    $teleMsg .= "🏠 <b>Địa chỉ nhà riêng:</b> " . htmlspecialchars($testDriveAddress) . "\n";
                }
                if (!empty($buildSheet)) {
                    $teleMsg .= "🛠️ <b>Cấu hình chọn thêm:</b> " . htmlspecialchars($buildSheet) . "\n";
                }
                $teleMsg .= "📝 <b>Ghi chú:</b> " . htmlspecialchars($notes) . "\n"
                           . "⏰ <b>Thời gian:</b> " . date('d/m/Y H:i:s');
                send_telegram_notification($teleMsg);
            } catch (Exception $teleEx) {}

            // Log administrative/system activity in activity_logs
            try {
                $db = Database::getConnection();
                $stmtLog = $db->prepare("INSERT INTO activity_logs (user_id, username, action, detail) VALUES (NULL, 'Khách hàng', 'Đăng ký Lái thử', ?)");
                $stmtLog->execute(["Khách hàng: $fullname đăng ký lái thử " . $car['model_name'] . ($buildSheet ? " ($buildSheet)" : "")]);
            } catch (Exception $logEx) {}
            
            $successBooking = true;
        } catch (Exception $e) {
            $errorBooking = 'Có lỗi xảy ra khi lưu thông tin đăng ký. Vui lòng thử lại!';
        }
    } else {
        $errorBooking = 'Vui lòng cung cấp đầy đủ Họ và tên và Số điện thoại liên hệ!';
    }
}

// Parse colors array: Glacier White|#ffffff, Mythos Black|#000000
$colorsRaw = isset($car['exterior_colors']) ? trim($car['exterior_colors']) : '';
$colorsList = [];
if ($colorsRaw) {
    $colorsArr = explode(',', $colorsRaw);
    foreach ($colorsArr as $colorStr) {
        $parts = explode('|', $colorStr);
        if (count($parts) === 2) {
            $colorsList[] = [
                'name' => trim($parts[0]),
                'hex' => trim($parts[1])
            ];
        }
    }
}

// Decode or fallback dynamic detailed features
$modelLower = mb_strtolower($car['model_name'] ?? '');

$coreFeatures = json_decode($car['core_features'] ?? '', true);
if (!is_array($coreFeatures) || count($coreFeatures) < 3) {
    $coreFeatures = [
        [
            "image" => "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=600&q=80",
            "tag" => "Smart Voice Assistant",
            "title" => "Trợ lý ảo tiếng Việt ViVi",
            "desc" => "Người bạn đồng hành thông minh, hỗ trợ điều khiển xe bằng giọng nói tiếng Việt đa vùng miền. Chỉ cần nói 'Hey VinFast', bạn có thể dễ dàng chỉnh điều hòa, bản đồ, nghe nhạc hay hỏi đáp mọi thông tin một cách tự nhiên nhất."
        ],
        [
            "image" => "https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&w=600&q=80",
            "tag" => "Safety & Intelligence",
            "title" => "Trợ lái nâng cao ADAS chuyên sâu",
            "desc" => "Gói công nghệ an toàn chủ động cao cấp giúp hỗ trợ phanh khẩn cấp, cảnh báo chệch làn, giữ làn đường, cảnh báo điểm mù và giám sát hành trình thích ứng, giúp giảm thiểu rủi ro va chạm trên đường cao tốc."
        ],
        [
            "image" => "https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=600&q=80",
            "tag" => "Electric Drive & Battery",
            "title" => "Hệ truyền động điện & Mạng lưới sạc",
            "desc" => "Động cơ điện mạnh mẽ cho mô-men xoắn tức thời không độ trễ kết hợp hệ thống pin tiên tiến. Khách hàng an tâm tuyệt đối nhờ mạng lưới 150.000 cổng sạc phủ rộng 63 tỉnh thành Việt Nam."
        ]
    ];
}

$techHighlights = json_decode($car['tech_highlights'] ?? '', true);
if (!is_array($techHighlights) || count($techHighlights) < 8) {
    $techHighlights = [
        ["icon" => "🔋", "title" => "Pin thông minh LFP/NMC", "desc" => "Công nghệ pin thế hệ mới với tuổi thọ cực cao, độ suy hao tối thiểu và an toàn tuyệt đối chống cháy nổ."],
        ["icon" => "⚡", "title" => "Hệ sạc siêu nhanh DC", "desc" => "Tiếp cận trạm sạc siêu nhanh công suất cao của VinFast toàn quốc, nạp đầy từ 10% lên 70% chỉ trong 25-30 phút."],
        ["icon" => "🌀", "title" => "Thu hồi năng lượng phanh", "desc" => "Hệ thống phanh tái sinh thông minh chuyển đổi động năng thừa khi giảm tốc thành điện năng sạc ngược lại vào pin."],
        ["icon" => "🔇", "title" => "Cabin tĩnh lặng tối đa", "desc" => "Tận hưởng không gian di chuyển êm ái, yên tĩnh nhờ động cơ điện không tiếng ồn và kính cách âm nhiều lớp."],
        ["icon" => "📐", "title" => "Thiết kế khí động học vượt trội", "desc" => "Hệ số cản gió tối thiểu nhờ các đường nét điêu khắc khí động học tinh tế, tối ưu hóa tầm hoạt động của pin xe."],
        ["icon" => "🔗", "title" => "Dẫn động AWD thông minh", "desc" => "Hệ dẫn động thông minh phân bổ lực kéo linh hoạt đến các trục bánh xe giúp tăng độ bám và kiểm soát tối ưu."],
        ["icon" => "🔮", "title" => "Buồng lái thông minh Smart Cabin", "desc" => "Màn hình giải trí cảm ứng sắc nét cỡ lớn, tích hợp quản lý hành trình, bản đồ dẫn đường dành riêng cho xe điện."],
        ["icon" => "🔊", "title" => "Hệ thống âm thanh sống động", "desc" => "Trải nghiệm âm nhạc rạp hát thu nhỏ với số lượng loa phân bổ đa hướng và tính năng điều chỉnh âm thanh thông minh."]
    ];
}

$ownerBenefits = json_decode($car['owner_benefits'] ?? '', true);
if (!is_array($ownerBenefits) || count($ownerBenefits) < 4) {
    $ownerBenefits = [
        ["title" => "Cảm xúc lái êm ái và mạnh mẽ", "desc" => "Hệ thống khung gầm cứng vững chịu lực cao kết hợp cùng động cơ điện mạnh mẽ mang lại cảm giác tăng tốc tức thì, êm ái và an tâm trên mọi hành trình."],
        ["title" => "Tấm khiên an toàn tiêu chuẩn quốc tế", "desc" => "Tuyệt đối an tâm bảo vệ gia đình nhờ hệ thống khung vỏ hấp thụ xung lực vững chắc kết hợp các túi khí quanh xe và gói trợ lái ADAS thông minh đạt các tiêu chuẩn an toàn quốc tế khắt khe nhất."],
        ["title" => "Tự hào biểu tượng chữ V kiêu hãnh", "desc" => "Sở hữu dòng xe ô tô điện thông minh mang logo chữ V kiêu hãnh đại diện cho niềm tự hào thương hiệu Việt, thể hiện phong cách sống xanh thời thượng và hiện đại."],
        ["title" => "Chính sách hậu mãi cực tốt", "desc" => "Đặc quyền bảo hành chính hãng lên tới 7 - 10 năm vượt trội, cùng dịch vụ cứu hộ khẩn cấp Roadside 24/7 và sửa chữa lưu động Mobile Service chuyên nghiệp bất kể ngày đêm."]
    ];
}

$siteTitle = !empty($car['seo_title']) ? htmlspecialchars($car['seo_title']) : "Giá Xe {model} | Trả Góp & Lăn Bánh Mới Nhất Tháng {month}/{year}";
$siteDesc = !empty($car['seo_desc']) ? htmlspecialchars($car['seo_desc']) : "Cập nhật bảng giá xe {model} lăn bánh mới nhất. Hỗ trợ mua xe trả góp lãi suất ưu đãi cực tốt chỉ từ 7.9%/năm, tư vấn duyệt hồ sơ nhanh, sẵn xe giao ngay tại VinFast Tam Phong.";
$seoCanonical = !empty($car['seo_canonical']) ? htmlspecialchars($car['seo_canonical']) : "";
$siteKeywords = !empty($car['focus_keyword']) ? htmlspecialchars($car['focus_keyword']) : "VinFast, {model}, giá xe {model}, trả góp {model}, mua xe {model} trả góp, giá lăn bánh {model}";
$pageBodyClass = 'page-car-detail';

return get_defined_vars();





