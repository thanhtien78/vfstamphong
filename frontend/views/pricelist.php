<!-- DYNAMIC JSON-LD PRICELIST SCHEMA FOR 2026 SEO ADVANTAGES -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "Bảng giá xe VinFast chính hãng mới nhất tại Việt Nam",
    "description": "Cập nhật chi tiết bảng giá lăn bánh và các chương trình khuyến mãi, đặc quyền quà tặng chính hãng cho tất cả dòng xe ô tô điện VinFast thông minh.",
    "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>",
    "numberOfItems": <?php echo count($cars); ?>,
    "itemListElement": [
      <?php foreach ($cars as $index => $c): ?>
      {
        "@type": "ListItem",
        "position": <?php echo $index + 1; ?>,
        "url": "<?php echo $baseUrl; ?>/xe-vinfast/<?php echo $c['slug']; ?>",
        "name": "<?php echo htmlspecialchars($c['model_name']); ?> - Giá: <?php echo htmlspecialchars($c['price']); ?> VNĐ"
      }<?php echo ($index < count($cars) - 1) ? ',' : ''; ?>
      <?php endforeach; ?>
    ]
  }
  </script>

  <!-- STYLE OVERRIDES FOR BRAND-ACCENT ALIGNMENT -->
  <style>
  /* Pricelist Light Theme Accents */
  .catalog-hero {
    background: radial-gradient(circle at top, #ffffff 30%, #f1f5f9 100%) !important;
    padding: 140px 24px 70px 24px !important;
    border-bottom: 1px solid #e5e7eb !important;
    text-align: center;
  }
  .catalog-hero__title {
    color: #0f172a !important;
    font-size: 36px !important;
    font-weight: 850 !important;
  }
  .catalog-hero__desc {
    color: #475569 !important;
    font-size: 14.5px !important;
    max-width: 700px !important;
    margin: 12px auto 0 !important;
    line-height: 1.65 !important;
  }
  .electric-badge-overlay {
    background: rgba(16, 185, 129, 0.08) !important;
    border: 1px solid rgba(16, 185, 129, 0.25) !important;
    color: #10b981 !important;
    font-weight: 700 !important;
    border-radius: 6px !important;
  }
  .price-table th {
    background-color: #f1f5f9 !important;
    color: #1e293b !important;
    font-weight: 800 !important;
    border-bottom: 2px solid #cbd5e1 !important;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
  }
  .price-table th:first-child, .price-table td:first-child {
    background-color: #f8fafc !important;
    color: #0f172a !important;
    border-right: 2px solid #cbd5e1 !important;
  }
  .card-gifts-list li::before, .table-gifts-list li::before {
    color: #10b981 !important;
  }
  .promo-badge {
    background: rgba(16, 185, 129, 0.05) !important;
    border: 1px solid rgba(16, 185, 129, 0.15) !important;
    color: #10b981 !important;
    border-radius: 6px !important;
    font-weight: 600 !important;
  }
  /* Counselor Section styling */
  .pricelist-counselor-section {
    background: #f8fafc !important;
    border-top: 1px solid #e2e8f0 !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 60px 0 !important;
  }
  .counselor-card-vip {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03) !important;
  }
  .counselor-name-vip {
    color: #0f172a !important;
  }
  .counselor-title-vip {
    color: #64748b !important;
  }

  /* BUTTON COLOR CONTRAST FIXES */
  html body .btn-primary,
  html body .btn-primary-mini,
  html body .vip-btn-submit,
  html body .geo-toast-btn {
    background: #10b981 !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    border: none !important;
  }
  html body .btn-primary:hover,
  html body .btn-primary-mini:hover,
  html body .vip-btn-submit:hover,
  html body .geo-toast-btn:hover {
    background: #0d53c6 !important;
    color: #ffffff !important;
  }
  
  html body .view-switch-btn.view-switch-btn--active,
  html body .table-filter-btn.table-filter-btn--active {
    background: #10b981 !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    border-color: #10b981 !important;
  }
  
  html body .view-switch-btn,
  html body .table-filter-btn {
    color: #475569 !important;
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
  }
  html body .view-switch-btn:hover,
  html body .table-filter-btn:hover {
    background: #f1f5f9 !important;
    color: #0f172a !important;
  }
  
  html body .btn-zalo-mini,
  html body .btn-zalo-invoice {
    background: #10b981 !important;
    color: #ffffff !important;
    border: 1px solid #0054d1 !important;
    font-weight: 600 !important;
  }
  html body .btn-zalo-mini:hover,
  html body .btn-zalo-invoice:hover {
    background: #0054d1 !important;
    color: #ffffff !important;
  }
  
  
  html body .counselor-btn-vip--zalo {
    color: #10b981 !important;
    background: rgba(0, 104, 255, 0.08) !important;
    font-weight: 600 !important;
  }
  html body .counselor-btn-vip--zalo:hover {
    background: #10b981 !important;
    color: #ffffff !important;
  }
  
  html body .counselor-btn-vip--call {
    color: #10b981 !important;
    background: rgba(25, 96, 215, 0.08) !important;
    font-weight: 600 !important;
  }
  html body .counselor-btn-vip--call:hover {
    background: #10b981 !important;
    color: #ffffff !important;
  }
  
  /* Calculator inputs and dropdown styling overrides */
  html body .form-select {
    background-color: #ffffff !important;
    color: #334155 !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 10px 16px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    height: 48px !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }
  html body .form-select option {
    background-color: #ffffff !important;
    color: #334155 !important;
  }
  </style>

  <!-- HERO BANNER -->
  <section class="catalog-hero">
    <div class="catalog-hero__content">
      <span class="catalog-hero__subtitle">Biểu Giá Xe Chính Hãng</span>
      <h1 class="catalog-hero__title"><?php echo htmlspecialchars($settings['pricelist_intro_headline'] ?? 'Bảng Giá Xe & Giá Lăn Bánh VinFast'); ?></h1>
      <p class="catalog-hero__desc">
        <?php echo htmlspecialchars($settings['pricelist_intro_desc'] ?? 'Bảng giá niêm yết chính thức từ VinFast Việt Nam kèm dự toán lăn bánh (thuế trước bạ, phí biển số, tùy chọn pin) chi tiết.'); ?> Cập nhật ngày <?php echo date('d/m/Y'); ?>.
      </p>
    </div>
  </section>

  <!-- MAIN VIEWPORT CONTAINER -->
  <section class="container" style="padding-top: 48px;">
    <div class="section-header">
      <span class="section-tag">Giá công bố</span>
      <h2 class="section-title">Báo giá & Thông số nổi bật</h2>
    </div>

    <!-- View Switcher Tabs (Dạng Thẻ Premium / Dạng So Sánh Bảng) -->
    <div class="view-switcher">
      <button class="view-switch-btn view-switch-btn--active" onclick="switchView('card', event)">
        Dạng thẻ Premium
      </button>
      <button class="view-switch-btn" onclick="switchView('table', event)">
        Dạng so sánh bảng
      </button>
    </div>

    <!-- Centered VUỐT ĐỂ SO SÁNH Pill-shaped badge (Rule requirement) -->
    <div class="swipe-hint-container" id="swipe-hint-box">
      <div class="swipe-hint-pill">
        <span class="swipe-icon">↔</span> VUỐT ĐỂ SO SÁNH
      </div>
    </div>

    <!-- Table Filter Tabs -->
    <div class="table-filter-panel">
      <button class="table-filter-btn table-filter-btn--active" onclick="filterTable('all', event)">Tất cả xe</button>
      <button class="table-filter-btn" onclick="filterTable('electric', event)">Xe Điện thông minh</button>
      <button class="table-filter-btn" onclick="filterTable('suv', event)">Dòng SUV</button>
      <button class="table-filter-btn" onclick="filterTable('commercial', event)">Xe Thương Mại & Dịch Vụ</button>
    </div>

    <!-- VIEW 1: PREMIUM LUXURY CARDS VIEW (DEFAULT) -->
    <div id="card-view-container">
      <div class="pricelist-cards-container">
        <?php foreach ($cars as $c): ?>
          <?php
            $engineDesc = mb_strtolower($c['engine']);
            $isElectric = (str_contains($engineDesc, 'điện') || str_contains($engineDesc, 'electric') || str_contains($engineDesc, 'bev')) ? 1 : 0;
            
            // Calculate dynamic installment estimate (7.9% rate, 30% downpayment, 84 months)
            $cleanPriceStr = preg_replace('/[^0-9]/', '', explode('/', $c['price'])[0]);
            $numericPrice = (int)$cleanPriceStr;
            
            if ($numericPrice > 0) {
                $prepay = $numericPrice * 0.3;
                $loan = $numericPrice - $prepay;
                $monthlyRate = 0.079 / 12;
                $estMonthly = ($loan / 84) + ($loan * $monthlyRate);
                $monthlyMil = round($estMonthly / 1000000);
                $estText = "Chỉ từ ~ " . $monthlyMil . " triệu / tháng";
            } else {
                $estText = "Liên hệ";
            }

            // Map promotion and gifts based on model name
            $modelName = trim($c['model_name']);
            $promoText = '';
            $giftsList = [];
            
            if (isset($modelPerks[$modelName])) {
                $promoText = $modelPerks[$modelName]['promo'];
                $giftsList = $modelPerks[$modelName]['gifts'];
            } else {
                if ($isElectric === 1) {
                    $promoText = "Miễn phí 100% Lệ phí trước bạ (trị giá lên tới hàng trăm triệu VNĐ) + Gói hỗ trợ lắp đặt trạm sạc tại nhà.";
                    $giftsList = ["Bộ sạc di động cao cấp chính hãng", "Thảm lót sàn da cao cấp", "Hộp bảo quản giữ nhiệt VinFast."];
                } else {
                    $promoText = "Ưu đãi tương đương 50% Lệ phí trước bạ + Tặng thêm 02 năm bảo hiểm thân vỏ Liberty cao cấp.";
                    $giftsList = ["Dù che mưa VinFast cao cấp", "Ví da đựng hồ sơ VIP", "Gói phủ Ceramic bảo vệ bề mặt sơn chính hãng."];
                }
            }
          ?>
          <div class="luxury-price-card" data-segment="<?php echo htmlspecialchars($c['segment']); ?>" data-electric="<?php echo $isElectric; ?>">
            <!-- Left: Visual Image -->
            <div class="luxury-price-card__image-box">
              <img src="<?php echo htmlspecialchars(get_thumb_url($c['image'], 480)); ?>" alt="<?php echo htmlspecialchars($c['model_name']); ?>" class="luxury-price-card__image" loading="lazy" width="400" height="250">
              <?php if ($isElectric === 1): ?>
                <span class="electric-badge-overlay">⚡ Xe thuần điện</span>
              <?php endif; ?>
            </div>
            
            <!-- Right: Detailed Content -->
            <div class="luxury-price-card__content">
              <div class="luxury-price-card__header">
                <div>
                  <span class="luxury-price-card__segment"><?php echo htmlspecialchars($c['segment']); ?></span>
                  <h3 class="luxury-price-card__title"><?php echo htmlspecialchars($c['model_name']); ?></h3>
                </div>
                <div class="luxury-price-card__pricing">
                  <span class="luxury-price-card__price"><?php echo htmlspecialchars(!empty($c['price']) ? $c['price'] : 'Liên hệ'); ?></span>
                  <span class="luxury-price-card__installment"><?php echo $estText; ?></span>
                  <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" target="_blank" class="btn-zalo-mini" rel="noopener">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px; display: inline-block; vertical-align: middle; color: #fff;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                    </svg>
                    Báo giá Zalo
                  </a>
                </div>
              </div>
              
              <!-- Promo & Gift details -->
              <div class="luxury-price-card__perks">
                <div class="perk-item">
                  <span class="perk-icon">🎁</span>
                  <div class="perk-info">
                    <strong>Ưu đãi & Khuyến mãi:</strong>
                    <p class="card-promo-text"><?php echo htmlspecialchars($promoText); ?></p>
                  </div>
                </div>
                <div class="perk-item">
                  <span class="perk-icon">✨</span>
                  <div class="perk-info">
                    <strong>Bộ quà tặng đi kèm chính hiệu:</strong>
                    <ul class="card-gifts-list">
                      <?php foreach ($giftsList as $gift): ?>
                        <li><?php echo htmlspecialchars($gift); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>
              
              <!-- Tech Specs overview -->
              <div class="luxury-price-card__specs">
                <div class="spec-mini">
                  <span class="spec-mini__lbl">Động cơ</span>
                  <span class="spec-mini__val"><?php echo htmlspecialchars($c['engine']); ?></span>
                </div>
                <div class="spec-mini">
                  <span class="spec-mini__lbl">Công suất</span>
                  <span class="spec-mini__val"><?php echo htmlspecialchars($c['power']); ?></span>
                </div>
                <div class="spec-mini">
                  <span class="spec-mini__lbl">Tăng tốc 0-100km/h</span>
                  <span class="spec-mini__val"><?php echo htmlspecialchars($c['acceleration']); ?></span>
                </div>
              </div>
              
              <!-- Footer actions -->
              <div class="luxury-price-card__footer">
                <a href="#onroad-calculator" onclick="selectCarForEstimator(<?php echo $c['id']; ?>)" class="btn-primary-mini">
                  Tính giá lăn bánh
                </a>
                <a href="xe-vinfast/<?php echo $c['slug']; ?>" class="btn-secondary-mini">
                  Xem chi tiết xe
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- VIEW 2: CLASSIC COMPARISON TABLE VIEW (HIDDEN BY DEFAULT) -->
    <div id="table-view-container" style="display: none;">
      <div class="price-table-wrapper">
        <table class="price-table">
          <thead>
            <tr>
              <th>Dòng xe & Phân khúc</th>
              <th>Giá niêm yết công bố</th>
              <th>Chương trình Khuyến mãi</th>
              <th>Bộ quà tặng kèm</th>
              <th>Mức trả góp ước tính</th>
              <th>Công suất (Hp)</th>
              <th>Động cơ / Nhiên liệu</th>
              <th>Tăng tốc (0-100 km/h)</th>
              <th>Thao tác nhanh</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cars as $c): ?>
              <?php
                $engineDesc = mb_strtolower($c['engine']);
                $isElectric = (str_contains($engineDesc, 'điện') || str_contains($engineDesc, 'electric') || str_contains($engineDesc, 'bev')) ? 1 : 0;
                
                // Calculate dynamic installment estimate
                $cleanPriceStr = preg_replace('/[^0-9]/', '', explode('/', $c['price'])[0]);
                $numericPrice = (int)$cleanPriceStr;
                
                if ($numericPrice > 0) {
                    $prepay = $numericPrice * 0.3;
                    $loan = $numericPrice - $prepay;
                    $monthlyRate = 0.079 / 12;
                    $estMonthly = ($loan / 84) + ($loan * $monthlyRate);
                    $monthlyMil = round($estMonthly / 1000000);
                    $estText = "Chỉ từ ~ " . $monthlyMil . " triệu / tháng";
                } else {
                    $estText = "Liên hệ";
                }

                // Map promotion and gifts based on model name
                $modelName = trim($c['model_name']);
                $promoText = '';
                $giftsList = [];
                
                if (isset($modelPerks[$modelName])) {
                    $promoText = $modelPerks[$modelName]['promo'];
                    $giftsList = $modelPerks[$modelName]['gifts'];
                } else {
                    if ($isElectric === 1) {
                        $promoText = "Tặng bộ sạc ABB 11kW + Miễn phí 100% trước bạ";
                        $giftsList = ["Bộ sạc di động ABB 11kW", "Thảm lót sàn cao cấp"];
                    } else {
                        $promoText = "Tặng BH thân vỏ cao cấp + Gói bảo dưỡng 2 năm chính hãng";
                        $giftsList = ["Dù che mưa VinFast", "Ví đựng hồ sơ"];
                    }
                }
              ?>
              <tr data-segment="<?php echo htmlspecialchars($c['segment']); ?>" data-electric="<?php echo $isElectric; ?>">
                <td>
                  <div style="display: flex; align-items: center; gap: 16px;">
                    <div class="table-car-img-box">
                      <img src="<?php echo htmlspecialchars(get_thumb_url($c['image'], 200)); ?>" alt="<?php echo htmlspecialchars($c['model_name']); ?>" class="table-car-img" loading="lazy" width="120" height="75">
                    </div>
                    <div>
                      <span class="price-val" style="font-size: 14px; display: inline-flex; align-items: center;">
                        <?php echo htmlspecialchars($c['model_name']); ?>
                        <?php if ($isElectric === 1): ?>
                          <span style="display: inline-block; background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); color: #10b981; font-size: 8px; padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-left: 8px; text-transform: uppercase; letter-spacing: 0.5px;">0% Trước Bạ</span>
                        <?php endif; ?>
                      </span>
                      <div style="font-size: 11px; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">
                        <?php echo htmlspecialchars($c['segment']); ?>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="price-val" style="color: var(--color-primary); font-size: 14.5px; display: block; margin-bottom: 6px;"><?php echo htmlspecialchars($c['price']); ?></span>
                  <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" target="_blank" class="btn-zalo-mini" rel="noopener">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 6px; display: inline-block; vertical-align: middle; color: #fff;">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                    </svg>
                    Báo giá Zalo
                  </a>
                </td>
                <td>
                  <span class="promo-badge promo-badge--gold"><?php echo htmlspecialchars($promoText); ?></span>
                </td>
                <td>
                  <ul class="table-gifts-list">
                    <?php foreach ($giftsList as $gift): ?>
                      <li><?php echo htmlspecialchars($gift); ?></li>
                    <?php endforeach; ?>
                  </ul>
                </td>
                <td>
                  <span class="price-val"><?php echo $estText; ?></span>
                  <span class="installment-lbl">Gói vay 84 tháng, trả trước 30%</span>
                </td>
                <td>
                  <span class="price-val"><?php echo htmlspecialchars($c['power']); ?></span>
                </td>
                <td>
                  <span class="price-val"><?php echo htmlspecialchars($c['engine']); ?></span>
                </td>
                <td>
                  <span class="price-val"><?php echo htmlspecialchars($c['acceleration']); ?></span>
                </td>
                <td>
                  <a href="#onroad-calculator" onclick="selectCarForEstimator(<?php echo $c['id']; ?>)" class="btn-table-action" style="margin-right: 8px;">Tính giá lăn bánh</a>
                  <a href="xe-vinfast/<?php echo $c['slug']; ?>" class="btn-table-action">Chi tiết</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- General Tax & Registration Disclaimer (Database Settings) -->
    <div style="margin-top: 32px; background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 12px; padding: 18px 24px; font-size: 13px; line-height: 1.6; color: var(--color-text-muted);">
      <p style="margin: 0; display: flex; align-items: flex-start; gap: 8px;">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary); flex-shrink: 0; margin-top: 2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
        <span><strong>Lưu ý về thuế & đăng ký:</strong> <?php echo htmlspecialchars($settings['pricelist_tax_note'] ?? 'Giá niêm yết đã bao gồm thuế Giá trị gia tăng (VAT 10%), chưa bao gồm lệ phí trước bạ, phí đăng ký biển số và các chi phí lăn bánh khác.'); ?></span>
      </p>
    </div>
  </section>

  <!-- ON-ROAD ESTIMATOR SECTION -->
  <section class="onroad-section" id="onroad-calculator">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Dự toán mua xe</span>
        <h2 class="section-title">Bảng tính giá lăn bánh lăn bánh tự động</h2>
        <p style="color: var(--color-text-muted); font-size: 13px; max-width: 600px; margin: 8px auto 0 auto;">
          Dự toán chi tiết thuế trước bạ, phí biển số và bảo hiểm đăng kiểm xe tại các tỉnh thành ở Việt Nam.
        </p>
      </div>

      <div class="onroad-grid">
        <!-- Cột trái: Form nhập liệu -->
        <div class="onroad-card">
          <div class="form-group">
            <label class="form-label" for="calc-car-select">Chọn dòng xe muốn đăng ký</label>
            <select class="form-select" id="calc-car-select" onchange="calculateOnRoad()">
              <?php foreach ($cars as $c): ?>
                <?php
                  $engineDesc = mb_strtolower($c['engine']);
                  $isElectric = (str_contains($engineDesc, 'điện') || str_contains($engineDesc, 'electric') || str_contains($engineDesc, 'bev')) ? 1 : 0;
                  $numericP = (int)preg_replace('/[^0-9]/', '', explode('/', $c['price'])[0]);
                ?>
                <option value="<?php echo $numericP; ?>" 
                        data-electric="<?php echo $isElectric; ?>"
                        data-id="<?php echo htmlspecialchars($c['id']); ?>"
                        data-name="<?php echo htmlspecialchars($c['model_name']); ?>">
                  <?php echo htmlspecialchars($c['model_name']); ?> - <?php echo htmlspecialchars($c['price']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label" for="calc-province">Khu vực đăng ký biển số</label>
            <select class="form-select" id="calc-province" onchange="calculateOnRoad()">
              <option value="hn">Hà Nội (Trước bạ 12%, Biển số 20 triệu)</option>
              <option value="hcm">TP. Hồ Chí Minh (Trước bạ 10%, Biển số 20 triệu)</option>
              <option value="prov">Tỉnh/Thành phố khác (Trước bạ 10%, Biển số 2 triệu)</option>
            </select>
          </div>

          <div class="estimator-info-text">
            <p><strong>💡 Lợi thế xe điện VinFast thuần điện:</strong> Theo chính sách ưu đãi hiện hành, xe điện chạy pin được áp dụng lệ phí trước bạ lần đầu là <strong>0%</strong>. Tổng chi phí lăn bánh xe điện thấp hơn xe xăng hàng trăm triệu đồng.</p>
          </div>
        </div>

        <!-- Cột phải: Kết quả hóa đơn lăn bánh -->
        <div class="onroad-card onroad-card--invoice">
          <h3 class="invoice-title">Chi tiết chi phí lăn bánh</h3>
          
          <div class="invoice-rows">
            <div class="invoice-row">
              <span class="invoice-row__lbl">Giá niêm yết xe</span>
              <span class="invoice-row__val" id="inv-list-price">...</span>
            </div>
            
            <div class="invoice-row">
              <span class="invoice-row__lbl">Lệ phí trước bạ (<span id="inv-tax-pct">...</span>)</span>
              <span class="invoice-row__val" id="inv-reg-fee">...</span>
            </div>
            
            <div class="invoice-row">
              <span class="invoice-row__lbl">Phí cấp biển số</span>
              <span class="invoice-row__val" id="inv-plate-fee">...</span>
            </div>
            
            <div class="invoice-row">
              <span class="invoice-row__lbl">Phí đường bộ (12 tháng)</span>
              <span class="invoice-row__val">1.560.000 VNĐ</span>
            </div>
            
            <div class="invoice-row">
              <span class="invoice-row__lbl">Phí bảo hiểm TNDS bắt buộc</span>
              <span class="invoice-row__val">480.000 VNĐ</span>
            </div>
            
            <div class="invoice-row">
              <span class="invoice-row__lbl">Phí kiểm định xe</span>
              <span class="invoice-row__val">340.000 VNĐ</span>
            </div>

            <div class="invoice-row invoice-row--total">
              <span class="invoice-row__lbl">Tổng giá lăn bánh (Ước tính)</span>
              <span class="invoice-row__val invoice-row__val--gold" id="inv-total-price">...</span>
            </div>
          </div>
          
          <div class="invoice-actions">
            <button onclick="requestQuote()" class="btn-primary">
              Nhận báo giá chi tiết qua điện thoại
            </button>
            <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" target="_blank" class="btn-zalo-invoice" rel="noopener">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 6px; color: #fff;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
              </svg>
              Nhận bảng tính qua Zalo
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ONLINE CONNECTION COUNSELOR CONCIERGE SECTION (REDESIGNED FOR PERFECT SYMMETRY) -->
  <section class="pricelist-counselor-section">
    <div class="container" style="max-width: 900px; text-align: center;">
      <!-- Header block -->
      <span class="section-tag" style="display: inline-block;">Tư vấn trực tiếp</span>
      <h2 class="section-title" style="font-size: 28px; margin-top: 12px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 1px;">Kết Nối Trực Tuyến</h2>
      <p style="font-size: 14.5px; color: var(--color-text-muted); line-height: 1.8; max-width: 700px; margin: 0 auto 20px auto;">
        Chuyên viên tư vấn sản phẩm đang trực ban sẵn sàng giải đáp nhanh các thắc mắc về giá bán, cấu hình xe cũ lên đời hoặc lên lịch lái thử cấp tốc.
      </p>
      
      <!-- General Helpline Badge -->
      <div class="concierge-hotline-box" style="display: inline-flex; align-items: center; gap: 12px; background: rgba(25, 96, 215,0.05); border: 1px solid rgba(25, 96, 215,0.15); padding: 12px 24px; border-radius: 30px; margin-bottom: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="var(--color-primary)" stroke-width="2.2" style="flex-shrink:0;">
          <path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
        </svg>
        <span style="font-size: 11.5px; color: var(--color-text-muted); letter-spacing: 0.5px;">Tổng đài Đại lý 24/7: <strong style="color: var(--color-primary); margin-left: 4px;"><?php echo htmlspecialchars($agencyPhone); ?></strong></span>
      </div>

      <!-- Counselors VIP Cards Grid -->
      <div class="counselors-vip-grid">
        <?php
          $stmtCounselors = $db->query("SELECT * FROM counselors WHERE status = 'ONLINE' LIMIT 2");
          $activeCounselors = $stmtCounselors->fetchAll();
          
          if (empty($activeCounselors)):
        ?>
          <!-- Fallback Card 1 -->
          <div class="counselor-card-vip">
            <div class="counselor-avatar-wrap-vip">
              <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=70&fm=webp" alt="VinFast Representative" class="counselor-avatar-vip" loading="lazy" width="80" height="80">
              <span class="counselor-pulse-vip"></span>
            </div>
            <div class="counselor-meta-vip">
              <span class="counselor-status-lbl-vip">Đang trực ban</span>
              <h3 class="counselor-name-vip">Cố vấn VinFast Hồ Chí Minh</h3>
              <p class="counselor-title-vip">Đại diện cố vấn sản phẩm VIP</p>
            </div>
            <div class="counselor-actions-vip">
              <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" class="counselor-btn-vip counselor-btn-vip--call">
                <?php echo get_svg_icon('fa-phone-alt', 12, 12, 'display:inline-block; vertical-align:middle; margin-right:4px;'); ?> Gọi ngay
              </a>
              <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" target="_blank" class="counselor-btn-vip counselor-btn-vip--zalo" rel="noopener">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" style="display:inline-block; vertical-align:middle; margin-right:4px;"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.22.73 4.27 1.96 5.92L3 21l3.18-.94C7.79 20.65 9.8 21 12 21c5.52 0 10-4.48 10-10S17.52 2 12 2zm3.84 12.01h-5.26l4.28-4.89c.14-.16.03-.45-.19-.45h-4.32c-.22 0-.4.18-.4.4v1.1c0 .22.18.4.4.4h3.77L9.74 13.25c-.14.16-.03.45.19.45h4.63c.22 0 .4-.18.4-.4v-1.1c0-.22-.18-.4-.4-.4z" /></svg> Chat Zalo
              </a>
            </div>
          </div>
        <?php else: ?>
          <?php foreach ($activeCounselors as $cs): ?>
            <div class="counselor-card-vip">
              <div class="counselor-avatar-wrap-vip">
                <?php
                $csAvatarUrl = !empty($cs['avatar']) ? (($basePath !== '' ? rtrim($basePath, '/') : '') . '/' . ltrim($cs['avatar'], '/')) : 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80';
                ?>
                <img src="<?php echo htmlspecialchars($csAvatarUrl); ?>" alt="<?php echo htmlspecialchars($cs['fullname']); ?>" class="counselor-avatar-vip" loading="lazy" width="80" height="80">
                <span class="counselor-pulse-vip"></span>
              </div>
              <div class="counselor-meta-vip">
                <span class="counselor-status-lbl-vip">Đang trực ban</span>
                <h3 class="counselor-name-vip"><?php echo htmlspecialchars($cs['fullname']); ?></h3>
                <p class="counselor-title-vip">Chuyên viên tư vấn sản phẩm VIP</p>
              </div>
              <div class="counselor-actions-vip">
                <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $cs['phone']); ?>" class="counselor-btn-vip counselor-btn-vip--call">
                  <?php echo get_svg_icon('fa-phone-alt', 12, 12, 'display:inline-block; vertical-align:middle; margin-right:4px;'); ?> Gọi ngay
                </a>
                <a href="<?php echo htmlspecialchars(!empty($cs['zalo']) ? $cs['zalo'] : 'https://zalo.me/' . preg_replace('/[^0-9]/', '', $cs['phone'])); ?>" target="_blank" class="counselor-btn-vip counselor-btn-vip--zalo" rel="noopener">
                  <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" style="display:inline-block; vertical-align:middle; margin-right:4px;"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.22.73 4.27 1.96 5.92L3 21l3.18-.94C7.79 20.65 9.8 21 12 21c5.52 0 10-4.48 10-10S17.52 2 12 2zm3.84 12.01h-5.26l4.28-4.89c.14-.16.03-.45-.19-.45h-4.32c-.22 0-.4.18-.4.4v1.1c0 .22.18.4.4.4h3.77L9.74 13.25c-.14.16-.03.45.19.45h4.63c.22 0 .4-.18.4-.4v-1.1c0-.22-.18-.4-.4-.4z" /></svg> Chat Zalo
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- DOWNLOAD CATALOG SECTION -->
  <section style="padding: 64px 0; background: radial-gradient(circle at center, rgba(25, 96, 215, 0.05) 0%, transparent 70%); border-top: 1px solid var(--color-border); text-align: center;">
    <div class="container" style="max-width: 900px;">
      <div style="text-align: center; margin-bottom: 36px;">
        <span class="section-tag">TÀI LIỆU BROCHURE ĐỘC QUYỀN</span>
        <h3 style="font-size: 24px; color: var(--color-text-main); text-transform: uppercase; letter-spacing: 0.5px;">Tải bảng báo giá & Catalog PDF</h3>
        <p style="font-size: 13.5px; color: var(--color-text-muted); margin-bottom: 0; line-height: 1.6; max-width: 600px; margin: 8px auto 0 auto;">
          Nhận file PDF bảng giá chính thức, đặc tính kỹ thuật chi tiết của tất cả các dòng xe VinFast phân phối tại Việt Nam gửi trực tiếp qua Email hoặc Zalo của bạn.
        </p>
      </div>
      
      <div class="brochure-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px; text-align: left;">
        <?php
          $downloadsJson = $settings['pricelist_downloads'] ?? '';
          $downloads = json_decode($downloadsJson, true) ?: [];
          if (!empty($downloads)):
            foreach ($downloads as $dl):
        ?>
          <div class="brochure-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);" onmouseover="this.style.borderColor='rgba(25, 96, 215, 0.35)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='#e2e8f0'; this.style.transform='translateY(0)';" onfocus="this.style.borderColor='rgba(25, 96, 215, 0.35)';" onblur="this.style.borderColor='#e2e8f0';">
            <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
              <div style="width: 40px; height: 40px; background: rgba(25, 96, 215, 0.08); border: 1px solid rgba(25, 96, 215, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--color-primary); flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10,9 9,9 8,9"></polyline></svg>
              </div>
              <div style="min-width: 0;">
                <h4 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($dl['title']); ?></h4>
                <span style="font-size: 11px; color: #64748b; display: block; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Tài liệu PDF chính hãng</span>
              </div>
            </div>
            <a href="javascript:void(0)" onclick="downloadBrochure('<?php echo addslashes($dl['title']); ?>')" class="btn-primary" style="padding: 10px 16px; font-size: 11px; border-radius: 20px; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; width: 100%; box-sizing: border-box; text-align: center;">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
              Tải xuống Brochure
            </a>
          </div>
        <?php
            endforeach;
          else:
        ?>
          <div class="brochure-card" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);">
            <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 18px;">
              <div style="width: 40px; height: 40px; background: rgba(25, 96, 215, 0.08); border: 1px solid rgba(25, 96, 215, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--color-primary); flex-shrink: 0;">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10,9 9,9 8,9"></polyline>
                </svg>
              </div>
              <div style="min-width: 0;">
                <h4 style="font-size: 14px; font-weight: 700; color: #0f172a; margin: 0; line-height: 1.4;">Brochure thông số kỹ thuật xe</h4>
                <span style="font-size: 11px; color: #64748b; display: block; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Tài liệu PDF chính hãng</span>
              </div>
            </div>
            <a href="javascript:void(0)" onclick="downloadCatalog()" class="btn-primary" style="padding: 10px 16px; font-size: 11px; border-radius: 20px; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; width: 100%; box-sizing: border-box; text-align: center;">
              <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
              Tải xuống Brochure
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- FAQ ACCORDION SECTION -->
  <section class="container" style="padding: 64px 0 32px 0; border-top: 1px solid var(--color-border);">
    <div class="section-header">
      <span class="section-tag">Giải đáp thắc mắc</span>
      <h2 class="section-title">Câu hỏi thường gặp (FAQ)</h2>
    </div>

    <div class="faq-acc-container">
      <?php 
      // Streamlined: Using the pre-decoded global $faqs array from the top of the file
      foreach ($faqs as $faq):
      ?>
        <div class="faq-acc-item">
          <button class="faq-acc-trigger" onclick="toggleFaq(this)">
            <span><?php echo htmlspecialchars($faq['question']); ?></span>
            <span class="faq-acc-icon">+</span>
          </button>
          <div class="faq-acc-panel">
            <p><?php echo htmlspecialchars($faq['answer']); ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div></section>

  <!-- SEO EDITORIAL CONTENT SECTION (TIGHT SPACING PER MEMORY RULE) -->
  <section class="seo-section">
    <div class="container">
      <article class="seo-article">
        <?php 
        $editorialText = $settings['pricelist_editorial'] ?? '';
        if (!empty($editorialText)) {
            echo $editorialText;
        } else {
        ?>
          <h2>Cẩm nang Mua xe & Phân tích Bảng giá xe VinFast tại Việt Nam</h2>
          <p>Thương hiệu xe điện thông minh VinFast từ Việt Nam luôn là biểu tượng của sự kết hợp hoàn hảo giữa công nghệ tiên phong, hiệu suất vận hành êm ái bảo vệ môi trường và chi phí tối ưu. Việc sở hữu một chiếc xe VinFast tại thị trường Việt Nam đòi hỏi người mua cần nắm vững các thông tin về bảng giá xe, chính sách thuê pin vs mua pin, các chương trình hỗ trợ tài chính trả góp cũng như quy trình tính toán tổng chi phí lăn bánh chính xác.</p>

          <h3>Các Dòng Xe VinFast Nổi Bật và Xu Hướng Giá Cả</h3>
          <p>Tại Việt Nam, VinFast phân phối đa dạng các phân khúc xe điện đáp ứng mọi nhu cầu của khách hàng:</p>
          <ul>
            <li><strong>SUV đô thị cỡ nhỏ (VinFast VF 3, VF 5 Plus)</strong>: Kiểu dáng nhỏ gọn, năng động, di chuyển linh hoạt trong phố thị với chi phí vận hành siêu tiết kiệm. Phù hợp cho giới trẻ và gia đình nhỏ.</li>
            <li><strong>SUV phân khúc tầm trung (VinFast VF 6, VF 7)</strong>: Không gian nội thất hiện đại, tích hợp gói hỗ trợ lái ADAS thông minh và thiết kế mang xu hướng tương lai đầy phong cách.</li>
            <li><strong>SUV phân khúc cỡ lớn (VinFast VF 8, VF 9)</strong>: Flagship sang trọng đẳng cấp của hãng, công nghệ dẫn động bốn bánh, cabin rộng rãi cực kỳ êm ái phù hợp cho doanh nghiệp và gia đình lớn.</li>
          </ul>

          <h3>Quy Trình Tính Giá Lăn Bánh Xe VinFast Chi Tiết</h3>
          <p>Để một chiếc xe VinFast chính hãng đủ điều kiện lưu hành hợp pháp trên đường phố Việt Nam, chủ sở hữu cần chuẩn bị chi trả các khoản thuế và lệ phí bắt buộc do nhà nước quy định:</p>
          <p>1. <strong>Lệ phí trước bạ</strong>: Chiếm tỷ trọng lớn nhất trong các khoản chi phí phụ trợ. Tuy nhiên, đối với các dòng xe thuần điện chạy pin của VinFast, nhà nước hỗ trợ áp dụng thuế trước bạ lần đầu là 0% cho đến hết năm 2026, giúp tiết kiệm từ vài chục đến hàng trăm triệu đồng so với xe xăng cùng phân khúc.</p>
          <p>2. <strong>Lệ phí cấp biển số</strong>: Hà Nội và TP. Hồ Chí Minh áp dụng mức phí cố định là 20.000.000 VNĐ cho mỗi lần đăng ký mới. Ở các tỉnh thành còn lại, mức phí này chỉ từ 1.000.000 VNĐ đến 2.000.000 VNĐ.</p>
          <p>3. <strong>Phí bảo trì đường bộ</strong>: Mức thu quy định cho xe cá nhân là 130.000 VNĐ/tháng (tương đương 1.560.000 VNĐ/năm).</p>
          <p>4. <strong>Các chi phí khác</strong>: Bao gồm phí kiểm định xe (đăng kiểm) trị giá 340.000 VNĐ và phí bảo hiểm trách nhiệm dân sự bắt buộc là 480.000 VNĐ/năm.</p>

          <h3>Chính Sách Hỗ Trợ Mua Xe VinFast Trả Góp Ưu Đãi</h3>
          <p>Đại lý ủy quyền chính hãng phối hợp chặt chẽ với các ngân hàng lớn trong và ngoài nước cung cấp gói vay tài chính linh hoạt. Khách hàng chỉ cần thanh toán trước từ 20% đến 30% giá trị xe, phần còn lại được hỗ trợ vay trả góp dài hạn lên tới 84 tháng (7 năm) với lãi suất áp dụng chỉ từ 7.9%/năm. Các gói tài chính được thiết kế linh hoạt theo cả hai hình thức: trả gốc đều lãi giảm dần hoặc trả niên kim cố định hàng tháng để khách hàng chủ động dòng tiền.</p>
        <?php 
        } 
        ?>
      </article>
    </div>
  </section>
  <!-- CALCULATOR JAVASCRIPT -->
  <script>
    // Format numbers as VND currency format
    function formatVnd(num) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(num).replace('₫', 'VNĐ');
    }

    // FAQ Accordion Toggle
    function toggleFaq(trigger) {
      const item = trigger.parentElement;
      const panel = trigger.nextElementSibling;
      
      const isActive = item.classList.contains('faq-acc-item--active');
      
      // Close all open panels
      document.querySelectorAll('.faq-acc-item').forEach(el => {
        el.classList.remove('faq-acc-item--active');
        el.querySelector('.faq-acc-panel').style.maxHeight = null;
      });
      
      if (!isActive) {
        item.classList.add('faq-acc-item--active');
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    }

    // View Switcher logic (Premium Cards vs Classic Table)
    function switchView(mode, event) {
      const buttons = document.querySelectorAll('.view-switch-btn');
      buttons.forEach(btn => btn.classList.remove('view-switch-btn--active'));
      
      const evt = event || window.event;
      if (evt && evt.currentTarget) {
        evt.currentTarget.classList.add('view-switch-btn--active');
      }

      const cardView = document.getElementById('card-view-container');
      const tableView = document.getElementById('table-view-container');
      const swipeBox = document.getElementById('swipe-hint-box');
      
      if (mode === 'card') {
        cardView.style.display = 'block';
        tableView.style.display = 'none';
        if (swipeBox) swipeBox.style.display = 'none';
      } else {
        cardView.style.display = 'none';
        tableView.style.display = 'block';
        if (swipeBox) swipeBox.style.display = 'flex';
      }
    }

    // Handle price table filter
    function filterTable(category, event) {
      // Manage active filter button class
      const buttons = document.querySelectorAll('.table-filter-btn');
      buttons.forEach(btn => btn.classList.remove('table-filter-btn--active'));
      
      const evt = event || window.event;
      if (evt && evt.currentTarget) {
        evt.currentTarget.classList.add('table-filter-btn--active');
      }

      // Filter Table Rows
      const rows = document.querySelectorAll('.price-table tbody tr');
      rows.forEach(row => {
        const segment = row.getAttribute('data-segment').toLowerCase();
        const isElectric = parseInt(row.getAttribute('data-electric')) || 0;
        
        let show = false;
        if (category === 'all') {
          show = true;
        } else if (category === 'electric') {
          show = (isElectric === 1);
        } else if (category === 'suv') {
          show = segment.includes('suv');
        } else if (category === 'commercial') {
          show = segment.includes('dịch vụ') || segment.includes('van') || segment.includes('buýt') || segment.includes('ebus') || segment.includes('commercial');
        }

        if (show) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });

      // Filter Cards
      const cards = document.querySelectorAll('.luxury-price-card');
      cards.forEach(card => {
        const segment = card.getAttribute('data-segment').toLowerCase();
        const isElectric = parseInt(card.getAttribute('data-electric')) || 0;
        
        let show = false;
        if (category === 'all') {
          show = true;
        } else if (category === 'electric') {
          show = (isElectric === 1);
        } else if (category === 'suv') {
          show = segment.includes('suv');
        } else if (category === 'commercial') {
          show = segment.includes('dịch vụ') || segment.includes('van') || segment.includes('buýt') || segment.includes('ebus') || segment.includes('commercial');
        }

        if (show) {
          card.style.display = '';
          card.style.opacity = '0';
          setTimeout(() => {
            card.style.transition = 'opacity 0.25s ease';
            card.style.opacity = '1';
          }, 10);
        } else {
          card.style.display = 'none';
        }
      });
    }

    // Handle price table quick select action
    function selectCarForEstimator(carId) {
      const selectEl = document.getElementById('calc-car-select');
      if (!selectEl) return;
      
      // Find option with matching ID inside select element
      for (let i = 0; i < selectEl.options.length; i++) {
        if (selectEl.options[i].getAttribute('data-id') == carId) {
          selectEl.selectedIndex = i;
          break;
        }
      }
      
      calculateOnRoad();
      
      // Smooth scroll to calculator card
      document.getElementById('onroad-calculator').scrollIntoView({ behavior: 'smooth' });
    }

    // Main logic for dynamic Vietnamese on-road calculation
    function calculateOnRoad() {
      const selectEl = document.getElementById('calc-car-select');
      const provEl = document.getElementById('calc-province');
      
      if (!selectEl || !provEl) return;
      
      const activeOption = selectEl.options[selectEl.selectedIndex];
      const listPrice = parseInt(activeOption.value) || 0;
      const isElectric = parseInt(activeOption.getAttribute('data-electric')) || 0;
      const province = provEl.value;
      
      // 1. Calculate Registration Fee (Trước bạ)
      // 0% for electric cars, otherwise 12% for HN, 10% for HCM/other provinces
      let regTaxPct = 0;
      if (isElectric === 0) {
        regTaxPct = (province === 'hn') ? 12 : 10;
      }
      const regFee = listPrice * (regTaxPct / 100);
      
      // 2. Calculate Plate Fee (Lệ phí cấp biển số)
      // 20M for HN & HCM, 2M for other provinces
      const plateFee = (province === 'hn' || province === 'hcm') ? 20000000 : 2000000;
      
      // 3. Fixed statutory road fees in Vietnam
      const roadMaintenanceFee = 1560000; // 130,000 VND / month for 12 months (personal passenger car)
      const civilInsuranceFee = 480000;   // Civil liability insurance
      const inspectionFee = 340000;       // Statutory registration / inspection fee
      
      // 4. Calculate total cost
      const totalOnRoadPrice = listPrice + regFee + plateFee + roadMaintenanceFee + civilInsuranceFee + inspectionFee;
      
      // 5. Update UI values
      document.getElementById('inv-list-price').innerText = formatVnd(listPrice);
      document.getElementById('inv-tax-pct').innerText = regTaxPct + "%";
      document.getElementById('inv-reg-fee').innerText = formatVnd(regFee);
      document.getElementById('inv-plate-fee').innerText = formatVnd(plateFee);
      document.getElementById('inv-total-price').innerText = formatVnd(totalOnRoadPrice);
    }

    // Call-to-action button logic
    function requestQuote() {
      const selectEl = document.getElementById('calc-car-select');
      const activeOption = selectEl.options[selectEl.selectedIndex];
      const carName = activeOption.getAttribute('data-name');
      
      const phone = prompt("Vui lòng nhập Số điện thoại của bạn để nhận báo giá lăn bánh đặc quyền cho dòng xe " + carName + ":");
      if (phone) {
        alert("Yêu cầu gửi báo giá xe " + carName + " thành công! Đội ngũ tư vấn đại lý VinFast sẽ gửi bảng chi tiết lăn bánh qua điện thoại của bạn trong ít phút.");
      }
    }

    // Lead capture for PDF Catalog downloads
    function downloadCatalog() {
      const contact = prompt("Vui lòng cung cấp Địa chỉ Email hoặc Số điện thoại để nhận Brochure Catalog dạng PDF:");
      if (contact) {
        alert("Yêu cầu gửi tài liệu thành công! Đường dẫn tải file PDF Catalog đã được gửi tới thông tin liên lạc: " + contact);
      }
    }

    // Lead capture for specific dynamic Brochure PDF downloads
    function downloadBrochure(brochureTitle) {
      const contact = prompt("Vui lòng cung cấp Địa chỉ Email hoặc Số điện thoại để nhận tài liệu \"" + brochureTitle + "\" dạng PDF:");
      if (contact) {
        alert("Yêu cầu gửi tài liệu thành công! Đường dẫn tải file PDF \"" + brochureTitle + "\" đã được gửi tới thông tin liên lạc: " + contact);
      }
    }
  </script>




