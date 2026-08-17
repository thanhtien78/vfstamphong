<?php
/**
 * Controller for VinFast Charging Stations Page
 */
global $db, $settings;

// Page specific SEO overrides
$siteTitle = "Mạng Lưới Trạm Sạc Xe Điện VinFast Toàn Quốc | Bản Đồ Trạm Sạc Gần Nhất";
$siteDesc = "Tìm kiếm vị trí trạm sạc xe điện VinFast gần nhất. Cập nhật bản đồ trạm sạc nhanh DC, trạm sạc thường AC toàn quốc, chi phí sạc và hướng dẫn sạc pin an toàn.";
$siteKeywords = "trạm sạc vinfast, tìm trạm sạc vinfast, bản đồ trạm sạc vinfast, giá sạc điện vinfast, trạm sạc nhanh vinfast";

$agencyPhone = $settings['agency_phone'] ?? "081.7777.855";
$agencyAddress = $settings['agency_address'] ?? "6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh";
$agencyName = $settings['agency_name'] ?? "VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh";

// Dynamic FAQ schema data for search visibility
$faqSchemaData = [
    [
        "question" => "Chi phí sạc xe điện VinFast tại trạm sạc công cộng là bao nhiêu?",
        "answer" => "Hiện nay, VinFast áp dụng đơn giá sạc điện tại các trạm sạc công cộng toàn quốc là 3.858 VND / kWh (đã bao gồm VAT). Ngoài ra, nếu pin đã sạc đầy 100% nhưng xe vẫn đỗ tại vị trí sạc quá 30 phút, phí đỗ xe quá giờ là 1.000 VND / phút."
    ],
    [
        "question" => "Thời gian sạc đầy pin xe điện VinFast mất bao lâu?",
        "answer" => "Thời gian sạc phụ thuộc vào công suất trụ sạc và dòng xe. Với trụ sạc siêu tốc DC 250kW, xe có thể sạc nhanh từ 10% lên 70% chỉ trong khoảng 18 - 25 phút. Đối với sạc thường AC 11kW tại nhà hoặc văn phòng, thời gian sạc đầy hoàn toàn là từ 6 đến 8 tiếng qua đêm."
    ],
    [
        "question" => "Mạng lưới trạm sạc VinFast hiện nay phân bố như thế nào?",
        "answer" => "VinFast đã quy hoạch và lắp đặt hệ thống hơn 150.000 cổng sạc trên khắp 63 tỉnh thành cả nước, phân bố dọc các tuyến cao tốc, quốc lộ, trung tâm thương mại, chung cư, tòa nhà văn phòng và bãi đỗ xe công cộng."
    ],
    [
        "question" => "Tôi có thể sạc xe điện VinFast khi trời mưa lớn hay không?",
        "answer" => "Có. Tất cả cổng sạc và trụ sạc của VinFast đều đạt tiêu chuẩn chống nước IP55 hoặc IP65, cùng hệ thống rơ-le tự ngắt điện tức thì khi có hiện tượng rò rỉ hoặc quá tải dòng điện, đảm bảo an toàn tuyệt đối khi sạc dưới trời mưa."
    ]
];

return [
    'siteTitle' => $siteTitle,
    'siteDesc' => $siteDesc,
    'siteKeywords' => $siteKeywords,
    'faqSchemaData' => $faqSchemaData,
    'agencyPhone' => $agencyPhone,
    'agencyAddress' => $agencyAddress,
    'agencyName' => $agencyName
];
