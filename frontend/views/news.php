<style>
/* Remove all grey backgrounds from side widgets, inputs and buttons */
html body .sidebar-widget {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
}

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
  background: #10b981 !important;
  border-color: #10b981 !important;
  color: #ffffff !important;
}

/* Remove dark/black background from VIP Invitation CTA and turn it into a premium light gold-tech theme */
html body .vip-invite-card {
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.02) 0%, rgba(16, 185, 129, 0.08) 100%) !important;
  border: 1.5px solid rgba(16, 185, 129, 0.2) !important;
  box-shadow: 0 10px 30px rgba(16, 185, 129, 0.06) !important;
}

html body .vip-invite-title {
  color: #0f172a !important;
}

html body .vip-invite-desc {
  color: #475569 !important;
}

html body .vip-invite-logo {
  color: #10b981 !important;
}

html body .vip-invite-btn {
  background: #10b981 !important;
  color: #ffffff !important;
  border: none !important;
  box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3) !important;
}

html body .vip-invite-btn:hover {
  background: #0f52c9 !important;
  box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
  color: #ffffff !important;
}

/* Category pills design optimization */
html body .news-category-pill {
  background: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  color: #475569 !important;
}

html body .news-category-pill--active {
  background: #10b981 !important;
  border-color: #10b981 !important;
  color: #ffffff !important;
}

html body .news-category-pill:hover:not(.news-category-pill--active) {
  background: #f8fafc !important;
  border-color: #10b981 !important;
  color: #10b981 !important;
}

/* News row list styling */
html body .news-row-card {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02) !important;
}
</style>
<section class="news-portal-section">
    <div class="container">
      
      <!-- PAGE HEADER -->
      <div class="news-page-title-wrap">
        <span class="section-tag">Góc nhìn chuyên gia</span>
        <h1>Tin Tức &amp; Sự Kiện VinFast</h1>
      </div>

      <!-- EDITORIAL FEATURED BLOCK (ONLY SHOW ON PAGE 1 FOR EXCLUSIVE MAGAZINE AESTHETICS) -->
      <?php if ($page === 1 && count($featuredPosts) > 0): ?>
        <div class="news-hero-grid">
          
          <!-- Large Primary Spotlight Post -->
          <?php if (isset($featuredPosts[0])): $p1 = $featuredPosts[0]; ?>
            <a href="<?php echo !empty($p1['slug']) ? 'tin-tuc/' . htmlspecialchars($p1['slug']) : 'news-detail.php?id=' . $p1['id']; ?>" class="featured-big-card">
              <img class="featured-big-img" src="<?php echo htmlspecialchars($p1['image']); ?>" alt="<?php echo htmlspecialchars($p1['title']); ?>" fetchpriority="high" width="800" height="500">
              <div class="featured-big-overlay"></div>
              <div class="featured-big-content">
                <div class="meta-tag-row">
                  <span class="news-category-badge"><?php echo htmlspecialchars($p1['category']); ?></span>
                  <span class="news-read-time">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
                    5 phút đọc
                  </span>
                </div>
                <h2 class="featured-big-title"><?php echo htmlspecialchars($p1['title']); ?></h2>
                <p class="featured-big-summary"><?php echo htmlspecialchars($p1['summary']); ?></p>
                <div class="news-row-action-link" style="color: var(--color-primary); font-size: 13px; font-weight:700;">
                  <span>Đọc bài viết chi tiết</span>
                  <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" width="13" height="13"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </div>
              </div>
            </a>
          <?php endif; ?>

          <!-- Side Stack Spotlight Posts -->
          <div class="featured-side-stack">
            
            <!-- Side Post 1 -->
            <?php if (isset($featuredPosts[1])): $p2 = $featuredPosts[1]; ?>
              <a href="<?php echo !empty($p2['slug']) ? 'tin-tuc/' . htmlspecialchars($p2['slug']) : 'news-detail.php?id=' . $p2['id']; ?>" class="featured-side-card">
                <img class="featured-side-img" src="<?php echo htmlspecialchars(get_thumb_url($p2['image'], 480)); ?>" alt="<?php echo htmlspecialchars($p2['title']); ?>" width="400" height="250">
                <div class="featured-side-overlay"></div>
                <div class="featured-side-content">
                  <div class="meta-tag-row">
                    <span class="news-category-badge" style="padding: 2px 8px; font-size: 9px;"><?php echo htmlspecialchars($p2['category']); ?></span>
                  </div>
                  <h3 class="featured-side-title"><?php echo htmlspecialchars($p2['title']); ?></h3>
                  <span class="news-read-time" style="font-size: 11px;">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
                    4 phút đọc
                  </span>
                </div>
              </a>
            <?php endif; ?>

            <!-- Side Post 2 -->
            <?php if (isset($featuredPosts[2])): $p3 = $featuredPosts[2]; ?>
              <a href="<?php echo !empty($p3['slug']) ? 'tin-tuc/' . htmlspecialchars($p3['slug']) : 'news-detail.php?id=' . $p3['id']; ?>" class="featured-side-card">
                <img class="featured-side-img" src="<?php echo htmlspecialchars(get_thumb_url($p3['image'], 480)); ?>" alt="<?php echo htmlspecialchars($p3['title']); ?>" width="400" height="250">
                <div class="featured-side-overlay"></div>
                <div class="featured-side-content">
                  <div class="meta-tag-row">
                    <span class="news-category-badge" style="padding: 2px 8px; font-size: 9px;"><?php echo htmlspecialchars($p3['category']); ?></span>
                  </div>
                  <h3 class="featured-side-title"><?php echo htmlspecialchars($p3['title']); ?></h3>
                  <span class="news-read-time" style="font-size: 11px;">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
                    4 phút đọc
                  </span>
                </div>
              </a>
            <?php endif; ?>

          </div>
        </div>
      <?php endif; ?>

      <!-- CATEGORY PILL NAVIGATION BAR -->
      <div class="news-category-nav-bar">
        <a href="news.php" class="news-category-pill <?php echo empty($categoryFilter) ? 'news-category-pill--active' : ''; ?>">Tất cả bài viết</a>
        <?php foreach ($categories as $cat): ?>
          <?php
            $activeClass = ($categoryFilter === $cat) ? 'news-category-pill--active' : '';
            $catUrl = 'news.php?category=' . urlencode($cat);
            if (!empty($searchQuery)) {
                $catUrl .= '&search=' . urlencode($searchQuery);
            }
          ?>
          <a href="<?php echo $catUrl; ?>" class="news-category-pill <?php echo $activeClass; ?>"><?php echo htmlspecialchars($cat); ?></a>
        <?php endforeach; ?>
      </div>

      <!-- MAIN SPLIT CONTENT GRID -->
      <div class="news-main-grid">
        
        <!-- LEFT: CATALOG LISTING -->
        <div>
          <?php if ($categoryFilter === 'Báo giá theo địa phương'): ?>
            <!-- RENDER LUXURY GEOGRAPHICAL SEO DIRECTORY GRID -->
            <div style="background: rgba(255, 255, 255, 0.01); border: 1px solid var(--color-border); border-radius: 12px; padding: 30px; margin-bottom: 30px;">
              <h2 style="font-size: 20px; font-weight: 600; color: var(--color-text-main); margin-bottom: 20px; border-left: 3px solid var(--color-primary); padding-left: 14px; text-transform: uppercase; font-family: 'Montserrat', sans-serif !important;">Hệ thống báo giá lăn bánh địa phương</h2>
              <p style="font-size: 13.5px; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 30px;">
                Quý khách vui lòng chọn khu vực địa phương của mình dưới đây để tra cứu chi tiết <strong>Bảng giá lăn bánh xe VinFast mới nhất</strong>, các chương trình hỗ trợ trước bạ đặc quyền và dịch vụ hỗ trợ giao xe điện EV tận nhà riêng chuyên nghiệp:
              </p>

              <div style="display: flex; flex-direction: column; gap: 30px;">
                <!-- Miền Bắc -->
                <div>
                  <h4 style="font-size: 13px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif !important;">
                    <span style="width: 6px; height: 6px; background: var(--color-primary); border-radius: 50%; display: inline-block;"></span>
                    KHU VỰC MIỀN BẮC
                  </h4>
                  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
                    <div>
                      <a href="gia-xe-VinFast-tai-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Hà Nội</a>
                      <a href="dai-ly-VinFast-tai-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý TP. Hà Nội</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-quan-cau-giay-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Cầu Giấy</a>
                      <a href="dai-ly-VinFast-tai-quan-cau-giay-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Q. Cầu Giấy</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-quan-tay-ho-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Tây Hồ</a>
                      <a href="dai-ly-VinFast-tai-quan-tay-ho-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Q. Tây Hồ</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-hai-phong.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Hải Phòng</a>
                      <a href="dai-ly-VinFast-tai-hai-phong.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý TP. Hải Phòng</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tinh-quang-ninh.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Quảng Ninh</a>
                      <a href="dai-ly-VinFast-tai-tinh-quang-ninh.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Tỉnh Q.Ninh</a>
                    </div>
                  </div>
                </div>

                <!-- Miền Trung -->
                <div>
                  <h4 style="font-size: 13px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif !important;">
                    <span style="width: 6px; height: 6px; background: var(--color-primary); border-radius: 50%; display: inline-block;"></span>
                    KHU VỰC MIỀN TRUNG
                  </h4>
                  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
                    <div>
                      <a href="gia-xe-VinFast-tai-quan-hai-chau-da-nang.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Hải Châu</a>
                      <a href="dai-ly-VinFast-tai-quan-hai-chau-da-nang.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Q. Hải Châu</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tp-vinh-nghe-an.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá TP. Vinh</a>
                      <a href="dai-ly-VinFast-tai-tp-vinh-nghe-an.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý TP. Vinh</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tinh-khanh-hoa.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Khánh Hòa</a>
                      <a href="dai-ly-VinFast-tai-tinh-khanh-hoa.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Tỉnh K.Hòa</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tinh-thua-thien-hue.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Huế</a>
                      <a href="dai-ly-VinFast-tai-tinh-thua-thien-hue.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Tỉnh T.T.Huế</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tinh-quang-tri.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Quảng Trị</a>
                      <a href="dai-ly-VinFast-tai-tinh-quang-tri.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Tỉnh Q.Trị</a>
                    </div>
                  </div>
                </div>

                <!-- Miền Nam -->
                <div>
                  <h4 style="font-size: 13px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif !important;">
                    <span style="width: 6px; height: 6px; background: var(--color-primary); border-radius: 50%; display: inline-block;"></span>
                    KHU VỰC MIỀN NAM
                  </h4>
                  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
                    <div>
                      <a href="gia-xe-VinFast-tai-quan-1-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Quận 1</a>
                      <a href="dai-ly-VinFast-tai-quan-1-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Quận 1, HCM</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-quan-7-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Quận 7</a>
                      <a href="dai-ly-VinFast-tai-quan-7-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Quận 7, HCM</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tp-bien-hoa-dong-nai.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Biên Hòa</a>
                      <a href="dai-ly-VinFast-tai-tp-bien-hoa-dong-nai.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý TP. Biên Hòa</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tinh-binh-duong.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Bình Dương</a>
                      <a href="dai-ly-VinFast-tai-tinh-binh-duong.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Tỉnh B.Dương</a>
                    </div>
                    <div>
                      <a href="gia-xe-VinFast-tai-tp-can-tho.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; margin-bottom: 5px;">📍 Bảng giá Cần Thơ</a>
                      <a href="dai-ly-VinFast-tai-tp-can-tho.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity:0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý TP. Cần Thơ</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php else: ?>
            <?php if (count($posts) > 0): ?>
              <div class="news-catalog-list">
                <?php foreach ($posts as $post): ?>
                  <article class="news-row-card">
                    <div class="news-row-img-wrap">
                      <img class="news-row-img" src="<?php echo htmlspecialchars(get_thumb_url($post['image'], 400)); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" loading="lazy" width="300" height="200">
                    </div>
                    <div class="news-row-info">
                      <div class="meta-tag-row" style="margin-bottom: 8px;">
                        <span class="news-category-badge" style="padding: 2px 8px; font-size: 9px;"><?php echo htmlspecialchars($post['category']); ?></span>
                        <span class="news-read-time" style="font-size: 11px;">
                          <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
                          <?php echo (strlen($post['summary'] ?? '') > 150) ? '5' : '4'; ?> phút đọc
                        </span>
                      </div>
                      <a href="<?php echo !empty($post['slug']) ? 'tin-tuc/' . htmlspecialchars($post['slug']) : 'news-detail.php?id=' . $post['id']; ?>" class="news-row-title">
                        <?php echo htmlspecialchars($post['title']); ?>
                      </a>
                      <p class="news-row-desc"><?php echo htmlspecialchars($post['summary']); ?></p>
                      <a href="<?php echo !empty($post['slug']) ? 'tin-tuc/' . htmlspecialchars($post['slug']) : 'news-detail.php?id=' . $post['id']; ?>" class="news-row-action-link">
                        <span>Đọc bài viết</span>
                        <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" width="12" height="12"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                      </a>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>

              <!-- SEO PAGINATION MODULE -->
              <?php if ($totalPages > 1): ?>
                <nav class="seo-pagination-wrap" aria-label="News Page Navigation">
                  
                  <!-- Prev Button -->
                  <?php
                    $prevUrl = 'news.php?page=' . ($page - 1);
                    if (!empty($categoryFilter)) $prevUrl .= '&category=' . urlencode($categoryFilter);
                    if (!empty($searchQuery)) $prevUrl .= '&search=' . urlencode($searchQuery);
                    $prevDisabled = ($page === 1) ? 'pagination-btn--disabled' : '';
                  ?>
                  <a href="<?php echo $prevUrl; ?>" class="pagination-btn <?php echo $prevDisabled; ?>" aria-label="Trang trước">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15,18 9,12 15,6"></polyline></svg>
                  </a>

                  <!-- Crawlable Page Numbers -->
                  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php
                      $isActive = ($i === $page) ? 'pagination-btn--active' : '';
                      $pageUrl = 'news.php?page=' . $i;
                      if (!empty($categoryFilter)) $pageUrl .= '&category=' . urlencode($categoryFilter);
                      if (!empty($searchQuery)) $pageUrl .= '&search=' . urlencode($searchQuery);
                    ?>
                    <a href="<?php echo $pageUrl; ?>" class="pagination-btn <?php echo $isActive; ?>"><?php echo $i; ?></a>
                  <?php endfor; ?>

                  <!-- Next Button -->
                  <?php
                    $nextUrl = 'news.php?page=' . ($page + 1);
                    if (!empty($categoryFilter)) $nextUrl .= '&category=' . urlencode($categoryFilter);
                    if (!empty($searchQuery)) $nextUrl .= '&search=' . urlencode($searchQuery);
                    $nextDisabled = ($page === $totalPages) ? 'pagination-btn--disabled' : '';
                  ?>
                  <a href="<?php echo $nextUrl; ?>" class="pagination-btn <?php echo $nextDisabled; ?>" aria-label="Trang sau">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9,18 15,12 9,6"></polyline></svg>
                  </a>

                </nav>
              <?php endif; ?>

            <?php else: ?>
              <!-- Fallback No-Posts display -->
              <div class="no-posts-card">
                <h3 class="no-posts-title">Không tìm thấy bài viết phù hợp</h3>
                <p class="no-posts-desc">Rất tiếc, các cố vấn kỹ thuật của đại lý chưa có bài viết trùng khớp với tìm kiếm của bạn. Quý khách vui lòng tra cứu từ khóa khác.</p>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>

        <!-- RIGHT: SIDEBAR -->
        <aside class="news-sidebar">
          
          <!-- Widget 1: Premium Smart Search -->
          <div class="sidebar-widget">
            <h4 class="widget-title">Tìm kiếm cẩm nang</h4>
            <form action="news.php" method="GET" class="search-widget-form">
              <?php if (!empty($categoryFilter)): ?>
                <input type="hidden" name="category" value="<?php echo htmlspecialchars($categoryFilter); ?>">
              <?php endif; ?>
              <input class="search-widget-input" type="text" name="search" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo htmlspecialchars($searchQuery); ?>">
              <button class="search-widget-btn" type="submit" aria-label="Tìm kiếm">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              </button>
            </form>
          </div>

          <!-- Widget 2: Popular Reading (Gold Rank Numerals) -->
          <?php if (count($popularPosts) > 0): ?>
            <div class="sidebar-widget">
              <h4 class="widget-title">Đọc nhiều nhất</h4>
              <div class="popular-list">
                <?php foreach ($popularPosts as $index => $pop): ?>
                  <div class="popular-row">
                    <span class="popular-num">0<?php echo $index + 1; ?></span>
                    <div>
                      <a href="<?php echo !empty($pop['slug']) ? 'tin-tuc/' . htmlspecialchars($pop['slug']) : 'news-detail.php?id=' . $pop['id']; ?>" class="popular-title">
                        <?php echo htmlspecialchars($pop['title']); ?>
                      </a>
                      <div class="popular-meta">
                        <span style="color: var(--color-primary); font-weight:600;"><?php echo htmlspecialchars($pop['category']); ?></span>
                        <span style="opacity: 0.5; padding: 0 4px;">|</span>
                        <span><?php echo number_format($pop['views']); ?> lượt đọc</span>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Widget 3: Tag Cloud -->
          <div class="sidebar-widget">
            <h4 class="widget-title">Xu hướng tìm kiếm</h4>
            <div class="tag-cloud">
              <a href="news.php?search=EV" class="tag-item">#EV</a>
              <a href="news.php?search=Sạc+nhanh" class="tag-item">#Sạc nhanh</a>
              <a href="news.php?search=VF+3" class="tag-item">#VF 3</a>
              <a href="news.php?search=AWD" class="tag-item">#AWD</a>
              <a href="news.php?search=Bảo+hành" class="tag-item">#Bảo hành</a>
              <a href="news.php?search=Thu+cũ+đổi+mới" class="tag-item">#Thu cũ đổi mới</a>
              <a href="news.php?search=VF+9" class="tag-item">#VinFast VF 9</a>
            </div>
          </div>

          <!-- Widget 3.5: Local pSEO Directory for Crawling and Navigation -->
          <div class="sidebar-widget">
            <h4 class="widget-title">Báo giá theo địa phương</h4>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <a href="gia-xe-VinFast-tai-quan-1-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none;">📍 Bảng giá Quận 1, TP. HCM</a>
              <a href="dai-ly-VinFast-tai-quan-1-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity: 0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Quận 1, TP. HCM</a>
              <a href="gia-xe-VinFast-tai-quan-7-tp-hcm.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none;">📍 Bảng giá Quận 7, TP. HCM</a>
              <a href="gia-xe-VinFast-tai-quan-cau-giay-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none;">📍 Bảng giá Cầu Giấy, HN</a>
              <a href="dai-ly-VinFast-tai-quan-cau-giay-ha-noi.html" class="tag-item" style="display: block; text-align: left; padding: 10px 14px; text-decoration:none; opacity: 0.85; border-color: rgba(25, 96, 215,0.15);">🏢 Đại lý Q. Cầu Giấy, HN</a>
            </div>
          </div>

          <!-- Widget 4: Luxury VIP Invitation CTA -->
          <div class="vip-invite-card">
            <!-- Styled V logo represent VinFast -->
            <svg class="vip-invite-logo" viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-bottom: 12px;">
              <path d="M4 4l8 16 8-16M7 4l5 10 5-10" />
            </svg>
            <h4 class="vip-invite-title">Đặc quyền VinFast VIP</h4>
            <p class="vip-invite-desc">Đăng ký nhận thông tin độc quyền về các sự kiện trải nghiệm xe VIP, lễ ra mắt EV toàn cầu và các ưu đãi giới hạn sớm nhất.</p>
            <a href="index.php#appointment-block" class="vip-invite-btn">Đăng ký trải nghiệm</a>
          </div>

        </aside>

      </div>

    </div>
  </section>





