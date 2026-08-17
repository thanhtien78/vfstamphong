<?php
/**
 * Controller for route: home
 */
use App\Models\Setting;
use App\Models\Counselor;
use App\Models\News;
use App\Models\Car;
use App\Models\Lead;

// Fetch settings from database via Model
$settings = Setting::getAll();

// Global configurations & SEO Meta
$siteTitle = $settings['site_title'] ?? "VinFast Việt Nam - Cổng thông tin chính thức";
$siteDesc = $settings['site_desc'] ?? "Khám phá các mẫu xe VinFast sang trọng, EV thuần điện và đặc quyền di chuyển xanh đẳng cấp chính hãng.";
$siteKeywords = $settings['site_keywords'] ?? "VinFast, VinFast vietnam, VinFast EV, VinFast VF 9, VinFast VF 8";
$seoCanonical = $settings['site_canonical'] ?? "";

$heroHeadline = $settings['hero_headline'] ?? "Ưu đãi chào hè - Sẵn sàng cho những hành trình mới";
$heroSubline = $settings['hero_subline'] ?? "Trị giá lên đến 300 triệu đồng.";
$heroBtn1 = $settings['hero_btn1'] ?? "Khám phá ưu đãi đặc biệt";
$heroBtn2 = $settings['hero_btn2'] ?? "Đăng ký trải nghiệm xe VinFast";

$s6Headline = $settings['s6_headline'] ?? "VinFast Việt Nam giới thiệu VinFast VF 9 - Mẫu SUV thuần điện phân khúc E hạng sang đầu tiên tại Việt Nam, mở ra kỷ nguyên di chuyển xanh.";
$s6Desc = $settings['s6_desc'] ?? "<p>Đây là cột mốc quan trọng trong chiến lược điện hóa của thương hiệu, đồng thời khẳng định định hướng mang đến trải nghiệm di chuyển bền vững nhưng vẫn giữ trọn DNA hiệu suất, công nghệ và sự sang trọng đặc trưng của VinFast. Giá khởi điểm từ 1.560.000.000 VNĐ.</p>";

$agencyName = $settings['agency_name'] ?? "VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh";
$agencyPhone = $settings['agency_phone'] ?? "081.7777.855";
$agencyAddress = $settings['agency_address'] ?? "6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh";
$agencyHours = $settings['agency_hours'] ?? "Thứ 2 - Thứ 7: 8:00 - 18:00 | Chủ Nhật: 9:00 - 17:00";

// Decode dynamic homepage section config variables with robust error fallbacks
$s5_privileges_data = json_decode($settings['s5_privileges'] ?? '', true);
if (!is_array($s5_privileges_data) || count($s5_privileges_data) < 4) {
    $s5_privileges_data = [
        ["watermark" => "Warranty", "title" => "Bảo hành 3 năm vô hạn km", "desc" => "Yên tâm tuyệt đối với chế độ bảo hành chính hãng toàn cầu không giới hạn quãng đường di chuyển.", "link_text" => "Tìm hiểu chính sách", "link_href" => "#catalog-block"],
        ["watermark" => "EV", "title" => "Độc quyền sạc nhanh EV", "desc" => "Truy cập hệ thống trạm sạc nhanh cao cấp công suất lớn phủ sóng rộng rãi tại các showroom VinFast Việt Nam.", "link_text" => "Hệ thống trạm sạc", "link_href" => "#catalog-block"],
        ["watermark" => "Roadside", "title" => "Cứu hộ VinFast Roadside 24/7", "desc" => "Đội ngũ kỹ sư hỗ trợ ứng cứu khẩn cấp trên mọi cung đường Việt Nam bất kể ngày đêm.", "link_text" => "Hotline cứu trợ", "link_href" => "#tradein-block"],
        ["watermark" => "Trade-in", "title" => "Chính sách thu cũ đổi mới", "desc" => "Định giá xe cũ minh bạch và hỗ trợ lên đời dòng xe VinFast thế hệ mới với nhiều ưu đãi đặc quyền.", "link_text" => "Đăng ký định giá", "link_href" => "#tradein-block"]
    ];
}

$s6_signature_quote = $settings['s6_signature_quote'] ?? 'Mỗi hành trình cùng VinFast không chỉ đơn thuần là di chuyển, đó là lời khẳng định về một phong cách sống thời thượng, sự an tâm tuyệt đối trên mọi nẻo đường và đặc quyền dịch vụ chuẩn 5 sao toàn cầu.';

$s6_reasons_data = json_decode($settings['s6_reasons'] ?? '', true);
if (!is_array($s6_reasons_data) || count($s6_reasons_data) < 4) {
    $s6_reasons_data = [
        ["title" => "100% Sản Xuất Tại Việt Nam", "desc" => "Đảm bảo nguồn gốc xuất xứ chính hãng từ tổ hợp nhà máy xe điện hiện đại bậc nhất của VinFast tại Hải Phòng, đầy đủ hồ sơ thông quan Hải quan (C/O, C/Q) minh bạch tuyệt đối."],
        ["title" => "Đội Ngũ Kỹ Sư Đạt Chuẩn Toàn Cầu", "desc" => "Đội ngũ cố vấn kỹ thuật và thợ máy chuyên trách được đào tạo bài bản, kiểm tra khắt khe và cấp chứng chỉ trực tiếp từ VinFast Việt Nam theo chuẩn quốc tế."],
        ["title" => "Hỗ Trợ Thủ Tục Siêu Tốc", "desc" => "Đội ngũ chuyên viên chuyên nghiệp hỗ trợ trọn gói mọi thủ tục đăng ký biển số, đăng kiểm lưu hành, dịch vụ tài chính liên kết và giao xe tận nhà chu đáo."],
        ["title" => "Showroom Đạt Chuẩn Quốc Tế", "desc" => "Hệ thống cơ sở hạ tầng, phòng trưng bày sang trọng theo nhận diện toàn cầu (VinFast Terminal), mang lại không gian trải nghiệm dịch vụ đỉnh cao 5 sao."]
    ];
}

$s8_offers_data = json_decode($settings['s8_offers'] ?? '', true);
if (!is_array($s8_offers_data) || count($s8_offers_data) < 4) {
    $s8_offers_data = [
        [
            "tag" => "CHÀO HÈ 2026",
            "title" => "Hỗ trợ lệ phí trước bạ",
            "desc" => "Ưu đãi lên tới 100% lệ phí trước bạ hoặc khấu trừ trực tiếp giá trị giao dịch lên tới 300 triệu đồng áp dụng cho một số dòng xe xăng.",
            "bullets" => [
                "Áp dụng cho các dòng sedan và SUV VinFast Lux A2.0, Lux SA2.0 chính hãng",
                "Hỗ trợ thực hiện nhanh trọn gói mọi thủ tục nộp thuế siêu tốc",
                "Sẵn sàng phương án quy trừ trực tiếp vào giá trị hợp đồng thanh toán"
            ]
        ],
        [
            "tag" => "EV PRIVILEGE",
            "title" => "Đặc quyền sạc pin 1 năm",
            "desc" => "Miễn phí hoàn toàn chi phí sạc pin tại tất cả trạm sạc nhanh của hệ thống đại lý VinFast Việt Nam trong 12 tháng đầu tiên kể từ khi nhận xe điện.",
            "bullets" => [
                "Áp dụng tại trạm sạc nhanh DC 180kW cao cấp nhất toàn quốc",
                "Đặc quyền cung ứng sạc điện lưu động cứu hộ khẩn cấp 24/7",
                "Giám sát dung lượng và chỉ đường trạm sạc thông minh qua ứng dụng"
            ]
        ],
        [
            "tag" => "VinFast ACCESSORIES",
            "title" => "Gói phụ kiện chính hãng",
            "desc" => "Tặng ngay bộ thảm sàn cao cấp thiết kế riêng, dù che nắng VinFast Collection, móc khóa da cao cấp cùng gói phủ Ceramic bảo vệ bề mặt sơn.",
            "bullets" => [
                "Bộ thảm sàn chất liệu cao cấp thiết kế riêng chuẩn khí động học của xe",
                "Gói phủ bảo vệ sơn ngoại thất Ceramic chuyên sâu tăng cứng bảo hành hãng",
                "Bộ quà tặng thương hiệu VinFast Collection thời thượng đẳng cấp quốc tế"
            ]
        ],
        [
            "tag" => "VinFast CLUB VIP",
            "title" => "Thẻ thành viên VIP đặc quyền",
            "desc" => "Hòa mình vào cộng đồng VinFast Club Vietnam, nhận ưu đãi giảm giá độc quyền tại các khách sạn 5 sao, khu resort cao cấp và sân golf hàng đầu.",
            "bullets" => [
                "Thẻ đặc quyền kết nối cộng đồng chủ nhân xe VinFast thượng lưu toàn quốc",
                "Ưu đãi giảm tới 25% các dịch vụ nghỉ dưỡng cao cấp, golf, ẩm thực",
                "Thư mời tham dự đặc quyền mọi sự kiện giới thiệu dòng xe mới và âm nhạc"
            ]
        ]
    ];
}

// Decode homepage FAQs with robust fallback values
$homepageFaqsJson = $settings['homepage_faqs'] ?? '';
$homeFaqs = json_decode($homepageFaqsJson, true);
if (!is_array($homeFaqs) || empty($homeFaqs)) {
    $homeFaqs = [
        [
            "question" => "Thời gian sạc nhanh xe điện tại Đại lý VinFast Tam Phong là bao lâu?",
            "answer" => "Tại hệ thống trạm sạc siêu nhanh công suất cao của Đại lý VinFast Tam Phong, quý khách có thể sạc pin xe điện từ 10% lên 70% chỉ trong khoảng 22 - 30 phút. Quý khách cũng có thể mua các bộ sạc AC tại nhà chính hãng do Đại lý VinFast Tam Phong cung cấp để sạc đầy xe tiện lợi qua đêm từ 6 đến 8 tiếng."
        ],
        [
            "question" => "Chính sách bảo hành và thuê pin xe điện tại Đại lý VinFast Tam Phong có gì đặc biệt?",
            "answer" => "Đại lý VinFast Tam Phong áp dụng đầy đủ chính sách bảo hành chính hãng của VinFast Việt Nam lên đến 10 năm hoặc 200.000 km cho xe và bảo hành pin trọn đời/8-10 năm tùy dòng xe. Đội ngũ cố vấn dịch vụ tại Đại lý VinFast Tam Phong sẽ hỗ trợ làm thủ tục thuê pin linh hoạt, tối ưu chi phí sử dụng cho quý khách hàng."
        ],
        [
            "question" => "Đại lý VinFast Tam Phong có hỗ trợ mua xe ô tô điện trả góp qua ngân hàng không?",
            "answer" => "Có. Đại lý VinFast Tam Phong liên kết chặt chẽ với các đối tác ngân hàng lớn (Vietcombank, Techcombank, Shinhan Bank...) mang đến gói trả góp độc quyền hỗ trợ vay tới 80% giá trị xe, thời hạn lên đến 8 năm với lãi suất ưu đãi cố định và thủ tục duyệt hồ sơ siêu tốc chỉ trong 4 giờ làm việc."
        ],
        [
            "question" => "Chi phí bảo dưỡng định kỳ xe ô tô điện tại xưởng dịch vụ Đại lý VinFast Tam Phong là bao nhiêu?",
            "answer" => "Xưởng dịch vụ 3S của Đại lý VinFast Tam Phong cung cấp gói dịch vụ bảo dưỡng đạt chuẩn quốc tế với chi phí tối ưu. Xe điện có chi phí bảo dưỡng định kỳ cực kỳ tiết kiệm, thấp hơn từ 30% đến 50% so với xe xăng do không cần thay dầu máy, lọc dầu, bugi định kỳ."
        ],
        [
            "question" => "Đại lý VinFast Tam Phong có hỗ trợ giao xe tận nhà và tổ chức lễ bàn giao VIP không?",
            "answer" => "Có. Đại lý VinFast Tam Phong hỗ trợ vận chuyển xe chuyên dụng bàn giao tận nơi trên toàn quốc. Đặc biệt, quý khách mua xe sẽ được trải nghiệm lễ bàn giao VIP cá nhân hóa (Private Handover Ceremony) thiết kế riêng trong phòng chờ sang trọng của showroom Đại lý VinFast Tam Phong."
        ],
        [
            "question" => "Hạ tầng trạm sạc xe điện xung quanh Đại lý VinFast Tam Phong phân bổ ra sao?",
            "answer" => "Bên cạnh các cổng sạc siêu nhanh trực tiếp tại showroom của Đại lý VinFast Tam Phong, quý khách có thể dễ dàng tiếp cận mạng lưới hơn 150.000 cổng sạc VinFast phủ khắp 63 tỉnh thành Việt Nam, kết nối thuận tiện ngay trên ứng dụng bản đồ trạm sạc thông minh được tích hợp sẵn trên xe."
        ]
    ];
}
$faqSchemaData = $homeFaqs;

// Load dynamic settings for Section 7 and 9 with robust defaults
$s7_tradein_title = $settings['s7_tradein_title'] ?? "Thu cũ đổi mới - Lên đời xe VinFast chính hãng";
$s7_tradein_desc = $settings['s7_tradein_desc'] ?? "Chương trình hỗ trợ độc quyền của đại lý VinFast dành cho quý khách hàng đang sở hữu bất kỳ hãng xe nào muốn đổi sang dòng xe VinFast mới đẳng cấp.";
$s7_default_counselor_name = $settings['s7_default_counselor_name'] ?? "Mr. Nguyễn Thành";
$s7_default_counselor_title = $settings['s7_default_counselor_title'] ?? "Chuyên viên tư vấn VIP";

$s7_tradein_steps_data = json_decode($settings['s7_tradein_steps'] ?? '', true);
if (!is_array($s7_tradein_steps_data) || count($s7_tradein_steps_data) < 3) {
    $s7_tradein_steps_data = [
        ["num" => "01", "title" => "Gửi Thông Tin Trực Tuyến", "desc" => "Điền thông số xe hiện tại và cách liên hệ của anh/chị tại biểu mẫu bên cạnh chỉ trong 1 phút."],
        ["num" => "02", "title" => "Thẩm Định Tại Nhà Miễn Phí", "desc" => "Đội ngũ kỹ sư thẩm định xe VinFast sẽ liên hệ trực tiếp và đến tận nhà thẩm định xe của anh/chị hoàn toàn miễn phí."],
        ["num" => "03", "title" => "Lên Đời Xe Giao Tận Nơi", "desc" => "Hưởng ưu đãi thu mua xe cũ giá cao nhất thị trường, khấu trừ trực tiếp vào giá xe VinFast mới và hỗ trợ giao xe tận nhà chu đáo."]
    ];
}



// Fetch one active counselor for Section 7 (Trade-in) VIP Concierge via Model
$homeCounselor = Counselor::getPrimary();

// Fetch up to 3 active counselors for Section 9 (Comparison Counselors) via Model
$compareCounselors = Counselor::getOnline(3);

// Fetch latest 3 news posts for clean homepage presentation via Model
$posts = News::getLatest(3);

// Fetch cars for comparison & calculator via Model
$compareCars = Car::all();

// Handle Trade-in / Old Car Valuation Request Submission
$successTradeIn = false;
$errorTradeIn = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'submit_trade_in') {
    $oldBrand = isset($_POST['old_brand']) ? trim($_POST['old_brand']) : '';
    $oldModel = isset($_POST['old_model']) ? trim($_POST['old_model']) : '';
    $oldYear = isset($_POST['old_year']) ? trim($_POST['old_year']) : '';
    $oldOdo = isset($_POST['old_odo']) ? trim($_POST['old_odo']) : '';
    $oldStatus = isset($_POST['old_status']) ? trim($_POST['old_status']) : '';
    $targetCarId = isset($_POST['target_car_id']) ? (int)$_POST['target_car_id'] : 0;
    $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $websiteUrl = isset($_POST['website_url']) ? trim($_POST['website_url']) : '';
    
    if (!empty($websiteUrl)) {
        // Silently fail/succeed for bot
        $successTradeIn = true;
    } elseif ($fullname && $phone && $oldBrand && $oldModel) {
        $notes = "YÊU CẦU THU CŨ ĐỔI MỚI (TRADE-IN):\n" .
                 "- Hãng xe cũ: " . $oldBrand . "\n" .
                 "- Dòng xe & Bản: " . $oldModel . " (Năm SX: " . $oldYear . ")\n" .
                 "- Số km đã đi: " . $oldOdo . " km\n" .
                 "- Tình trạng xe: " . $oldStatus . "\n" .
                 "- Khách đăng ký online qua Cổng thông tin.";
                 
        try {
            // Save lead using Lead Model
            Lead::create([
                'car_id' => $targetCarId,
                'fullname' => $fullname,
                'phone' => $phone,
                'email' => $email,
                'test_drive_type' => 'Thu cũ đổi mới',
                'notes' => $notes,
                'status' => 'Chưa liên hệ'
            ]);
            
            // Trigger Telegram Notification
            try {
                $targetCarName = Car::getNameById($targetCarId);

                $teleMsg = "<b>🔄 YÊU CẦU THU CŨ ĐỔI MỚI (TRADE-IN)</b>\n"
                         . "-----------------------------------\n"
                         . "👤 <b>Khách hàng:</b> " . htmlspecialchars($fullname) . "\n"
                         . "📞 <b>Số điện thoại:</b> " . htmlspecialchars($phone) . "\n"
                         . "📧 <b>Email:</b> " . htmlspecialchars($email) . "\n"
                         . "🚗 <b>Dòng xe VinFast muốn đổi sang:</b> " . htmlspecialchars($targetCarName) . "\n"
                         . "📝 <b>Chi tiết xe cũ:</b>\n"
                         . "  - Hãng xe: " . htmlspecialchars($oldBrand) . "\n"
                         . "  - Model & Phiên bản: " . htmlspecialchars($oldModel) . " (Đời " . htmlspecialchars($oldYear) . ")\n"
                         . "  - ODO đã đi: " . htmlspecialchars($oldOdo) . " km\n"
                         . "  - Tình trạng: " . htmlspecialchars($oldStatus) . "\n"
                         . "⏰ <b>Thời gian:</b> " . date('d/m/Y H:i:s');
                send_telegram_notification($teleMsg);
            } catch (Exception $teleEx) {}

            $successTradeIn = true;
        } catch (Exception $e) {
            $errorTradeIn = 'Có lỗi xảy ra trong quá trình xử lý yêu cầu. Vui lòng thử lại!';
        }
    } else {
        $errorTradeIn = 'Vui lòng cung cấp đầy đủ thông tin Họ tên, Số điện thoại, Hãng xe và Dòng xe cũ!';
    }
}
$pageBodyClass = 'page-homepage';

return get_defined_vars();




