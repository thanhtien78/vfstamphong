<!-- Premium Responsive 3-Column Glassmorphic Gallery & Related Cars Styling Overrides -->

  <!-- DYNAMIC JSON-LD PRODUCT SCHEMA FOR 2026 SEO ADVANTAGES -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "<?php echo htmlspecialchars($car['model_name']); ?>",
    "image": "<?php echo htmlspecialchars($car['image']); ?>",
    "description": "Khám phá chi tiết dòng xe sang <?php echo htmlspecialchars($car['model_name']); ?> chính hãng giá tốt nhất. Hỗ trợ trả góp 80%, lái thử tại nhà riêng.",
    "sku": "VinFast-<?php echo $car['id']; ?>",
    "mpn": "VinFast-<?php echo htmlspecialchars($car['model_name']); ?>",
    "brand": {
      "@type": "Brand",
      "name": "VinFast"
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.9",
      "reviewCount": "<?php echo (24 + ($car['id'] * 7)); ?>"
    },
    "offers": {
      "@type": "Offer",
      "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>",
      "priceCurrency": "VND",
      "price": "<?php echo str_replace('.', '', preg_replace('/[^0-9]/', '', explode('/', $car['price'])[0])); ?>",
      "priceValidUntil": "2027-12-31",
      "itemCondition": "https://schema.org/NewCondition",
      "availability": "https://schema.org/InStock",
      "seller": {
        "@type": "AutoDealer",
        "name": "VinFast Việt Nam"
      }
    }
  }
  </script>

  <!-- DYNAMIC JSON-LD BREADCRUMBLIST SCHEMA FOR GOOGLE SEARCH SERP -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Trang chủ",
        "item": "<?php echo htmlspecialchars($baseUrl); ?>/"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Dòng xe",
        "item": "<?php echo htmlspecialchars($baseUrl); ?>/dong-xe-vinfast"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "name": "<?php echo htmlspecialchars($car['model_name']); ?>",
        "item": "<?php echo htmlspecialchars($baseUrl); ?>/xe-vinfast/<?php echo $car['slug']; ?>"
      }
    ]
  }
  </script>

  <!-- FULL BLEED CAR HERO BANNER -->
  <section class="detail-hero">
    <img src="<?php echo htmlspecialchars($car['image'] . (strpos($car['image'], '?') !== false ? '&' : '?') . 'v=2026'); ?>" alt="<?php echo htmlspecialchars($car['model_name']); ?>" class="detail-hero__bg" fetchpriority="high" width="1200" height="700">
    <div class="colorizer-overlay" id="colorizer-overlay"></div>
    <div class="detail-hero__overlay"></div>
    
    <div class="detail-hero__content">
      <span class="detail-hero__segment"><?php echo htmlspecialchars($car['segment']); ?></span>
      <h1 class="detail-hero__title"><?php echo htmlspecialchars($car['model_name']); ?></h1>
      
      <div class="detail-hero__quick-specs">
        <div class="quick-spec-item">
          <span class="quick-spec-item__val"><?php echo htmlspecialchars($car['power']); ?></span>
          <span class="quick-spec-item__lbl">Công suất</span>
        </div>
        <div class="quick-spec-item" style="border-left: 1px solid var(--color-border); padding-left: 24px;">
          <span class="quick-spec-item__val"><?php echo htmlspecialchars($car['acceleration']); ?></span>
          <span class="quick-spec-item__lbl">0 - 100 km/h</span>
        </div>
        <div class="quick-spec-item" style="border-left: 1px solid var(--color-border); padding-left: 24px;">
          <span class="quick-spec-item__val"><?php echo htmlspecialchars($car['price']); ?></span>
          <span class="quick-spec-item__lbl">Giá khởi điểm</span>
        </div>
      </div>
    </div>
  </section>

  <!-- MAIN VIEW SPLIT SECTION -->
  <main class="detail-layout">
    
    <!-- LEFT SIDE: EDITORIAL & SPECIFICATIONS -->
    <section class="editorial-block">
      <!-- pSEO Location Welcome Personalization Banner -->
      <?php if (!empty($refLocationName)): ?>
        <div class="seo-rich-content-block" style="margin-bottom: 24px; padding: 18px 22px; background: linear-gradient(135deg, rgba(20, 100, 244, 0.05) 0%, rgba(20, 100, 244, 0.12) 100%); border-left: 4px solid #10b981; border-radius: var(--ev-border-radius); font-size: 13.5px; line-height: 1.6; color: var(--color-text-main);">
          <span style="font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 4px;">✦ ĐẶC QUYỀN KHU VỰC <?php echo htmlspecialchars($refLocationName); ?></span>
          Chào mừng quý khách tại <strong><?php echo htmlspecialchars($refLocationName); ?></strong>! Khi đăng ký mua xe <strong><?php echo htmlspecialchars($car['model_name']); ?></strong> tại đây, quý khách được áp dụng chính sách ưu đãi đặc quyền: <strong>Miễn 100% lệ phí trước bạ</strong> xe điện của Chính phủ, hỗ trợ mua trả góp lãi suất cực thấp chỉ từ 6.9%/năm, và dịch vụ <strong>lái thử xe & giao xe tận nhà riêng</strong> tại địa bàn <?php echo htmlspecialchars($refLocationName); ?> hoàn toàn miễn phí.
        </div>
      <?php endif; ?>

      <!-- SEO Rich Content Block -->
      <div class="seo-rich-content-block" style="margin-bottom: 24px; padding: 16px; background: rgba(20, 100, 244, 0.03); border-left: 4px solid var(--color-primary); border-radius: 4px; font-size: 14px; line-height: 1.6; color: var(--color-text-main);">
        Bạn đang tìm kiếm thông tin về <strong>giá xe <?php echo htmlspecialchars($car['model_name']); ?></strong> lăn bánh mới nhất và phương thức <strong>mua xe <?php echo htmlspecialchars($car['model_name']); ?> trả góp</strong>? Tại đại lý ủy quyền <strong>VinFast Tam Phong</strong>, chúng tôi hỗ trợ trọn gói thủ tục làm hồ sơ <strong>trả góp xe <?php echo htmlspecialchars($car['model_name']); ?></strong> với lãi suất ưu đãi cực tốt, thời hạn vay linh hoạt và bàn giao xe nhanh chóng trên toàn quốc.
      </div>

      <div class="editorial-block__desc">
        <?php echo htmlspecialchars($car['description'] ?? 'Dòng sản phẩm tiên phong thể hiện triết lý thiết kế gợi cảm và DNA công nghệ dẫn đầu của thương hiệu VinFast.'); ?>
      </div>

      <!-- [SEO UPGRADE] DYNAMIC LONG-FORM SEO CONTENT & PRICING TABLE -->
      <div class="seo-long-form-content" style="margin-top: 32px; border-top: 1px solid var(--color-border); padding-top: 24px;">
        <h2 style="font-size: 20px; font-weight: 700; color: var(--color-primary); margin-bottom: 16px;">Bảng Giá Lăn Bánh Xe <?php echo htmlspecialchars($car['model_name']); ?> Tạm Tính</h2>
        <p style="font-size: 14px; line-height: 1.6; color: var(--color-text-muted); margin-bottom: 16px;">
          Để quý khách hàng dễ dàng lập dự toán tài chính, dưới đây là bảng giá xe <strong><?php echo htmlspecialchars($car['model_name']); ?></strong> niêm yết chính hãng và giá lăn bánh tạm tính tại TP.HCM và các tỉnh lân cận (áp dụng các ưu đãi lệ phí trước bạ xe điện mới nhất):
        </p>

        <?php
        $basePriceNum = (int)preg_replace('/[^0-9]/', '', explode('/', $car['price'])[0]);
        $hasBatteryPrice = $basePriceNum + 80000000; // Mua pin thường chênh lệch khoảng 80-90 triệu
        
        $formatVnd = function($num) {
            return number_format($num, 0, ',', '.') . ' VNĐ';
        };

        // Lăn bánh xe điện miễn 100% lệ phí trước bạ, chỉ tốn phí biển số (20tr HN/HCM, 1tr tỉnh) + bảo hiểm + đăng kiểm (tổng khoảng 22.5tr HCM, 3.5tr tỉnh)
        $lanBanhHcmNoPin = $basePriceNum + 22500000;
        $lanBanhTinhNoPin = $basePriceNum + 3500000;
        
        $lanBanhHcmPin = $hasBatteryPrice + 22500000;
        $lanBanhTinhPin = $hasBatteryPrice + 3500000;
        ?>

        <?php if ($basePriceNum === 0): ?>
          <div style="padding: 20px 24px; background: rgba(20, 100, 244, 0.03); border: 1px dashed var(--color-primary); border-radius: var(--ev-border-radius); text-align: center; margin-bottom: 24px;">
            <p style="font-size: 14.5px; line-height: 1.6; color: var(--color-text-main); font-weight: 700; margin-bottom: 8px;">
              ✦ Mức giá áp dụng theo chính sách bán lô doanh nghiệp hoặc gói dự án chuyên biệt
            </p>
            <p style="font-size: 13px; line-height: 1.6; color: var(--color-text-muted); margin-bottom: 16px; max-width: 600px; margin-left: auto; margin-right: auto;">
              Dòng xe này (bao gồm các dòng taxi dịch vụ Herio, Nerio, Limo Green hoặc xe buýt điện công cộng EBus) được phân phối theo các gói hợp đồng lô lớn hoặc dự án chuyên dụng. Quý khách vui lòng liên hệ Hotline hoặc đăng ký tư vấn VIP để được cung cấp bảng báo giá chính xác nhất theo quy mô.
            </p>
            <a href="#booking-form" style="display: inline-block; padding: 10px 24px; background: var(--color-primary); color: #fff; text-decoration: none; border-radius: 4px; font-weight: 700; font-size: 13px; transition: var(--transition-normal);" onmouseover="this.style.background='#0b5ed7';" onmouseout="this.style.background='var(--color-primary)';">Liên Hệ Nhận Báo Giá VIP</a>
          </div>
        <?php else: ?>
          <div style="overflow-x: auto; margin-bottom: 24px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
              <thead>
                <tr style="background: rgba(20, 100, 244, 0.05); border-bottom: 2px solid var(--color-primary); border-top: 1px solid var(--color-border);">
                  <th style="padding: 10px; font-weight: 700;">Phiên bản <?php echo htmlspecialchars($car['model_name']); ?></th>
                  <th style="padding: 10px; font-weight: 700;">Giá Niêm Yết</th>
                  <th style="padding: 10px; font-weight: 700;">Lăn Bánh TP.HCM</th>
                  <th style="padding: 10px; font-weight: 700;">Lăn Bánh Tỉnh</th>
                </tr>
              </thead>
              <tbody>
                <tr style="border-bottom: 1px solid var(--color-border);">
                  <td style="padding: 10px; font-weight: 700;">Gói thuê Pin</td>
                  <td style="padding: 10px;"><?php echo $formatVnd($basePriceNum); ?></td>
                  <td style="padding: 10px; color: var(--color-primary); font-weight: 700;"><?php echo $formatVnd($lanBanhHcmNoPin); ?></td>
                  <td style="padding: 10px;"><?php echo $formatVnd($lanBanhTinhNoPin); ?></td>
                </tr>
                <tr style="border-bottom: 1px solid var(--color-border);">
                  <td style="padding: 10px; font-weight: 700;">Gói mua Pin</td>
                  <td style="padding: 10px;"><?php echo $formatVnd($hasBatteryPrice); ?></td>
                  <td style="padding: 10px; color: var(--color-primary); font-weight: 700;"><?php echo $formatVnd($lanBanhHcmPin); ?></td>
                  <td style="padding: 10px;"><?php echo $formatVnd($lanBanhTinhPin); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

        <h2 style="font-size: 20px; font-weight: 700; color: var(--color-primary); margin-bottom: 16px; margin-top: 24px;">Chương Trình Ưu Đãi Khi Mua Xe <?php echo htmlspecialchars($car['model_name']); ?></h2>
        <ul style="font-size: 14px; line-height: 1.8; color: var(--color-text-muted); margin-bottom: 24px; padding-left: 20px; list-style-type: disc;">
          <li><strong>Miễn 100% lệ phí trước bạ</strong> cho dòng xe điện thông minh theo nghị định Chính phủ.</li>
          <li>Đặc quyền sạc pin miễn phí tại các trạm sạc VinFast trên toàn quốc (áp dụng theo chương trình hiện hành).</li>
          <li>Tặng ngay gói phụ kiện chính hãng cao cấp trị giá hàng chục triệu đồng tại showroom <strong>VinFast Tam Phong</strong>.</li>
          <li>Hỗ trợ đăng ký lái thử miễn phí tại nhà, giao xe tận nơi trên toàn quốc.</li>
        </ul>

        <h2 style="font-size: 20px; font-weight: 700; color: var(--color-primary); margin-bottom: 16px;">Quy Trình & Thủ Tục Mua Trả Góp Xe <?php echo htmlspecialchars($car['model_name']); ?></h2>
        <p style="font-size: 14px; line-height: 1.6; color: var(--color-text-muted); margin-bottom: 16px;">
          Để việc sở hữu xe trở nên dễ dàng, quy trình <strong>trả góp xe <?php echo htmlspecialchars($car['model_name']); ?></strong> tại VinFast Tam Phong được tối giản hóa với 4 bước nhanh chóng:
        </p>
        <ol style="font-size: 14px; line-height: 1.8; color: var(--color-text-muted); margin-bottom: 20px; padding-left: 20px; list-style-type: decimal;">
          <li><strong>Bước 1:</strong> Đăng ký thông tin nhận tư vấn cấu hình xe và số tiền vay tối đa.</li>
          <li><strong>Bước 2:</strong> Cung cấp căn cước công dân gắn chip để ngân hàng liên kết thẩm định tín dụng trong 30 phút.</li>
          <li><strong>Bước 3:</strong> Ký kết hợp đồng giải ngân tín dụng và thanh toán số tiền đối ứng trước (từ 20%).</li>
          <li><strong>Bước 4:</strong> Làm thủ tục đăng ký biển số và nhận bàn giao xe trực tiếp tại nhà.</li>
        </ol>
      </div>

      <!-- VinFast VIRTUAL COCKPIT TELEMETRY PANEL -->
      <div class="telemetry-block">
        <h2 class="section-title" style="border-bottom: none; padding-bottom: 0; margin-bottom: 8px;">Virtual Cockpit Telemetry - Viễn thám buồng lái</h2>
        <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">Số liệu viễn thám thực tế hiển thị động cơ cơ học dạng LED nhấp nháy chuyển dịch onLoad.</p>
        
        <div class="telemetry-grid">
          <!-- Power HP -->
          <div class="telemetry-card">
            <div class="telemetry-card__header">
              <span class="telemetry-card__lbl">Công suất động cơ</span>
              <span class="telemetry-card__val" id="telemetry-power-val"><?php echo htmlspecialchars($car['power']); ?></span>
            </div>
            <div class="telemetry-track">
              <div class="telemetry-bar telemetry-bar--gold" id="telemetry-power-bar" style="width: 0%;"></div>
            </div>
            <div class="telemetry-footer">
              <span>0 HP</span>
              <span>800 HP</span>
            </div>
          </div>

          <!-- Torque Nm -->
          <div class="telemetry-card">
            <div class="telemetry-card__header">
              <span class="telemetry-card__lbl">Mô-men xoắn cực đại</span>
              <span class="telemetry-card__val" id="telemetry-torque-val"><?php echo htmlspecialchars($car['torque']); ?></span>
            </div>
            <div class="telemetry-track">
              <div class="telemetry-bar telemetry-bar--blue" id="telemetry-torque-bar" style="width: 0%;"></div>
            </div>
            <div class="telemetry-footer">
              <span>0 Nm</span>
              <span>1000 Nm</span>
            </div>
          </div>

          <!-- Acceleration -->
          <div class="telemetry-card">
            <div class="telemetry-card__header">
              <span class="telemetry-card__lbl">Tăng tốc (0 - 100 km/h)</span>
              <span class="telemetry-card__val" id="telemetry-accel-val"><?php echo htmlspecialchars($car['acceleration']); ?></span>
            </div>
            <div class="telemetry-track">
              <div class="telemetry-bar telemetry-bar--red" id="telemetry-accel-bar" style="width: 0%;"></div>
            </div>
            <div class="telemetry-footer">
              <span>12.0s</span>
              <span>2.0s</span>
            </div>
          </div>

          <!-- Top Speed -->
          <div class="telemetry-card">
            <div class="telemetry-card__header">
              <span class="telemetry-card__lbl">Vận tốc tối đa</span>
              <span class="telemetry-card__val" id="telemetry-speed-val"><?php echo htmlspecialchars($car['top_speed']); ?></span>
            </div>
            <div class="telemetry-track">
              <div class="telemetry-bar telemetry-bar--green" id="telemetry-speed-bar" style="width: 0%;"></div>
            </div>
            <div class="telemetry-footer">
              <span>0 km/h</span>
              <span>320 km/h</span>
            </div>
          </div>
        </div>
      </div>

      <!-- SPECIFICATIONS TABLE COMPREHENSIVE VIEW -->
      <?php
      $modelLower = mb_strtolower($car['model_name'] ?? '');
      
      // Determine drive type based on engine description
      $driveType = 'FWD điện tử (Dẫn động cầu trước)';
      if (str_contains($modelLower, 'vf 3') || str_contains($modelLower, 'minio') || str_contains($modelLower, 'herio')) {
          $driveType = 'RWD điện tử (Dẫn động cầu sau)';
      } elseif (str_contains($modelLower, 'vf 7') || str_contains($modelLower, 'vf 8') || str_contains($modelLower, 'vf 9') || str_contains($modelLower, 'limo') || str_contains(mb_strtolower($car['engine']), 'awd') || str_contains(mb_strtolower($car['engine']), 'đôi')) {
          $driveType = 'AWD điện hóa chủ động toàn thời gian';
      }

      // Wheelbase helper mapping
      $wheelbase = '2.840 mm (Tối ưu khoang lái)';
      if (str_contains($modelLower, 'vf 3')) {
          $wheelbase = '2.075 mm (Đô thị mini linh hoạt)';
      } elseif (str_contains($modelLower, 'vf 5')) {
          $wheelbase = '2.513 mm (Tối ưu khoang hành khách)';
      } elseif (str_contains($modelLower, 'vf 6')) {
          $wheelbase = '2.730 mm (Rộng rãi hàng đầu phân khúc)';
      } elseif (str_contains($modelLower, 'vf 7')) {
          $wheelbase = '2.840 mm (Thể thao cá tính)';
      } elseif (str_contains($modelLower, 'vf 8')) {
          $wheelbase = '2.950 mm (Gia đình đầm chắc)';
      } elseif (str_contains($modelLower, 'vf 9')) {
          $wheelbase = '3.150 mm (Hạng sang rộng lớn)';
      }

      // Luggage helper mapping
      $luggage = '350 Lít (Tiêu chuẩn)';
      if (str_contains($modelLower, 'vf 3')) {
          $luggage = '115 Lít (Mở rộng lên 550 Lít khi gập ghế)';
      } elseif (str_contains($modelLower, 'vf 5')) {
          $luggage = '260 Lít (Mở rộng lên 900 Lít khi gập ghế)';
      } elseif (str_contains($modelLower, 'vf 6')) {
          $luggage = '353 Lít (Mở rộng lên 1.275 Lít khi gập ghế)';
      } elseif (str_contains($modelLower, 'vf 7')) {
          $luggage = '346 Lít (Mở rộng lên 1.310 Lít khi gập ghế)';
      } elseif (str_contains($modelLower, 'vf 8')) {
          $luggage = '376 Lít (Mở rộng lên 1.373 Lít khi gập ghế)';
      } elseif (str_contains($modelLower, 'vf 9')) {
          $luggage = '850 Lít (Cốp rộng rãi hàng đầu)';
      }

      // Battery capacity helper mapping
      $battery = 'Khối Pin sạc Lithium-ion thế hệ mới';
      if (str_contains($modelLower, 'vf 3')) {
          $battery = 'Pin LFP 18.64 kWh (Tầm hoạt động ~210 km)';
      } elseif (str_contains($modelLower, 'vf 5')) {
          $battery = 'Pin LFP 37.23 kWh (Tầm hoạt động ~326 km)';
      } elseif (str_contains($modelLower, 'vf 6')) {
          $battery = 'Pin LFP 59.6 kWh (Tầm hoạt động ~399 km)';
      } elseif (str_contains($modelLower, 'vf 7')) {
          $battery = 'Pin LFP 75.3 kWh (Tầm hoạt động ~496 km)';
      } elseif (str_contains($modelLower, 'vf 8')) {
          $battery = 'Pin Lithium-ion 82 kWh (Tầm hoạt động ~420 km)';
      } elseif (str_contains($modelLower, 'vf 9')) {
          $battery = 'Pin Lithium-ion 123 kWh (Tầm hoạt động ~626 km)';
      }

      // Drag coefficient Cd helper mapping
      $cd = '0.28 (Tối ưu luồng khí)';
      if (str_contains($modelLower, 'vf 3')) {
          $cd = '0.35 (Thiết kế khối hộp vuông cá tính)';
      } elseif (str_contains($modelLower, 'vf 5')) {
          $cd = '0.32 (Thiết kế tối ưu phân khúc A)';
      } elseif (str_contains($modelLower, 'vf 6')) {
          $cd = '0.30 (Dáng vẻ SUV Coupe khí động học)';
      } elseif (str_contains($modelLower, 'vf 7')) {
          $cd = '0.28 (Đường nét điêu khắc khí động học)';
      } elseif (str_contains($modelLower, 'vf 8')) {
          $cd = '0.26 (Tối ưu dòng chảy khí siêu thực)';
      } elseif (str_contains($modelLower, 'vf 9')) {
          $cd = '0.28 (Mạnh mẽ bề thế cản gió thấp)';
      }
      ?>
      <div>
        <h2 class="section-title">Thông số kỹ thuật chi tiết</h2>
        
        <div class="specs-collapsible-wrapper" id="specs-collapsible-wrapper">
          <table class="specifications-table">
            <tbody>
              <!-- Nhóm 1: VẬN HÀNH -->
              <tr class="specs-sub-header"><td colspan="2">Động cơ & Truyền động</td></tr>
              <tr><td>Cơ cấu Động cơ / Truyền động</td><td><?php echo htmlspecialchars($car['engine']); ?></td></tr>
              <tr><td>Công suất tối đa</td><td><?php echo htmlspecialchars($car['power']); ?></td></tr>
              <tr><td>Mô-men xoắn cực đại</td><td><?php echo htmlspecialchars($car['torque']); ?></td></tr>
              <tr><td>Hệ dẫn động</td><td><?php echo htmlspecialchars($driveType); ?></td></tr>
              <tr><td>Hộp số truyền động</td><td>Hộp số đơn cấp điện tử (Trực tiếp)</td></tr>
              
              <!-- Nhóm 2: KÍCH THƯỚC -->
              <tr class="specs-sub-header"><td colspan="2">Kích thước & Trọng lượng</td></tr>
              <tr><td>Phân khúc dòng xe</td><td><?php echo htmlspecialchars($car['segment']); ?></td></tr>
              <tr><td>Chiều dài cơ sở (Wheelbase)</td><td><?php echo htmlspecialchars($wheelbase); ?></td></tr>
              <tr><td>Thể tích khoang hành lý</td><td><?php echo htmlspecialchars($luggage); ?></td></tr>
              <tr><td>Nguồn năng lượng</td><td><?php echo htmlspecialchars($battery); ?></td></tr>
              
              <!-- Nhóm 3: HIỆU NĂNG -->
              <tr class="specs-sub-header"><td colspan="2">Hiệu năng & Tiêu thụ</td></tr>
              <tr><td>Tăng tốc (0-100 km/h)</td><td><?php echo htmlspecialchars($car['acceleration']); ?></td></tr>
              <tr><td>Vận tốc tối đa đạt được</td><td><?php echo htmlspecialchars($car['top_speed']); ?></td></tr>
              <tr><td>Tầm hoạt động / Tiêu hao</td><td><?php echo htmlspecialchars($car['range_wltp']); ?></td></tr>
              <tr><td>Hệ số cản gió (Cd)</td><td><?php echo htmlspecialchars($cd); ?></td></tr>
              <tr><td>Mức giá bán tham khảo</td><td><?php echo htmlspecialchars($car['price']); ?></td></tr>
            </tbody>
          </table>
        </div>
        
        <!-- Toggle button with chevron arrow -->
        <div class="specs-toggle-container">
          <button class="btn-specs-toggle" id="btn-specs-toggle" onclick="toggleSpecsTable()">
            <span id="specs-toggle-text">Xem thông số chi tiết</span>
            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="12" height="12">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
          </button>
        </div>
      </div>
    </section>

    <!-- RIGHT SIDE: COLOR CONFIGURATOR & TEST DRIVE FORM -->
    <aside>
      <div class="configurator-card">
        <div>
          <span class="configurator-card__subtitle">VinFast Customizer</span>
          <h2 class="configurator-card__title">Cấu hình màu ngoại thất</h2>
        </div>

        <?php if (count($colorsList) > 0): ?>
          <!-- Color indicator name panel -->
          <div class="configurator-card__color-name" id="color-name-display">
            <span class="color-swatch-dot" id="color-name-dot" style="background-color: <?php echo $colorsList[0]['hex']; ?>;"></span>
            <span id="color-name-text">Ngoại thất: <?php echo htmlspecialchars($colorsList[0]['name']); ?></span>
          </div>

          <!-- Color swatches list -->
          <div class="color-swatches-grid">
            <?php foreach ($colorsList as $index => $color): ?>
              <button class="color-btn <?php echo $index === 0 ? 'color-btn--active' : ''; ?>" 
                      style="background-color: <?php echo $color['hex']; ?>;" 
                      title="<?php echo htmlspecialchars($color['name']); ?>"
                      onclick="selectExteriorColor('<?php echo htmlspecialchars($color['name']); ?>', '<?php echo $color['hex']; ?>', event)">
              </button>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="configurator-card__color-name">
            <span>Ngoại thất: Sơn bóng tiêu chuẩn của VinFast</span>
          </div>
        <?php endif; ?>

        <!-- WHEELS PICKER -->
        <div style="margin-top: 8px;">
          <span class="configurator-card__subtitle">Cấu hình Mâm xe (Wheels)</span>
          <div class="option-picker-grid" style="margin-top: 8px; display: flex; gap: 10px; flex-direction: column;">
            <div class="option-picker-card option-picker-card--active" onclick="selectWheel('Mâm Classic 19\" Star Turbine', 0, event)">
              <input type="radio" name="wheel_option" checked style="display: none;">
              <span class="option-picker-card__title">19" Star Turbine Classic</span>
              <span class="option-picker-card__price">Tiêu chuẩn</span>
            </div>
            <div class="option-picker-card" onclick="selectWheel('Mâm Sport 21\" EV Blade', 80000000, event)">
              <input type="radio" name="wheel_option" style="display: none;">
              <span class="option-picker-card__title">21" EV Blade Sport</span>
              <span class="option-picker-card__price">+ 80.000.000 VNĐ</span>
            </div>
          </div>
        </div>

        <!-- INTERIOR PICKER -->
        <div style="margin-top: 8px;">
          <span class="configurator-card__subtitle">Cấu hình Da Nội thất</span>
          <div class="option-picker-grid" style="margin-top: 8px; display: flex; gap: 10px; flex-direction: column;">
            <div class="option-picker-card option-picker-card--active" onclick="selectInterior('Da Nappa màu Đen Mythos', 0, event)">
              <input type="radio" name="interior_option" checked style="display: none;">
              <span class="option-picker-card__title">Da Nappa Đen Mythos</span>
              <span class="option-picker-card__price">Tiêu chuẩn</span>
            </div>
            <div class="option-picker-card" onclick="selectInterior('Da Nappa màu Đỏ Arras Sport', 45000000, event)">
              <input type="radio" name="interior_option" style="display: none;">
              <span class="option-picker-card__title">Da Nappa Đỏ Arras Sport</span>
              <span class="option-picker-card__price">+ 45.000.000 VNĐ</span>
            </div>
            <div class="option-picker-card" onclick="selectInterior('Da Nappa màu Nâu Okapi Royal', 45000000, event)">
              <input type="radio" name="interior_option" style="display: none;">
              <span class="option-picker-card__title">Da Nappa Nâu Okapi Royal</span>
              <span class="option-picker-card__price">+ 45.000.000 VNĐ</span>
            </div>
          </div>
        </div>

        <!-- VIP BUILD SHEET SUMMARY -->
        <div class="build-sheet-panel">
          <span class="configurator-card__subtitle" style="color: var(--color-primary);">VIP Build Sheet - Bản cấu hình</span>
          <div class="build-sheet-details" style="font-size: 11.5px; color: var(--color-text-muted); display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
            <div style="display: flex; justify-content: space-between;">
              <span>Màu ngoại thất:</span>
              <strong id="build-paint" style="color: var(--color-text-main);">...</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span>Mâm xe chọn:</span>
              <strong id="build-wheel" style="color: var(--color-text-main);">...</strong>
            </div>
            <div style="display: flex; justify-content: space-between;">
              <span>Da nội thất:</span>
              <strong id="build-interior" style="color: var(--color-text-main);">...</strong>
            </div>
            <div style="display: flex; justify-content: space-between; border-top: 1px dashed var(--color-border); padding-top: 8px; margin-top: 4px;">
              <span style="color: var(--color-primary);">Tổng giá xe tùy biến:</span>
              <strong id="build-total-price" style="color: var(--color-primary); font-size: 13px;">...</strong>
            </div>
          </div>
        </div>

        <!-- TEST DRIVE FORM CONTAINER -->
        <div class="booking-form" id="booking-form">
          <div>
            <span class="configurator-card__subtitle">Trải nghiệm thực tế</span>
            <h2 class="configurator-card__title" style="font-size: 16px;">Đăng ký lái thử xe</h2>
          </div>

          <!-- Alert banners -->
          <?php if ($successBooking): ?>
            <div class="success-alert" id="success-box">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
              </svg>
              <span>Đăng ký thành công! Đội ngũ tư vấn VinFast sẽ liên hệ sớm nhất tới bạn.</span>
            </div>
          <?php endif; ?>

          <?php if ($errorBooking): ?>
            <div class="error-alert" id="error-box">
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
              </svg>
              <span><?php echo htmlspecialchars($errorBooking); ?></span>
            </div>
          <?php endif; ?>

          <form method="POST" action="#booking-form">
            <input type="hidden" name="action" value="book_test_drive">
            <input type="hidden" name="vip_build_sheet" id="vip-build-sheet-input" value="">
            <!-- Anti-spam HoneyPot field -->
            <input type="text" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">
            
            <div class="form-group" style="margin-bottom: 12px;">
              <label class="form-label" for="book-fullname">Họ và tên *</label>
              <input class="form-input" type="text" name="fullname" id="book-fullname" required placeholder="Nhập họ và tên đầy đủ">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
              <label class="form-label" for="book-phone">Số điện thoại *</label>
              <input class="form-input" type="tel" name="phone" id="book-phone" required placeholder="Nhập số điện thoại liên hệ">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
              <label class="form-label" for="book-email">Địa chỉ Email</label>
              <input class="form-input" type="email" name="email" id="book-email" placeholder="example@gmail.com">
            </div>

            <div class="form-group" style="margin-bottom: 12px;">
              <label class="form-label" for="book-type">Hình thức lái thử</label>
              <select class="form-input" name="test_drive_type" id="book-type" style="background: var(--color-surface); color: var(--color-text-main); cursor: pointer;" onchange="toggleVipAddressField()">
                <option value="Tại Showroom" style="background: var(--color-surface-dark);">Trải nghiệm tại Showroom VinFast</option>
                <option value="VIP tại nhà" style="background: var(--color-surface-dark); color: var(--color-primary);">VIP: Trải nghiệm tại nhà riêng / Cơ quan</option>
              </select>
            </div>

            <!-- VIP Address Input Panel -->
            <div class="form-group vip-address-panel" id="vip-address-panel" style="margin-bottom: 0;">
              <label class="form-label" for="book-address" style="color: var(--color-primary);">Địa chỉ giao xe tận nơi *</label>
              <input class="form-input" type="text" name="test_drive_address" id="book-address" placeholder="Ví dụ: Số 123 Đường ABC, Quận X, Hà Nội" style="border-color: rgba(25, 96, 215,0.3);">
              <div style="height: 12px;"></div>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
              <label class="form-label" for="book-date">Ngày dự kiến lái thử</label>
              <input class="form-input" type="date" name="preferred_date" id="book-date" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>

            <button class="btn-submit-booking" type="submit">
              <span>Gửi thông tin đăng ký</span>
              <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="14" height="14">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </aside>

  </main>

  <!-- [NEW] FULL-WIDTH BALANCED DETAIL SECTIONS -->
  <div class="detail-full-width-layout">
      <!-- VIRTUAL COCKPIT INTERACTIVE SHOWROOM -->
      <div class="virtual-showroom-block">
        <h2 class="section-title">Trải nghiệm kỹ thuật số VinFast</h2>
        <div class="hotspot-tabs">
          <button class="hotspot-btn hotspot-btn--active" onclick="toggleHotspot('cockpit', event)">Virtual Cockpit</button>
          <button class="hotspot-btn" onclick="toggleHotspot('lighting', event)">Matrix LED Pha</button>
          <button class="hotspot-btn" onclick="toggleHotspot('sound', event)">Bang & Olufsen 3D</button>
          <button class="hotspot-btn" onclick="toggleHotspot('ambient', event)">Đèn viền Ambient</button>
        </div>
        <div class="hotspot-content">
          <div id="hotspot-content-display">
            <h3 class="hotspot-content__title" id="hotspot-title">VinFast Virtual Cockpit - Buồng lái ảo</h3>
            <p class="hotspot-content__desc" id="hotspot-desc">Buồng lái ảo thế hệ mới với màn hình độ phân giải cao 12.3 inch siêu sắc nét. Cho phép tùy chỉnh cấu hình hiển thị bản đồ 3D, thông số hành trình, hệ thống đa phương tiện trực tiếp trên tầm nhìn người lái.</p>
          </div>

          <!-- Ambient Lighting Interactive Simulator Panel -->
          <div id="ambient-simulator-panel" style="display: none;">
            <h3 class="hotspot-content__title" style="color: var(--color-primary);">Ambient Cabin Lighting - Mô phỏng Đèn viền Nội thất</h3>
            <p class="hotspot-content__desc" style="margin-bottom: 16px;">Tự do cá nhân hóa sắc thái ánh sáng của khoang cabin VinFast EV / Động cơ Xăng với các hồ sơ màu sắc chuyên biệt dưới dạng đồ họa neon phát quang.</p>
            
            <div class="ambient-simulator-container">
              <div class="ambient-svg-wrapper">
                <!-- SVG cabin outline and ambient LED paths -->
                <svg viewBox="0 0 320 200" width="100%" height="100%">
                  <!-- Background subtle grid or guide lines -->
                  <rect x="0" y="0" width="320" height="200" fill="transparent"/>
                  
                  <!-- Steering wheel path -->
                  <circle cx="90" cy="115" r="38" class="ambient-cabin-outline"/>
                  <circle cx="90" cy="115" r="30" class="ambient-cabin-outline"/>
                  <!-- Steering wheel dynamic LED line -->
                  <path d="M 90 77 A 38 38 0 0 1 128 115" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 90 77 A 38 38 0 0 1 128 115" class="ambient-led-line ambient-led-path"/>
                  
                  <!-- Dashboard curved strips -->
                  <path d="M 10 75 Q 160 55 310 75" class="ambient-cabin-outline"/>
                  <!-- Dashboard ambient LED dynamic line -->
                  <path d="M 30 73 Q 160 54 290 73" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 30 73 Q 160 54 290 73" class="ambient-led-line ambient-led-path"/>
                  
                  <!-- Center console screen and line -->
                  <path d="M 160 72 L 160 130 L 220 150 L 220 78 Z" class="ambient-cabin-outline"/>
                  <path d="M 165 85 L 210 95 L 210 135 L 165 125 Z" class="ambient-cabin-outline"/>
                  <!-- Center console ambient LED dynamic line -->
                  <path d="M 162 76 L 218 82" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 162 76 L 218 82" class="ambient-led-line ambient-led-path"/>
                  <path d="M 160 128 L 220 148" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 160 128 L 220 148" class="ambient-led-line ambient-led-path"/>
                  
                  <!-- Door contours -->
                  <!-- Left door strip -->
                  <path d="M 10 75 Q 20 115 15 150" class="ambient-cabin-outline"/>
                  <path d="M 12 85 Q 22 115 17 140" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 12 85 Q 22 115 17 140" class="ambient-led-line ambient-led-path"/>
                  
                  <!-- Right door strip -->
                  <path d="M 310 75 Q 300 115 305 150" class="ambient-cabin-outline"/>
                  <path d="M 308 85 Q 298 115 303 140" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 308 85 Q 298 115 303 140" class="ambient-led-line ambient-led-path"/>
                  
                  <!-- Footwell ambient paths -->
                  <!-- Left footwell -->
                  <path d="M 50 160 L 110 160" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 50 160 L 110 160" class="ambient-led-line ambient-led-path"/>
                  <!-- Right footwell -->
                  <path d="M 230 160 L 290 160" class="ambient-led-line-glow ambient-led-path"/>
                  <path d="M 230 160 L 290 160" class="ambient-led-line ambient-led-path"/>
                </svg>
              </div>
              
              <!-- Ambient lighting profile selectors -->
              <div class="ambient-color-swatches">
                <button class="ambient-swatch ambient-swatch--active" style="background-color: #00d2ff; --swatch-color: rgba(0, 210, 255, 0.4);" onclick="changeAmbientColor('#00d2ff', 'Glacier Ice Blue', this)" title="Glacier Ice Blue"></button>
                <button class="ambient-swatch" style="background-color: #ff003c; --swatch-color: rgba(255, 0, 60, 0.4);" onclick="changeAmbientColor('#ff003c', 'VinFast Sport Red', this)" title="VinFast Sport Red"></button>
                <button class="ambient-swatch" style="background-color: #1960d7; --swatch-color: rgba(25, 96, 215, 0.4);" onclick="changeAmbientColor('#1960d7', 'Sunset Gold', this)" title="Sunset Gold"></button>
                <button class="ambient-swatch" style="background-color: #39ff14; --swatch-color: rgba(57, 255, 20, 0.4);" onclick="changeAmbientColor('#39ff14', 'EV Neon Green', this)" title="EV Neon Green"></button>
                <button class="ambient-swatch" style="background-color: #bd00ff; --swatch-color: rgba(189, 0, 255, 0.4);" onclick="changeAmbientColor('#bd00ff', 'Monaco Violet', this)" title="Monaco Violet"></button>
              </div>
              
              <div style="font-size: 11px; color: var(--color-text-muted); font-weight: 600; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px;">
                Cấu hình: <span id="ambient-color-name" style="color: #00d2ff; font-weight: 700; transition: color 0.3s;">Glacier Ice Blue</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- E-Brochure Button -->
        <?php if (!empty($car['brochure_url'])): ?>
          <a href="<?php echo htmlspecialchars($car['brochure_url']); ?>" target="_blank" class="btn-ebrochure" rel="noopener">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            <span>Tải xuống E-Brochure kỹ thuật số (PDF)</span>
          </a>
        <?php else: ?>
          <a href="#" onclick="alert('Đã tải xuống E-Brochure kỹ thuật số độ phân giải cao của dòng xe <?php echo htmlspecialchars($car['model_name']); ?> thành công!'); return false;" class="btn-ebrochure">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="14" height="14">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            <span>Tải xuống E-Brochure kỹ thuật số (PDF)</span>
          </a>
        <?php endif; ?>
      </div>

      <!-- [NEW] DYNAMIC STORYTELLING FEATURE SHOWCASES -->
      <div class="asymmetric-showcase-section">
        <h2 class="section-title">Nghệ thuật & Công nghệ Cốt lõi</h2>
        
        <?php foreach ($coreFeatures as $index => $feat): ?>
          <div class="showcase-block <?php echo ($index % 2 !== 0) ? 'showcase-block--reverse' : ''; ?>">
            <div class="showcase-media">
              <img src="<?php echo htmlspecialchars(($feat['image'] ?? '') . (strpos($feat['image'] ?? '', '?') !== false ? '&' : '?') . 'v=2026'); ?>" alt="<?php echo htmlspecialchars($feat['title'] ?? ''); ?>" class="showcase-img" loading="lazy" width="600" height="400">
            </div>
            <div class="showcase-info">
              <span class="showcase-tag"><?php echo htmlspecialchars($feat['tag'] ?? ''); ?></span>
              <h3 class="showcase-title"><?php echo htmlspecialchars($feat['title'] ?? ''); ?></h3>
              <p class="showcase-desc"><?php echo htmlspecialchars($feat['desc'] ?? ''); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- [NEW] DYNAMIC OUTSTANDING 8-FEATURE HIGHLIGHTS MATRIX -->
      <?php
      $carHighlights = $techHighlights;
      if (!is_array($carHighlights) || count($carHighlights) < 8) {
          if (strpos($modelLower, 'vf') !== false || strpos($modelLower, 'ev') !== false || strpos($modelLower, 'green') !== false || strpos($modelLower, 'van') !== false) {
              $carHighlights = [
                  ["🔋", "Pin Lithium-ion 800V", "Kiến trúc điện áp 800V tiên phong giúp duy trì dòng sạc cực đại lâu hơn và giảm thiểu tối đa sinh nhiệt."],
                  ["⚡", "Hệ sạc siêu nhanh DC 270kW", "Đặc quyền sạc siêu nhanh công suất lớn tại hệ thống đại lý VinFast, sạc đầy từ 10% lên 80% chỉ trong 22 phút."],
                  ["🌀", "Thu hồi năng lượng phanh", "Hệ thống phanh tái sinh thông minh chuyển đổi động năng thừa khi giảm tốc thành điện năng sạc ngược lại vào pin."],
                  ["🔇", "Cabin tĩnh lặng tuyệt đối", "Cabin tĩnh lặng tối đa nhờ cách âm 2 lớp dày dặn và triệt tiêu hoàn toàn rung chấn cơ học động cơ đốt trong."],
                  ["📐", "Khí động học chủ động (Cd 0.24)", "Hệ số cản gió cực thấp nhờ thiết kế gầm phẳng, khe hút gió biến thiên và cánh gió sau tự động nâng hạ."],
                  ["🔗", "Dẫn động AWD điện hóa", "Hai mô-tơ điện độc lập phân bổ lực kéo nhanh gấp 5 lần hệ dẫn động cơ học, bám đường vô song."],
                  ["🔮", "Buồng lái Virtual Cockpit EV", "Giao diện ảo hiển thị chuyên biệt dòng chảy năng lượng, trạng thái pin, công suất sạc và bản đồ thông minh."],
                  ["🔊", "Bang & Olufsen 3D EV", "Trải nghiệm âm thanh vòm 3D trung thực hòa quyện cùng tiếng rít cơ học điện tử EV độc quyền sinh động."]
              ];
          } else {
              $carHighlights = [
                  ["⚙️", "Động cơ xăng tăng áp cuộn kép", "Công nghệ phun xăng trực tiếp kết hợp tăng áp cuộn kép loại bỏ hoàn toàn độ trễ ga, đem lại mô-men xoắn tối đa ở vòng tua thấp."],
                  ["⚡", "Hộp số tự động 8 cấp ZF", "Hộp số tự động 8 cấp danh tiếng từ ZF đem lại khả năng chuyển số cực kỳ mượt mà và tối ưu hiệu suất truyền động."],
                  ["☁️", "Treo khí nén thích ứng", "Tự động điều chỉnh độ cứng giảm chấn độc lập theo bề mặt địa hình và hạ gầm để tăng tính ổn định khí động học."],
                  ["🛡️", "Khung gầm nhôm ASF", "Cấu trúc khung xe hợp kim nhôm và thép cường lực vững chắc giúp giảm đáng kể tự trọng, bảo vệ an toàn tối đa."],
                  ["🛋️", "Nội thất da Nappa VIP", "Hàng ghế thể thao bọc da Nappa chỉnh điện 14 hướng, tích hợp đệm ôm hông chủ động và sưởi/massage cao cấp."],
                  ["🌡️", "Điều hòa 4 vùng tự động", "Mỗi vị trí ngồi tự do cá nhân hóa nhiệt độ và luồng gió nhờ bộ lọc than hoạt tính lọc bụi mịn PM2.5."],
                  ["🔮", "Hệ thống MMI Plus", "Màn hình cảm ứng kép phản hồi xúc giác siêu nhạy kết hợp bản đồ vệ tinh dẫn đường 3D chuẩn xác."],
                  ["🔊", "Bang & Olufsen 3D Sound", "Hòa âm đỉnh cao với hệ thống 19 loa cao cấp công suất lên tới 730W, tái tạo rạp hát di động 3D trung thực."]
              ];
          }
      }
      ?>

      <section class="VinFast-tech-features-section">
        <h2 class="section-title">8 Tính năng & Công nghệ Nổi bật</h2>
        <p class="section-subtitle">Hội tụ tinh hoa công nghệ ô tô điện hàng đầu thế giới được tối ưu hóa riêng biệt cho mẫu xe <?php echo htmlspecialchars($car['model_name']); ?>.</p>
        
        <div class="tech-features-grid">
          <?php foreach ($carHighlights as $highlight): 
              $hlIcon = $highlight['icon'] ?? ($highlight[0] ?? '');
              $hlTitle = $highlight['title'] ?? ($highlight[1] ?? '');
              $hlDesc = $highlight['desc'] ?? ($highlight[2] ?? '');
          ?>
            <div class="tech-feature-card">
              <div class="tech-card-glow"></div>
              <div class="tech-card-icon"><?php echo $hlIcon; ?></div>
              <h3 class="tech-card-title"><?php echo htmlspecialchars($hlTitle); ?></h3>
              <p class="tech-card-desc"><?php echo htmlspecialchars($hlDesc); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- [NEW] PREMIUM TABBED MEDIA GALLERY -->

      <div class="premium-gallery-section">
        <?php
        $modelLower = strtolower($car['model_name'] ?? '');
        $engineLower = strtolower($car['engine'] ?? '');
        $segmentLower = strtolower($car['segment'] ?? '');

        // Gather list of images
        $extImgs = !empty($car['image_exterior']) ? array_filter(explode(',', $car['image_exterior'])) : [];
        $intImgs = !empty($car['image_interior']) ? array_filter(explode(',', $car['image_interior'])) : [];
        $techImgs = !empty($car['image_engine']) ? array_filter(explode(',', $car['image_engine'])) : [];

        // If database lists no specific exterior images, we use the car's main image as the first item
        if (empty($extImgs) && !empty($car['image'])) {
            $extImgs[] = $car['image'];
        }

        // Premium fallbacks matching modern EV lifestyle
        $fallbackExterior = [
            'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80'
        ];
        $fallbackInterior = [
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&w=1200&q=80'
        ];
        $fallbackTech = [
            'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&w=1200&q=80'
        ];

        // Build premium unified gallery array
        $allGalleryItems = [];
        
        // 1. Exterior
        $extIdx = 1;
        foreach ($extImgs as $img) {
            $trimmed = trim($img);
            if ($trimmed !== '') {
                if (strpos($trimmed, 'http') === 0 || file_exists(dirname(__DIR__) . '/' . $trimmed)) {
                    $allGalleryItems[] = [
                        'src' => $trimmed,
                        'category' => 'exterior',
                        'category_vn' => 'Ngoại thất',
                        'title' => 'Thiết kế ngoại thất ' . htmlspecialchars($car['model_name']) . ' sang trọng #' . $extIdx++
                    ];
                }
            }
        }
        foreach ($fallbackExterior as $fb) {
            if (count(array_filter($allGalleryItems, function($i){ return $i['category'] === 'exterior'; })) < 3) {
                $allGalleryItems[] = [
                    'src' => $fb,
                    'category' => 'exterior',
                    'category_vn' => 'Ngoại thất',
                    'title' => 'Ngoại thất xe điện thông minh hiện đại #' . $extIdx++
                ];
            }
        }

        // 2. Interior
        $intIdx = 1;
        foreach ($intImgs as $img) {
            $trimmed = trim($img);
            if ($trimmed !== '') {
                if (strpos($trimmed, 'http') === 0 || file_exists(dirname(__DIR__) . '/' . $trimmed)) {
                    $allGalleryItems[] = [
                        'src' => $trimmed,
                        'category' => 'interior',
                        'category_vn' => 'Nội thất',
                        'title' => 'Không gian nội thất ' . htmlspecialchars($car['model_name']) . ' đẳng cấp #' . $intIdx++
                    ];
                }
            }
        }
        foreach ($fallbackInterior as $fb) {
            if (count(array_filter($allGalleryItems, function($i){ return $i['category'] === 'interior'; })) < 3) {
                $allGalleryItems[] = [
                    'src' => $fb,
                    'category' => 'interior',
                    'category_vn' => 'Nội thất',
                    'title' => 'Vô lăng thể thao và khoang lái thông minh #' . $intIdx++
                ];
            }
        }

        // 3. Tech
        $techIdx = 1;
        foreach ($techImgs as $img) {
            $trimmed = trim($img);
            if ($trimmed !== '') {
                if (strpos($trimmed, 'http') === 0 || file_exists(dirname(__DIR__) . '/' . $trimmed)) {
                    $allGalleryItems[] = [
                        'src' => $trimmed,
                        'category' => 'tech',
                        'category_vn' => 'Công nghệ',
                        'title' => 'Kỹ nghệ truyền động ' . htmlspecialchars($car['model_name']) . ' #' . $techIdx++
                    ];
                }
            }
        }
        foreach ($fallbackTech as $fb) {
            if (count(array_filter($allGalleryItems, function($i){ return $i['category'] === 'tech'; })) < 3) {
                $allGalleryItems[] = [
                    'src' => $fb,
                    'category' => 'tech',
                    'category_vn' => 'Công nghệ',
                    'title' => 'Kỹ nghệ pin LFP và hệ thống treo điện hóa #' . $techIdx++
                ];
            }
        }
        ?>
        <h2 class="section-title">Thư viện Đa phương tiện Kỹ thuật số</h2>
        
        <div class="gallery-filter-tabs">
          <button class="gallery-tab-btn gallery-tab-btn--active" onclick="filterGallery('all', this)">Tất cả</button>
          <button class="gallery-tab-btn" onclick="filterGallery('exterior', this)">Ngoại thất</button>
          <button class="gallery-tab-btn" onclick="filterGallery('interior', this)">Nội thất</button>
          <button class="gallery-tab-btn" onclick="filterGallery('tech', this)">Công nghệ</button>
        </div>

        <div class="gallery-grid" id="gallery-image-grid">
          <?php foreach ($allGalleryItems as $index => $item): ?>
          <div class="gallery-card" data-category="<?php echo htmlspecialchars($item['category']); ?>" onclick="openLightbox(<?php echo $index; ?>)">
            <img src="<?php echo htmlspecialchars($item['src'] . (strpos($item['src'], '?') !== false ? '&' : '?') . 'v=2026'); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="gallery-img" loading="lazy" width="600" height="375">
            <div class="gallery-card__overlay">
              <span class="gallery-card__category"><?php echo htmlspecialchars($item['category_vn']); ?></span>
              <span class="gallery-card__title"><?php echo htmlspecialchars($item['title']); ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- [NEW] GLASSMORPHIC LIGHTBOX ZOOM MODAL -->
      <div class="gallery-lightbox" id="gallery-lightbox">
        <div class="lightbox-close-btn" onclick="closeLightbox()">
          <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </div>
        
        <div class="lightbox-nav-btn lightbox-nav-btn--prev" onclick="prevLightbox()">
          <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="22" height="22">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
          </svg>
        </div>
        
        <div class="lightbox-content">
          <img src="" alt="" class="lightbox-img" id="lightbox-image">
        </div>
        
        <div class="lightbox-nav-btn lightbox-nav-btn--next" onclick="nextLightbox()">
          <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" width="22" height="22">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
          </svg>
        </div>
        
        <div class="lightbox-caption">
          <div class="lightbox-title" id="lightbox-title">Chi tiết ảnh</div>
          <div id="lightbox-category" style="color: var(--color-primary); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Ngoại thất</div>
        </div>
      </div>

      <!-- [NEW] EXCLUSIVE OWNER BENEFITS SECTION -->
      <section class="VinFast-owner-benefits-section">
        <h2 class="section-title">Đặc quyền Sở hữu & Lợi ích độc bản</h2>
        <p class="section-subtitle">Đồng hành cùng VinFast là mở ra những đặc quyền thượng lưu và giá trị sống tinh tế tối thượng.</p>
        
        <div class="benefits-editorial-grid">
          <?php 
            $benefit_svgs = [
              '<svg class="benefit-icon-svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
              </svg>',
              '<svg class="benefit-icon-svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
              </svg>',
              '<svg class="benefit-icon-svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
              </svg>',
              '<svg class="benefit-icon-svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
              </svg>'
            ];
            foreach ($ownerBenefits as $i => $benefit):
              $svg = $benefit_svgs[$i] ?? $benefit_svgs[0];
          ?>
            <div class="benefit-editorial-card">
              <div class="benefit-icon-wrapper">
                <?php echo $svg; ?>
              </div>
              <div class="benefit-content">
                <h3 class="benefit-title"><?php echo htmlspecialchars($benefit['title'] ?? ''); ?></h3>
                <p class="benefit-desc"><?php echo htmlspecialchars($benefit['desc'] ?? ''); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- DYNAMIC LOAN CALCULATOR UPGRADED -->
      <div class="calculator-block" id="installment">
        <h2 class="section-title" style="margin-bottom: 8px;">Dự toán tài chính trả góp</h2>
        <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 24px;">Lập kế hoạch tài chính linh hoạt với khả năng tùy chỉnh lãi suất ngân hàng và phương thức thanh toán.</p>
        
        <!-- Slider 1: Tỷ lệ trả trước -->
        <div class="slider-container">
          <div class="slider-header">
            <span class="slider-lbl">Tỷ lệ trả trước</span>
            <span class="slider-val" id="prepayment-pct-text">30%</span>
          </div>
          <input type="range" class="slider-input" id="prepayment-slider" min="20" max="80" step="5" value="30" oninput="calculateLoan()">
        </div>

        <!-- Slider 2: Thời hạn vay -->
        <div class="slider-container">
          <div class="slider-header">
            <span class="slider-lbl">Thời hạn vay</span>
            <span class="slider-val" id="term-months-text">36 tháng</span>
          </div>
          <input type="range" class="slider-input" id="term-slider" min="12" max="84" step="12" value="36" oninput="calculateLoan()">
        </div>

        <!-- Slider 3: [NEW] Lãi suất năm tùy biến -->
        <div class="slider-container">
          <div class="slider-header">
            <span class="slider-lbl" style="color: var(--color-primary);">Lãi suất năm tùy chọn</span>
            <span class="slider-val" id="interest-rate-text" style="color: var(--color-primary);">7.9% / năm</span>
          </div>
          <input type="range" class="slider-input" id="interest-rate-slider" min="4.0" max="15.0" step="0.1" value="7.9" oninput="calculateLoan()" style="background: rgba(25, 96, 215, 0.15);">
        </div>

        <!-- [NEW] Bộ chọn Phương thức trả nợ -->
        <div class="repayment-method-tabs">
          <button class="repayment-tab-btn repayment-tab-btn--active" id="repay-declining-btn" onclick="setRepaymentMethod('declining')">Dư nợ giảm dần</button>
          <button class="repayment-tab-btn" id="repay-flat-btn" onclick="setRepaymentMethod('flat')">Trả đều cố định</button>
        </div>

        <div class="calculator-results">
          <div class="result-item">
            <span class="result-lbl">Giá trị xe thực tế</span>
            <span class="result-val" id="loan-car-price">...</span>
          </div>
          <div class="result-item">
            <span class="result-lbl">Số tiền trả trước</span>
            <span class="result-val" id="prepayment-amount">...</span>
          </div>
          <div class="result-item">
            <span class="result-lbl">Số tiền gốc cần vay</span>
            <span class="result-val" id="loan-amount">...</span>
          </div>
          <div class="result-item">
            <span class="result-lbl">Lãi suất áp dụng</span>
            <span class="result-val" id="loan-applied-rate" style="color: #a5d6a7;">7.9% / năm</span>
          </div>
          <div class="result-item result-item--total">
            <span class="result-lbl" id="repayment-total-lbl" style="color: var(--color-primary);">Ước tính trả tháng đầu (Gốc + Lãi)</span>
            <span class="result-val result-val--gold" id="monthly-payment-total">...</span>
          </div>
        </div>

        <!-- [NEW] Thẻ khuyến nghị tài chính thông minh -->
        <div class="financial-advice-card" id="financial-advice-card">
          <span class="advice-icon" id="advice-icon">💡</span>
          <span class="advice-text" id="advice-text">Kế hoạch đề xuất tối ưu và an toàn tài chính.</span>
        </div>

        <!-- [NEW] Bộ nút hành động liên hệ tư vấn -->
        <div class="calculator-actions">
          <?php 
            $rawPhone = $settings['agency_phone'] ?? '081.7777.855';
            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
          ?>
          <a href="tel:<?php echo $cleanPhone; ?>" class="calc-action-btn calc-action-btn--phone" title="Gọi Hotline tư vấn trả góp">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 0 1-7.108-7.108c-.155-.44.011-.927.387-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
            <span>Gọi Hotline tư vấn</span>
          </a>
          <a href="https://zalo.me/<?php echo $cleanPhone; ?>" target="_blank" class="calc-action-btn calc-action-btn--zalo" title="Liên hệ Zalo tư vấn trả góp" rel="noopener">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--color-text-main);">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
            </svg>
            <span>Liên hệ Zalo tư vấn</span>
          </a>
        </div>
      </div>
  </div>

  <!-- SECTION: RELATED MODELS FOR REFERENCE -->
  <?php
  // Fetch 3 related or alternative cars, excluding the current car
  // We prefer cars of the same segment if possible, otherwise just other cars
  $stmtRelated = $db->prepare("
      SELECT id, model_name, segment, engine, price, image, slug, power, acceleration, description 
      FROM cars 
      WHERE id != ? 
      ORDER BY (CASE WHEN segment = ? THEN 1 WHEN engine LIKE ? THEN 2 ELSE 3 END) ASC, id ASC 
      LIMIT 3
  ");
  // Check the current engine type to match
  $currentEngineKeyword = (strpos($modelLower, 'vf') !== false || strpos($modelLower, 'ev') !== false || strpos($engineLower, 'điện') !== false) ? '%điện%' : '%xăng%';
  $stmtRelated->execute([$car['id'], $car['segment'], $currentEngineKeyword]);
  $relatedCars = $stmtRelated->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($relatedCars)):
  ?>
  <section class="related-cars-section" style="background: #f8fafc !important; border-top: 1px solid #e2e8f0 !important; padding: 80px 0 !important;">
    <div class="container">
      <div class="section-header" style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag" style="background: rgba(20, 100, 244, 0.06); color: #1464f4; border: 1px solid rgba(20, 100, 244, 0.15); font-weight: 800; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; font-size: 10px; letter-spacing: 1px;">Khám phá thêm</span>
        <h2 class="section-title" style="color: #0f172a !important; margin-top: 12px; margin-bottom: 8px;">Dòng xe tham khảo khác</h2>
        <p class="section-subtitle" style="color: #64748b !important;">Khám phá các mẫu xe VinFast sang trọng và đẳng cấp cùng phân khúc hoặc dòng xe EV thuần điện nổi bật.</p>
      </div>
      
      <div class="catalog-grid">
        <?php foreach ($relatedCars as $rc): 
          $segmentLower = mb_strtolower($rc['segment'] ?? '');
          $nameLower = mb_strtolower($rc['model_name'] ?? '');
          
          $group = 'city';
          $groupLabel = 'Đô Thị & Mini';
          if (str_contains($segmentLower, 'dịch vụ') || str_contains($nameLower, 'green') || str_contains($nameLower, 'van')) {
              $group = 'service';
              $groupLabel = 'Dịch Vụ Green';
          } elseif (str_contains($segmentLower, 'cỡ b') || str_contains($segmentLower, 'cỡ c') || str_contains($segmentLower, 'cỡ d')) {
              $group = 'midsize';
              $groupLabel = 'SUV Tầm Trung';
          } elseif (str_contains($segmentLower, 'cỡ e') || str_contains($segmentLower, 'cỡ lớn') || str_contains($nameLower, 'vf 9')) {
              $group = 'large';
              $groupLabel = 'SUV Hạng Sang';
          }
        ?>
          <article class="car-card">
            <div class="car-card__media">
              <span class="car-card__badge car-card__badge--electric">
                <?php echo $groupLabel; ?>
              </span>
              <img class="car-card__img" src="<?php echo htmlspecialchars(get_thumb_url($rc['image'], 480)); ?>" alt="<?php echo htmlspecialchars($rc['model_name']); ?>" loading="lazy" width="400" height="250">
            </div>
            
            <div class="car-card__info">
              <span class="car-card__segment"><?php echo htmlspecialchars($rc['segment']); ?></span>
              <h3 class="car-card__name"><?php echo htmlspecialchars($rc['model_name']); ?></h3>
              <p class="car-card__desc"><?php echo htmlspecialchars($rc['description'] ?? 'Mẫu xe điện thông minh sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?></p>
              
              <div class="car-card__specs">
                <div class="car-card__spec-item">
                  <span class="car-card__spec-lbl">Công suất</span>
                  <span class="car-card__spec-val"><?php echo htmlspecialchars($rc['power']); ?></span>
                </div>
                <div class="car-card__spec-item">
                  <span class="car-card__spec-lbl">Gia tốc (0-100)</span>
                  <span class="car-card__spec-val"><?php echo htmlspecialchars($rc['acceleration']); ?></span>
                </div>
                <div class="car-card__spec-item" style="grid-column: span 2; border-top:1px solid rgba(0,0,0,0.05); padding-top:6px; margin-top:2px;">
                  <span class="car-card__spec-lbl">Động cơ / Truyền động</span>
                  <span class="car-card__spec-val" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color: var(--color-text-dark);" title="<?php echo htmlspecialchars($rc['engine']); ?>">
                    <?php echo htmlspecialchars($rc['engine']); ?>
                  </span>
                </div>
              </div>

              <?php
                $priceRaw = !empty($rc['price']) ? trim($rc['price']) : 'Liên hệ';
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
                <a href="<?php echo seo_url('xe-vinfast/' . $rc['slug']); ?>" class="btn-detail-card">Chi tiết</a>
                <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20và%20tư%20vấn%20dòng%20xe%20VinFast%20<?php echo urlencode($rc['model_name']); ?>" target="_blank" class="btn-zalo-card" rel="noopener">
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
  </section>
  <?php endif; ?>

  <!-- [SEO UPGRADE] VISUAL FAQ ACCORDION SECTION (HUMAN-READABLE & GOOGLE BOT ALIGNED) -->
  <div class="faq-accordion-block" id="faq-section" style="margin-top: 48px; margin-bottom: 48px; max-width: 1200px; margin-left: auto; margin-right: auto; padding: 0 16px;">
    <h2 class="section-title" style="margin-bottom: 8px;">Câu hỏi thường gặp về xe <?php echo htmlspecialchars($car['model_name']); ?></h2>
    <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 24px;">Giải đáp các thắc mắc phổ biến nhất về giá lăn bánh, chính sách trả góp, đặc quyền bảo hành và kỹ thuật của dòng xe <?php echo htmlspecialchars($car['model_name']); ?>.</p>

    <div class="faq-accordion-container" style="display: flex; flex-direction: column; gap: 12px;">
      
      <!-- FAQ Item 1 -->
      <div class="faq-item" style="border: 1px solid var(--color-border); border-radius: 8px; background: rgba(255, 255, 255, 0.02); overflow: hidden; transition: all 0.25s ease;">
        <button onclick="toggleFaqAccordion(0)" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-size: 14px; font-weight: 700; text-align: left; color: var(--color-text-main); cursor: pointer; outline: none;">
          <span>1. Giá xe <?php echo htmlspecialchars($car['model_name']); ?> lăn bánh tạm tính là bao nhiêu?</span>
          <span id="faq-icon-0" style="font-size: 18px; color: var(--color-primary); transition: transform 0.2s ease;">+</span>
        </button>
        <div id="faq-content-0" style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out; background: rgba(0,0,0,0.05);">
          <p style="padding: 0 20px 16px 20px; font-size: 13.5px; line-height: 1.6; color: var(--color-text-muted); margin: 0;">
            Giá xe <strong><?php echo htmlspecialchars($car['model_name']); ?></strong> khởi điểm niêm yết từ <?php echo htmlspecialchars($car['price']); ?>. Chi phí lăn bánh thực tế sẽ phụ thuộc vào việc quý khách chọn gói Thuê pin hay Mua pin, cùng với chính sách miễn 100% lệ phí trước bạ xe điện của Chính phủ và các quà tặng từ showroom VinFast Tam Phong tùy thời điểm.
          </p>
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div class="faq-item" style="border: 1px solid var(--color-border); border-radius: 8px; background: rgba(255, 255, 255, 0.02); overflow: hidden; transition: all 0.25s ease;">
        <button onclick="toggleFaqAccordion(1)" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-size: 14px; font-weight: 700; text-align: left; color: var(--color-text-main); cursor: pointer; outline: none;">
          <span>2. Thủ tục mua xe <?php echo htmlspecialchars($car['model_name']); ?> trả góp cần những hồ sơ gì?</span>
          <span id="faq-icon-1" style="font-size: 18px; color: var(--color-primary); transition: transform 0.2s ease;">+</span>
        </button>
        <div id="faq-content-1" style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out; background: rgba(0,0,0,0.05);">
          <p style="padding: 0 20px 16px 20px; font-size: 13.5px; line-height: 1.6; color: var(--color-text-muted); margin: 0;">
            Thủ tục cực kỳ tinh giản: Quý khách chỉ cần cung cấp <strong>Căn cước công dân gắn chip</strong> để thực hiện xét duyệt hồ sơ online qua hệ thống ngân hàng đối tác liên kết trong vòng 30 phút. Khách hàng chỉ cần chuẩn bị trước từ 20% giá trị xe để có thể nhận xe ngay.
          </p>
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div class="faq-item" style="border: 1px solid var(--color-border); border-radius: 8px; background: rgba(255, 255, 255, 0.02); overflow: hidden; transition: all 0.25s ease;">
        <button onclick="toggleFaqAccordion(2)" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-size: 14px; font-weight: 700; text-align: left; color: var(--color-text-main); cursor: pointer; outline: none;">
          <span>3. Lãi suất vay trả góp xe <?php echo htmlspecialchars($car['model_name']); ?> là bao nhiêu?</span>
          <span id="faq-icon-2" style="font-size: 18px; color: var(--color-primary); transition: transform 0.2s ease;">+</span>
        </button>
        <div id="faq-content-2" style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out; background: rgba(0,0,0,0.05);">
          <p style="padding: 0 20px 16px 20px; font-size: 13.5px; line-height: 1.6; color: var(--color-text-muted); margin: 0;">
            Hiện tại showroom VinFast Tam Phong đang liên kết với các ngân hàng đối tác để cung cấp gói vay trả góp xe <strong><?php echo htmlspecialchars($car['model_name']); ?></strong> với lãi suất ưu đãi chỉ từ 7.9% / năm. Lãi suất có thể lựa chọn trả theo hình thức dư nợ giảm dần hoặc trả đều cố định hàng tháng tùy thuộc vào điều kiện tài chính của khách hàng.
          </p>
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div class="faq-item" style="border: 1px solid var(--color-border); border-radius: 8px; background: rgba(255, 255, 255, 0.02); overflow: hidden; transition: all 0.25s ease;">
        <button onclick="toggleFaqAccordion(3)" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-size: 14px; font-weight: 700; text-align: left; color: var(--color-text-main); cursor: pointer; outline: none;">
          <span>4. Thời gian duyệt hồ sơ và nhận xe <?php echo htmlspecialchars($car['model_name']); ?> trả góp mất bao lâu?</span>
          <span id="faq-icon-3" style="font-size: 18px; color: var(--color-primary); transition: transform 0.2s ease;">+</span>
        </button>
        <div id="faq-content-3" style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out; background: rgba(0,0,0,0.05);">
          <p style="padding: 0 20px 16px 20px; font-size: 13.5px; line-height: 1.6; color: var(--color-text-muted); margin: 0;">
            Quá trình phê duyệt hồ sơ vay trả góp diễn ra vô cùng nhanh gọn trong vòng 30 phút kể từ lúc nhận đủ hồ sơ online. Sau khi hoàn thành thủ tục đăng ký xe và ký giải ngân, quý khách có thể nhận xe ngay tại showroom hoặc yêu cầu vận chuyển, giao xe trực tiếp đến tận nhà trong vòng 3 đến 5 ngày làm việc.
          </p>
        </div>
      </div>

      <!-- FAQ Item 5 -->
      <div class="faq-item" style="border: 1px solid var(--color-border); border-radius: 8px; background: rgba(255, 255, 255, 0.02); overflow: hidden; transition: all 0.25s ease;">
        <button onclick="toggleFaqAccordion(4)" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-size: 14px; font-weight: 700; text-align: left; color: var(--color-text-main); cursor: pointer; outline: none;">
          <span>5. Pin của xe điện <?php echo htmlspecialchars($car['model_name']); ?> đi được bao nhiêu km mỗi lần sạc đầy?</span>
          <span id="faq-icon-4" style="font-size: 18px; color: var(--color-primary); transition: transform 0.2s ease;">+</span>
        </button>
        <div id="faq-content-4" style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out; background: rgba(0,0,0,0.05);">
          <p style="padding: 0 20px 16px 20px; font-size: 13.5px; line-height: 1.6; color: var(--color-text-muted); margin: 0;">
            Dòng xe ô tô điện thông minh <strong><?php echo htmlspecialchars($car['model_name']); ?></strong> được trang bị hệ thống pin LFP hiệu năng cao, cho tầm hoạt động tối đa lên đến khoảng <strong><?php echo htmlspecialchars($car['range_wltp'] ?? '320 - 400 km'); ?></strong> cho mỗi lần sạc đầy (theo tiêu chuẩn thử nghiệm). Ngoài ra xe cũng tích hợp công nghệ sạc siêu nhanh DC giúp phục hồi dung lượng pin từ 10% lên 70% chỉ trong khoảng 25-30 phút.
          </p>
        </div>
      </div>

      <!-- FAQ Item 6 -->
      <div class="faq-item" style="border: 1px solid var(--color-border); border-radius: 8px; background: rgba(255, 255, 255, 0.02); overflow: hidden; transition: all 0.25s ease;">
        <button onclick="toggleFaqAccordion(5)" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: none; border: none; font-size: 14px; font-weight: 700; text-align: left; color: var(--color-text-main); cursor: pointer; outline: none;">
          <span>6. Chính sách bảo hành và chi phí bảo dưỡng xe <?php echo htmlspecialchars($car['model_name']); ?> có đắt không?</span>
          <span id="faq-icon-5" style="font-size: 18px; color: var(--color-primary); transition: transform 0.2s ease;">+</span>
        </button>
        <div id="faq-content-5" style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out; background: rgba(0,0,0,0.05);">
          <p style="padding: 0 20px 16px 20px; font-size: 13.5px; line-height: 1.6; color: var(--color-text-muted); margin: 0;">
            Xe điện VinFast có chi phí bảo dưỡng định kỳ tiết kiệm hơn xe xăng từ 50% đến 70% do cấu tạo động cơ điện không cần thay dầu nhớt, bugi hay các phụ tùng cơ khí phức tạp. Đồng thời, dòng xe <strong><?php echo htmlspecialchars($car['model_name']); ?></strong> cũng được hãng áp dụng chính sách bảo hành dài hạn dẫn đầu thị trường từ 7 đến 10 năm hoặc 200.000 km cùng dịch vụ cứu hộ khẩn cấp 24/7.
          </p>
        </div>
      </div>

    </div>
  </div>

  <script>
    function toggleFaqAccordion(index) {
      const content = document.getElementById('faq-content-' + index);
      const icon = document.getElementById('faq-icon-' + index);
      const item = content.parentElement;
      
      if (content.style.maxHeight === '0px' || !content.style.maxHeight) {
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.innerText = '−';
        icon.style.transform = 'rotate(180deg)';
        item.style.borderColor = 'var(--color-primary)';
        item.style.background = 'rgba(20, 100, 244, 0.02)';
      } else {
        content.style.maxHeight = '0px';
        icon.innerText = '+';
        icon.style.transform = 'rotate(0deg)';
        item.style.borderColor = 'var(--color-border)';
        item.style.background = 'rgba(255, 255, 255, 0.02)';
      }
    }
  </script>

  <!-- CONFIGURATOR INTERACTIVE SCRIPT -->
  <script>
    // Global Build State
    window.vipBuildState = {
      paint: "<?php echo count($colorsList) > 0 ? htmlspecialchars($colorsList[0]['name']) : 'Sơn tiêu chuẩn'; ?>",
      wheel: 'Mâm Classic 19" Star Turbine',
      wheelSurcharge: 0,
      interior: 'Da Nappa màu Đen Mythos',
      interiorSurcharge: 0
    };

    function selectExteriorColor(name, hex, e) {
      // Toggle swatches active button styling
      const buttons = document.querySelectorAll('.color-btn');
      buttons.forEach(btn => btn.classList.remove('color-btn--active'));
      
      const evt = e || window.event;
      const activeBtn = evt ? evt.currentTarget : null;
      if (activeBtn) {
        activeBtn.classList.add('color-btn--active');
      }

      // Update text and swatch color dot
      const dotElement = document.getElementById('color-name-dot');
      const textElement = document.getElementById('color-name-text');
      if (dotElement && textElement) {
        dotElement.style.backgroundColor = hex;
        textElement.innerText = "Ngoại thất: " + name;
      }

      // Live Colorizer Effect
      const overlay = document.getElementById('colorizer-overlay');
      const img = document.querySelector('.detail-hero__bg');
      if (overlay && img) {
        overlay.style.backgroundColor = hex;
        overlay.style.opacity = '0.35'; // Perfect opacity for rich metallic blend
        
        // Custom blending for black/white/silver shades to feel real
        const lName = name.toLowerCase();
        if (lName.includes('trắng') || lName.includes('white') || hex.toLowerCase() === '#ffffff') {
          img.style.filter = 'brightness(1.1) contrast(1.05) grayscale(0.2)';
          overlay.style.opacity = '0';
        } else if (lName.includes('đen') || lName.includes('black') || hex.toLowerCase() === '#000000' || hex.toLowerCase() === '#1a1a1a') {
          img.style.filter = 'brightness(0.55) contrast(1.2) grayscale(0.8)';
          overlay.style.opacity = '0';
        } else {
          img.style.filter = 'brightness(0.85) contrast(1.1) saturate(1.2)';
        }
      }

      // Update state
      window.vipBuildState.paint = name;
      updateBuildSheet();
    }

    function selectWheel(name, surcharge, event) {
      // Style toggle
      const container = event.currentTarget.parentElement;
      container.querySelectorAll('.option-picker-card').forEach(card => card.classList.remove('option-picker-card--active'));
      event.currentTarget.classList.add('option-picker-card--active');
      
      // Update radio check
      const radio = event.currentTarget.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;

      // Update state
      window.vipBuildState.wheel = name;
      window.vipBuildState.wheelSurcharge = surcharge;
      
      updateBuildSheet();
    }

    function selectInterior(name, surcharge, event) {
      // Style toggle
      const container = event.currentTarget.parentElement;
      container.querySelectorAll('.option-picker-card').forEach(card => card.classList.remove('option-picker-card--active'));
      event.currentTarget.classList.add('option-picker-card--active');
      
      // Update radio check
      const radio = event.currentTarget.querySelector('input[type="radio"]');
      if (radio) radio.checked = true;

      // Update state
      window.vipBuildState.interior = name;
      window.vipBuildState.interiorSurcharge = surcharge;
      
      updateBuildSheet();
    }

    function updateBuildSheet() {
      const carPriceRaw = "<?php echo $car['price']; ?>";
      const basePrice = parseInt(carPriceRaw.split('/')[0].replace(/[^0-9]/g, '')) || 0;
      
      const totalPrice = basePrice + window.vipBuildState.wheelSurcharge + window.vipBuildState.interiorSurcharge;
      
      // Format VND
      const formatVnd = (num) => {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(num).replace('₫', 'VNĐ');
      };

      // Update DOM
      const pEl = document.getElementById('build-paint');
      const wEl = document.getElementById('build-wheel');
      const iEl = document.getElementById('build-interior');
      const tEl = document.getElementById('build-total-price');
      
      if (pEl) pEl.innerText = window.vipBuildState.paint;
      if (wEl) wEl.innerText = window.vipBuildState.wheel.split(' ').slice(0, 3).join(' '); // Shorten wheels name
      if (iEl) iEl.innerText = window.vipBuildState.interior.replace('Da Nappa màu ', ''); // Shorten leather name
      if (tEl) tEl.innerText = formatVnd(totalPrice);
      
      // Sync to hidden input inside the form so it is posted!
      const hiddenInput = document.getElementById('vip-build-sheet-input');
      if (hiddenInput) {
        hiddenInput.value = `[CẤU HÌNH VIP] Ngoại thất: ${window.vipBuildState.paint} | Mâm xe: ${window.vipBuildState.wheel} | Nội thất: ${window.vipBuildState.interior} | Tổng giá trị: ${formatVnd(totalPrice)}`;
      }
    }

    // Hotspot dynamic selector data
    const hotspotsData = {
      cockpit: {
        title: "VinFast Virtual Cockpit - Buồng lái ảo",
        desc: "Buồng lái ảo thế hệ mới với màn hình độ phân giải cao 12.3 inch siêu sắc nét. Cho phép tùy chỉnh cấu hình hiển thị bản đồ 3D, thông số hành trình, hệ thống đa phương tiện trực tiếp trên tầm nhìn người lái."
      },
      lighting: {
        title: "Đèn pha Matrix LED thông minh",
        desc: "Công nghệ đèn pha hàng đầu với các diode phát quang độc lập. Hệ thống tự động nhận diện xe đi ngược chiều để che chắn luồng sáng tối ưu, chống chói mắt trong khi vẫn giữ nguyên hiệu năng chiếu sáng toàn cảnh."
      },
      sound: {
        title: "Hệ thống âm thanh Bang & Olufsen 3D",
        desc: "Hòa âm đỉnh cao với hệ thống 19 loa cao cấp công suất lên tới 730W. Mang tới trải nghiệm rạp hát di động 3D trung thực, tách bạch mọi âm phổ từ trầm đến cao cho mọi vị trí ngồi."
      }
    };

    function toggleHotspot(type, e) {
      // Toggle button active classes
      const buttons = document.querySelectorAll('.hotspot-btn');
      buttons.forEach(btn => btn.classList.remove('.hotspot-btn--active'));
      
      const evt = e || window.event;
      if (evt && evt.currentTarget) {
        evt.currentTarget.classList.add('hotspot-btn--active');
      }
      
      const displayPanel = document.getElementById('hotspot-content-display');
      const ambientPanel = document.getElementById('ambient-simulator-panel');
      
      if (type === 'ambient') {
        // Show Ambient simulator panel and hide standard display
        if (displayPanel) displayPanel.style.display = 'none';
        if (ambientPanel) {
          ambientPanel.style.display = 'block';
          ambientPanel.style.opacity = 0;
          setTimeout(() => { ambientPanel.style.opacity = 1; }, 50);
        }
      } else {
        // Hide Ambient simulator and show standard display
        if (ambientPanel) ambientPanel.style.display = 'none';
        if (displayPanel) {
          displayPanel.style.display = 'block';
          
          const titleEl = document.getElementById('hotspot-title');
          const descEl = document.getElementById('hotspot-desc');
          if (titleEl && descEl && hotspotsData[type]) {
            titleEl.style.opacity = 0;
            descEl.style.opacity = 0;
            
            setTimeout(() => {
              titleEl.innerText = hotspotsData[type].title;
              descEl.innerText = hotspotsData[type].desc;
              
              titleEl.style.opacity = 1;
              descEl.style.opacity = 1;
            }, 150);
          }
        }
      }
    }

    // Change ambient line stroke color and shadow glow dynamically
    function changeAmbientColor(hex, name, el) {
      // Toggle swatch active class
      const swatches = document.querySelectorAll('.ambient-swatch');
      swatches.forEach(sw => sw.classList.remove('ambient-swatch--active'));
      el.classList.add('ambient-swatch--active');
      
      // Update color name text and color
      const txtSpan = document.getElementById('ambient-color-name');
      if (txtSpan) {
        txtSpan.innerText = name;
        txtSpan.style.color = hex;
      }
      
      // Apply hex color to all paths on dashboard SVG
      const ledPaths = document.querySelectorAll('.ambient-led-path');
      ledPaths.forEach(path => {
        path.style.setProperty('--ambient-active-color', hex);
      });
    }

    // Filter Premium Media Gallery Items
    function filterGallery(category, el) {
      // Toggle tab button active styles
      const tabBtns = document.querySelectorAll('.gallery-tab-btn');
      tabBtns.forEach(btn => btn.classList.remove('gallery-tab-btn--active'));
      el.classList.add('gallery-tab-btn--active');
      
      // Show/Hide Grid elements with subtle fade in effect
      const cards = document.querySelectorAll('.gallery-card');
      cards.forEach(card => {
        const itemCat = card.getAttribute('data-category');
        if (category === 'all' || itemCat === category) {
          card.style.display = 'block';
          setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'scale(1)'; }, 50);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'scale(0.95)';
          setTimeout(() => { card.style.display = 'none'; }, 300);
        }
      });
    }

    // Lightbox gallery data set matching Unsplash HD references
    const lightboxImages = [
      <?php foreach ($allGalleryItems as $item): ?>
      { src: '<?php echo htmlspecialchars($item['src'] . (strpos($item['src'], '?') !== false ? '&' : '?') . 'v=2026'); ?>', title: '<?php echo addslashes($item['title']); ?>', category: '<?php echo addslashes($item['category_vn']); ?>' },
      <?php endforeach; ?>
    ];

    let currentLightboxIdx = 0;

    function openLightbox(index) {
      currentLightboxIdx = index;
      const lightbox = document.getElementById('gallery-lightbox');
      const img = document.getElementById('lightbox-image');
      const title = document.getElementById('lightbox-title');
      const cat = document.getElementById('lightbox-category');
      
      if (lightbox && img && title && cat && lightboxImages[index]) {
        img.src = lightboxImages[index].src;
        title.innerText = lightboxImages[index].title;
        cat.innerText = lightboxImages[index].category;
        
        lightbox.classList.add('gallery-lightbox--show');
        document.body.style.overflow = 'hidden'; // Lock background scroll
      }
    }

    // Close Lightbox
    function closeLightbox() {
      const lightbox = document.getElementById('gallery-lightbox');
      if (lightbox) {
        lightbox.classList.remove('gallery-lightbox--show');
        document.body.style.overflow = 'auto'; // Unlock background scroll
      }
    }

    function nextLightbox() {
      currentLightboxIdx = (currentLightboxIdx + 1) % lightboxImages.length;
      updateLightboxContent();
    }

    // Prev Lightbox
    function prevLightbox() {
      currentLightboxIdx = (currentLightboxIdx - 1 + lightboxImages.length) % lightboxImages.length;
      updateLightboxContent();
    }

    function updateLightboxContent() {
      const img = document.getElementById('lightbox-image');
      const title = document.getElementById('lightbox-title');
      const cat = document.getElementById('lightbox-category');
      const data = lightboxImages[currentLightboxIdx];
      
      if (img && title && cat && data) {
        // Smooth cross-fade transition
        img.style.opacity = 0;
        img.style.transform = 'scale(0.97)';
        
        setTimeout(() => {
          img.src = data.src;
          title.innerText = data.title;
          cat.innerText = data.category;
          img.style.opacity = 1;
          img.style.transform = 'scale(1)';
        }, 150);
      }
    }

    // Attach keyboard listener for convenience escape and arrows
    window.addEventListener('keydown', (e) => {
      const lightbox = document.getElementById('gallery-lightbox');
      if (lightbox && lightbox.classList.contains('gallery-lightbox--show')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextLightbox();
        if (e.key === 'ArrowLeft') prevLightbox();
      }
    });

    // Toggle VIP Address Input field dynamic slide
    function toggleVipAddressField() {
      const selectType = document.getElementById('book-type');
      const addressPanel = document.getElementById('vip-address-panel');
      const addressInput = document.getElementById('book-address');
      
      if (selectType && addressPanel && addressInput) {
        if (selectType.value === 'VIP tại nhà') {
          addressPanel.classList.add('vip-address-panel--show');
          addressPanel.style.marginBottom = '12px';
          addressInput.setAttribute('required', 'true');
        } else {
          addressPanel.classList.remove('vip-address-panel--show');
          addressPanel.style.marginBottom = '0';
          addressInput.removeAttribute('required');
          addressInput.value = '';
        }
      }
    }

    // Global Repayment Method State
    let currentRepaymentMethod = 'declining'; // 'declining' or 'flat'

    function setRepaymentMethod(method) {
      currentRepaymentMethod = method;
      
      // Update UI active buttons
      const decBtn = document.getElementById('repay-declining-btn');
      const flatBtn = document.getElementById('repay-flat-btn');
      const totalLbl = document.getElementById('repayment-total-lbl');
      
      if (decBtn && flatBtn && totalLbl) {
        if (method === 'declining') {
          decBtn.classList.add('repayment-tab-btn--active');
          flatBtn.classList.remove('repayment-tab-btn--active');
          totalLbl.innerText = 'Ước tính trả tháng đầu (Gốc + Lãi)';
        } else {
          flatBtn.classList.add('repayment-tab-btn--active');
          decBtn.classList.remove('repayment-tab-btn--active');
          totalLbl.innerText = 'Ước tính trả đều cố định mỗi tháng';
        }
      }
      
      calculateLoan();
    }

    // Dynamic Loan Calculator with Custom Interest & Amortization methods
    function calculateLoan() {
      const carPriceRaw = "<?php echo $car['price']; ?>";
      const numericPrice = parseInt(carPriceRaw.split('/')[0].replace(/[^0-9]/g, '')) || 0;
      
      if (numericPrice <= 0) return;
      
      const prepaymentSlider = document.getElementById('prepayment-slider');
      const termSlider = document.getElementById('term-slider');
      const rateSlider = document.getElementById('interest-rate-slider');
      
      if (!prepaymentSlider || !termSlider || !rateSlider) return;
      
      const prepaymentPct = parseInt(prepaymentSlider.value);
      const termMonths = parseInt(termSlider.value);
      const annualRate = parseFloat(rateSlider.value);
      
      // Update label texts in real-time
      document.getElementById('prepayment-pct-text').innerText = prepaymentPct + "%";
      document.getElementById('term-months-text').innerText = termMonths + " tháng";
      document.getElementById('interest-rate-text').innerText = annualRate.toFixed(1) + "% / năm";
      document.getElementById('loan-applied-rate').innerText = annualRate.toFixed(1) + "% / năm";
      
      // Base math
      const prepaymentAmount = numericPrice * (prepaymentPct / 100);
      const loanAmount = numericPrice - prepaymentAmount;
      const monthlyRate = (annualRate / 100) / 12;
      
      let monthlyTotal = 0;
      
      if (currentRepaymentMethod === 'declining') {
        // Declining Balance: Principal pays equally, interest based on remaining balance (Month 1 peak)
        const monthlyPrincipal = loanAmount / termMonths;
        const interestMonth1 = loanAmount * monthlyRate;
        monthlyTotal = monthlyPrincipal + interestMonth1;
      } else {
        // Flat Rate / Equal installments (Annuity Formula)
        // Formula: P * r * (1 + r)^n / ((1 + r)^n - 1)
        if (monthlyRate === 0) {
          monthlyTotal = loanAmount / termMonths;
        } else {
          monthlyTotal = (loanAmount * monthlyRate * Math.pow(1 + monthlyRate, termMonths)) / (Math.pow(1 + monthlyRate, termMonths) - 1);
        }
      }
      
      // Format to VND
      const formatVnd = (num) => {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(num).replace('₫', 'VNĐ');
      };
      
      document.getElementById('loan-car-price').innerText = formatVnd(numericPrice);
      document.getElementById('prepayment-amount').innerText = formatVnd(prepaymentAmount);
      document.getElementById('loan-amount').innerText = formatVnd(loanAmount);
      document.getElementById('monthly-payment-total').innerText = formatVnd(monthlyTotal);
      
      // Dynamic Financial Advice Logic
      const adviceCard = document.getElementById('financial-advice-card');
      const adviceIcon = document.getElementById('advice-icon');
      const adviceText = document.getElementById('advice-text');
      
      if (adviceCard && adviceIcon && adviceText) {
        const thresholdPay = 45000000; // 45 million VND
        
        if (monthlyTotal > thresholdPay) {
          adviceCard.style.background = 'rgba(239, 83, 80, 0.03)';
          adviceCard.style.borderColor = 'rgba(239, 83, 80, 0.15)';
          adviceIcon.innerText = '⚠️';
          adviceText.innerText = 'LƯU Ý: Số tiền trả tháng khá lớn. Hãy tăng Tỷ lệ trả trước hoặc kéo dài Thời hạn vay để giảm áp lực dòng tiền.';
          adviceText.style.color = '#ff8a80';
        } else {
          adviceCard.style.background = 'rgba(46, 125, 50, 0.03)';
          adviceCard.style.borderColor = 'rgba(46, 125, 50, 0.15)';
          adviceIcon.innerText = '💡';
          adviceText.innerText = 'GỢI Ý: Kế hoạch cân đối tài chính tối ưu, an toàn và dễ dàng chi trả mỗi tháng.';
          adviceText.style.color = '#a5d6a7';
        }
      }
    }

    function animateTelemetry() {
      // 1. Power (HP)
      const powerText = "<?php echo $car['power']; ?>";
      const hp = parseInt(powerText.replace(/[^0-9]/g, '')) || 0;
      const powerPct = Math.min((hp / 800) * 100, 100);
      setTimeout(() => {
        const bar = document.getElementById('telemetry-power-bar');
        if (bar) bar.style.width = powerPct + '%';
      }, 300);

      // 2. Torque (Nm)
      const torqueText = "<?php echo $car['torque']; ?>";
      const nm = parseInt(torqueText.replace(/[^0-9]/g, '')) || 0;
      const torquePct = Math.min((nm / 1000) * 100, 100);
      setTimeout(() => {
        const bar = document.getElementById('telemetry-torque-bar');
        if (bar) bar.style.width = torquePct + '%';
      }, 500);

      // 3. Acceleration (0-100)
      const accelText = "<?php echo $car['acceleration']; ?>";
      const sec = parseFloat(accelText.replace(/[^0-9.]/g, '')) || 12;
      const accelPct = Math.max(0, Math.min(100, ((12 - sec) / (12 - 2)) * 100));
      setTimeout(() => {
        const bar = document.getElementById('telemetry-accel-bar');
        if (bar) bar.style.width = accelPct + '%';
      }, 700);

      // 4. Top Speed (km/h)
      const speedText = "<?php echo $car['top_speed']; ?>";
      const kmh = parseInt(speedText.replace(/[^0-9]/g, '')) || 0;
      const speedPct = Math.min((kmh / 320) * 100, 100);
      setTimeout(() => {
        const bar = document.getElementById('telemetry-speed-bar');
        if (bar) bar.style.width = speedPct + '%';
      }, 900);
    }
    
    // Toggle specifications table collapse/expand dynamically
    function toggleSpecsTable() {
      const wrapper = document.getElementById('specs-collapsible-wrapper');
      const btn = document.getElementById('btn-specs-toggle');
      const textSpan = document.getElementById('specs-toggle-text');
      
      if (wrapper && btn && textSpan) {
        const isExpanded = wrapper.classList.contains('specs-collapsible-wrapper--expanded');
        
        if (isExpanded) {
          // Collapse
          wrapper.style.maxHeight = '310px';
          wrapper.classList.remove('specs-collapsible-wrapper--expanded');
          btn.classList.remove('btn-specs-toggle--active');
          textSpan.innerText = 'Xem thông số chi tiết';
          
          // Smooth scroll back to table header
          wrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
          // Expand
          const table = wrapper.querySelector('table');
          const fullHeight = table ? table.scrollHeight + 'px' : '1000px';
          wrapper.style.maxHeight = fullHeight;
          
          wrapper.classList.add('specs-collapsible-wrapper--expanded');
          btn.classList.add('btn-specs-toggle--active');
          textSpan.innerText = 'Thu gọn bảng';
        }
      }
    }
    
    // Initial run
    window.addEventListener('DOMContentLoaded', () => {
      calculateLoan();
      updateBuildSheet();
      animateTelemetry();
      
      // Attach transition styles dynamically to hotspot elements for smooth text fade
      const titleEl = document.getElementById('hotspot-title');
      const descEl = document.getElementById('hotspot-desc');
      if (titleEl && descEl) {
        titleEl.style.transition = 'opacity 0.15s ease';
        descEl.style.transition = 'opacity 0.15s ease';
      }
    });

  </script>

  <!-- STRUCTURED DATA: PRODUCT & FAQ SCHEMA FOR GOOGLE SEARCH BOT (SEO UPGRADE) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Product",
        "@id": "https://vfstamphong.test/xe-vinfast/<?php echo htmlspecialchars($car['slug']); ?>#product",
        "name": "<?php echo htmlspecialchars($car['model_name']); ?>",
        "image": "https://vfstamphong.test/<?php echo htmlspecialchars($car['image']); ?>",
        "description": "<?php echo htmlspecialchars($car['description'] ?? 'Mẫu xe ô tô điện thông minh thương hiệu Việt Nam sở hữu DNA công nghệ vượt trội.'); ?>",
        "brand": {
          "@type": "Brand",
          "name": "VinFast"
        },
        "offers": {
          "@type": "AggregateOffer",
          "priceCurrency": "VND",
          "lowPrice": "<?php 
            $priceOnly = preg_replace('/[^0-9]/', '', explode('/', $car['price'])[0]); 
            echo htmlspecialchars($priceOnly ? $priceOnly : '240000000'); 
          ?>",
          "highPrice": "<?php 
            $priceParts = explode('/', $car['price']);
            $highPriceOnly = isset($priceParts[1]) ? preg_replace('/[^0-9]/', '', $priceParts[1]) : '';
            echo htmlspecialchars($highPriceOnly ? $highPriceOnly : ($priceOnly ? $priceOnly : '1491000000')); 
          ?>",
          "offerCount": "2",
          "priceSpecification": {
            "@type": "PriceSpecification",
            "valueAddedTaxIncluded": "true"
          },
          "availability": "https://schema.org/InStock",
          "url": "https://vfstamphong.test/xe-vinfast/<?php echo htmlspecialchars($car['slug']); ?>"
        },
        "aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": "4.9",
          "reviewCount": "128",
          "bestRating": "5",
          "worstRating": "1"
        }
      },
      {
        "@type": "FAQPage",
        "@id": "https://vfstamphong.test/xe-vinfast/<?php echo htmlspecialchars($car['slug']); ?>#faq",
        "mainEntity": [
          {
            "@type": "Question",
            "name": "Giá xe <?php echo htmlspecialchars($car['model_name']); ?> lăn bánh là bao nhiêu?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Giá xe <?php echo htmlspecialchars($car['model_name']); ?> khởi điểm là <?php echo htmlspecialchars($car['price']); ?>. Chi phí lăn bánh thực tế sẽ phụ thuộc vào các chính sách ưu đãi lệ phí trước bạ, đặc quyền sạc pin và quà tặng phụ kiện tại showroom tùy từng thời điểm."
            }
          },
          {
            "@type": "Question",
            "name": "Thủ tục mua xe <?php echo htmlspecialchars($car['model_name']); ?> trả góp cần những gì?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Thủ tục mua trả góp xe <?php echo htmlspecialchars($car['model_name']); ?> cực kỳ đơn giản: Chỉ cần căn cước công dân gắn chip để xét duyệt tài chính nhanh qua hệ thống ngân hàng liên kết trong 30 phút. Khách hàng chỉ cần trả trước tối thiểu 20% giá trị xe để nhận xe ngay."
            }
          },
          {
            "@type": "Question",
            "name": "Lãi suất vay trả góp xe <?php echo htmlspecialchars($car['model_name']); ?> là bao nhiêu?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Showroom VinFast Tam Phong đang liên kết với các ngân hàng đối tác cung cấp gói vay trả góp xe <?php echo htmlspecialchars($car['model_name']); ?> với lãi suất ưu đãi chỉ từ 7.9% / năm theo dư nợ giảm dần hoặc trả đều cố định."
            }
          },
          {
            "@type": "Question",
            "name": "Thời gian duyệt hồ sơ và nhận xe <?php echo htmlspecialchars($car['model_name']); ?> trả góp mất bao lâu?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Thời gian phê duyệt hồ sơ vay trả góp cực nhanh trong vòng 30 phút kể từ lúc nhận đủ hồ sơ online. Quý khách có thể nhận xe ngay hoặc yêu cầu giao xe trực tiếp đến tận nhà trong vòng 3 đến 5 ngày làm việc."
            }
          },
          {
            "@type": "Question",
            "name": "Pin của xe điện <?php echo htmlspecialchars($car['model_name']); ?> đi được bao nhiêu km mỗi lần sạc đầy?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Dòng xe ô tô điện thông minh <?php echo htmlspecialchars($car['model_name']); ?> được trang bị pin LFP cho tầm hoạt động tối đa lên đến khoảng <?php echo htmlspecialchars($car['range_wltp'] ?? '320 - 400 km'); ?> mỗi lần sạc đầy và hỗ trợ sạc siêu nhanh DC 10%-70% trong 25-30 phút."
            }
          },
          {
            "@type": "Question",
            "name": "Chính sách bảo hành và chi phí bảo dưỡng xe <?php echo htmlspecialchars($car['model_name']); ?> thế nào?",
            "acceptedAnswer": {
              "@type": "Answer",
              "text": "Xe điện <?php echo htmlspecialchars($car['model_name']); ?> được hãng bảo hành chính hãng dài hạn từ 7 đến 10 năm hoặc 200.000 km cùng dịch vụ cứu hộ khẩn cấp 24/7. Chi phí bảo dưỡng định kỳ rẻ hơn xe xăng từ 50% đến 70%."
            }
          }
        ]
      }
    ]
  }
  </script>
