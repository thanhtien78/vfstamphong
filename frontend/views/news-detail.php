<style>
/* Remove black/dark background from related cars section and convert it into a luxury light-tech layout */
html body .news-related-cars {
  background: #ffffff !important;
  border-top: 1px solid #e2e8f0 !important;
  padding: 80px 0 !important;
}

html body .news-related-title {
  color: #0f172a !important;
}

html body .news-related-subtitle {
  color: #475569 !important;
}

/* Redesign recommended car cards for premium light aesthetic */
html body .news-related-card {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02) !important;
}

html body .news-related-card__content {
  background: #ffffff !important;
}

html body .news-related-card__title {
  color: #0f172a !important;
}

html body .news-related-card__segment {
  color: #1464f4 !important;
}

html body .news-price-lbl {
  color: #64748b !important;
}

html body .news-price-val {
  color: #1464f4 !important;
}

/* Button modernization */
html body .news-related-card__btn {
  background: #1464f4 !important;
  color: #ffffff !important;
  border-radius: 30px !important;
  padding: 8px 18px !important;
  font-weight: 700 !important;
  transition: all 0.3s ease !important;
  border: none !important;
}

html body .news-related-card__btn:hover {
  background: #0f52c9 !important;
  color: #ffffff !important;
}

/* Sidebar and widgets clean-up */
html body .sidebar-widget,
html body .exclusive-privilege-widget,
html body .consultant-widget {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
}

html body .privilege-widget-title,
html body .consultant-widget-title {
  color: #0f172a !important;
}

html body .privilege-widget-item {
  color: #334155 !important;
}

html body .privilege-widget-btn {
  background: #1464f4 !important;
  color: #ffffff !important;
  border-radius: 30px !important;
  border: none !important;
  box-shadow: 0 4px 14px rgba(20, 100, 244, 0.3) !important;
}

html body .privilege-widget-btn:hover {
  background: #0f52c9 !important;
  color: #ffffff !important;
}

/* Tags and search input */
html body .search-widget-input {
  background: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  color: #0f172a !important;
}

html body .tag-item {
  background: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  color: #475569 !important;
  transition: all 0.25s ease !important;
}

html body .tag-item:hover {
  background: #1464f4 !important;
  border-color: #1464f4 !important;
  color: #ffffff !important;
}

/* Sound DNA widget white design modernization */
html body .sound-dna-widget {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
}

html body .sound-dna-title {
  color: #0f172a !important;
}

html body .sound-dna-desc {
  color: #475569 !important;
}

html body .sound-dna-tab {
  background: #f8fafc !important;
  border: 1px solid #e2e8f0 !important;
  color: #475569 !important;
  font-weight: 600 !important;
}

html body .sound-dna-tab.active {
  background: #1464f4 !important;
  border-color: #1464f4 !important;
  color: #ffffff !important;
}

html body .sound-dna-visualizer {
  background: #f8fafc !important;
  border: 1px solid #e2e8f0 !important;
}

html body .sound-dna-status-text {
  color: #475569 !important;
}

html body .sound-dna-cta {
  background: #1464f4 !important;
  color: #ffffff !important;
  border-radius: 30px !important;
  border: none !important;
  box-shadow: 0 4px 14px rgba(20, 100, 244, 0.3) !important;
}

html body .sound-dna-cta:hover {
  background: #0f52c9 !important;
  color: #ffffff !important;
}

/* Staff call/zalo buttons styling overrides to prevent text blending */
html body .staff-btn {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-weight: 700 !important;
  font-size: 13px !important;
  padding: 8px 16px !important;
  border-radius: 30px !important;
  transition: all 0.25s ease !important;
  text-decoration: none !important;
}

html body .btn-call {
  background: #1464f4 !important;
  color: #ffffff !important;
  border: 1px solid #1464f4 !important;
}

html body .btn-call svg {
  stroke: #ffffff !important;
  fill: none !important;
}

html body .btn-call:hover {
  background: #0f52c9 !important;
  border-color: #0f52c9 !important;
  color: #ffffff !important;
}

html body .btn-zalo {
  background: #ffffff !important;
  color: #1464f4 !important;
  border: 1px solid rgba(20, 100, 244, 0.3) !important;
}

html body .btn-zalo svg {
  stroke: #1464f4 !important;
  fill: none !important;
}

html body .btn-zalo:hover {
  background: rgba(20, 100, 244, 0.05) !important;
  border-color: #1464f4 !important;
  color: #1464f4 !important;
}
</style>

  <!-- DYNAMIC JSON-LD ARTICLE SCHEMA FOR ADVANCED SEO SEARCH RANKING -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>"
    },
    "headline": "<?php echo addslashes($post['title']); ?>",
    "description": "<?php echo addslashes($post['summary']); ?>",
    "image": "<?php echo htmlspecialchars(seo_url($post['image'])); ?>",  
    "datePublished": "<?php echo date('c', strtotime($post['created_at'])); ?>",
    "dateModified": "<?php echo date('c', strtotime($post['created_at'])); ?>",
    "author": {
      "@type": "Organization",
      "name": "VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh"
    },
    "publisher": {
      "@type": "Organization",
      "name": "VinFast Việt Nam",
      "logo": {
        "@type": "ImageObject",
        "url": "<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"; ?>/assets/favicon/favicon.ico"
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
        "name": "Tin tức",
        "item": "<?php echo htmlspecialchars($baseUrl); ?>/tin-tuc-su-kien"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "name": "<?php echo htmlspecialchars($post['title']); ?>",
        "item": "<?php echo htmlspecialchars($baseUrl); ?>/tin-tuc/<?php echo $post['slug']; ?>"
      }
    ]
  }
  </script>

  <!-- BANNER HEADER HERO -->
  <section class="article-header-banner">
    <img class="article-banner-bg" src="<?php echo htmlspecialchars(seo_url($post['image'])); ?>" alt="Banner Background" fetchpriority="high" width="1200" height="600">
    <div class="article-banner-overlay"></div>
    <div class="article-header-container">
      <span class="news-category-badge"><?php echo htmlspecialchars($post['category']); ?></span>
      <h1 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h1>
      
      <div class="article-meta-row">
        <div class="article-meta-item">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          <span>Ngày đăng: <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
        </div>
        <div class="article-meta-item">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
          <span><?php echo number_format($post['views']); ?> lượt đọc</span>
        </div>
        <div class="article-meta-item">
          <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
          <span>5 phút đọc</span>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTENT MAIN GRID -->
  <section class="article-content-section">
    <div class="container">
      <div class="article-layout-grid">
        
        <!-- LEFT: ARTICLE CONTENT -->
        <article class="article-body-wrapper">
          <a href="news.php" class="back-catalog-link">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12,19 5,12 12,5"></polyline></svg>
            <span>Quay lại trang tin tức</span>
          </a>

          <div class="article-lead-summary">
            <?php echo htmlspecialchars($post['summary']); ?>
          </div>

          <div class="article-rendered-content">
            <?php 
              $content = $post['content'];
              
              // 1. Replace geographic template placeholders dynamically to ensure real-world localized SEO
              $content = str_replace(
                  ['{PROVINCE_NAME}', '{DISTRICT_NAME}', '{WARD_NAME}'],
                  ['TP. Hồ Chí Minh', 'Quận 1', 'Bến Nghé'],
                  $content
              );

              // 2. Automatically wrap tables in a responsive container with a pulsing "VUỐT ĐỂ SO SÁNH" visual hint pill above them for mobile viewports
              $content = preg_replace('/<table(.*?)>(.*?)<\/table>/is', '
                <div class="swipe-hint-container">
                  <div class="swipe-hint-pill">
                    <svg class="swipe-icon-svg" viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline-block; vertical-align:middle; margin-right:4px;"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    <span>VUỐT ĐỂ SO SÁNH</span>
                  </div>
                </div>
                <div class="responsive-table-wrapper"><table$1>$2</table></div>
              ', $content);
              
              echo $content; 
            ?>
          </div>

          <!-- Luxury signature author panel / Premium 24/7 Digital Concierge & Hotlines Grid -->
          <?php 
            $cleanPhone = preg_replace('/[^0-9]/', '', $agencyPhone); 
          ?>
          <div class="article-bottom-concierge">
            <div class="concierge-header">
              <div class="author-avatar" style="width: 40px; height: 40px;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
              </div>
              <div>
                <h4 class="concierge-title">
                  <span>Kết Nối Trực Tuyến</span>
                  <span class="online-indicator" title="Live Support Active"></span>
                </h4>
                <p class="concierge-subtitle">Trực ban hỗ trợ 24/7</p>
              </div>
            </div>
            
            <div class="concierge-staff-grid">
              <!-- Staff Member 1: Nguyễn Thanh Hương -->
              <div class="staff-card">
                <div class="staff-info-row">
                  <div class="staff-avatar-wrapper">
                    <div class="staff-avatar">TH</div>
                    <span class="staff-status-dot"></span>
                  </div>
                  <div class="staff-details">
                    <h5 class="staff-name">Nguyễn Thanh Hương</h5>
                    <span class="staff-status-text">Đang trực ban hỗ trợ</span>
                  </div>
                </div>
                <div class="staff-actions">
                  <a href="tel:<?php echo $cleanPhone; ?>" class="staff-btn btn-call">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline-block; vertical-align:middle; margin-right:3px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <span>Gọi</span>
                  </a>
                  <a href="https://zalo.me/<?php echo $cleanPhone; ?>" target="_blank" rel="noopener" class="staff-btn btn-zalo">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline-block; vertical-align:middle; margin-right:3px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>Zalo</span>
                  </a>
                </div>
              </div>
              
              <!-- Staff Member 2: Trần Minh Hoàng -->
              <div class="staff-card">
                <div class="staff-info-row">
                  <div class="staff-avatar-wrapper">
                    <div class="staff-avatar">MH</div>
                    <span class="staff-status-dot"></span>
                  </div>
                  <div class="staff-details">
                    <h5 class="staff-name">Trần Minh Hoàng</h5>
                    <span class="staff-status-text">Đang trực ban hỗ trợ</span>
                  </div>
                </div>
                <div class="staff-actions">
                  <a href="tel:<?php echo $cleanPhone; ?>" class="staff-btn btn-call">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline-block; vertical-align:middle; margin-right:3px;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <span>Gọi</span>
                  </a>
                  <a href="https://zalo.me/<?php echo $cleanPhone; ?>" target="_blank" rel="noopener" class="staff-btn btn-zalo">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="display:inline-block; vertical-align:middle; margin-right:3px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>Zalo</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </article>

        <!-- RIGHT: SIDEBAR -->
        <aside>
          <div class="sidebar-sticky-panel">
            
            <!-- Widget 1: Premium Exclusive June Privileges -->
            <div class="exclusive-privilege-widget">
              <span class="privilege-widget-tag"><?php echo htmlspecialchars($settings['sidebar_privilege_tag'] ?? 'VinFast Exclusive'); ?></span>
              <h4 class="privilege-widget-title"><?php echo htmlspecialchars($settings['sidebar_privilege_title'] ?? 'Đặc Quyền Sở Hữu Chào Hè'); ?></h4>
              
              <ul class="privilege-widget-list">
                <li class="privilege-widget-item">
                  <span class="privilege-widget-icon">⚡</span>
                  <span><?php echo $settings['sidebar_privilege_item1'] ?? '<strong>Tặng bộ sạc VinFast Wallbox 11kW</strong> cao cấp lắp đặt tại nhà riêng (áp dụng dòng xe EV).'; ?></span>
                </li>
                <li class="privilege-widget-item">
                  <span class="privilege-widget-icon">🎁</span>
                  <span><?php echo $settings['sidebar_privilege_item2'] ?? '<strong>Hỗ trợ 100% Lệ phí trước bạ</strong> (khấu trừ trực tiếp lên tới 300 triệu đồng cho xe động cơ xăng).'; ?></span>
                </li>
                <li class="privilege-widget-item">
                  <span class="privilege-widget-icon">🛠️</span>
                  <span><?php echo $settings['sidebar_privilege_item3'] ?? '<strong>Gói bảo dưỡng 3 năm chính hãng</strong> miễn phí từ đội ngũ kỹ sư đạt chuẩn VinFast.'; ?></span>
                </li>
              </ul>
              
              <a href="#appointment-stage" class="privilege-widget-btn" onclick="document.querySelector('.news-related-cars').scrollIntoView({ behavior: 'smooth' }); return false;">
                <?php echo htmlspecialchars($settings['sidebar_privilege_btn'] ?? 'Đăng ký nhận ưu đãi'); ?>
              </a>
            </div>

            <!-- Widget 2: VinFast Sound DNA Simulator -->
            <div class="sound-dna-widget">
              <span class="sound-dna-tag">VinFast Sound DNA</span>
              <h4 class="sound-dna-title">Bản Sắc Âm Thanh VinFast</h4>
              <p class="sound-dna-desc">Trải nghiệm âm thanh động cơ V8 xăng cơ khí mạnh mẽ hoặc động cơ EV thuần điện tương lai ngay trên trình duyệt.</p>
              
              <!-- Tab selectors -->
              <div class="sound-dna-tabs">
                <button type="button" class="sound-dna-tab active" id="dna-tab-gasoline" onclick="switchEngine('gasoline')">
                  Động cơ xăng V8
                </button>
                <button type="button" class="sound-dna-tab" id="dna-tab-electric" onclick="switchEngine('electric')">
                  EV
                </button>
              </div>

              <!-- Visualizer & Control Container -->
              <div class="sound-dna-visualizer">
                <canvas id="sound-dna-canvas" width="280" height="80"></canvas>
                
                <button type="button" class="sound-dna-play-btn" id="sound-dna-play-btn" onclick="toggleEngineSound()" aria-label="Bật/Tắt âm thanh động cơ">
                  <svg id="sound-dna-play-icon" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="display: block; margin-left: 2px;">
                    <path id="sound-dna-play-path" d="M8 5v14l11-7z"></path>
                  </svg>
                </button>
              </div>

              <div class="sound-dna-status">
                <span id="sound-dna-status-text">Chạm để khởi động động cơ Xăng V8</span>
              </div>

              <button type="button" class="sound-dna-cta" onclick="triggerVipPopup()">
                Đăng ký trải nghiệm VIP
              </button>
            </div>

            <!-- Widget 3: Luxury Call-to-action consult -->
            <div class="consult-specialist-card">
              <h4 class="consult-title">Tư vấn xe EV</h4>
              <p class="consult-desc">Đội ngũ kỹ sư và chuyên viên tư vấn của VinFast luôn sẵn sàng giải thích cặn kẽ mọi thắc mắc của quý khách hàng về pin và công nghệ trạm sạc.</p>
              <a href="index.php#appointment-block" class="consult-btn">Đặt lịch hẹn tư vấn</a>
            </div>

          </div>
        </aside>

      </div>
    </div>
  </section>

  <!-- SECTION: RECOMMENDED VinFast MODELS FOR REFERENCE -->
  <?php
  // Smart editorial model selection
  $postTitle = mb_strtolower($post['title'] ?? '');
  $postContent = mb_strtolower($post['content'] ?? '');
  
  $isElectricTopic = (
      strpos($postTitle, 'EV') !== false || 
      strpos($postTitle, 'điện') !== false || 
      strpos($postTitle, 'pin') !== false || 
      strpos($postTitle, 'sạc') !== false ||
      strpos($postContent, 'EV') !== false ||
      strpos($postContent, 'điện') !== false
  );
  
  try {
      if ($isElectricTopic) {
          // Recommend electric cars first (excluding dummy VF 2 and service cars)
          $stmtRec = $db->query("
              SELECT id, model_name, segment, engine, price, image, slug, power, acceleration, description 
              FROM cars 
              WHERE model_name NOT LIKE '%VF 2%' AND segment NOT LIKE '%Xe dịch vụ%'
              ORDER BY (CASE WHEN engine LIKE '%điện%' OR engine LIKE '%electric%' OR model_name LIKE '%EV%' THEN 1 ELSE 2 END) ASC, id ASC 
              LIMIT 3
          ");
      } else {
          // Recommend a premium balanced mix of active VinFast models (excluding dummy VF 2 and service cars)
          $stmtRec = $db->query("
              SELECT id, model_name, segment, engine, price, image, slug, power, acceleration, description 
              FROM cars 
              WHERE model_name NOT LIKE '%VF 2%' AND segment NOT LIKE '%Xe dịch vụ%'
              ORDER BY id ASC 
              LIMIT 3
          ");
      }
      $recommendedCars = $stmtRec->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
      $recommendedCars = [];
  }

  if (!empty($recommendedCars)):
  ?>
  <section class="news-related-cars" style="background: var(--color-bg-base) !important; border-top: 1px solid var(--color-border); padding: 80px 0;">
    <div class="container">
      <div class="section-header" style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">Bộ Sưu Tập</span>
        <h2 class="section-title" style="color: var(--color-text-dark) !important;">Dòng Xe VinFast Nổi Bật</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Khám phá các dòng xe điện thông minh đột phá mới nhất từ VinFast Việt Nam.</p>
      </div>
      
      <div class="catalog-grid" id="catalog-grid-container">
        <?php foreach ($recommendedCars as $rc): 
          $segmentLower = mb_strtolower($rc['segment'] ?? '');
          $nameLower = mb_strtolower($rc['model_name'] ?? '');
          
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
              <img class="car-card__img" src="<?php echo htmlspecialchars(get_thumb_url($rc['image'], 480)); ?>" alt="<?php echo htmlspecialchars($rc['model_name']); ?>" loading="lazy" width="400" height="250" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
              <div class="car-card__img-fallback" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, hsla(216, 20%, 85%, 0.9), #ffffff); align-items: center; justify-content: center; text-align: center; padding: 24px; border: 1px solid rgba(16, 185, 129, 0.15); z-index: 1;">
                <span style="font-family: 'Montserrat', sans-serif !important; font-weight: 800 !important; font-size: 16px; letter-spacing: 2px; text-transform: uppercase; color: var(--color-ev-green); text-shadow: 0 0 10px rgba(16, 185, 129, 0.2); background: linear-gradient(135deg, #000 30%, var(--color-ev-green) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo htmlspecialchars($rc['model_name']); ?></span>
              </div>
            </div>
            
            <div class="car-card__info">
              <span class="car-card__segment"><?php echo htmlspecialchars($rc['segment']); ?></span>
              <h3 class="car-card__name"><?php echo htmlspecialchars($rc['model_name']); ?></h3>
              <p class="car-card__desc"><?php echo htmlspecialchars($rc['description'] ?? 'Mẫu xe điện thông minh sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?></p>
              
              <div class="car-card__specs">
                <div class="car-card__spec-item">
                  <span class="car-card__spec-lbl">Công suất</span>
                  <span class="car-card__spec-val"><?php echo htmlspecialchars($rc['power'] ?: 'N/A'); ?></span>
                </div>
                <div class="car-card__spec-item">
                  <span class="car-card__spec-lbl">Gia tốc (0-100)</span>
                  <span class="car-card__spec-val"><?php echo htmlspecialchars($rc['acceleration'] ?: 'N/A'); ?></span>
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

  <!-- Floating Back to Top Button for streamlined reading navigation -->
  <button type="button" class="back-to-top-btn" id="backToTopBtn" title="Về đầu trang">
    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="3" style="display:block;"><polyline points="18 15 12 9 6 15"></polyline></svg>
  </button>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const backBtn = document.getElementById("backToTopBtn");
      if (backBtn) {
        window.addEventListener("scroll", () => {
          if (window.scrollY > 300) {
            backBtn.classList.add("show");
          } else {
            backBtn.classList.remove("show");
          }
        });
        backBtn.addEventListener("click", () => {
          window.scrollTo({ top: 0, behavior: "smooth" });
        });
      }
    });
  </script>

  <!-- Web VinFasto Synthesis & Visualizer engine for VinFast Sound DNA -->
  <script>
    let VinFastoCtx = null;
    let synthInterval = null;
    let isPlayingSound = false;
    let canvasAnimation = null;
    let currentEngineType = 'gasoline'; // default

    function switchEngine(type) {
      if (currentEngineType === type) return;
      
      // Stop playing if it is currently running
      if (isPlayingSound) {
        stopEngineSound();
      }
      
      currentEngineType = type;
      
      // Update Tab Active Style
      const tabGasoline = document.getElementById('dna-tab-gasoline');
      const tabElectric = document.getElementById('dna-tab-electric');
      const statusText = document.getElementById('sound-dna-status-text');
      const btn = document.getElementById('sound-dna-play-btn');
      
      if (type === 'gasoline') {
        if (tabGasoline) tabGasoline.classList.add('active');
        if (tabElectric) tabElectric.classList.remove('active');
        if (statusText) statusText.innerText = 'Chạm để khởi động động cơ Xăng V8';
        if (btn) {
          btn.style.borderColor = 'var(--color-primary)';
          btn.style.color = 'var(--color-primary)';
        }
      } else {
        if (tabElectric) tabElectric.classList.add('active');
        if (tabGasoline) tabGasoline.classList.remove('active');
        if (statusText) statusText.innerText = 'Chạm để khởi động động cơ EV';
        if (btn) {
          btn.style.borderColor = '#00d2ff';
          btn.style.color = '#00d2ff';
        }
      }
    }

    function toggleEngineSound() {
      if (isPlayingSound) {
        stopEngineSound();
      } else {
        startEngineSound();
      }
    }

    function startEngineSound() {
      // Initialize VinFasto Context
      const VinFastoContext = window.VinFastoContext || window.webkitVinFastoContext;
      if (!VinFastoContext) {
        alert("Trình duyệt không hỗ trợ Web VinFasto API.");
        return;
      }
      
      VinFastoCtx = new VinFastoContext();
      isPlayingSound = true;
      
      // Update UI
      const btn = document.getElementById('sound-dna-play-btn');
      const text = document.getElementById('sound-dna-status-text');
      const path = document.getElementById('sound-dna-play-path');
      
      const isElectric = (currentEngineType === 'electric');
      
      if (btn && text && path) {
        btn.style.background = isElectric ? '#00d2ff' : 'var(--color-primary)';
        btn.style.color = '#ffffff';
        btn.style.borderColor = isElectric ? '#00d2ff' : 'var(--color-primary)';
        text.innerText = isElectric ? 'Đang giả lập động cơ EV thuần điện...' : 'Đang giả lập động cơ V8 xăng...';
        path.setAttribute('d', 'M6 19h4V5H6v14zm8-14v14h4V5h-4z'); // Pause icon path
      }

      // VinFasto Nodes
      const osc1 = VinFastoCtx.createOscillator();
      const osc2 = VinFastoCtx.createOscillator();
      const gainNode = VinFastoCtx.createGain();
      const filterNode = VinFastoCtx.createBiquadFilter();

      osc1.connect(filterNode);
      osc2.connect(filterNode);
      filterNode.connect(gainNode);
      gainNode.connect(VinFastoCtx.destination);

      // Synthesizer Settings
      if (isElectric) {
        // EV electric futuristic growl
        osc1.type = 'sawtooth';
        osc1.frequency.setValueAtTime(65, VinFastoCtx.currentTime); // C2 chord
        osc1.frequency.exponentialRampToValueAtTime(140, VinFastoCtx.currentTime + 3.0);
        
        osc2.type = 'sine';
        osc2.frequency.setValueAtTime(130, VinFastoCtx.currentTime);
        osc2.frequency.exponentialRampToValueAtTime(280, VinFastoCtx.currentTime + 3.0);
        
        filterNode.type = 'lowpass';
        filterNode.Q.setValueAtTime(4, VinFastoCtx.currentTime);
        filterNode.frequency.setValueAtTime(300, VinFastoCtx.currentTime);
        filterNode.frequency.exponentialRampToValueAtTime(800, VinFastoCtx.currentTime + 3.0);
        
        gainNode.gain.setValueAtTime(0.01, VinFastoCtx.currentTime);
        gainNode.gain.linearRampToValueAtTime(0.2, VinFastoCtx.currentTime + 0.5);
      } else {
        // Động cơ xăng V8 gasoline mechanical roaring growl
        osc1.type = 'sawtooth';
        osc1.frequency.setValueAtTime(45, VinFastoCtx.currentTime); // Deep V8 bass
        osc1.frequency.linearRampToValueAtTime(180, VinFastoCtx.currentTime + 1.2);
        osc1.frequency.linearRampToValueAtTime(95, VinFastoCtx.currentTime + 2.5);

        osc2.type = 'triangle';
        osc2.frequency.setValueAtTime(90, VinFastoCtx.currentTime);
        osc2.frequency.linearRampToValueAtTime(360, VinFastoCtx.currentTime + 1.2);
        osc2.frequency.linearRampToValueAtTime(190, VinFastoCtx.currentTime + 2.5);

        filterNode.type = 'lowpass';
        filterNode.Q.setValueAtTime(5, VinFastoCtx.currentTime);
        filterNode.frequency.setValueAtTime(180, VinFastoCtx.currentTime);
        filterNode.frequency.linearRampToValueAtTime(600, VinFastoCtx.currentTime + 1.2);
        filterNode.frequency.linearRampToValueAtTime(250, VinFastoCtx.currentTime + 2.5);

        gainNode.gain.setValueAtTime(0.01, VinFastoCtx.currentTime);
        gainNode.gain.linearRampToValueAtTime(0.28, VinFastoCtx.currentTime + 0.3);
      }

      osc1.start();
      osc2.start();

      // Fade out and stop at end of loop or after 4.2 seconds
      gainNode.gain.setValueAtTime(0.25, VinFastoCtx.currentTime + 3.5);
      gainNode.gain.exponentialRampToValueAtTime(0.0001, VinFastoCtx.currentTime + 4.2);
      
      osc1.stop(VinFastoCtx.currentTime + 4.2);
      osc2.stop(VinFastoCtx.currentTime + 4.2);

      // Stop loop in JS
      synthInterval = setTimeout(() => {
        stopEngineSound();
      }, 4200);

      // Start Canvas Equalizer Visualizer
      drawSoundWave(isElectric);
    }

    function stopEngineSound() {
      isPlayingSound = false;
      if (synthInterval) clearTimeout(synthInterval);
      if (VinFastoCtx) {
        VinFastoCtx.close();
        VinFastoCtx = null;
      }
      if (canvasAnimation) cancelAnimationFrame(canvasAnimation);

      // Reset UI
      const btn = document.getElementById('sound-dna-play-btn');
      const text = document.getElementById('sound-dna-status-text');
      const path = document.getElementById('sound-dna-play-path');
      
      const isElectric = (currentEngineType === 'electric');
      
      if (btn && text && path) {
        btn.style.background = 'rgba(255, 255, 255, 0.05)';
        btn.style.color = isElectric ? '#00d2ff' : 'var(--color-primary)';
        btn.style.borderColor = isElectric ? '#00d2ff' : 'var(--color-primary)';
        text.innerText = isElectric ? 'Chạm để khởi động động cơ EV' : 'Chạm để khởi động động cơ Xăng V8';
        path.setAttribute('d', 'M8 5v14l11-7z'); // Play icon path
      }

      // Reset Canvas
      const canvas = document.getElementById('sound-dna-canvas');
      if (canvas) {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
      }
    }

    function drawSoundWave(isElectric) {
      const canvas = document.getElementById('sound-dna-canvas');
      if (!canvas) return;
      const ctx = canvas.getContext('2d');
      
      let waveOffset = 0;
      
      function render() {
        if (!isPlayingSound) return;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        ctx.beginPath();
        ctx.lineWidth = 1.8;
        
        // Pick visual color: Cyan for EV electric, Gold for gasoline engine
        ctx.strokeStyle = isElectric ? '#00d2ff' : '#1960d7';
        ctx.shadowBlur = 10;
        ctx.shadowColor = isElectric ? '#00d2ff' : '#1960d7';
        
        const width = canvas.width;
        const height = canvas.height;
        const sliceWidth = width / 50;
        
        ctx.moveTo(0, height / 2);
        
        for (let i = 0; i <= 50; i++) {
          const x = i * sliceWidth;
          let amplitude = 18;
          if (i < 5 || i > 45) amplitude = 2; // fade edges
          
          const freq = isElectric ? 0.28 : 0.45;
          const y = height / 2 + Math.sin(i * freq + waveOffset) * (Math.random() * 0.4 + 0.6) * amplitude;
          
          ctx.lineTo(x, y);
        }
        
        ctx.stroke();
        
        waveOffset += isElectric ? 0.16 : 0.32;
        
        canvasAnimation = requestAnimationFrame(render);
      }
      
      render();
    }

    function triggerVipPopup() {
      // Re-use the existing VIP Popup modal trigger from footer.php
      const popup = document.getElementById('vipPromoPopup');
      if (popup) {
        popup.classList.add('vip-popup-show');
      } else {
        // Fallback smooth scroll to recommendation section if modal not found
        document.querySelector('.news-related-cars').scrollIntoView({ behavior: 'smooth' });
      }
    }
  </script>




