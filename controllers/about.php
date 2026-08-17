<?php
/**
 * Controller for route: about
 */

/**
 * VinFast Premium About Us Page (GIỚI THIỆU)
 * Hand-crafted luxurious storytelling page representing VinFast brand values.
 */




// Fetch settings from database for consistent header/footer dynamic contact info
$stmt = $db->query("SELECT * FROM settings");
$settings = [];
while ($row = $stmt->fetch()) {
    $settings[$row['key']] = $row['value'];
}

// Global configurations & Custom SEO Meta for the About page
$siteTitle = !empty($settings['about_seo_title']) ? $settings['about_seo_title'] : (($settings['about_title'] ?? "Giới thiệu Đại lý VinFast Tam Phong") . " | Kiến tạo tương lai xanh");
$siteDesc = !empty($settings['about_seo_desc']) ? $settings['about_seo_desc'] : "Khám phá lịch sử thương hiệu VinFast, tinh thần Việt Nam chinh phục thế giới, hệ dẫn động bốn bánh AWD huyền thoại và đặc quyền dịch vụ chính hãng chuẩn 5 sao toàn cầu.";
$siteKeywords = !empty($settings['about_seo_keywords']) ? $settings['about_seo_keywords'] : "giới thiệu VinFast, triết lý VinFast, xe điện thông minh, lịch sử VinFast, đại lý VinFast việt nam, trạm sạc VinFast EV";
$seoCanonical = !empty($settings['about_seo_canonical']) ? $settings['about_seo_canonical'] : "";
$pageBodyClass = 'page-about';

return get_defined_vars();




