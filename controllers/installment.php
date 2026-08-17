<?php
/**
 * Controller for route: installment
 */
use App\Models\Setting;
use App\Models\Car;

// Fetch settings from database via Model
$settings = Setting::getAll();
$agencyName = $settings['agency_name'] ?? 'VinFast Hồ Chí Minh';
$agencyPhone = $settings['agency_phone'] ?? '081.7777.855';
$agencyAddress = $settings['agency_address'] ?? 'Tòa nhà Lim Tower, 9-11 Tôn Đức Thắng, Q.1, TP. HCM';
$agencyHours = $settings['agency_hours'] ?? 'Thứ 2 - Thứ 7: 8:00 - 18:00 | Chủ Nhật: 9:00 - 17:00';

// Fetch cars from database for dynamic select dropdown via Model
$cars = Car::getPricelist();

$navCarId = 1;
if (!empty($cars)) {
    $navCarId = $cars[0]['id'];
}
$installmentLink = "installment.php";
$siteTitle = !empty($settings['installment_seo_title']) ? $settings['installment_seo_title'] : 'Mua Xe VinFast Trả Góp Lãi Suất Thấp | Đại lý VinFast Tam Phong';
$siteDesc = !empty($settings['installment_seo_desc']) ? $settings['installment_seo_desc'] : "Công cụ tính toán trả góp xe VinFast chuyên nghiệp. Dự toán chính xác hạn mức vay, số tiền trả trước, lãi suất hàng tháng và thời hạn thanh toán linh hoạt lên đến 8 năm.";
$siteKeywords = !empty($settings['installment_seo_keywords']) ? $settings['installment_seo_keywords'] : "VinFast trả góp, mua xe VinFast trả góp, lãi suất trả góp VinFast, dự toán vay VinFast";
$seoCanonical = !empty($settings['installment_seo_canonical']) ? $settings['installment_seo_canonical'] : "";

// Decode installment FAQs at the top for JSON-LD schema inclusion in head
$faqsJson = $settings['installment_faqs'] ?? '';
$faqs = json_decode($faqsJson, true);
if (!is_array($faqs) || empty($faqs)) {
    $faqs = [
        [
            "question" => "Nợ xấu nhóm 2 có mua xe VinFast trả góp được không?",
            "answer" => "Khách hàng có lịch sử nợ xấu nhóm 2 (chậm thanh toán dưới 90 ngày) vẫn hoàn toàn có thể mua xe VinFast trả góp thông qua một số ngân hàng đối tác hoặc công ty tài chính có chính sách mở. Chúng tôi có đội ngũ chuyên gia hỗ trợ làm hồ sơ khó giúp tỷ lệ phê duyệt đạt kết quả cao nhất. Quý khách vui lòng để lại thông tin để được hỗ trợ chuyên sâu bảo mật."
        ],
        [
            "question" => "Hạn mức vay tối đa là bao nhiêu và thời gian trong bao lâu?",
            "answer" => "Ngân hàng đối tác hỗ trợ gói tài chính tối đa lên tới 80% đến 85% giá trị xe VinFast. Thời hạn trả góp vay linh hoạt kéo dài từ 1 năm (12 tháng) lên tới 8 năm (96 tháng), giúp quý khách cân đối dòng tiền chi trả mỗi tháng nhẹ nhàng nhất."
        ],
        [
            "question" => "Mua xe điện VinFast EV trả góp có lợi ích gì hơn xe xăng?",
            "answer" => "Tất cả các dòng xe thuần điện VinFast EV đều được áp dụng mức lệ phí trước bạ ưu đãi 0% theo chính sách hỗ trợ phát triển xe xanh của Chính phủ. Nhờ đó, số tiền mặt thanh toán ban đầu (tiền đối ứng lăn bánh) của quý khách sẽ giảm từ 10% đến 12% so với xe xăng thông thường, giúp bài toán tài chính trở nên tối ưu và nhẹ nhàng hơn rất nhiều."
        ],
        [
            "question" => "Có bắt buộc mua bảo hiểm thân vỏ hàng năm không?",
            "answer" => "Có. Khi mua xe trả góp thông qua ngân hàng, xe ô tô là tài sản thế chấp nên ngân hàng bắt buộc khách hàng phải mua Bảo hiểm thân vỏ (Bảo hiểm vật chất) hàng năm trong suốt thời gian vay vốn. Điều này vừa đáp ứng yêu cầu giải ngân của ngân hàng, vừa bảo vệ trực tiếp quyền lợi tài chính của quý khách nếu xảy ra va chạm hay rủi ro thiên tai."
        ],
        [
            "question" => "Quy trình giải ngân nhận xe mất tổng cộng bao lâu?",
            "answer" => "Sau khi thu thập đầy đủ các hồ sơ tối thiểu, ngân hàng sẽ phát thông báo cho vay trong vòng 4-8 giờ. Sau đó, quy trình nộp tiền đối ứng của khách hàng, tiến hành đi đăng ký biển số và hoàn tất giải ngân nhận xe thường diễn ra trong vòng từ 3 đến 5 ngày làm việc."
        ]
    ];
}
$faqSchemaData = $faqs;

$pageBodyClass = 'page-installment';

return get_defined_vars();




