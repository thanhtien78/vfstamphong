<?php
/**
 * Controller for route: pricelist
 */
use App\Models\Setting;
use App\Models\Car;

// Fetch settings from database via Model
$settings = Setting::getAll();
$agencyName = $settings['agency_name'] ?? 'VinFast Hồ Chí Minh';
$agencyPhone = $settings['agency_phone'] ?? '081.7777.855';
$agencyAddress = $settings['agency_address'] ?? 'Tòa nhà Lim Tower, 9-11 Tôn Đức Thắng, Q.1, TP. HCM';
$agencyHours = $settings['agency_hours'] ?? 'Thứ 2 - Thứ 7: 8:00 - 18:00 | Chủ Nhật: 9:00 - 17:00';

// Fetch cars from database via Model
$cars = Car::getPricelist();

// Mảng ánh xạ chương trình Khuyến mãi & Quà tặng thực tế cho các dòng xe VinFast tại Việt Nam
$promosJson = $settings['pricelist_promos'] ?? '';
$promosData = json_decode($promosJson, true);
$modelPerks = [];
if (is_array($promosData) && !empty($promosData)) {
    foreach ($promosData as $item) {
        $modelName = $item['model_name'] ?? '';
        if ($modelName !== '') {
            $gifts = explode('|', $item['gifts'] ?? '');
            $modelPerks[$modelName] = [
                'promo' => $item['promo'] ?? '',
                'gifts' => array_filter(array_map('trim', $gifts))
            ];
        }
    }
} else {
    // Gorgeous default fallback perks
    $modelPerks = [
        'VinFast VF 2' => [
            'promo' => 'Hỗ trợ miễn phí trước bạ + Tặng voucher dịch vụ sạc pin công cộng.',
            'gifts' => [
                'Bộ sạc di động 2.2kW chính hãng',
                'Thảm lót sàn cao cấp'
            ]
        ],
        'VinFast VF 3' => [
            'promo' => 'Hỗ trợ 100% lệ phí trước bạ xe điện (thuế suất 0%) + Tặng bộ thảm lót sàn cao cấp chính hãng.',
            'gifts' => [
                'Bộ sạc di động chính hãng tiện lợi',
                'Thảm lót sàn cao su đúc logo VinFast',
                'Móc khóa da VinFast sang trọng'
            ]
        ],
        'VinFast VF 5 Plus' => [
            'promo' => 'Đặc quyền ưu đãi miễn phí sạc pin 1 năm đầu tại tất cả các trạm sạc nhanh VinFast toàn quốc.',
            'gifts' => [
                'Bộ sạc di động 2.2kW chính hãng',
                'Gói phủ Ceramic bảo vệ sơn cao cấp',
                'Thảm lót sàn da 5D thiết kế riêng'
            ]
        ],
        'VinFast VF e34' => [
            'promo' => 'Hỗ trợ giá sạc pin ưu đãi đặc biệt + Tặng thẻ sạc pin V-Green trị giá 5 triệu đồng.',
            'gifts' => [
                'Bộ sạc treo tường thông minh',
                'Phim cách nhiệt 3M cao cấp'
            ]
        ],
        'VinFast VF 6' => [
            'promo' => 'Hỗ trợ lãi suất vay cố định 5.0%/năm trong 2 năm đầu + Miễn phí hoàn toàn chi phí cứu hộ 24/7.',
            'gifts' => [
                'Bộ sạc treo tường thông minh 11kW',
                'Dán phim cách nhiệt 3M chính hãng',
                'Ô che nắng gấp gọn VinFast'
            ]
        ],
        'VinFast VF MPV 7' => [
            'promo' => 'Hỗ trợ 100% lệ phí trước bạ + Tặng bảo hiểm vật chất xe 1 năm chính hãng.',
            'gifts' => [
                'Bộ sạc treo tường thông minh 11kW',
                'Bộ thảm lót sàn 7 chỗ cao cấp'
            ]
        ],
        'VinFast VF 7' => [
            'promo' => 'Đặc quyền ưu đãi miễn phí sạc pin 2 năm đầu tại hệ thống trạm sạc công cộng VinFast toàn quốc.',
            'gifts' => [
                'Hộp sạc treo tường thông minh 11kW',
                'Gói phủ thủy tinh bảo vệ bề mặt sơn',
                'Ví da đựng hồ sơ xe cao cấp'
            ]
        ],
        'VinFast VF 8' => [
            'promo' => 'Hỗ trợ lãi suất vay mua xe ưu đãi tối ưu cố định 4.8%/năm trong 3 năm đầu tại ngân hàng đối tác.',
            'gifts' => [
                'Trạm sạc treo tường 11kW',
                'Gói bảo dưỡng xe định kỳ miễn phí 2 năm',
                'Vali kéo du lịch VinFast Collection'
            ]
        ],
        'VinFast VF 8 The New' => [
            'promo' => 'Đặc quyền trải nghiệm sạc không dây Qi2 + Gói bảo dưỡng xe 3 năm miễn phí tại hãng.',
            'gifts' => [
                'Trạm sạc treo tường 11kW',
                'Gói phủ Ceramic bảo vệ sơn thế hệ mới'
            ]
        ],
        'VinFast VF 9' => [
            'promo' => 'Đặc quyền VIP hỗ trợ giao xe tận nhà bằng xe chuyên dụng + Tặng thẻ thành viên VinClub hạng kim cương.',
            'gifts' => [
                'Hộp sạc treo tường 11kW',
                'Gói spa làm đẹp xe phủ Ceramic kim cương',
                'Ví đựng hồ sơ da thật cao cấp dập chìm logo chữ V'
            ]
        ],
        'VinFast Minio Green' => [
            'promo' => 'Ưu đãi miễn phí sạc pin V-Green đến năm 2029 + Hỗ trợ mua trả góp lãi suất 0% cho tài xế.',
            'gifts' => [
                'Thảm cao su chống nước chuyên dụng',
                'Bộ cứu hộ xe khẩn cấp'
            ]
        ],
        'VinFast Herio Green' => [
            'promo' => 'Chiết khấu lô doanh nghiệp vận tải cực tốt + Tặng gói cứu hộ V-Green VIP 24/7.',
            'gifts' => [
                'Hỗ trợ dán tem logo taxi miễn phí',
                'Thảm cao su đúc logo thương hiệu'
            ]
        ],
        'VinFast Nerio Green' => [
            'promo' => 'Ưu đãi mua sỉ cho hợp tác xã/doanh nghiệp taxi + Bảo hành xe 10 năm hoặc 200.000km.',
            'gifts' => [
                'Bộ định vị giám sát hành trình GPS hợp chuẩn',
                'Thảm cao su cao cấp'
            ]
        ],
        'VinFast Limo Green' => [
            'promo' => 'Tặng 1 năm bảo hiểm thân vỏ cho xe kinh doanh + Gói hỗ trợ tài chính lãi suất siêu thấp.',
            'gifts' => [
                'Hộp đen định vị hợp chuẩn Bộ GTVT',
                'Lót sàn 7 chỗ chuyên dụng'
            ]
        ],
        'VinFast EC Van' => [
            'promo' => 'Hỗ trợ đăng ký biển số xe van không lo cấm giờ + Tặng gói bảo dưỡng miễn phí 2 năm đầu.',
            'gifts' => [
                'Bộ sạc công suất lớn di động tiện dụng',
                'Thảm lót sàn chuyên dụng chống thấm cho xe van'
            ]
        ],
        'VinFast EBus' => [
            'promo' => 'Hỗ trợ kỹ thuật dự án xanh 24/7 + Đào tạo kỹ năng lái xe buýt điện an toàn miễn phí.',
            'gifts' => [
                'Gói lắp đặt hệ thống trạm sạc dự án riêng',
                'Phần mềm quản lý xe buýt thông minh VinFast'
            ]
        ]
    ];
}
$siteTitle = 'Bảng Giá Xe VinFast Mới Nhất | Đại lý VinFast Tam Phong';
$siteDesc = "Bảng giá xe VinFast mới nhất năm 2026 tại đại lý ủy quyền Việt Nam. Cập nhật chi tiết giá niêm yết, giá lăn bánh các mẫu xe điện thông minh VF 3, VF 5, VF 6, VF 7, VF 8, VF 9 và ưu đãi cực tốt.";

// Decode pricelist FAQs at the top for JSON-LD schema inclusion in head
$faqsJson = $settings['pricelist_faqs'] ?? '';
$faqs = json_decode($faqsJson, true);
if (!is_array($faqs) || empty($faqs)) {
    $faqs = [
        [
            "question" => "Giá xe VinFast lăn bánh tại Việt Nam bao gồm những chi phí nào?",
            "answer" => "Giá xe VinFast lăn bánh bao gồm giá niêm yết xe từ nhà phân phối và các khoản chi phí bắt buộc theo luật định: lệ phí trước bạ (10% - 12% tùy địa phương), phí cấp biển số (20 triệu VNĐ tại HN & TP.HCM, 2 triệu VNĐ tại các tỉnh khác), phí đường bộ 12 tháng (1.560.000 VNĐ), bảo hiểm trách nhiệm dân sự bắt buộc (480.000 VNĐ) và phí đăng kiểm xe (340.000 VNĐ)."
        ],
        [
            "question" => "Mua xe điện VinFast EV được hưởng chính sách ưu đãi gì?",
            "answer" => "Hiện nay, theo chính sách khuyến khích xe xanh của nhà nước, xe ô tô điện chạy pin như VinFast EV được áp dụng mức lệ phí trước bạ là 0%. Điều này giúp tổng chi phí lăn bánh của xe điện tiết kiệm hơn xe động cơ xăng truyền thống tương đương hàng trăm triệu đồng."
        ],
        [
            "question" => "Tôi có thể mua xe VinFast trả góp với hạn mức tối đa bao nhiêu?",
            "answer" => "Đại lý VinFast liên kết với hệ thống ngân hàng lớn hỗ trợ khách hàng mua xe trả góp lên đến 70% - 80% giá trị xe niêm yết, thời hạn vay linh hoạt đến 84 tháng (7 năm). Lãi suất áp dụng cực kỳ ưu đãi chỉ từ 7.9%/năm với thủ tục xét duyệt hồ sơ nhanh gọn."
        ]
    ];
}
$faqSchemaData = $faqs;

$pageBodyClass = 'page-pricelist';

return get_defined_vars();




