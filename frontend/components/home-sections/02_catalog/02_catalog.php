<!-- SECTION 2: BRAND SPOTLIGHT -->
  <section class="brand-spotlight">
    <div class="container">
      <div class="spotlight-grid">
        <div class="spotlight-info">
          <span class="spotlight-tag">KỶ NGUYÊN ĐIỆN HÓA MỚI</span>
          <h2 class="spotlight-title"><?php echo htmlspecialchars($s6Headline); ?></h2>
          <div class="spotlight-desc">
            <?php echo $s6Desc; ?>
          </div>
          <div style="margin-top: 20px;">
            <a href="#catalog-block" class="btn-primary" style="font-size:13px; padding:14px 28px; border-radius: 30px; text-decoration: none; display: inline-block;">Khám phá bộ sưu tập điện</a>
          </div>
        </div>
        <div class="spotlight-visual">
          <span class="spotlight-visual-badge">
            <span class="pulse-dot"></span>
            LIVE COCKPIT UX
          </span>
          <img src="<?php echo $basePath; ?>/assets/uploads/vinfast-digital-cockpit.jpg" alt="VinFast digital cockpit cabin" loading="lazy" width="800" height="500">
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 3: INTERACTIVE CATALOG (Da đẩy lên vị trí 3) -->
  <section class="catalog-section" id="catalog-block">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Kiệt tác cơ khí</span>
        <h2 class="section-title">Bảng Giá Xe VinFast Mới Nhất Tại Đại lý VinFast Tam Phong</h2>
      </div>

      <!-- Pill Tab Filter Bar (EV Groups) -->
      <div class="filter-tabs">
        <button class="filter-tab-btn filter-tab-btn--active" onclick="filterHomeCatalog('all', event)">Tất cả dòng xe</button>
        <button class="filter-tab-btn" onclick="filterHomeCatalog('city', event)">Đô Thị & Mini (VF 3, VF 5)</button>
        <button class="filter-tab-btn" onclick="filterHomeCatalog('midsize', event)">SUV Tầm Trung (VF 6, VF 7, VF 8)</button>
        <button class="filter-tab-btn" onclick="filterHomeCatalog('large', event)">SUV Hạng Sang (VF 9)</button>
        <button class="filter-tab-btn" onclick="filterHomeCatalog('service', event)">Dịch Vụ Green</button>
      </div>

      <!-- Grid Catalog -->
      <div class="catalog-grid" id="catalog-grid-container">
        <?php foreach ($compareCars as $c): ?>
          <?php
            $segmentLower = mb_strtolower($c['segment'] ?? '');
            $nameLower = mb_strtolower($c['model_name'] ?? '');
            
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
          <article class="car-card <?php echo $group === 'service' ? 'car-card--fleet' : ''; ?>" data-group="<?php echo $group; ?>">
            <div class="car-card__media">
              <span class="car-card__badge <?php echo $group === 'service' ? 'car-card__badge--fleet' : 'car-card__badge--electric'; ?>">
                <?php echo $group === 'service' ? '🚕 Dịch Vụ Green B2B' : $groupLabel; ?>
              </span>
              <img class="car-card__img" src="<?php echo htmlspecialchars(get_thumb_url($c['image'], 480)); ?>" alt="<?php echo htmlspecialchars($c['model_name']); ?>" loading="lazy" width="400" height="250" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
              <div class="car-card__img-fallback" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, hsla(216, 20%, 85%, 0.9), #ffffff); align-items: center; justify-content: center; text-align: center; padding: 24px; border: 1px solid rgba(16, 185, 129, 0.15); z-index: 1;">
                <span style="font-family: 'Montserrat', sans-serif !important; font-weight: 800 !important; font-size: 16px; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ev-green); text-shadow: 0 0 10px rgba(16, 185, 129, 0.2); background: linear-gradient(135deg, #000 30%, var(--color-ev-green) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo htmlspecialchars($c['model_name']); ?></span>
              </div>
            </div>
            
            <div class="car-card__info">
              <span class="car-card__segment"><?php echo htmlspecialchars($c['segment']); ?></span>
              <h3 class="car-card__name"><?php echo htmlspecialchars($c['model_name']); ?></h3>
              <p class="car-card__desc"><?php echo htmlspecialchars($c['description'] ?? 'Mẫu xe điện thông minh sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?></p>
              
              <div class="car-card__specs">
                <div class="car-card__spec-item">
                  <span class="car-card__spec-lbl">Công suất</span>
                  <span class="car-card__spec-val"><?php echo htmlspecialchars($c['power']); ?></span>
                </div>
                <div class="car-card__spec-item">
                  <span class="car-card__spec-lbl">Gia tốc (0-100)</span>
                  <span class="car-card__spec-val"><?php echo htmlspecialchars($c['acceleration']); ?></span>
                </div>
                <div class="car-card__spec-item" style="grid-column: span 2; border-top:1px solid rgba(0,0,0,0.05); padding-top:6px; margin-top:2px;">
                  <span class="car-card__spec-lbl">Động cơ / Truyền động</span>
                  <span class="car-card__spec-val" style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap; color: var(--color-text-dark);" title="<?php echo htmlspecialchars($c['engine']); ?>">
                    <?php echo htmlspecialchars($c['engine']); ?>
                  </span>
                </div>
              </div>

              <?php
                $priceRaw = !empty($c['price']) ? trim($c['price']) : 'Liên hệ';
                $formattedPriceHtml = '';
                
                if ($priceRaw === 'Liên hệ') {
                    $formattedPriceHtml = '<div class="price-row-main"><span class="price-main-num">Liên hệ</span></div>';
                } else {
                    if (strpos($priceRaw, '/') !== false) {
                        $parts = explode('/', $priceRaw);
                        $rentPart = trim($parts[0]);
                        $buyPart = trim($parts[1]);
                        
                        $rentText = trim(str_replace('(Thuê pin)', '', $rentPart));
                        $formattedPriceHtml = '<div class="price-row-main"><span class="price-main-num">' . htmlspecialchars($rentText) . '</span> <span class="price-badge-rent">Thuê pin</span></div>';
                        
                        $buyText = trim(str_replace('(Mua pin)', '', $buyPart));
                        if (strpos($buyText, 'Từ') === false) {
                            $buyText = 'Từ ' . $buyText;
                        }
                        $formattedPriceHtml .= '<div class="price-row-sub"><span class="price-buy-lbl">Mua đứt pin:</span> <span class="price-buy-val">' . htmlspecialchars($buyText) . '</span></div>';
                    } else {
                        $mainText = $priceRaw;
                        $subNoteText = '';
                        
                        if (strpos($priceRaw, '(Đã kèm pin)') !== false) {
                            $mainText = trim(str_replace('(Đã kèm pin)', '', $priceRaw));
                            $subNoteText = 'Đã bao gồm pin';
                        } elseif (strpos($priceRaw, '(Thuê pin)') !== false) {
                            $mainText = trim(str_replace('(Thuê pin)', '', $priceRaw));
                            $subNoteText = 'Gói thuê pin';
                        } elseif (strpos($priceRaw, '(Kèm ưu đãi sạc)') !== false) {
                            $mainText = trim(str_replace('(Kèm ưu đãi sạc)', '', $priceRaw));
                            $subNoteText = 'Đã kèm ưu đãi sạc';
                        }
                        
                        $formattedPriceHtml = '<div class="price-row-main"><span class="price-main-num">' . htmlspecialchars($mainText) . '</span></div>';
                        if ($subNoteText) {
                            $formattedPriceHtml .= '<div class="price-row-sub"><span class="price-info-note">* ' . htmlspecialchars($subNoteText) . '</span></div>';
                        }
                    }
                }
              ?>
              <div class="car-card__price-box">
                <span class="car-card__price-lbl">Giá khởi điểm</span>
                <div class="car-card__price-val-container"><?php echo $formattedPriceHtml; ?></div>
              </div>

              <div class="car-card__footer">
                <a href="xe-vinfast/<?php echo $c['slug']; ?>" class="btn-detail-card <?php echo $group === 'service' ? 'btn-detail-card--fleet' : ''; ?>">
                  <?php echo $group === 'service' ? 'Báo giá sỉ' : 'Chi tiết'; ?>
                </a>
                <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20và%20tư%20vấn%20dòng%20xe%20VinFast%20<?php echo urlencode($c['model_name']); ?>" target="_blank" class="btn-zalo-card" rel="noopener">
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