<?php
if ($isAdmin && (empty($matchedKeyword['import_created']) || $matchedKeyword['import_status'] !== 'completed')) {
    echo '
    <div style="background: linear-gradient(90deg, #8a6d3b 0%, #a67c1e 100%); color: #ffffff; padding: 12px 20px; text-align: center; font-size: 13px; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; gap: 10px; z-index: 9999; position: relative;">
      <span>⚠️ CHẾ ĐỘ XEM TRƯỚC: Chiến dịch này chưa được import bài viết lên hệ thống (Chỉ quản trị viên mới nhìn thấy trang này).</span>
    </div>';
}
?>

<?php
if (!function_exists('estimate_distance_to_showroom')) {
    function estimate_distance_to_showroom($slug, $province = '') {
        $hash = abs(crc32($slug));
        $isHCM = empty($province) || stripos($province, 'Hồ Chí Minh') !== false || stripos($province, 'HCM') !== false;
        
        if ($isHCM) {
            // Distance inside city: 2 to 18 km
            $distance = 2 + ($hash % 17);
            $time = ceil($distance * 2.5); // 2.5 minutes per km in city traffic
        } else {
            // Distance outside city: 25 to 145 km
            $distance = 25 + ($hash % 120);
            $time = ceil($distance * 1.5); // 1.5 minutes per km on highways
        }
        
        return [
            'distance' => $distance,
            'time' => $time
        ];
    }
}
?>

  <!-- DYNAMIC LOCALBUSINESS & PRODUCT GRAPH SCHEMA FOR RICH SNIPPETS -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "AutoDealer",
        "@id": "<?php echo htmlspecialchars($baseUrl . '/' . $slug . '.html#dealer'); ?>",
        "name": "<?php echo htmlspecialchars("Đại lý VinFast Tam Phong phục vụ tại " . $locationName); ?>",
        "alternateName": "VinFast Tam Phong",
        "url": "<?php echo htmlspecialchars($baseUrl . '/' . $slug . '.html'); ?>",
        "telephone": "<?php echo htmlspecialchars($phoneVal); ?>",
        "priceRange": "$$$$",
        "address": {
          "@type": "PostalAddress",
          "streetAddress": "6B Tôn Đức Thắng, Phường Bến Nghé",
          "addressLocality": "Quận 1",
          "addressRegion": "TP. Hồ Chí Minh",
          "addressCountry": "VN"
        },
        "image": "<?php echo htmlspecialchars(!empty($selectedImage) ? $baseUrl . '/' . $selectedImage : $baseUrl . '/assets/uploads/showroom.webp'); ?>",
        "areaServed": {
          "@type": "AdministrativeArea",
          "name": "<?php echo htmlspecialchars($locationName); ?>"
        },
        "openingHoursSpecification": {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
          ],
          "opens": "08:00",
          "closes": "18:00"
        }
      }
      <?php if (!empty($cars)): ?>,
      {
        "@type": "Product",
        "name": "<?php echo htmlspecialchars($cars[0]['model_name'] . " - Phân phối tại " . $locationName); ?>",
        "image": "<?php echo htmlspecialchars($baseUrl . '/' . $cars[0]['image']); ?>",
        "description": "<?php echo htmlspecialchars($cars[0]['description'] ?: "Bảng giá lăn bánh và thông số kỹ thuật xe ô tô điện VinFast chính hãng tại " . $locationName); ?>",
        "brand": {
          "@type": "Brand",
          "name": "VinFast"
        },
        "offers": {
          "@type": "AggregateOffer",
          "priceCurrency": "VND",
          "lowPrice": "<?php echo htmlspecialchars($cars[0]['price']); ?>",
          "highPrice": "<?php echo htmlspecialchars($cars[count($cars)-1]['price']); ?>",
          "offerCount": "<?php echo count($cars); ?>",
          "url": "<?php echo htmlspecialchars($baseUrl . '/' . $slug . '.html'); ?>"
        }
      }
      <?php endif; ?>
    ]
  }
  </script>

  <!-- READING PROGRESS BAR -->
  <div id="reading-progress-container">
    <div id="reading-progress-bar"></div>
  </div>

  <style>
  /* 1. Pricing table design alignment - fix contrast issues */
  html body .seo-price-table {
    background: #ffffff !important;
    border-collapse: collapse !important;
    width: 100% !important;
    border: 1px solid #e2e8f0 !important;
  }

  html body .seo-price-table thead th {
    background: #f8fafc !important;
    color: #0f172a !important; /* Fixed: dark text color on light background for perfect readability */
    font-weight: 700 !important;
    font-size: 13px !important;
    text-transform: uppercase !important;
    border-bottom: 2px solid #cbd5e1 !important;
    padding: 14px 18px !important;
  }

  html body .seo-price-table tbody td {
    background: #ffffff !important;
    color: #334155 !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 14px 18px !important;
    font-size: 13.5px !important;
  }

  html body .seo-price-table tbody tr:hover td {
    background: #f8fafc !important;
  }

  /* 2. Remove all dark and grey backgrounds from card boxes and sidebars */
  html body .local-card-box {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02) !important;
    color: #334155 !important;
  }

  html body .local-card-title {
    color: #0f172a !important;
    border-left-color: #10b981 !important;
  }

  html body .local-card-text {
    color: #475569 !important;
  }

  /* 3. Redesign counselor (contact) widget to white tech theme */
  html body .local-card-box[style*="background: linear-gradient"] {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
  }

  html body .local-card-box div[style*="background: rgba(255, 255, 255, 0.01)"] {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.01) !important;
  }

  html body .local-card-box h4[style*="font-family"] {
    color: #0f172a !important;
  }

  /* Counselor button colors: white background with blue text and solid blue call button */
  html body .local-card-box a[style*="background: rgba(76,175,80,0.1)"] {
    background: #10b981 !important;
    color: #ffffff !important;
    border-color: #10b981 !important;
  }

  html body .local-card-box a[style*="background: rgba(76,175,80,0.1)"]:hover {
    background: #0f52c9 !important;
    border-color: #0f52c9 !important;
  }

  html body .local-card-box a[style*="background: var(--color-primary-glow)"] {
    background: #ffffff !important;
    color: var(--color-primary) !important;
    border-color: rgba(52, 211, 153, 0.3) !important;
  }

  html body .local-card-box a[style*="background: var(--color-primary-glow)"]:hover {
    background: rgba(52, 211, 153, 0.05) !important;
    border-color: var(--color-primary) !important;
  }

  /* 4. Redesign Online Installment Calculator widget to clean light-tech theme */
  html body .vip-local-card-calculator {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
  }

  html body .vip-local-card-calculator .vip-local-title {
    color: #0f172a !important;
  }

  html body .vip-local-card-calculator .vip-local-desc {
    color: #475569 !important;
  }

  /* Inputs and Selects inside calculator */
  html body .vip-local-card-calculator select,
  html body .vip-local-card-calculator input {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #0f172a !important;
  }

  html body .vip-local-card-calculator select option {
    background: #ffffff !important;
    color: #0f172a !important;
  }

  /* Calculation results container */
  html body .vip-local-card-calculator div[style*="background: rgba(0,0,0,0.3)"] {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
  }

  html body .vip-local-card-calculator div[style*="background: rgba(0,0,0,0.3)"] span[style*="color: #fff"] {
    color: #0f172a !important;
  }

  html body .vip-local-card-calculator div[style*="background: rgba(0,0,0,0.3)"] span[style*="color: rgba(255,255,255,0.3)"] {
    color: #64748b !important;
  }

  html body .vip-local-card-calculator div[style*="background: rgba(0,0,0,0.3)"] span[style*="color: var(--color-primary)"] {
    color: #10b981 !important;
  }

  /* Calculator submit button */
  html body .vip-local-card-calculator a[style*="background: var(--color-primary)"] {
    background: #10b981 !important;
    color: #ffffff !important;
  }

  html body .vip-local-card-calculator a[style*="background: var(--color-primary)"]:hover {
    background: #0f52c9 !important;
  }

  /* 5. General widgets on sidebar (Tư Vấn VIP) */
  html body .vip-local-card {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
  }

  html body .vip-local-title {
    color: #0f172a !important;
  }

  html body .vip-local-desc {
    color: #475569 !important;
  }

  html body .vip-local-card svg {
    color: #10b981 !important;
  }

  html body .vip-local-card input,
  html body .vip-local-card select {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    color: #0f172a !important;
  }

  html body .vip-local-btn {
    background: #10b981 !important;
    color: #ffffff !important;
    border-radius: 30px !important;
    font-weight: 700 !important;
    padding: 12px 24px !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3) !important;
    border: none !important;
  }

  html body .vip-local-btn:hover {
    background: #0f52c9 !important;
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
  }

  /* 6. Interlinking blocks */
  html body .local-card-box a[style*="background: rgba(255,255,255,0.01)"] {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    color: #475569 !important;
  }

  html body .local-card-box a[style*="background: rgba(255,255,255,0.01)"]:hover {
    border-color: #10b981 !important;
    color: #10b981 !important;
    background: rgba(16, 185, 129, 0.02) !important;
  }

  /* 7. Featured cars cards */
  html body .local-card-box div[style*="background: rgba(255,255,255,0.01); border: var(--ev-border-light); border-radius: var(--ev-border-radius); overflow: hidden;"] {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
  }

  html body .local-card-box div[style*="background: rgba(255,255,255,0.01); border: var(--ev-border-light); border-radius: var(--ev-border-radius); overflow: hidden;"] h4 {
    color: #0f172a !important;
  }

  html body .local-card-box div[style*="background: rgba(255,255,255,0.01); border: var(--ev-border-light); border-radius: var(--ev-border-radius); overflow: hidden;"] p {
    color: #64748b !important;
  }

  html body .local-card-box div[style*="background: rgba(255,255,255,0.01); border: var(--ev-border-light); border-radius: var(--ev-border-radius); overflow: hidden;"] a {
    border-radius: 30px !important;
  }

  /* 8. Spun paragraph and article styling */
  html body .local-article-content p,
  html body .local-article-content li {
    color: #475569 !important;
    line-height: 1.7 !important;
  }

  /* 9. Fix contrast issue for bold text/location tags inside light themed local-seo section */
  html body .local-seo-section strong,
  html body .local-seo-section b,
  html body .local-seo-section span strong,
  html body .local-seo-section td strong,
  html body .local-seo-section p strong,
  html body .local-seo-section li strong {
    color: #0f172a !important;
    font-weight: 700 !important;
  }

  /* 10. Clean styling for nearby areas links to eliminate white-out on hover */
  html body .local-seo-section .nearby-link {
    display: block !important;
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: var(--ev-border-radius) !important;
    padding: 10px 14px !important;
    font-size: 12.5px !important;
    color: #475569 !important;
    text-decoration: none !important;
    transition: all 0.2s ease !important;
    line-height: 1.4 !important;
  }

  html body .local-seo-section .nearby-link:hover {
    border-color: #10b981 !important;
    color: #10b981 !important;
    background: rgba(16, 185, 129, 0.04) !important;
  }

  /* 11. Status Badges for Pricing Table */
  html body .local-seo-section .status-badge {
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    padding: 3px 10px !important;
    border-radius: 20px !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.3px !important;
    text-transform: uppercase !important;
  }
  html body .local-seo-section .status-ready {
    background: #e0f2fe !important;
    color: #0369a1 !important;
  }
  html body .local-seo-section .status-waiting {
    background: #fef3c7 !important;
    color: #d97706 !important;
  }
  html body .local-seo-section .status-order {
    background: #f1f5f9 !important;
    color: #475569 !important;
  }
  html body .local-seo-section .status-dot {
    width: 6px !important;
    height: 6px !important;
    background: #0284c7 !important;
    border-radius: 50% !important;
    display: inline-block !important;
    animation: statusPulse 1.5s infinite !important;
  }
  @keyframes statusPulse {
    0% { transform: scale(0.9); opacity: 0.6; }
    50% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(0.9); opacity: 0.6; }
  }

  /* 12. Local Perks Grid Layout */
  html body .local-seo-section .local-perks-grid {
    display: grid !important;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) !important;
    gap: 15px !important;
    margin: 20px 0 !important;
  }
  html body .local-seo-section .local-perk-card {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 12px !important;
    padding: 18px !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
  }
  
  /* FLOATING TABLE OF CONTENTS (TOC) STYLING */
  .pseo-toc-container {
    position: fixed;
    bottom: 85px;
    right: 20px;
    z-index: 998;
    font-family: 'Montserrat', sans-serif !important;
  }
  .pseo-toc-trigger {
    background: #10b981;
    color: #fff;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.35);
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .pseo-toc-trigger:hover {
    background: #0f52c9;
    transform: scale(1.05);
  }
  .pseo-toc-trigger-text {
    font-size: 8px;
    font-weight: 700;
    margin-top: 2px;
    text-transform: uppercase;
  }
  .pseo-toc-panel {
    position: absolute;
    bottom: 60px;
    right: 0;
    width: 250px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    padding: 15px;
    display: none;
    transform-origin: bottom right;
    animation: scale-in 0.2s ease-out;
  }
  .pseo-toc-panel.show {
    display: block;
  }
  .pseo-toc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 8px;
    margin-bottom: 10px;
  }
  .pseo-toc-header strong {
    font-size: 11px;
    color: #0f172a;
    letter-spacing: 0.5px;
  }
  .pseo-toc-header button {
    background: none;
    border: none;
    font-size: 20px;
    color: #94a3b8;
    cursor: pointer;
    line-height: 1;
  }
  .pseo-toc-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  .pseo-toc-list a {
    color: #475569;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    display: block;
    padding: 4px 0;
    transition: color 0.2s;
  }
  .pseo-toc-list a:hover {
    color: #10b981;
  }
  @keyframes scale-in {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  
  @media (max-width: 991px) {
    .pseo-toc-container {
      bottom: 90px;
      right: 15px;
    }
  }
  </style>

  <section class="local-seo-section">
    <div class="container">
      
      <!-- HERO BANNER -->
      <div class="local-hero-banner">
        <span class="local-seo-tag">Địa phương hỗ trợ: <?php echo $locationName; ?></span>
        <h1 class="local-hero-title">
          <?php if ($isPriceSEO): ?>
            <?php echo PSEO_Helper::processSpintax(interpolate_pseo_text("{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất|Giá Lăn Bánh Xe Điện VinFast|Bảng Báo Giá Xe Điện VinFast} {MONTH}/{YEAR} Tại {LOCATION}")); ?>
          <?php else: ?>
            <?php echo PSEO_Helper::processSpintax(interpolate_pseo_text("{Đại Lý Ủy Quyền Xe VinFast Chính Hãng|Showroom Trải Nghiệm Xe Điện VinFast|Đại Lý Xe Điện VinFast Đạt Chuẩn Terminal} {YEAR} Phục Vụ Tại {LOCATION}")); ?>
          <?php endif; ?>
        </h1>
        <p class="local-hero-desc">
          <?php if ($isPriceSEO): ?>
            <?php echo PSEO_Helper::processSpintax(interpolate_pseo_text("{Chào đón|Hân hạnh chào mừng|Chào mừng} quý khách hàng tại khu vực <strong>{LOCATION}</strong>. {Khám phá ngay|Cập nhật mới nhất|Xem ngay} bảng báo giá lăn bánh mới nhất {MONTH}/{YEAR}, các chương trình ưu đãi {đặc quyền|VIP hấp dẫn} và chính sách giao xe điện EV tận nhà {chuyên nghiệp|chu đáo|uy tín}.")); ?>
          <?php else: ?>
            <?php echo PSEO_Helper::processSpintax(interpolate_pseo_text("{Chào mừng|Hân hạnh phục vụ} quý khách tại <strong>{LOCATION}</strong> đến với hệ thống dịch vụ ủy quyền 5 sao của VinFast Việt Nam năm {year}. {Đăng ký lái thử xe tại nhà riêng|Hỗ trợ lái thử xe tận nơi} và trải nghiệm {chương trình cứu hộ kỹ thuật 24/7|dịch vụ cứu hộ lưu động chuyên nghiệp} an tâm tuyệt đối.")); ?>
          <?php endif; ?>
        </p>
      </div>

      <!-- MAIN SPLIT GRID -->
      <div class="local-grid-split">
        
        <!-- LEFT: MAIN EDITORIAL CONTENT -->
        <div class="local-main-content">
          
          <!-- KEY SELLING POINT STATS ROW (Premium Tech Theme) -->
          <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 25px;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 15px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.01); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.borderColor='var(--color-primary)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
              <span style="font-size: 20px; display: block; margin-bottom: 5px;">💰</span>
              <strong style="font-size: 14.5px; font-weight: 800; color: var(--color-primary); display: block; margin-bottom: 2px;">0% Lệ Phí</strong>
              <span style="font-size: 11px; color: var(--color-text-muted); line-height: 1.3; display: block;">Trước bạ ô tô điện</span>
            </div>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 15px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.01); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.borderColor='var(--color-primary)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
              <span style="font-size: 20px; display: block; margin-bottom: 5px;">🛡️</span>
              <strong style="font-size: 14.5px; font-weight: 800; color: #10b981; display: block; margin-bottom: 2px;">10 Năm</strong>
              <span style="font-size: 11px; color: var(--color-text-muted); line-height: 1.3; display: block;">Bảo hành chính hãng</span>
            </div>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 15px; text-align: center; box-shadow: 0 4px 12px rgba(0,0,0,0.01); transition: all 0.3s ease; cursor: default;" onmouseover="this.style.borderColor='var(--color-primary)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';">
              <span style="font-size: 20px; display: block; margin-bottom: 5px;">⚡</span>
              <strong style="font-size: 14.5px; font-weight: 800; color: #f59e0b; display: block; margin-bottom: 2px;">150 kW</strong>
              <span style="font-size: 11px; color: var(--color-text-muted); line-height: 1.3; display: block;">Sạc siêu nhanh DC</span>
            </div>
          </div>
          
          <?php if (!empty($selectedImage)): ?>
            <!-- GORGEOUS PREMIUM CAMPAIGN FEATURED IMAGE BANNER -->
            <div class="pseo-campaign-banner-container">
              <img src="<?php echo htmlspecialchars($selectedImage); ?>" alt="<?php echo htmlspecialchars($locationName); ?>" width="800" height="380" style="width:100%; height:100%; object-fit:cover;" fetchpriority="high" decoding="async">
              <div style="position: absolute; inset:0; background: linear-gradient(to top, var(--color-surface) 0%, transparent 40%);"></div>
              <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; z-index:3;">
                <span style="font-size: 10px; font-weight:700; color:var(--color-primary); letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:5px;">HÌNH ẢNH THỰC TẾ CHIẾN DỊCH</span>
                <h3 style="font-size: 16px; font-weight:500; color: var(--color-text-main); margin:0; text-transform:uppercase; font-family:'Montserrat', sans-serif !important;"><?php echo htmlspecialchars($keywordVal); ?></h3>
              </div>
            </div>
          <?php endif; ?>
          
          <?php if ($isProject && !empty($projectData)): ?>
            <!-- LUXURY PROJECT SPECIFIC PRESENTATION -->
            <div class="local-card-box" style="border-color: var(--color-border); background: linear-gradient(135deg, rgba(10,14,21,0.98) 0%, var(--color-primary-glow) 100%);">
              <h2 class="local-card-title" style="border-left-color: var(--color-primary); font-family: 'Montserrat', sans-serif !important; text-transform: uppercase;">Đặc Quyền Di Chuyển Thượng Lưu Cư Dân</h2>
              <p class="local-card-text">
                Chào mừng quý cư dân tại dự án cao cấp <strong><?php echo htmlspecialchars($projectData['ten_du_an']); ?></strong>. Nhằm đáp ứng nhu cầu trải nghiệm các dòng xe điện thông minh vượt trội, VinFast Việt Nam mang đến những chương trình ưu đãi phục vụ đặc biệt và giải pháp di chuyển thông minh cho quý vị:
              </p>
              
              <div style="display: grid; grid-template-columns: 1fr; gap: 15px; background: rgba(0,0,0,0.2); padding: 20px; border-radius: var(--ev-border-radius); border: var(--ev-border-light); margin: 20px 0;">
                <div style="display: grid; grid-template-columns: 120px 1fr; gap: 10px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 8px;">
                  <span style="color: var(--color-primary); font-weight: 700; text-transform: uppercase; font-size: 11px;">Dự Án:</span>
                  <span style="color: var(--color-text-main); font-weight: 600;"><?php echo htmlspecialchars($projectData['ten_du_an']); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 120px 1fr; gap: 10px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 8px;">
                  <span style="color: var(--color-primary); font-weight: 700; text-transform: uppercase; font-size: 11px;">Chủ Đầu Tư:</span>
                  <span style="color: var(--color-text-muted);"><?php echo htmlspecialchars($projectData['chu_dau_tu'] ?: 'Đang cập nhật'); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 120px 1fr; gap: 10px; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 8px;">
                  <span style="color: var(--color-primary); font-weight: 700; text-transform: uppercase; font-size: 11px;">Địa Chỉ:</span>
                  <span style="color: var(--color-text-muted);"><?php echo htmlspecialchars($projectData['dia_chi'] ?: 'Đang cập nhật'); ?></span>
                </div>
                <div style="display: grid; grid-template-columns: 120px 1fr; gap: 10px; font-size: 13px; padding-bottom: 2px;">
                  <span style="color: var(--color-primary); font-weight: 700; text-transform: uppercase; font-size: 11px;">Quy Mô:</span>
                  <span style="color: var(--color-text-muted);"><?php echo htmlspecialchars($projectData['quy_mo'] ?: 'Đang cập nhật'); ?></span>
                </div>
              </div>

              <?php if (!empty($projectData['tien_ich_noi_bat'])): ?>
                <h4 style="font-size: 13.5px; color: var(--color-text-main); margin-bottom: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tiện ích nội khu đẳng cấp:</h4>
                <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;">
                  <?php foreach ($projectData['tien_ich_noi_bat'] as $util): ?>
                    <span style="background: var(--color-primary-glow); border: 1px solid rgba(52, 211, 153, 0.15); padding: 5px 12px; border-radius: 20px; font-size: 11.5px; color: var(--color-primary); font-weight: 500;">
                      ✦ <?php echo htmlspecialchars($util); ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <?php if (!empty($spunContentParagraph)): ?>
                <div class="local-article-content" style="margin-top: 15px;">
                  <?php echo $spunContentParagraph; ?>
                </div>
              <?php else: ?>
                <p class="local-card-text" style="margin-bottom: 0;">
                  Sở hữu một chiếc xe thuần điện như <strong>VinFast EV</strong> ngay tại <strong><?php echo htmlspecialchars($projectData['ten_du_an']); ?></strong> trở nên vô cùng thuận tiện. Chúng tôi cam kết hỗ trợ tối đa việc lắp đặt và bảo hành bộ sạc treo tường thông minh chính hãng ngay tại vị trí đỗ xe của cư dân, kết hợp với các dịch vụ VIP như lái thử xe tại gia và bàn giao xe tận nhà chuyên nghiệp.
                </p>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <?php
          // ==========================================
          // PROGRAMMATIC SEO DYNAMIC LAYOUT SHUFFLING
          // ==========================================
          // Calculate lists and FAQ variables BEFORE capturing blocks
          $nearby = PSEO_Helper::getNearbyLocations($locSlug, 6);
          
          $featuredCars = [];
          if (!empty($cars)) {
              $tempCars = $cars;
              shuffle($tempCars);
              $featuredCars = array_slice($tempCars, 0, 3);
          }

          if ($isPriceSEO) {
              $q1 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Giá lăn bánh xe VinFast tại|Biểu giá lăn bánh xe ô tô VinFast ở|Báo giá lăn bánh xe VinFast khu vực} {LOCATION} mới nhất {MONTH}/{YEAR} gồm {những chi phí nào|các hạng mục lệ phí gì}?"));
              $a1 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Giá lăn bánh xe VinFast thực tế tại|Chi phí lăn bánh xe ô tô VinFast ở} {LOCATION} trong tháng {month}/{year} bao gồm: {Giá xe niêm yết chính hãng|Mức giá công bố từ nhà máy}, lệ phí trước bạ (đặc biệt {các dòng xe điện thuần EV được ưu đãi 100% trước bạ|Chính phủ miễn hoàn toàn lệ phí trước bạ cho ô tô điện}), phí đăng ký biển số, phí kiểm định, phí đường bộ và bảo hiểm TNDS bắt buộc."));
              
              $q2 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Tôi có thể mua xe VinFast trả góp tại|Chính sách mua xe VinFast trả góp ở|Hỗ trợ mua xe trả góp tại} {LOCATION} trong tháng {month}/{year} {không|như thế nào}?"));
              $a2 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Có, đại lý liên kết|Chúng tôi hợp tác chặt chẽ} với các ngân hàng uy tín tại {LOCATION} để hỗ trợ quý khách {mua xe trả góp|sở hữu xe với chính sách vay} trong tháng {month}/{year} với {hạn mức vay tối đa lên đến 80%|mức hỗ trợ tối đa 80% giá trị xe}. Thời hạn vay {kéo dài đến 8 năm|linh hoạt lên tới 96 tháng} với {lãi suất ưu đãi cực kỳ cạnh tranh|lãi suất thấp nhất phân khúc} và thủ tục {giải ngân nhanh chóng|phê duyệt hồ sơ trong ngày}."));
              
              $q3 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Đăng ký lái thử xe VinFast tại nhà ở|Làm sao đăng ký lái thử xe VinFast tại|Cách thức đăng ký lái thử xe ở} {LOCATION} trong tháng {month}/{year}?"));
              $a3 = PSEO_Helper::processSpintax(interpolate_pseo_text("Quý khách tại {LOCATION} chỉ cần {liên hệ hotline hoặc điền thông tin vào form tư vấn VIP|gửi yêu cầu lái thử qua website} trong tháng {month}/{year}. Đội ngũ cố vấn của VinFast sẽ {lái chiếc xe quý khách quan tâm đến tận địa chỉ nhà riêng|giao xe lái thử tận nơi cư trú hoặc nơi làm việc} để quý khách trải nghiệm hoàn toàn miễn phí."));
              
              $q4 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Chế độ bảo hành xe VinFast chính hãng tại|Chính sách bảo hành xe điện VinFast ở} {LOCATION} năm {year} như thế nào?"));
              $a4 = PSEO_Helper::processSpintax(interpolate_pseo_text("Tất cả các dòng xe VinFast mới bàn giao tại {LOCATION} trong {YEAR} đều được hưởng {chế độ bảo hành chính hãng dài hạn nhất thị trường|chính sách bảo hành 10 năm hoặc 200.000 km vượt trội}. Đối với dòng xe thuần điện EV, pin Lithium-ion được bảo hành chính hãng {lên tới 8-10 năm không giới hạn km|trọn đời hoặc theo gói thuê pin cực kỳ an tâm}."));
          } else {
              $q1 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Showroom đại lý VinFast chính hãng phục vụ khu vực|Đại lý ủy quyền VinFast phục vụ địa bàn} {LOCATION} trong tháng {month}/{year} cung cấp {những dịch vụ gì|các hạng mục chăm sóc nào}?"));
              $a1 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Showroom đạt tiêu chuẩn VinFast Terminal toàn cầu|Đại lý chuẩn 3S của VinFast} phục vụ khách hàng tại {LOCATION} trong tháng {month}/{year} cung cấp {trọn gói các dịch vụ khép kín|hệ thống dịch vụ toàn diện} bao gồm: {Trưng bày và phân phối xe VinFast mới chính hãng|Bán lẻ các mẫu xe điện VinFast chính thức}, khu xưởng sửa chữa & bảo dưỡng công nghệ cao, kho phụ tùng chính hãng VinFast và hệ thống trạm sạc nhanh DC."));
              
              $q2 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Dịch vụ nhận trả xe bảo dưỡng tại nhà ở|Quy trình giao nhận xe bảo dưỡng tại nhà tại|Hình thức bảo dưỡng xe giao nhận tận nhà ở} {LOCATION} năm {year} {hoạt động thế nào|quy trình ra sao}?"));
              $a2 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Nhằm hỗ trợ tối đa cho quý khách|Để mang lại sự tiện lợi tốt nhất|Nhằm tối ưu hóa thời gian} tại {LOCATION} trong năm {year}, chúng tôi {cung cấp dịch vụ|áp dụng chính sách|triển khai hình thức} giao nhận xe bảo dưỡng tại nhà. {Chuyên viên kỹ thuật|Đội ngũ kỹ thuật viên} sẽ đến tận nơi nhận xe mang đi bảo dưỡng định kỳ và bàn giao lại tận nhà sau khi hoàn tất, {giúp quý khách tiết kiệm thời gian|mang lại sự an tâm tuyệt đối}."));
              
              $q3 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Thủ tục trả góp khi mua xe tại đại lý VinFast khu vực|Quy trình làm hồ sơ trả góp tại showroom VinFast gần} {LOCATION} trong tháng {month}/{year} cần những gì?"));
              $a3 = PSEO_Helper::processSpintax(interpolate_pseo_text("Quý khách tại {LOCATION} chỉ cần chuẩn bị {các giấy tờ nhân thân cơ bản|hồ sơ pháp lý cơ bản} (CCCD, đăng ký kết hôn hoặc xác nhận độc thân) và {giấy tờ chứng minh thu nhập|nguồn thu thực tế}. Đội ngũ tư vấn tài chính của đại lý sẽ {hỗ trợ xử lý hồ sơ nhanh chóng trong vòng 24h|cam kết phê duyệt hồ sơ vay trả góp siêu tốc}."));
              
              $q4 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Làm sao để sạc pin xe điện VinFast EV khi di chuyển tại|Các hình thức sạc pin xe điện VinFast ở|Cách sạc pin xe điện VinFast tiện lợi tại} {LOCATION} năm {year}?"));
              $a4 = PSEO_Helper::processSpintax(interpolate_pseo_text("{Quý khách có thể sạc linh hoạt|Khách hàng sử dụng xe điện có thể sạc} tại nhà qua bộ sạc di động (nguồn điện gia đình), lắp đặt hộp sạc treo tường sạc qua đêm, hoặc sử dụng hệ thống trạm sạc nhanh DC công suất lớn tại {showroom đại lý VinFast chính hãng phục vụ khu vực|hệ thống trạm sạc công cộng phủ rộng tại} {LOCATION} trong năm {year}."));
          }

          $layoutBlocks = [];

          // --- BLOCK 1: Price Table OR Showroom Card ---
          ob_start();
          if ($isPriceSEO):
          ?>
            <!-- Section: Price Table -->
            <div class="local-card-box" id="pseo-showroom-section">
              <h2 class="local-card-title"><?php echo PSEO_Helper::processSpintax(interpolate_pseo_text("{Báo giá xe VinFast niêm yết mới nhất|Bảng giá xe VinFast niêm yết chính hãng|Biểu giá niêm yết xe điện VinFast} {MONTH}/{YEAR}")); ?></h2>
              <?php if (!empty($spunContentParagraph)): ?>
                <div class="local-article-content">
                  <?php echo $spunContentParagraph; ?>
                </div>
              <?php else: ?>
                <p class="local-card-text">
                  <?php echo interpolate_pseo_text("Dưới đây là bảng báo giá chính hãng được cập nhật từ hệ thống quản trị CRM của VinFast Việt Nam, áp dụng cho khách hàng đặt mua xe tại khu vực <strong>{LOCATION}</strong> trong tháng {month}/{year}:"); ?>
                </p>
              <?php endif; ?>

              <!-- User Preference: Prominent pulsing gold 'VUỐT ĐỂ SO SÁNH' button -->
              <div class="swipe-hint-container">
                <div class="swipe-hint-btn">
                  VUỐT ĐỂ SO SÁNH ↔
                </div>
              </div>

              <div class="seo-price-table-container">
                <table class="seo-price-table">
                  <thead>
                    <tr>
                      <th>Mẫu Xe VinFast</th>
                      <th>Phân Khúc</th>
                      <th>Thông Số</th>
                      <th>Giá Niêm Yết (VNĐ)</th>
                      <th>Trạng Thái Giao Xe</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($cars) > 0): ?>
                      <?php foreach ($cars as $car): ?>
                        <?php 
                        $statusText = '';
                        $modelLower = strtolower($car['model_name']);
                        if (strpos($modelLower, 'vf 2') !== false || strpos($modelLower, 'vf 3') !== false || strpos($modelLower, 'vf 5') !== false || strpos($modelLower, 'minio') !== false || strpos($modelLower, 'herio') !== false || strpos($modelLower, 'ec van') !== false) {
                            $statusText = '<span class="status-badge status-ready"><span class="status-dot"></span>SẴN XE GIAO NGAY</span>';
                        } else if (strpos($modelLower, 'vf 6') !== false || strpos($modelLower, 'vf 7') !== false || strpos($modelLower, 'vf 8') !== false || strpos($modelLower, 'nerio') !== false || strpos($modelLower, 'limo') !== false || strpos($modelLower, 'e34') !== false) {
                            $statusText = '<span class="status-badge status-waiting">HẸN BÀN GIAO 7 NGÀY</span>';
                        } else {
                            $statusText = '<span class="status-badge status-order">ĐẶT TRƯỚC SỚM</span>';
                        }
                        ?>
                        <tr>
                          <td>
                            <strong>
                              <a href="<?php echo htmlspecialchars(seo_url('xe-vinfast/' . $car['slug'] . '?ref_loc=' . urlencode($locSlug))); ?>" style="color: var(--color-text-main); text-decoration: none; transition: var(--transition-normal);" onmouseover="this.style.color='var(--color-primary)'; this.style.textDecoration='underline';" onmouseout="this.style.color='var(--color-text-main)'; this.style.textDecoration='none';">
                                <?php echo htmlspecialchars($car['model_name']); ?>
                              </a>
                            </strong>
                          </td>
                          <td><?php echo htmlspecialchars($car['segment']); ?></td>
                          <td><?php echo htmlspecialchars($car['engine'] . ' | ' . ($car['range_wltp'] ?: 'Xe động cơ xăng')); ?></td>
                          <td class="price-gold"><?php echo htmlspecialchars($car['price']); ?></td>
                          <td><?php echo $statusText; ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="5" style="text-align: center; color: var(--color-text-muted);">Đang cập nhật bảng giá chính hãng từ CRM...</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <div style="background: rgba(245, 158, 11, 0.05); border: 1.5px solid rgba(245, 158, 11, 0.25); border-radius: var(--ev-border-radius); padding: 16px 20px; margin-top: 20px; display: flex; gap: 12px; align-items: flex-start;">
                <div style="color: #d97706; font-size: 18px; line-height: 1;">💡</div>
                <div>
                  <h5 style="margin: 0 0 5px; font-size: 13px; font-weight: 700; color: #b45309; text-transform: uppercase;">Nhận Dự Toán Lăn Bánh Chi Tiết:</h5>
                  <p style="margin: 0; font-size: 12.5px; color: #475569; line-height: 1.5;">
                    Giá lăn bánh thực tế tại <strong><?php echo $locationName; ?></strong> bao gồm các loại thuế phí đăng ký (Lệ phí trước bạ xe điện được miễn 100%). Quý khách vui lòng điền thông tin vào form ở cột bên (hoặc bên dưới trên điện thoại) để hệ thống tự động gửi bảng tính giá lăn bánh chi tiết qua Zalo trong 5 phút.
                  </p>
                </div>
              </div>

              <!-- DYNAMIC REGISTRATION FEES & ROAD TAXES ESTIMATE TABLE -->
              <?php
              $isHanoi = !empty($provinceName) && (stripos($provinceName, 'Hà Nội') !== false || stripos($provinceName, 'HN') !== false);
              $isHCM = empty($provinceName) || stripos($provinceName, 'Hồ Chí Minh') !== false || stripos($provinceName, 'HCM') !== false;
              
              $registrationFeeLabel = $isHanoi ? 'Trước bạ Hà Nội (0% xe điện)' : ($isHCM ? 'Trước bạ TP.HCM (0% xe điện)' : 'Trước bạ tỉnh (0% xe điện)');
              $plateFee = ($isHanoi || $isHCM) ? 20000000 : 2000000;
              $plateFeeLabel = ($isHanoi || $isHCM) ? 'Phí biển số (Hà Nội/TP.HCM)' : 'Phí biển số (Tỉnh lẻ)';
              ?>
              <div style="background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255,255,255,0.04); border-radius: var(--ev-border-radius); padding: 20px; margin-top: 25px;">
                <h4 style="font-size: 13.5px; font-weight: 700; color: var(--color-primary); margin: 0 0 10px; text-transform: uppercase; font-family: 'Montserrat', sans-serif !important;">📊 Bảng Tính Lệ Phí Lăn Bánh Tạm Tính Tại <?php echo htmlspecialchars($locationName); ?>:</h4>
                <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px;">
                  Dưới đây là dự toán các khoản thuế và lệ phí bắt buộc khi đăng ký xe điện VinFast lưu hành tại địa bàn <strong><?php echo htmlspecialchars($locationName); ?></strong>:
                </p>
                <div class="seo-price-table-container">
                  <table class="seo-price-table" style="font-size: 12px;">
                    <thead>
                      <tr>
                        <th>Hạng Mục Lệ Phí Đăng Ký</th>
                        <th>Mức Phí (VNĐ)</th>
                        <th>Ghi Chú Hướng Dẫn</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Lệ phí trước bạ (Ô tô điện)</strong></td>
                        <td><span style="color:#10b981; font-weight:700;">0 VNĐ</span></td>
                        <td>Nghị định Chính phủ miễn 100% lệ phí trước bạ cho ô tô điện đăng ký mới</td>
                      </tr>
                      <tr>
                        <td><strong><?php echo $plateFeeLabel; ?></strong></td>
                        <td><?php echo number_format($plateFee); ?> VNĐ</td>
                        <td>Hộ khẩu thường trú tại khu vực thuộc <?php echo $isHanoi ? 'Hà Nội' : ($isHCM ? 'TP. Hồ Chí Minh' : 'Các Tỉnh/Thành phố khác'); ?></td>
                      </tr>
                      <tr>
                        <td><strong>Phí kiểm định xe cơ giới</strong></td>
                        <td>340.000 VNĐ</td>
                        <td>Áp dụng chung toàn quốc cho đăng kiểm lần đầu</td>
                      </tr>
                      <tr>
                        <td><strong>Phí bảo trì đường bộ (12 tháng)</strong></td>
                        <td>1.560.000 VNĐ</td>
                        <td>Đóng hộ nhà nước, xe đăng ký tên cá nhân dưới 9 chỗ</td>
                      </tr>
                      <tr>
                        <td><strong>Bảo hiểm trách nhiệm dân sự</strong></td>
                        <td>480.000 VNĐ</td>
                        <td>Gói bắt buộc tối thiểu đối với xe con du lịch</td>
                      </tr>
                      <tr style="background: rgba(25, 96, 215,0.05); font-weight: 700;">
                        <td><strong>Tổng chi phí đăng ký biển số</strong></td>
                        <td style="color: var(--color-primary);"><?php echo number_format($plateFee + 340000 + 1560000 + 480000); ?> VNĐ</td>
                        <td>Chưa bao gồm giá mua xe & Phí dịch vụ đăng ký hộ (nếu có)</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <p style="font-size: 11px; color: var(--color-text-muted); font-style: italic; margin-top: 12px; line-height: 1.4; text-align: left;">
                  * Ghi chú: Bảng tính trên áp dụng cho xe điện dưới 9 chỗ ngồi đăng ký cá nhân phi thương mại. Đối với các dòng xe dịch vụ Taxi (Minio, Herio, Nerio, Limo Green), xe tải van (EC Van) hoặc xe buýt (EBus), các mức phí bảo trì đường bộ, phí biển số và bảo hiểm TNDS bắt buộc sẽ áp dụng theo biểu phí phương tiện kinh doanh vận tải riêng biệt theo quy định hiện hành.
                </p>
              </div>
            </div>

            <!-- SECTION: CUSTOMER DECISION & EV BENEFITS GUIDE -->
            <div class="local-card-box">
              <h3 class="local-card-title" style="font-size: 14.5px; text-transform: uppercase;">Cẩm Nang Chọn Xe & Tối Ưu Chi Phí Sử Dụng</h3>
              <p class="local-card-text">
                Để giúp quý khách hàng tại <strong><?php echo $locationName; ?></strong> dễ dàng đưa ra quyết định lựa chọn dòng xe phù hợp và hiểu rõ hơn về lợi ích kinh tế vượt trội của xe điện VinFast, chúng tôi xin tóm tắt các thông tin tư vấn hữu ích dưới đây:
              </p>

              <!-- Sub-tab 1: Smart Quiz -->
              <div style="background: rgba(16, 185, 129, 0.02); border: 1px solid rgba(16, 185, 129, 0.1); border-radius: var(--ev-border-radius); padding: 18px; margin-bottom: 20px;">
                <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin: 0 0 12px; display: flex; align-items: center; gap: 8px;">🚗 Gợi Ý Chọn Xe Theo Nhu Cầu Thực Tế:</h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                  <div style="border-left: 3px solid #10b981; padding-left: 10px;">
                    <span style="font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase; display: block; margin-bottom: 2px;">Di chuyển đô thị, dễ luồn lách:</span>
                    <span style="font-size: 12.5px; color: #475569;">👉 Lựa chọn dòng xe <strong>VinFast VF 3</strong> hoặc <strong>VF 5 Plus</strong>. Kích thước nhỏ gọn, bán kính quay vòng tối ưu, dễ đỗ xe trong phố và chi phí vận hành siêu tiết kiệm.</span>
                  </div>
                  <div style="border-left: 3px solid #10b981; padding-left: 10px;">
                    <span style="font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase; display: block; margin-bottom: 2px;">Xe gia đình, rộng rãi & an toàn cao:</span>
                    <span style="font-size: 12.5px; color: #475569;">👉 Lựa chọn dòng xe <strong>VinFast VF 6</strong> hoặc <strong>VF 8</strong>. Cabin rộng rãi, khoang cốp lớn, trang bị gói trợ lái ADAS thông minh phòng ngừa va chạm vượt trội.</span>
                  </div>
                  <div style="border-left: 3px solid #f59e0b; padding-left: 10px;">
                    <span style="font-size: 11px; font-weight: 700; color: #f59e0b; text-transform: uppercase; display: block; margin-bottom: 2px;">Đẳng cấp SUV hạng sang, doanh nhân VIP:</span>
                    <span style="font-size: 12.5px; color: #475569;">👉 Lựa chọn dòng xe flagship <strong>VinFast VF 9</strong>. SUV 7 chỗ cỡ lớn hạng sang, hàng ghế cơ trưởng VIP tích hợp chức năng massage, sưởi và làm mát cao cấp.</span>
                  </div>
                </div>
              </div>

              <!-- Sub-tab 2: Interactive EV vs Gas Cost Calculator -->
              <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin: 20px 0 10px; text-transform: uppercase;">⚡ So Sánh Chi Phí Vận Hành Hàng Tháng (Xăng vs Điện):</h4>
              <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 20px; margin-bottom: 25px;">
                <p style="font-size: 12.5px; color: #475569; margin: 0 0 15px; line-height: 1.5;">
                  Kéo thanh trượt để chọn số km di chuyển thực tế hàng tháng của bạn tại <strong><?php echo htmlspecialchars($locationName); ?></strong> để so sánh chi phí chênh lệch:
                </p>
                
                <!-- Range Slider -->
                <div style="margin: 25px 0 20px; text-align: center;">
                  <input type="range" id="mileageSlider" min="500" max="5000" step="100" value="1500" style="width: 100%; height: 6px; border-radius: 3px; background: #cbd5e1; outline: none; -webkit-appearance: none; cursor: pointer;">
                  <div style="margin-top: 12px; font-family: 'Montserrat', sans-serif !important; font-size: 15px; font-weight: 800; color: var(--color-primary);">
                    📍 Quãng đường: <span id="mileageVal">1.500</span> km / tháng
                  </div>
                </div>

                <!-- Comparison Grid -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; margin-top: 20px;">
                  <!-- Gas Car Card -->
                  <div style="background: #ffffff; border: 1px solid #fee2e2; border-radius: 8px; padding: 15px; border-top: 4px solid #ef4444; box-shadow: 0 4px 10px rgba(0,0,0,0.01);">
                    <span style="font-size: 11px; font-weight: 700; color: #ef4444; text-transform: uppercase; display: block; margin-bottom: 5px;">🚗 Xe Xăng Cùng Phân Khúc</span>
                    <strong id="gasCostVal" style="font-size: 17px; font-weight: 800; color: #1e293b; display: block; margin-bottom: 5px;">3.000.000 VNĐ</strong>
                    <span style="font-size: 11px; color: var(--color-text-muted); line-height: 1.4; display: block;">Tạm tính tiêu hao nhiên liệu trung bình 8L/100km (Giá xăng 25.000đ/L)</span>
                  </div>
                  
                  <!-- EV Car Card -->
                  <div style="background: #ffffff; border: 1px solid #d1fae5; border-radius: 8px; padding: 15px; border-top: 4px solid #10b981; box-shadow: 0 4px 10px rgba(0,0,0,0.01);">
                    <span style="font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase; display: block; margin-bottom: 5px;">⚡ Ô Tô Điện VinFast</span>
                    <strong id="evCostVal" style="font-size: 17px; font-weight: 800; color: #10b981; display: block; margin-bottom: 5px;">825.000 VNĐ</strong>
                    <span style="font-size: 11px; color: var(--color-text-muted); line-height: 1.4; display: block;">Đơn giá sạc trạm 3.858đ/kWh (Tiêu thụ 15 kWh/100km). Đã bao gồm pin.</span>
                  </div>
                </div>

                <!-- Savings Callout -->
                <div style="margin-top: 20px; background: rgba(16, 185, 129, 0.05); border: 1px dashed rgba(16, 185, 129, 0.3); border-radius: 8px; padding: 15px; text-align: center;">
                  <span style="font-size: 12px; color: #065f46; display: block; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">💰 SỐ TIỀN TIẾT KIỆM ĐƯỢC:</span>
                  <strong style="font-size: 19px; font-weight: 800; color: #047857; display: block; margin: 4px 0 2px;">
                    <span id="savingsVal">2.175.000</span> VNĐ / tháng
                  </strong>
                  <span style="font-size: 11.5px; color: #065f46; font-weight: 600;">
                    (~<span id="savingsYearVal">26.100.000</span> VNĐ / năm)
                  </span>
                </div>
              </div>

              <!-- Sub-tab 3: Battery Policy -->
              <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 15px;">
                <h4 style="font-size: 13px; font-weight: 700; color: #0f172a; margin: 0 0 10px; text-transform: uppercase;">🔑 Cẩm Nang Thuê Pin vs Mua Đứt Pin:</h4>
                <p style="margin: 0 0 10px; font-size: 12.5px; color: #475569; line-height: 1.5;">
                  VinFast cung cấp hai hình thức sở hữu pin linh hoạt đáp ứng tối đa mục đích sử dụng của quý khách:
                </p>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; font-size: 12.5px; line-height: 1.5; color: #475569;">
                  <div>
                    <strong style="color: #10b981; display:block; margin-bottom:4px;">1. Hình thức Thuê Pin:</strong>
                    Giúp hạ thấp giá mua xe ban đầu (tiết kiệm từ 90 triệu - 500 triệu đồng). Đặc biệt, hãng chịu mọi rủi ro về pin, cam kết **đổi pin mới 100% miễn phí** khi dung lượng pin tối đa giảm dưới 70%.
                  </div>
                  <div>
                    <strong style="color: #10b981; display:block; margin-bottom:4px;">2. Hình thức Mua Đứt Pin:</strong>
                    Sở hữu trọn vẹn pin đi kèm xe. Bạn hoàn toàn chủ động, không tốn chi phí đóng tiền thuê pin hàng tháng. Đây là lựa chọn tối ưu cho khách hàng đi lại nhiều, muốn khấu hao tài sản nhanh.
                  </div>
                </div>
              </div>
            </div>
          <?php else: ?>
            <!-- SECTION: DEDICATED LUXURY SHOWROOM VIEW -->
            <div class="local-card-box" id="pseo-showroom-section">
              <h2 class="local-card-title">Showroom Đạt Chuẩn VinFast Terminal Toàn Cầu</h2>
              <?php if (!$isProject && !empty($spunContentParagraph)): ?>
                <div class="local-article-content">
                  <?php echo $spunContentParagraph; ?>
                </div>
              <?php else: ?>
                <p class="local-card-text">
                  Chào mừng quý khách tại khu vực <strong><?php echo $locationName; ?></strong>. Showroom đại diện ủy quyền chính hãng của VinFast phục vụ khu vực của quý khách được thiết kế theo tiêu chuẩn kiến trúc <strong>VinFast Terminal</strong> toàn cầu – mang phong cách thiết kế đương đại phi đối xứng, sử dụng chất liệu nhôm tổ ong kết hợp hệ thống ánh sáng tinh tế, tạo nên một không gian trải nghiệm ô tô hạng sang đẳng cấp bậc nhất.
                </p>
              <?php endif; ?>
              
              <div style="position: relative; border-radius: var(--ev-border-radius); overflow: hidden; border: var(--ev-border-light); margin: 25px 0; height: 320px; background: #000;">
                <img src="https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=70&fm=webp" alt="VinFast Terminal Showroom" style="width:100%; height:100%; object-fit:cover; filter:brightness(0.55);" loading="lazy" width="800" height="500">
                <div style="position: absolute; inset:0; background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.1) 75%);"></div>
                <div style="position: absolute; bottom: 24px; left: 24px; right: 24px; z-index:3;">
                  <span style="font-size: 10px; font-weight:700; color:#34d399 !important; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:5px; text-shadow: 0 1px 2px rgba(0,0,0,0.8);">TRẠI NGHIỆM ĐẲNG CẤP CHÂU ÂU</span>
                  <h3 style="font-size: 18px; font-weight:700; color: #ffffff !important; margin-bottom: 8px; text-transform:uppercase; font-family:'Montserrat', sans-serif !important; text-shadow: 0 2px 4px rgba(0,0,0,0.9);">Tiêu chuẩn 4S Ủy Quyền Chính Thức</h3>
                  <p style="font-size:12px; color:rgba(255,255,255,0.9) !important; line-height:1.6; margin:0; text-shadow: 0 1px 2px rgba(0,0,0,0.8);">
                    Đáp ứng trọn vẹn từ không gian trưng bày xe sang, khu xưởng dịch vụ kỹ thuật cao, kho phụ tùng chính hãng VinFast và trạm sạc nhanh VinFast DC 150kW.
                    <?php
                    $distData = estimate_distance_to_showroom($locSlug, $provinceName);
                    $dist1 = $distData['distance'];
                    $timeEstimate = $distData['time'];
                    $hashVal = abs(crc32($locationName));
                    $routes = ['Đại lộ Võ Văn Kiệt', 'Đại lộ Nguyễn Văn Linh', 'Xa lộ Hà Nội', 'Đường Mai Chí Thọ', 'Đường Điện Biên Phủ'];
                    $chosenRoute = $routes[$hashVal % count($routes)];
                    ?>
                    <br><span style="color: #34d399 !important; font-weight: 700;">📍 Hướng dẫn di chuyển:</span> Từ địa bàn <strong style="color:#ffffff !important;"><?php echo $locationName; ?></strong>, quý khách có thể di chuyển qua tuyến đường huyết mạch <strong style="color:#ffffff !important;"><?php echo $chosenRoute; ?></strong> để kết nối trực tiếp đến Showroom của chúng tôi ở Quận 1 (Cách khoảng <strong style="color:#ffffff !important;"><?php echo $dist1; ?> km</strong>, đi xe mất khoảng <strong style="color:#ffffff !important;"><?php echo $timeEstimate; ?> phút</strong>).
                  </p>
                </div>
              </div>

              <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 30px;">
                <div style="background: rgba(255,255,255,0.005); border: 1px solid rgba(255,255,255,0.03); border-radius: var(--ev-border-radius); padding: 20px;">
                  <h4 style="font-size: 14px; font-weight:600; color: var(--color-text-main); margin-bottom: 10px; display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="var(--color-primary)" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Dịch Vụ Kỹ Thuật High-Tech đạt chuẩn quốc tế
                  </h4>
                  <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.6; margin:0;">
                    Khu xưởng dịch vụ quy mô lớn được trang bị 12 khoang sửa chữa công nghệ cao, máy chẩn đoán lỗi vi tính kết nối trực tiếp với trung tâm kỹ thuật VinFast Việt Nam, đảm bảo xử lý chính xác tuyệt đối mọi vấn đề cơ học và điện tử.
                  </p>
                </div>
                <div style="background: rgba(255,255,255,0.005); border: 1px solid rgba(255,255,255,0.03); border-radius: var(--ev-border-radius); padding: 20px;">
                  <h4 style="font-size: 14px; font-weight:600; color: var(--color-text-main); margin-bottom: 10px; display:flex; align-items:center; gap:8px;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="var(--color-primary)" stroke-width="2.5"><path d="M23 7l-7 5 7 5V7z"></path><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                    Phòng Chờ VIP Lounge Thương Gia
                  </h4>
                  <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.6; margin:0;">
                    Trong lúc xe được chăm sóc kỹ thuật, quý khách có thể thư giãn tại phòng chờ VIP Lounge tiêu chuẩn thương gia. Phục vụ miễn phí cafe pha máy, quầy bar cao cấp, wifi tốc độ cao và phòng trưng bày phụ kiện VinFast chính hãng.
                  </p>
                </div>
              </div>
            </div>

            <!-- SECTION: LOCAL COMMITMENT & RADAR COVERAGE FOR DEALER -->
            <div class="local-card-box">
              <h2 class="local-card-title">Mạng Lưới Phục Vụ Địa Phương 24/7</h2>
              <p class="local-card-text">
                Đối với quý khách hàng sở hữu xe VinFast tại <strong><?php echo $locationName; ?></strong>, chúng tôi cam kết cung cấp mạng lưới chăm sóc khách hàng khép kín với các dịch vụ cứu hộ khẩn cấp và giao nhận xe tận nhà:
              </p>
              
              <div class="local-perks-grid">
                <div class="local-perk-card">
                  <div style="background: rgba(16, 185, 129, 0.08); width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; margin-bottom: 12px;">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16,8 20,8 23,11 23,16 16,16"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                  </div>
                  <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Cứu Hộ 24/7 Chuyên Nghiệp</h4>
                  <p style="font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0;">Sẵn sàng xuất kích xe cứu hộ chuyên dụng hỗ trợ kỹ thuật tận nơi tại <strong><?php echo $locationName; ?></strong> bất kể ngày đêm.</p>
                </div>
                
                <div class="local-perk-card">
                  <div style="background: rgba(16, 185, 129, 0.08); width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; margin-bottom: 12px;">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9,22 9,12 15,12 15,22"></polyline></svg>
                  </div>
                  <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Nhận Trả Xe Bảo Dưỡng</h4>
                  <p style="font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0;">Đến nhận xe tận nơi mang đi bảo dưỡng định kỳ và bàn giao lại hoàn tất tại <strong><?php echo $locationName; ?></strong>.</p>
                </div>

                <div class="local-perk-card">
                  <div style="background: rgba(16, 185, 129, 0.08); width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #10b981; margin-bottom: 12px;">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
                  </div>
                  <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin-bottom: 8px;">Lái Thử Tại Nhà (Free)</h4>
                  <p style="font-size: 12.5px; color: #475569; line-height: 1.5; margin: 0;">Đăng ký trải nghiệm lái thử dòng xe điện VinFast thông minh ngay trên các cung đường ở <strong><?php echo $locationName; ?></strong>.</p>
                </div>
              </div>
            </div>

            <!-- EXCLUSIVE DEALER PROMOTIONS BOARD -->
            <div class="local-card-box" id="pseo-promotions-section" style="border: 1px solid rgba(16, 185, 129, 0.3); background: linear-gradient(135deg, rgba(15, 23, 42, 0.98) 0%, rgba(16, 185, 129, 0.05) 100%);">
              <h3 class="local-card-title" style="border-left-color: var(--color-primary); color: #fff; font-family: 'Montserrat', sans-serif !important; font-size: 14.5px; text-transform: uppercase;">
                🎁 Ưu Đãi Đặc Quyền Khi Mua Xe Tại Đại Lý <?php echo htmlspecialchars($locationName); ?> (Tháng <?php echo "$currentMonth/$currentYear"; ?>)
              </h3>
              <p class="local-card-text" style="color: var(--color-text-muted); font-size: 12.5px;">
                Chính sách hỗ trợ lăn bánh và quà tặng đặc biệt áp dụng cho khách hàng hoàn tất cọc sớm trong tháng tại địa phương:
              </p>
              
              <div style="display: grid; grid-template-columns: 1fr; gap: 10px; margin-top: 15px;">
                <div style="display: flex; align-items: flex-start; gap: 10px; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 6px; border-left: 3px solid var(--color-primary);">
                  <span style="font-size: 16px;">🔋</span>
                  <div>
                    <strong style="color: #fff; font-size: 13px; display: block; margin-bottom: 2px;">Miễn Phí 01 Năm Sạc Pin V-Green</strong>
                    <span style="color: var(--color-text-muted); font-size: 12px; line-height:1.4;">Hưởng đặc quyền sạc pin miễn phí tại toàn bộ các trạm sạc công cộng V-Green trên phạm vi cả nước.</span>
                  </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 10px; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 6px; border-left: 3px solid var(--color-primary);">
                  <span style="font-size: 16px;">🔌</span>
                  <div>
                    <strong style="color: #fff; font-size: 13px; display: block; margin-bottom: 2px;">Tặng Bộ Sạc Treo Tường 7.4 kW Thông Minh</strong>
                    <span style="color: var(--color-text-muted); font-size: 12px; line-height:1.4;">Bàn giao và lắp đặt miễn phí hộp sạc treo tường thông minh chính hãng ngay tại nhà riêng cho khách hàng.</span>
                  </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 10px; background: rgba(255,255,255,0.02); padding: 12px; border-radius: 6px; border-left: 3px solid var(--color-primary);">
                  <span style="font-size: 16px;">🛡️</span>
                  <div>
                    <strong style="color: #fff; font-size: 13px; display: block; margin-bottom: 2px;">Gói Cứu Hộ VIP V-Green 24/7 Trọn Đời</strong>
                    <span style="color: var(--color-text-muted); font-size: 12px; line-height:1.4;">Dịch vụ cứu hộ xe khẩn cấp 24/7 phục vụ tận tụy trên các nẻo đường tại khu vực <?php echo htmlspecialchars($locationName); ?>.</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- LIVE DEALER INVENTORY -->
            <div class="local-card-box" id="pseo-inventory-section">
              <h3 class="local-card-title" style="font-size: 14.5px; text-transform: uppercase;">
                🚗 Kho Xe VinFast Sẵn Có Giao Ngay Tại Khu Vực <?php echo htmlspecialchars($locationName); ?>
              </h3>
              <p class="local-card-text" style="font-size: 12.5px; margin-bottom: 15px;">
                Cập nhật thực tế danh sách xe đang có sẵn số khung giao ngay trong ngày tại đại lý phục vụ quý khách:
              </p>
              
              <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
                <div style="background: var(--color-bg-dark); border: 1px solid var(--color-border); border-radius: var(--ev-border-radius); padding: 15px; display: flex; flex-direction: column; justify-content: space-between;">
                  <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                      <strong style="font-size: 14px; color: var(--color-text-main);">VinFast VF 3</strong>
                      <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">Sẵn xe</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                      <span style="font-size: 11px; color: var(--color-text-muted);">Màu sẵn có:</span>
                      <div style="display: flex; gap: 5px;">
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #facc15; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Vàng (Solar Yellow)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #6b7280; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Xám (Zenith Grey)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #ec4899; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Hồng (Rose Pink)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #34d399; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Xanh lục (Creative Green)"></span>
                      </div>
                    </div>
                  </div>
                  <div style="border-top: 1px solid rgba(255,255,255,0.03); padding-top: 8px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 11px;">
                    <span style="color: var(--color-text-muted);">Giá từ: <strong style="color: var(--color-primary);">240 Triệu</strong></span>
                    <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20xe%20VF3%20giao%20ngay%20tại%20<?php echo urlencode($locationName); ?>" target="_blank" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">Xem chi tiết →</a>
                  </div>
                </div>

                <div style="background: var(--color-bg-dark); border: 1px solid var(--color-border); border-radius: var(--ev-border-radius); padding: 15px; display: flex; flex-direction: column; justify-content: space-between;">
                  <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                      <strong style="font-size: 14px; color: var(--color-text-main);">VinFast VF 5 Plus</strong>
                      <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">Sẵn xe</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                      <span style="font-size: 11px; color: var(--color-text-muted);">Màu sẵn có:</span>
                      <div style="display: flex; gap: 5px;">
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #ffffff; border: 1px solid rgba(0,0,0,0.25); display: inline-block;" title="Trắng (Brahminy White)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #047857; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Xanh dương (Aurora Blue)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #f97316; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Cam (Sunset Orange)"></span>
                      </div>
                    </div>
                  </div>
                  <div style="border-top: 1px solid rgba(255,255,255,0.03); padding-top: 8px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 11px;">
                    <span style="color: var(--color-text-muted);">Giá từ: <strong style="color: var(--color-primary);">468 Triệu</strong></span>
                    <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20xe%20VF5%20giao%20ngay%20tại%20<?php echo urlencode($locationName); ?>" target="_blank" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">Xem chi tiết →</a>
                  </div>
                </div>

                <div style="background: var(--color-bg-dark); border: 1px solid var(--color-border); border-radius: var(--ev-border-radius); padding: 15px; display: flex; flex-direction: column; justify-content: space-between;">
                  <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                      <strong style="font-size: 14px; color: var(--color-text-main);">VinFast VF 8</strong>
                      <span style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 4px; text-transform: uppercase;">Đặt cọc sớm</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                      <span style="font-size: 11px; color: var(--color-text-muted);">Màu sẵn có:</span>
                      <div style="display: flex; gap: 5px;">
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #ffffff; border: 1px solid rgba(0,0,0,0.25); display: inline-block;" title="Trắng (Brahminy White)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #111827; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Đen (Deep Black)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #dc2626; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Đỏ (Crimson Red)"></span>
                        <span style="width: 14px; height: 14px; border-radius: 50%; background: #047857; border: 1px solid rgba(0,0,0,0.15); display: inline-block;" title="Xanh dương (Aurora Blue)"></span>
                      </div>
                    </div>
                  </div>
                  <div style="border-top: 1px solid rgba(255,255,255,0.03); padding-top: 8px; margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 11px;">
                    <span style="color: var(--color-text-muted);">Giá từ: <strong style="color: var(--color-primary);">1.090 Triệu</strong></span>
                    <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20xe%20VF8%20tại%20<?php echo urlencode($locationName); ?>" target="_blank" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">Xem chi tiết →</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- LOCAL TESTIMONIALS -->
            <?php if (!empty($nearby) && count($nearby) >= 2): 
              $loc1 = $nearby[0]['display_name'];
              $loc2 = $nearby[1]['display_name'];
            ?>
            <div class="local-card-box">
              <h3 class="local-card-title" style="font-size: 14.5px; text-transform: uppercase;">
                ⭐ Đánh Giá Thực Tế Từ Khách Hàng Tại <?php echo htmlspecialchars($locationName); ?>
              </h3>
              <p class="local-card-text" style="font-size: 12.5px; margin-bottom: 20px;">
                Cảm nhận thực tế của các chủ xe điện VinFast chia sẻ về dịch vụ bàn giao xe và bảo dưỡng tại khu vực:
              </p>
              
              <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
                <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.03); border-radius: var(--ev-border-radius); padding: 18px; position: relative;">
                  <span style="font-size: 30px; color: rgba(16, 185, 129, 0.15); position: absolute; top: 10px; right: 15px; font-family: Georgia, serif; line-height: 1;">“</span>
                  <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                    <strong style="font-size: 13px; color: var(--color-text-main);">Anh Quốc Bảo</strong>
                    <span style="color: var(--color-text-muted); font-size: 11px;">(Đại diện cư dân tại <?php echo htmlspecialchars($loc1); ?>)</span>
                  </div>
                  <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.5; margin: 0; font-style: italic;">
                    "Quyết định mua chiếc xe điện VF 5 Plus là lựa chọn sáng suốt của gia đình tôi. Showroom hỗ trợ làm mọi thủ tục lăn bánh trọn gói, bàn giao xe tận nhà tại <?php echo htmlspecialchars($loc1); ?> cực kỳ chu đáo. Chi phí sạc điện hàng tháng tiết kiệm hơn hẳn xe xăng trước đây."
                  </p>
                </div>

                <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.03); border-radius: var(--ev-border-radius); padding: 18px; position: relative;">
                  <span style="font-size: 30px; color: rgba(16, 185, 129, 0.15); position: absolute; top: 10px; right: 15px; font-family: Georgia, serif; line-height: 1;">“</span>
                  <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                    <strong style="font-size: 13px; color: var(--color-text-main);">Chị Thanh Vân</strong>
                    <span style="color: var(--color-text-muted); font-size: 11px;">(Chủ xe VF 3 sinh sống tại <?php echo htmlspecialchars($loc2); ?>)</span>
                  </div>
                  <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.5; margin: 0; font-style: italic;">
                    "Xe VF 3 nhỏ gọn đi chợ và đón con ở quanh <?php echo htmlspecialchars($loc2); ?> rất tiện. Các bạn tư vấn viên rất tận tình, xe gặp sự cố nhỏ về lốp được đội cứu hộ lưu động của hãng tới xử lý ngay lập tức tại nhà, dịch vụ 5 sao!"
                  </p>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php
          endif;
          $layoutBlocks['price_or_showroom'] = ob_get_clean();

          // --- BLOCK 2: Local Tax Calculator ---
          ob_start();
          if ($isPriceSEO) {
              $isHanoi = !empty($provinceName) && (stripos($provinceName, 'Hà Nội') !== false || stripos($provinceName, 'HN') !== false);
              $isHCM = empty($provinceName) || stripos($provinceName, 'Hồ Chí Minh') !== false || stripos($provinceName, 'HCM') !== false;
              
              $registrationFeeLabel = $isHanoi ? 'Trước bạ Hà Nội (0% xe điện)' : ($isHCM ? 'Trước bạ TP.HCM (0% xe điện)' : 'Trước bạ tỉnh (0% xe điện)');
              $plateFee = ($isHanoi || $isHCM) ? 20000000 : 2000000;
              $plateFeeLabel = ($isHanoi || $isHCM) ? 'Phí biển số (Hà Nội/TP.HCM)' : 'Phí biển số (Tỉnh lẻ)';
          ?>
            <!-- SECTION: LOCAL TAX CALCULATOR -->
            <div class="local-card-box local-tax-card" style="margin-top: 25px;">
              <h4 style="font-size: 13.5px; font-weight: 700; color: var(--color-primary); margin: 0 0 10px; text-transform: uppercase; font-family: 'Montserrat', sans-serif !important;">📊 Bảng Tính Lệ Phí Lăn Bánh Tạm Tính Tại <?php echo htmlspecialchars($locationName); ?>:</h4>
              <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px;">
                Dưới đây là dự toán các khoản thuế và lệ phí bắt buộc khi đăng ký xe điện VinFast lưu hành tại địa bàn <strong><?php echo htmlspecialchars($locationName); ?></strong>:
              </p>
              <div class="seo-price-table-container">
                <table class="seo-price-table" style="font-size: 12px;">
                  <thead>
                    <tr>
                      <th>Hạng Mục Lệ Phí Đăng Ký</th>
                      <th>Mức Phí (VNĐ)</th>
                      <th>Mức Phí Xe Điện EV</th>
                      <th>Ghi Chú Nghiệp Vụ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><strong>1. Lệ phí trước bạ đăng ký</strong></td>
                      <td>10% - 12% giá trị xe (Xe xăng)</td>
                      <td style="color:#10b981; font-weight:700;">Được miễn 100% (0đ)</td>
                      <td>Nghị định 10/2022/NĐ-CP của Chính phủ</td>
                    </tr>
                    <tr>
                      <td><strong>2. Lệ phí cấp biển số xe</strong></td>
                      <td>Tùy theo khu vực quy định</td>
                      <td style="color:var(--color-primary); font-weight:700;"><?php echo number_format($plateFee, 0, ',', '.') . ' VNĐ'; ?></td>
                      <td><?php echo $plateFeeLabel; ?> tại Việt Nam</td>
                    </tr>
                    <tr>
                      <td><strong>3. Phí kiểm định đăng kiểm</strong></td>
                      <td>90.000 VNĐ / chu kỳ</td>
                      <td>90.000 VNĐ</td>
                      <td>Áp dụng chung toàn quốc</td>
                    </tr>
                    <tr>
                      <td><strong>4. Phí bảo trì đường bộ</strong></td>
                      <td>1.560.000 VNĐ / năm</td>
                      <td>1.560.000 VNĐ</td>
                      <td>Đóng tạm tính 12 tháng lưu hành</td>
                    </tr>
                    <tr>
                      <td><strong>5. Bảo hiểm TNDS bắt buộc</strong></td>
                      <td>480.700 VNĐ / năm</td>
                      <td>480.700 VNĐ</td>
                      <td>Áp dụng cho xe dưới 5 chỗ ngồi</td>
                    </tr>
                    <tr style="background: rgba(16, 185, 129, 0.05); border-top: 1.5px solid var(--color-ev-green);">
                      <td><strong>TỔNG LỆ PHÍ ĐĂNG KÝ</strong></td>
                      <td>Lên tới 70tr - 150tr (Xe xăng)</td>
                      <td style="color:#10b981; font-weight:700; font-size: 13.5px;"><?php echo number_format($plateFee + 90000 + 1560000 + 480700, 0, ',', '.') . ' VNĐ'; ?></td>
                      <td><strong>Tiết kiệm hàng chục triệu đồng</strong></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <p style="font-size: 11.5px; color: var(--color-text-muted); line-height: 1.6; margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.03); padding-top: 10px;">
                💡 <em>Ghi chú: Bảng tính trên áp dụng cho xe điện dưới 9 chỗ ngồi đăng ký cá nhân phi thương mại. Đối với các dòng xe dịch vụ Taxi (Minio, Herio, Nerio, Limo Green), xe tải van (EC Van) hoặc xe buýt (EBus), các mức phí bảo trì đường bộ, phí biển số và bảo hiểm TNDS bắt buộc sẽ áp dụng theo biểu phí phương tiện kinh doanh vận tải riêng biệt theo quy định hiện hành.</em>
              </p>

              <!-- DYNAMIC COMPARISON WITH TRADITIONAL GASOLINE CARS -->
              <div style="background: rgba(16, 185, 129, 0.03); border: 1px solid rgba(16, 185, 129, 0.15); border-radius: var(--ev-border-radius); padding: 20px; margin-top: 25px;">
                <h4 style="font-size: 13.5px; font-weight: 700; color: var(--color-ev-green); margin: 0 0 10px; text-transform: uppercase; font-family: 'Montserrat', sans-serif !important;">💡 So Sánh Lợi Ích Lăn Bánh Xe Điện vs Xe Xăng Tại <?php echo htmlspecialchars($locationName); ?>:</h4>
                <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.6; margin-bottom: 15px;">
                  Sở hữu xe điện VinFast giúp quý khách tiết kiệm chi phí lăn bánh vượt trội so với các dòng xe động cơ xăng truyền thống cùng phân khúc:
                </p>
                <div class="seo-price-table-container">
                  <table class="seo-price-table" style="font-size: 12px; border-collapse: collapse;">
                    <thead>
                      <tr style="background: rgba(16, 185, 129, 0.05); border-bottom: 2px solid var(--color-ev-green);">
                        <th>Hạng Mục So Sánh</th>
                        <th>Xe Xăng Truyền Thống</th>
                        <th>Xe Điện Thông Minh EV</th>
                        <th>Lợi Thế Vượt Trội</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Thuế Trước Bạ Lăn Bánh</strong></td>
                        <td>Đóng 10% - 12% giá niêm yết</td>
                        <td style="color:#10b981; font-weight:700;">Miễn phí 100% (0%)</td>
                        <td><strong>Tiết kiệm từ 40tr - 200tr đồng</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Chi phí sạc pin/nhiên liệu</strong></td>
                        <td>Khoảng 2.000 - 2.500đ / km</td>
                        <td style="color:#10b981; font-weight:700;">Khoảng 500đ - 800đ / km</td>
                        <td><strong>Giảm tới 70% chi phí vận hành</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Chi phí bảo dưỡng định kỳ</strong></td>
                        <td>Cao (Nhiều chi tiết cơ khí phức tạp)</td>
                        <td style="color:#10b981; font-weight:700;">Rất thấp (Chủ yếu kiểm tra phần mềm & pin)</td>
                        <td><strong>Tiết kiệm 50% chi phí bảo dưỡng</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Chế độ bảo hành hãng</strong></td>
                        <td>3 - 5 năm (Giới hạn quãng đường)</td>
                        <td><span style="color:#10b981; font-weight:700;">10 năm hoặc 200.000 km</span></td>
                        <td><strong>An tâm dài hạn gấp đôi</strong></td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Sub-tab 3: Battery Policy -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 15px;">
                  <h4 style="font-size: 13px; font-weight: 700; color: #0f172a; margin: 0 0 10px; text-transform: uppercase;">🔑 Cẩm Nang Thuê Pin vs Mua Đứt Pin:</h4>
                  <p style="margin: 0 0 10px; font-size: 12.5px; color: #475569; line-height: 1.5;">
                    VinFast cung cấp hai hình thức sở hữu pin linh hoạt đáp ứng tối đa mục đích sử dụng của quý khách:
                  </p>
                  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; font-size: 12.5px; line-height: 1.5; color: #475569;">
                    <div>
                      <strong style="color: #10b981; display:block; margin-bottom:4px;">1. Hình thức Thuê Pin:</strong>
                      Giúp hạ thấp giá mua xe ban đầu (tiết kiệm từ 90 triệu - 500 triệu đồng). Đặc biệt, hãng chịu mọi rủi ro về pin, cam kết **đổi pin mới 100% miễn phí** khi dung lượng pin tối đa giảm dưới 70%.
                    </div>
                    <div>
                      <strong style="color: #10b981; display:block; margin-bottom:4px;">2. Hình thức Mua Đứt Pin:</strong>
                      Sở hữu trọn vẹn pin đi kèm xe. Bạn hoàn toàn chủ động, không tốn chi phí đóng tiền thuê pin hàng tháng. Đây là lựa chọn tối ưu cho khách hàng đi lại nhiều, muốn khấu hao tài sản nhanh.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          $layoutBlocks['tax_calc'] = ob_get_clean();

          // --- BLOCK 3: Brand Commitment, Calculator & Online counselors ---
          ob_start();
          ?>
          <!-- Section: Brand commitment -->
          <div class="local-card-box">
            <h2 class="local-card-title">Cam kết từ VinFast Việt Nam</h2>
            <p class="local-card-text" style="margin-bottom: 0;">
              Mỗi chiếc xe VinFast được bàn giao tại <strong><?php echo $locationName; ?></strong> đều được sản xuất lắp ráp hoàn toàn tại tổ hợp nhà máy hiện đại bậc nhất Hải Phòng với chế độ bảo hành 3 năm không giới hạn quãng đường di chuyển. Đối với dòng xe thuần điện VinFast EV, pin lithium-ion được cam kết bảo hành chính hãng lên tới 8 năm hoặc 160.000km, mang lại sự an tâm trọn vẹn và niềm kiêu hãnh bền bỉ vượt thời gian.
            </p>
          </div>

          <!-- PLACEHOLDER FOR MOBILE CALCULATOR POSITIONING -->
          <div id="mobile-calc-target">
            <?php echo renderInstallmentCalculator($locationName, $cars, $interestRate, true); ?>
          </div>

          <!-- SECTION: ONLINE CONNECT & 24/7 SUPPORT CENTER -->
          <?php
          if (empty($counselors)) {
              $counselors = [
                  [
                      'fullname' => 'Nguyễn Thanh Hương',
                      'phone' => '0817777855',
                      'zalo' => 'https://zalo.me/0817777855',
                      'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
                      'status' => 'ONLINE'
                  ],
                  [
                      'fullname' => 'Trần Minh Hoàng',
                      'phone' => '0817777855',
                      'zalo' => 'https://zalo.me/0817777855',
                      'avatar' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80',
                      'status' => 'ONLINE'
                  ]
              ];
          }
          ?>
          <div class="local-card-box" id="pseo-counselor-section" style="border-color: var(--color-border); background: linear-gradient(135deg, rgba(10,14,21,0.98) 0%, var(--color-primary-glow) 100%);">
            <div style="text-align: center; margin-bottom: 20px;">
              <span style="font-size: 11px; font-weight: 700; color: var(--color-primary); letter-spacing: 2px; text-transform: uppercase;">Kết Nối Trực Tuyến</span>
              <h3 style="font-size: 20px; font-weight: 500; color: var(--color-text-main); margin: 5px 0 0; text-transform: uppercase; font-family: 'Montserrat', sans-serif !important;">Trực ban hỗ trợ 24/7</h3>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
              <?php foreach ($counselors as $c): ?>
                <div style="background: rgba(255,255,255,0.01); border: var(--ev-border-light); border-radius: var(--ev-border-radius); padding: 15px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                  <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="position: relative; width: 50px; height: 50px; flex-shrink: 0;">
                      <?php
                      $cAvatar = $c['avatar'] ?? '';
                      $cAvatarUrl = preg_match('#^(https?://|//)#i', $cAvatar) ? $cAvatar : seo_url($cAvatar);
                      ?>
                      <img src="<?php echo htmlspecialchars($cAvatarUrl); ?>" alt="<?php echo htmlspecialchars($c['fullname']); ?>" width="50" height="50" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; border: 1.5px solid var(--color-primary);" loading="lazy" decoding="async">
                      <span class="pulse-dot" style="position: absolute; bottom: 2px; right: 2px; width: 10px; height: 10px; background-color: #4caf50; border: 1.5px solid #000; border-radius: 50%;"></span>
                    </div>
                    <div>
                      <h4 style="font-size: 14.5px; font-weight: 600; color: var(--color-text-main); margin: 0 0 3px; font-family: 'Montserrat', sans-serif !important;"><?php echo htmlspecialchars($c['fullname']); ?></h4>
                      <span style="font-size: 11.5px; color: var(--color-text-muted); display: inline-flex; align-items: center; gap: 4px;">
                        <span style="width: 5px; height: 5px; border-radius: 50%; background: #4caf50; display: inline-block;"></span>
                        Đang trực ban hỗ trợ
                      </span>
                    </div>
                  </div>
                  <div style="display: flex; flex-direction: column; gap: 6px;">
                    <a href="tel:<?php echo htmlspecialchars($c['phone']); ?>" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: rgba(76,175,80,0.1); border: 1.5px solid rgba(76,175,80,0.3); color: #4caf50; padding: 6px 14px; border-radius: var(--ev-border-radius); font-size: 12px; font-weight: 700; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#4caf50'; this.style.color='#fff';" onmouseout="this.style.background='rgba(76,175,80,0.1)'; this.style.color='#4caf50';">
                      <?php echo get_svg_icon('fa-phone-alt', 10, 10, 'vertical-align: middle;'); ?> Gọi
                    </a>
                    <a href="<?php echo htmlspecialchars($c['zalo']); ?>" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: var(--color-primary-glow); border: 1.5px solid rgba(52, 211, 153, 0.3); color: var(--color-primary); padding: 6px 14px; border-radius: var(--ev-border-radius); font-size: 12px; font-weight: 700; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='var(--color-primary)'; this.style.color='#fff';" onmouseout="this.style.background='var(--color-primary-glow)'; this.style.color='var(--color-primary)';">
                      <?php echo get_svg_icon('fa-comment-dots', 10, 10, 'vertical-align: middle;'); ?> Zalo
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php
          $layoutBlocks['brand_counselors'] = ob_get_clean();

          // --- BLOCK 4: Catalog Grid ---
          ob_start();
          if (!empty($featuredCars)):
          ?>
            <div class="local-card-box" id="pseo-catalog-section">
              <div class="section-header" style="text-align: center; margin-bottom: 35px;">
                <span class="section-tag" style="display: inline-block;">Tuyệt Tác Thiết Kế & Hiệu Suất</span>
                <h3 class="section-title" style="font-size: 22px; font-weight: 800; color: var(--color-text-dark) !important; margin: 8px 0 0; text-transform: uppercase; text-shadow: none;"><?php echo htmlspecialchars($settings['news_related_cars_title'] ?? 'Dòng Xe VinFast Nổi Bật'); ?></h3>
              </div>
              
              <div class="catalog-grid" id="catalog-grid-container" style="gap: 20px;">
                <?php foreach ($featuredCars as $fCar): 
                  $segmentLower = mb_strtolower($fCar['segment'] ?? '');
                  $nameLower = mb_strtolower($fCar['model_name'] ?? '');
                  
                  $groupLabel = 'Đô Thị & Mini';
                  if (str_contains($segmentLower, 'dịch vụ') || str_contains($nameLower, 'green') || str_contains($nameLower, 'van')) {
                      $groupLabel = 'Dịch Vụ Green';
                  } elseif (str_contains($segmentLower, 'cỡ b') || str_contains($segmentLower, 'cỡ c') || str_contains($segmentLower, 'cỡ d')) {
                      $groupLabel = 'SUV Tầm Trung';
                  } elseif (str_contains($segmentLower, 'cỡ e') || str_contains($segmentLower, 'cỡ lớn') || str_contains($nameLower, 'vf 9')) {
                      $groupLabel = 'SUV Hạng Sang';
                  }
                ?>
                  <article class="car-card">
                    <div class="car-card__media">
                      <span class="car-card__badge car-card__badge--electric">
                        <?php echo $groupLabel; ?>
                      </span>
                      <img class="car-card__img" src="<?php echo htmlspecialchars(get_thumb_url($fCar['image'], 480)); ?>" alt="<?php echo htmlspecialchars($fCar['model_name']); ?>" loading="lazy" width="400" height="250" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                      <div class="car-card__img-fallback" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, hsla(216, 20%, 85%, 0.9), #ffffff); align-items: center; justify-content: center; text-align: center; padding: 24px; border: 1px solid rgba(16, 185, 129, 0.15); z-index: 1;">
                        <span style="font-family: 'Montserrat', sans-serif !important; font-weight: 800 !important; font-size: 16px; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ev-green); text-shadow: 0 0 10px rgba(16, 185, 129, 0.2); background: linear-gradient(135deg, #000 30%, var(--color-ev-green) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo htmlspecialchars($fCar['model_name']); ?></span>
                      </div>
                    </div>
                    
                    <div class="car-card__info">
                      <span class="car-card__segment"><?php echo htmlspecialchars($fCar['segment']); ?></span>
                      <h3 class="car-card__name"><?php echo htmlspecialchars($fCar['model_name']); ?></h3>
                      <p class="car-card__desc"><?php echo htmlspecialchars($fCar['description'] ?? 'Mẫu xe điện thông minh sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?></p>
                      
                      <div class="car-card__specs">
                        <div class="car-card__spec-item">
                          <span class="car-card__spec-lbl">Công suất</span>
                          <span class="car-card__spec-val"><?php echo htmlspecialchars($fCar['power'] ?: 'N/A'); ?></span>
                        </div>
                        <div class="car-card__spec-item">
                          <span class="car-card__spec-lbl">Gia tốc (0-100)</span>
                          <span class="car-card__spec-val"><?php echo htmlspecialchars($fCar['acceleration'] ?: 'N/A'); ?></span>
                        </div>
                        <div class="car-card__spec-item" style="grid-column: span 2; border-top:1px solid rgba(0,0,0,0.05); padding-top:6px; margin-top:2px;">
                          <span class="car-card__spec-lbl">Động cơ / Truyền động</span>
                          <span class="car-card__spec-val" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color: var(--color-text-dark);" title="<?php echo htmlspecialchars($fCar['engine']); ?>">
                            <?php echo htmlspecialchars($fCar['engine']); ?>
                          </span>
                        </div>
                      </div>

                      <?php
                        $priceRaw = !empty($fCar['price']) ? trim($fCar['price']) : 'Liên hệ';
                        if ($priceRaw === 'Liên hệ') {
                            $formattedPriceHtml = '<span class="price-main-num">Liên hệ</span>';
                        } elseif (strpos($priceRaw, '/') !== false) {
                            $parts = explode('/', $priceRaw);
                            $mainPrice = trim($parts[0]);
                            $subNote = '/ ' . trim($parts[1]);
                            $formattedPriceHtml = '<span class="price-main-num">' . htmlspecialchars($mainPrice) . '</span><span class="price-sub-note">' . htmlspecialchars($subNote) . '</span>';
                        } else {
                            $formattedPriceHtml = '<span class="price-main-num">' . htmlspecialchars($priceRaw) . '</span>';
                        }
                      ?>
                      <div class="car-card__price-box">
                        <span class="car-card__price-lbl">Giá khởi điểm</span>
                        <div class="car-card__price-val"><?php echo $formattedPriceHtml; ?></div>
                      </div>

                      <div class="car-card__footer">
                        <a href="<?php echo seo_url('xe-vinfast/' . $fCar['slug']); ?>" class="btn-detail-card">Chi tiết</a>
                        <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20và%20tư%20vấn%20dòng%20xe%20VinFast%20<?php echo urlencode($fCar['model_name']); ?>" target="_blank" class="btn-zalo-card" rel="noopener">
                          <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                          </svg>
                          <span>Tư vấn Zalo</span>
                        </a>
                      </div>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            </div>
          <?php
          endif;
          $layoutBlocks['catalog'] = ob_get_clean();

          // --- BLOCK 5: Silo Interlinking ---
          ob_start();
          if (!empty($nearby)):
          ?>
            <div class="local-card-box" id="pseo-silo-section">
              <h3 class="local-card-title" style="font-size: 14.5px; text-transform: uppercase;">Các Khu Vực Lân Cận Được Hỗ Trợ</h3>
              <p class="local-card-text" style="font-size: 12.5px; margin-bottom: 15px;">
                Quý khách hàng cũng có thể tham khảo bảng giá lăn bánh và showroom trải nghiệm xe VinFast chính hãng tại các khu vực lân cận <strong><?php echo $locationName; ?></strong>:
              </p>
              <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
                <?php foreach ($nearby as $item): 
                  $url = 'tai-' . $item['slug'] . '.html';
                  if ($item['type'] === 'chungcu' && strpos($item['slug'], 'chung-cu-') === false) {
                      $url = 'gan-' . $item['slug'] . '.html';
                  }
                  $fullUrl = seo_url($matchedKeyword['slug'] . '-' . $url);
                ?>
                  <a href="<?php echo htmlspecialchars($fullUrl); ?>" class="nearby-link">
                    📍 <?php echo htmlspecialchars($item['display_name']); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
            
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--ev-border-radius); padding: 18px; margin-top: 20px;">
              <h4 style="font-size: 13.5px; font-weight: 700; color: #0f172a; margin: 0 0 10px; text-transform: uppercase;">🚗 Mua Xe VinFast Giá Tốt Tại <?php echo htmlspecialchars($locationName); ?>:</h4>
              <p style="font-size: 12.5px; color: #475569; margin: 0 0 12px; line-height: 1.5;">
                Quý khách hàng quan tâm đến các dòng xe điện thông minh đột phá có thể tham khảo chi tiết báo giá và chính sách hỗ trợ riêng tại địa phương:
              </p>
              <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 8px 15px; font-size: 12.5px;">
                <?php foreach ($cars as $car): 
                  $carUrl = seo_url('xe-vinfast/' . $car['slug'] . '?ref_loc=' . urlencode($locSlug));
                ?>
                  <a href="<?php echo htmlspecialchars($carUrl); ?>" style="color: #10b981; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                    👉 Bảng giá xe <?php echo htmlspecialchars($car['model_name']); ?> tại <?php echo htmlspecialchars($locationName); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php
          endif;
          $layoutBlocks['silo'] = ob_get_clean();
          ?>
          <?php
          // --- BLOCK 6: FAQs Section ---
          ob_start();
          ?>

          <div class="local-card-box faq-section" id="pseo-faq-section">
            <h3 class="local-card-title" style="font-size: 14.5px; text-transform: uppercase;">Câu Hỏi Thường Gặp (FAQs)</h3>
            <p class="local-card-text" style="font-size: 12.5px; margin-bottom: 20px;">
              Giải đáp nhanh các thắc mắc phổ biến của khách hàng quan tâm đến các dòng xe VinFast cao cấp tại khu vực <strong><?php echo $locationName; ?></strong>:
            </p>

            <div class="faq-list">
              <div class="faq-item">
                <div class="faq-header">
                  <h4 class="faq-question"><?php echo htmlspecialchars($q1); ?></h4>
                  <span class="faq-icon"><?php echo get_svg_icon('fa-chevron-down', 12, 12); ?></span>
                </div>
                <div class="faq-answer-wrapper">
                  <p class="faq-answer"><?php echo htmlspecialchars($a1); ?></p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-header">
                  <h4 class="faq-question"><?php echo htmlspecialchars($q2); ?></h4>
                  <span class="faq-icon"><?php echo get_svg_icon('fa-chevron-down', 12, 12); ?></span>
                </div>
                <div class="faq-answer-wrapper">
                  <p class="faq-answer"><?php echo htmlspecialchars($a2); ?></p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-header">
                  <h4 class="faq-question"><?php echo htmlspecialchars($q3); ?></h4>
                  <span class="faq-icon"><?php echo get_svg_icon('fa-chevron-down', 12, 12); ?></span>
                </div>
                <div class="faq-answer-wrapper">
                  <p class="faq-answer"><?php echo htmlspecialchars($a3); ?></p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-header">
                  <h4 class="faq-question"><?php echo htmlspecialchars($q4); ?></h4>
                  <span class="faq-icon"><?php echo get_svg_icon('fa-chevron-down', 12, 12); ?></span>
                </div>
                <div class="faq-answer-wrapper">
                  <p class="faq-answer"><?php echo htmlspecialchars($a4); ?></p>
                </div>
              </div>
            </div>
          </div>

          <!-- DYNAMIC FAQ SCHEMA FOR GOOGLE SEARCH RICH SNIPPETS -->
          <script type="application/ld+json">
          {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
              {
                "@type": "Question",
                "name": "<?php echo htmlspecialchars($q1); ?>",
                "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "<?php echo htmlspecialchars($a1); ?>"
                }
              },
              {
                "@type": "Question",
                "name": "<?php echo htmlspecialchars($q2); ?>",
                "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "<?php echo htmlspecialchars($a2); ?>"
                }
              },
              {
                "@type": "Question",
                "name": "<?php echo htmlspecialchars($q3); ?>",
                "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "<?php echo htmlspecialchars($a3); ?>"
                }
              },
              {
                "@type": "Question",
                "name": "<?php echo htmlspecialchars($q4); ?>",
                "acceptedAnswer": {
                  "@type": "Answer",
                  "text": "<?php echo htmlspecialchars($a4); ?>"
                }
              }
            ]
          }
          </script>
          <?php
          $layoutBlocks['faqs'] = ob_get_clean();

          // --- EXECUTE DETERMINISTIC SEEDED SHUFFLE (Core Article Content Blocks Only) ---
          $shuffledBlocks = [];
          foreach (['price_or_showroom', 'tax_calc', 'brand_counselors'] as $bk) {
              if (isset($layoutBlocks[$bk]) && !empty(trim($layoutBlocks[$bk]))) {
                  $shuffledBlocks[$bk] = $layoutBlocks[$bk];
              }
          }
          
          $layoutSeed = crc32($locSlug);
          mt_srand($layoutSeed);
          $keys = array_keys($shuffledBlocks);
          for ($i = count($keys) - 1; $i > 0; $i--) {
              $j = mt_rand(0, $i);
              $tmp = $keys[$i];
              $keys[$i] = $keys[$j];
              $keys[$j] = $tmp;
          }
          mt_srand(); // reset seed to original

          // Render shuffled core blocks
          foreach ($keys as $key) {
              echo $shuffledBlocks[$key];
          }

          // Render fixed bottom blocks in natural sequence
          if (isset($layoutBlocks['catalog']) && !empty(trim($layoutBlocks['catalog']))) {
              echo $layoutBlocks['catalog'];
          }
          if (isset($layoutBlocks['silo']) && !empty(trim($layoutBlocks['silo']))) {
              echo $layoutBlocks['silo'];
          }
          if (isset($layoutBlocks['faqs']) && !empty(trim($layoutBlocks['faqs']))) {
              echo $layoutBlocks['faqs'];
          }
          ?>

        </div>

        <!-- RIGHT: SIDEBAR VIP CONSULT CTA -->
        <aside class="local-sidebar">
          <div class="vip-local-card" id="pseo-sidebar-card">
            <svg class="vip-local-icon" viewBox="0 0 100 35" width="60" height="20" fill="none" stroke="currentColor" stroke-width="2.5">
              <circle cx="16" cy="17.5" r="12" />
              <circle cx="37" cy="17.5" r="12" />
              <circle cx="58" cy="17.5" r="12" />
              <circle cx="79" cy="17.5" r="12" />
            </svg>
            <h3 class="vip-local-title">Tư Vấn VIP Tại <?php echo $locationName; ?></h3>
            <p class="vip-local-desc" id="pseo-sidebar-desc">
              Đăng ký nhận bảng tính giá lăn bánh chi tiết từng tháng, ưu đãi mùa hè hoặc đăng ký lái thử xe tại nhà ở khu vực <strong><?php echo $locationName; ?></strong>:
            </p>
            
            <form id="pseo-sidebar-form" method="POST" style="display: flex; flex-direction: column; gap: 15px; text-align: left; margin-top: 20px;">
              <!-- Anti-spam HoneyPot field -->
              <input type="text" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">
              <input type="hidden" name="loc_name" value="<?php echo htmlspecialchars($locationName); ?>">
              <input type="hidden" name="loc_slug" value="<?php echo htmlspecialchars($slug); ?>">
              
              <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-size: 11px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Họ và Tên *</label>
                <input type="text" name="fullname" required placeholder="Nguyễn Văn A" style="background: var(--color-surface); border: var(--ev-border-light); border-radius: var(--ev-border-radius); padding: 10px 14px; font-size: 13px; color: var(--color-text-main); width: 100%; outline: none; transition: var(--transition-normal);" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
              </div>
              
              <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-size: 11px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Số Điện Thoại *</label>
                <input type="tel" name="phone" required placeholder="0912345678" style="background: var(--color-surface); border: var(--ev-border-light); border-radius: var(--ev-border-radius); padding: 10px 14px; font-size: 13px; color: var(--color-text-main); width: 100%; outline: none; transition: var(--transition-normal);" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
              </div>
              
              <div style="display: flex; flex-direction: column; gap: 5px;">
                <label style="font-size: 11px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Dòng xe quan tâm *</label>
                <select name="car_id" required style="background: var(--color-surface); border: var(--ev-border-light); border-radius: var(--ev-border-radius); padding: 10px 14px; font-size: 13px; color: var(--color-text-main); width: 100%; outline: none; transition: var(--transition-normal); cursor: pointer;" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
                  <option value="" disabled selected style="background: var(--color-bg-base); color: var(--color-text-main);">Chọn dòng xe...</option>
                  <?php foreach ($cars as $car): ?>
                    <option value="<?php echo $car['id']; ?>" style="background: var(--color-bg-base); color: var(--color-text-main);"><?php echo htmlspecialchars($car['model_name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <button type="submit" class="vip-local-btn" style="border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 10px;">
                <span>Đăng ký nhận báo giá</span>
              </button>
            </form>
            
            <div id="pseo-sidebar-success" style="display: none; flex-direction: column; align-items: center; justify-content: center; gap: 15px; padding: 20px 10px; margin-top: 20px;">
              <div style="width: 50px; height: 50px; border-radius: 50%; border: 2px solid var(--color-primary); display: flex; align-items: center; justify-content: center; color: var(--color-primary); font-size: 24px; animation: scale-up 0.4s ease-out;">
                ✓
              </div>
              <h4 style="font-size: 16px; font-weight: 600; color: var(--color-text-main); margin: 0; text-transform: uppercase;">Đăng Ký Thành Công!</h4>
              <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.6; margin: 0; text-align: center;" id="pseo-success-message">
                Chuyên viên cố vấn VinFast sẽ liên hệ tới quý khách tại <?php echo $locationName; ?> trong vòng 15 phút.
              </p>
            </div>
          </div>

          <!-- SIDEBAR WIDGET: INTERACTIVE INSTALLMENT CALCULATOR -->
          <?php echo renderInstallmentCalculator($locationName, $cars, $interestRate, false); ?>

          <!-- SIDEBAR WIDGET: SHOWROOM & ESTIMATED DISTANCE -->
          <?php
            $distData = estimate_distance_to_showroom($locSlug, $provinceName);
            $hashVal = abs(crc32($locationName));
            $dist1 = $distData['distance'];
          ?>
          <div class="vip-local-card" style="margin-top: 20px; border-color: var(--color-border); text-align: left; background: rgba(0,0,0,0.25);">
            <h3 class="vip-local-title" style="font-size: 14px; display: flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif !important; font-weight:700;">
              📍 Dẫn đường & Khoảng cách
            </h3>
            <p style="font-size: 12px; line-height: 1.5; color: var(--color-text-muted); margin-bottom: 12px;">
              Ước tính khoảng cách từ vị trí của bạn tại <strong><?php echo htmlspecialchars($locationName); ?></strong> đến Showroom phân phối xe điện VinFast chính hãng:
            </p>
            
            <div style="background: rgba(255,255,255,0.02); border: var(--ev-border-light); border-radius: 8px; padding: 12px; font-size: 12px; display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px;">
              <!-- Leaflet Interactive Map -->
              <div id="pseo-local-map" style="height: 160px; border-radius: 8px; border: var(--ev-border-light); background: #111; overflow: hidden; position: relative; cursor: pointer;">
                <div style="position: absolute; inset:0; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 5; text-align: center; padding: 15px;" id="map-placeholder">
                  <span style="font-size:11px; color: var(--color-text-muted); line-height: 1.4;">⚡ Bấm vào để tải bản đồ trạm sạc & showroom vệ tinh gần <?php echo htmlspecialchars($locationName); ?>...</span>
                </div>
                <div id="map-iframe-container" style="width:100%; height:100%; display:none;"></div>
              </div>

              <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode(($settings['agency_name'] ?? 'VinFast Tam Phong') . ' ' . ($settings['agency_address'] ?? '6B Tôn Đức Thắng, Quận 1')); ?>" target="_blank" rel="noopener" class="vip-local-btn" style="display: block; width: 100%; text-align: center; text-decoration: none; padding: 10px 0; font-size: 12px; font-weight: 700; margin-top: 15px; background: rgba(255,255,255,0.03); border: 1px solid var(--color-primary); color: var(--color-primary);">
                Mở Google Maps dẫn đường ↗
              </a>

              <?php
              $isHCM = empty($provinceName) || stripos($provinceName, 'Hồ Chí Minh') !== false || stripos($provinceName, 'HCM') !== false;
              $isHanoi = !empty($provinceName) && (stripos($provinceName, 'Hà Nội') !== false || stripos($provinceName, 'HN') !== false);
              
              if ($isHCM) {
                  $nearestShowroomLabel = 'Showroom Bến Nghé Q.1';
                  $nearestShowroomAddress = $settings['agency_address'] ?? '6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh';
              } elseif ($isHanoi) {
                  $nearestShowroomLabel = 'Showroom Royal City';
                  $nearestShowroomAddress = 'TTTM Royal City, 72A Nguyễn Trãi, Thượng Đình, Thanh Xuân, Hà Nội';
              } else {
                  $nearestShowroomLabel = 'Đại lý Ủy Quyền VinFast';
                  $nearestShowroomAddress = 'Hệ thống Showroom 3S & Đại lý Ủy Quyền gần nhất tại ' . ($provinceName ?: 'địa phương của bạn');
              }
              $dist2 = round((($hashVal * 7) % 12) + 2.5, 1);
              $dist3 = round((($hashVal * 13) % 8) + 0.8, 1);
              ?>
              <div style="background: rgba(16, 185, 129, 0.02); border: 1.5px dashed rgba(16, 185, 129, 0.15); border-radius: var(--ev-border-radius); padding: 15px; margin-top: 15px;">
                <h4 style="font-size: 12.5px; font-weight: 700; color: #0f172a; margin: 0 0 10px; display: flex; align-items: center; gap: 8px; text-transform: uppercase;">⚡ Điểm Sạc Pin Gần <?php echo htmlspecialchars($locationName); ?> Nhất:</h4>
                <ul style="margin: 0; padding-left: 20px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 6px; list-style-type: square;">
                  <li><strong><?php echo $nearestShowroomLabel; ?>:</strong> Cách khoảng <strong><?php echo $dist1; ?> km</strong></li>
                  <li><strong>TTTM Vincom Center:</strong> Cách khoảng <strong><?php echo $dist2; ?> km</strong></li>
                  <li><strong>Trạm Sạc Vệ Tinh Gần Nhất:</strong> Cách khoảng <strong><?php echo $dist3; ?> km</strong></li>
                </ul>
              </div>

              <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 6px; margin-top: 10px;">
                <span style="color: var(--color-text-muted);">Khoảng cách dự kiến:</span>
                <span style="color: var(--color-primary); font-weight: 700;"><?php echo $distData['distance']; ?> km</span>
              </div>
              <div style="display: flex; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 6px;">
                <span style="color: var(--color-text-muted);">Thời gian di chuyển:</span>
                <span style="color: #fff; font-weight: 600;"><?php echo $distData['time']; ?> phút</span>
              </div>
              <div style="display: flex; flex-direction: column; gap: 4px; margin-top: 4px;">
                <span style="color: var(--color-text-muted); font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Địa chỉ Showroom:</span>
                <span style="color: #fff; font-size: 12px; line-height: 1.4;"><?php echo htmlspecialchars($nearestShowroomAddress); ?></span>
              </div>
            </div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
              // 1. Sidebar VIP Lead Form Submission
              const vipForm = document.getElementById('pseo-sidebar-form');
              if (vipForm) {
                vipForm.addEventListener('submit', function(e) {
                  e.preventDefault();
                  const form = this;
                  const submitBtn = form.querySelector('button[type="submit"]');
                  const origBtnText = submitBtn.innerHTML;
                  
                  submitBtn.disabled = true;
                  submitBtn.innerHTML = '<span>Đang gửi thông tin...</span>';
                  
                  const formData = new FormData(form);
                  
                  fetch('<?php echo seo_url("ajax-vip-lead.php"); ?>', {
                    method: 'POST',
                    body: formData
                  })
                  .then(res => res.json())
                  .then(data => {
                    if (data.success) {
                      form.style.display = 'none';
                      const descEl = document.getElementById('pseo-sidebar-desc');
                      if (descEl) descEl.style.display = 'none';
                      const msgEl = document.getElementById('pseo-success-message');
                      if (msgEl) msgEl.innerText = data.message;
                      const successBox = document.getElementById('pseo-sidebar-success');
                      if (successBox) successBox.style.display = 'flex';
                    } else {
                      alert(data.message);
                      submitBtn.disabled = false;
                      submitBtn.innerHTML = origBtnText;
                    }
                  })
                  .catch(err => {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = origBtnText;
                  });
                });
              }

              // 2. Class-based multi-instance Calculator logic to eliminate CLS (Cumulative Layout Shift)
              function formatMoney(num) {
                return num.toLocaleString('vi-VN') + ' VNĐ';
              }

              function initCalculator(card) {
                const carSelect = card.querySelector(".calc-car-select");
                const ratioSelect = card.querySelector(".calc-ratio-select");
                const termSelect = card.querySelector(".calc-term-select");
                const interestInput = card.querySelector(".calc-interest-input");
                
                const resListed = card.querySelector(".calc-res-listed");
                const resLoan = card.querySelector(".calc-res-loan");
                const resMonthly = card.querySelector(".calc-res-monthly");
                const resInterest = card.querySelector(".calc-res-interest");

                function calculate() {
                  if (!carSelect || !ratioSelect || !termSelect || !interestInput) return;
                  const priceStr = carSelect.value;
                  if (!priceStr) return;
                  
                  const firstPriceStr = priceStr.split('/')[0].split('(')[0];
                  const price = parseInt(firstPriceStr.replace(/[^0-9]/g, ''), 10);
                  if (isNaN(price) || price === 0) return;
                  
                  const ratio = parseFloat(ratioSelect.value) / 100;
                  const years = parseInt(termSelect.value, 10);
                  const interestRate = parseFloat(interestInput.value) || 6.9;
                  
                  const loanAmount = price * ratio;
                  const months = years * 12;
                  
                  const r = (interestRate / 100) / 12;
                  
                  let monthlyPayment = 0;
                  if (r > 0) {
                    monthlyPayment = (loanAmount * r) / (1 - Math.pow(1 + r, -months));
                  } else {
                    monthlyPayment = loanAmount / months;
                  }
                  
                  if (resListed) resListed.innerText = formatMoney(price);
                  if (resLoan) resLoan.innerText = formatMoney(Math.round(loanAmount));
                  if (resMonthly) resMonthly.innerText = formatMoney(Math.round(monthlyPayment));
                  if (resInterest) resInterest.innerText = interestRate.toFixed(1);
                }

                if (carSelect && ratioSelect && termSelect && interestInput) {
                  carSelect.addEventListener("change", calculate);
                  ratioSelect.addEventListener("change", calculate);
                  termSelect.addEventListener("change", calculate);
                  interestInput.addEventListener("input", calculate);
                  interestInput.addEventListener("change", calculate);
                  
                  calculate();
                }
              }

              // Initialize all calculator cards on the page (mobile and sidebar)
              document.querySelectorAll(".vip-local-card-calculator").forEach(card => {
                initCalculator(card);
              });
            });
          </script>
        </aside>

      </div>

    </div>
  </section>

  <!-- FLOATING TABLE OF CONTENTS (TOC) -->
  <div class="pseo-toc-container">
    <button class="pseo-toc-trigger" aria-label="Mục lục bài viết" onclick="toggleTocPanel(event)">
      <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
      </svg>
      <span class="pseo-toc-trigger-text">Mục Lục</span>
    </button>
    
    <div class="pseo-toc-panel" id="pseoTocPanel">
      <div class="pseo-toc-header">
        <strong>MỤC LỤC BÀI VIẾT</strong>
        <button onclick="closeTocPanel()">&times;</button>
      </div>
      <ul class="pseo-toc-list">
        <li><a href="#pseo-showroom-section" onclick="closeTocPanel()">📍 Bảng Giá / Showroom</a></li>
        <li><a href="#pseo-promotions-section" onclick="closeTocPanel()">🎁 Ưu Đãi Đặc Quyền</a></li>
        <li><a href="#pseo-inventory-section" onclick="closeTocPanel()">🚗 Kho Xe Sẵn Có</a></li>
        <li><a href="#pseo-calculator-section" onclick="closeTocPanel()">📊 Tính Phí Trả Góp</a></li>
        <li><a href="#pseo-counselor-section" onclick="closeTocPanel()">💬 Trực Ban Tư Vấn</a></li>
        <li><a href="#pseo-catalog-section" onclick="closeTocPanel()">🏆 Dòng Xe Nổi Bật</a></li>
        <li><a href="#pseo-silo-section" onclick="closeTocPanel()">🌐 Khu Vực Hỗ Trợ</a></li>
        <li><a href="#pseo-faq-section" onclick="closeTocPanel()">❓ Câu Hỏi Thường Gặp</a></li>
      </ul>
    </div>
  </div>

  <!-- STICKY MOBILE ACTION BAR -->
  <div class="mobile-sticky-action-bar">
    <a href="tel:<?php echo htmlspecialchars($phoneVal); ?>" class="btn-sticky-phone">
      <?php echo get_svg_icon('fa-phone-alt', 14, 14, 'vertical-align: middle; margin-right: 4px;'); ?> Gọi Hotline
    </a>
    <a href="javascript:void(0);" onclick="scrollToCalculator()" class="btn-sticky-calc">
      <?php echo get_svg_icon('fa-calculator', 14, 14, 'vertical-align: middle; margin-right: 4px;'); ?> Tính Trả Góp
    </a>
  </div>

  <script>
    // 1. Smooth Scroll to Calculator (Dynamically targets active visible instance to eliminate CLS)
    function scrollToCalculator() {
      let calcWidget = null;
      if (window.innerWidth <= 991) {
        calcWidget = document.querySelector(".pseo-calculator-card-mobile");
      } else {
        calcWidget = document.querySelector(".pseo-calculator-card-sidebar");
      }
      if (calcWidget) {
        calcWidget.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // Briefly highlight the card with a gold shadow pulse to guide the user's attention
        calcWidget.style.transition = 'box-shadow 0.3s ease, border-color 0.3s ease';
        calcWidget.style.boxShadow = '0 0 25px var(--color-primary)';
        calcWidget.style.borderColor = 'var(--color-primary)';
        setTimeout(() => {
          calcWidget.style.boxShadow = 'none';
          calcWidget.style.borderColor = 'var(--color-border)';
        }, 1800);
      }
    }

    // 2. Reading Progress Bar Logic
    window.addEventListener('scroll', () => {
      const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
      const progressBar = document.getElementById('reading-progress-bar');
      if (progressBar) {
        progressBar.style.width = scrolled + '%';
      }
    });

    // 3. FAQ Accordion Click Logic
    document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll('.faq-header').forEach(header => {
        header.addEventListener('click', () => {
          const item = header.parentElement;
          const wrapper = item.querySelector('.faq-answer-wrapper');
          const isActive = item.classList.contains('faq-active');
          
          // Close all other FAQs
          document.querySelectorAll('.faq-item').forEach(otherItem => {
            otherItem.classList.remove('faq-active');
            const otherWrapper = otherItem.querySelector('.faq-answer-wrapper');
            if (otherWrapper) otherWrapper.style.maxHeight = null;
          });
          
          if (!isActive) {
            item.classList.add('faq-active');
            if (wrapper) wrapper.style.maxHeight = wrapper.scrollHeight + "px";
          }
        });
      });

      // 4. Lazy-loaded Map click handler
      const mapContainer = document.getElementById('pseo-local-map');
      if (mapContainer) {
        mapContainer.addEventListener('click', function() {
          const placeholder = document.getElementById('map-placeholder');
          const iframeContainer = document.getElementById('map-iframe-container');
          if (placeholder && iframeContainer) {
            placeholder.style.display = 'none';
            iframeContainer.style.display = 'block';
            iframeContainer.innerHTML = `<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=106.7001%2C10.7715%2C106.7081%2C10.7795&amp;layer=mapnik&amp;marker=10.7755%2C106.7041" style="border: 0; filter: invert(90%) hue-rotate(180deg); width:100%; height:100%;"></iframe>`;
          }
        }, { once: true });
      }

      // 5. Interactive Operational Cost Slider Logic
      const slider = document.getElementById("mileageSlider");
      const mileageVal = document.getElementById("mileageVal");
      const gasCostVal = document.getElementById("gasCostVal");
      const evCostVal = document.getElementById("evCostVal");
      const savingsVal = document.getElementById("savingsVal");
      const savingsYearVal = document.getElementById("savingsYearVal");

      if (slider) {
        function updateCosts() {
          const mileage = parseInt(slider.value, 10);
          mileageVal.innerText = mileage.toLocaleString('vi-VN');

          // Gas: 2.000 VNĐ / km (8L/100km @ 25k/L)
          const gasCost = mileage * 2000;
          
          // EV: 550 VNĐ / km (15kWh/100km @ 3.858đ/kWh)
          const evCost = mileage * 550;
          
          const savings = gasCost - evCost;
          const savingsYear = savings * 12;

          gasCostVal.innerText = gasCost.toLocaleString('vi-VN') + ' VNĐ';
          evCostVal.innerText = evCost.toLocaleString('vi-VN') + ' VNĐ';
          savingsVal.innerText = savings.toLocaleString('vi-VN');
          savingsYearVal.innerText = savingsYear.toLocaleString('vi-VN');
        }

        slider.addEventListener("input", updateCosts);
        updateCosts(); // init
      }

      // 6. Floating TOC Smooth Scroll Logic
      document.querySelectorAll('.pseo-toc-list a').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const targetId = this.getAttribute('href').substring(1);
          const targetElement = document.getElementById(targetId);
          if (targetElement) {
            targetElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Briefly highlight target card
            targetElement.style.transition = 'box-shadow 0.4s ease, border-color 0.4s ease';
            const originalShadow = targetElement.style.boxShadow;
            const originalBorder = targetElement.style.borderColor;
            targetElement.style.boxShadow = '0 0 25px var(--color-primary)';
            targetElement.style.borderColor = 'var(--color-primary)';
            setTimeout(() => {
              targetElement.style.boxShadow = originalShadow || 'none';
              targetElement.style.borderColor = originalBorder || 'var(--color-border)';
            }, 1800);
          }
        });
      });
    });

    // 7. Floating TOC Open/Close helper methods
    function toggleTocPanel(e) {
      if (e) e.stopPropagation();
      const panel = document.getElementById('pseoTocPanel');
      if (panel) {
        panel.classList.toggle('show');
      }
    }
    function closeTocPanel() {
      const panel = document.getElementById('pseoTocPanel');
      if (panel) {
        panel.classList.remove('show');
      }
    }
    // Close TOC when clicking outside
    document.addEventListener('click', function(e) {
      const panel = document.getElementById('pseoTocPanel');
      const trigger = document.querySelector('.pseo-toc-trigger');
      if (panel && panel.classList.contains('show')) {
        if (!panel.contains(e.target) && !trigger.contains(e.target)) {
          closeTocPanel();
        }
      }
    });
  </script>






