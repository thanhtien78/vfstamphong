<style>
/* Global Clean Light-Tech Override for About Page */
html body {
  background-color: #ffffff !important;
  color: #334155 !important;
}

/* Alternate Rhythm: White vs Soft Tech-Grey backgrounds */
html body .about-intro,
html body .about-tech-showcase,
html body .about-pillars,
html body .about-commitments,
html body .about-ctas {
  background-color: #ffffff !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .about-gallery,
html body .about-stats,
html body .about-history,
html body .about-showcase {
  background-color: #f1f5f9 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

/* Compact spacings: Section padding and margins */
html body section:not(.about-hero) {
  padding: 30px 0 !important;
}

html body section .container > .section-header,
html body section .container > div[style*="margin-bottom"] {
  margin-bottom: 24px !important;
}

/* Remove text shadows globally */
html body h1,
html body h2,
html body h3,
html body h4,
html body h5,
html body h6,
html body span,
html body strong,
html body p,
html body blockquote,
html body a {
  text-shadow: none !important;
}

/* Hero Section Refinements - Premium Dark Cinematic Banner */
html body .about-hero {
  background-image: linear-gradient(rgba(15, 23, 42, 0.55), rgba(15, 23, 42, 0.55)), url('assets/uploads/vinfast_showroom_banner.jpg') !important;
  background-size: cover !important;
  background-position: center !important;
  padding: 120px 0 !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  text-align: center !important;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

html body .about-hero-tag {
  color: #34d399 !important;
  font-weight: 800 !important;
  font-size: 12px !important;
  letter-spacing: 2.5px !important;
  text-transform: uppercase !important;
}

html body .about-hero-title {
  color: #ffffff !important;
  font-weight: 900 !important;
  font-size: clamp(32px, 4.5vw, 54px) !important;
  line-height: 1.2 !important;
  margin-top: 16px !important;
  text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5) !important;
}

html body .about-hero-desc {
  color: #ffffff !important;
  font-size: 15px !important;
  max-width: 700px !important;
  margin: 16px auto 0 auto !important;
  line-height: 1.6 !important;
  text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6) !important;
}

/* Statistics Section Overrides (No Dark Background) */
html body .about-stats {
  background-color: #f1f5f9 !important;
  padding: 40px 0 !important;
}

html body .stat-card {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  padding: 24px !important;
  text-align: center !important;
  box-shadow: 0 10px 25px rgba(16, 185, 129, 0.02) !important;
}

html body .stat-number {
  color: #10b981 !important;
  font-size: 36px !important;
  font-weight: 900 !important;
  display: block !important;
  margin-bottom: 8px !important;
}

html body .stat-label {
  color: #0f172a !important;
  font-weight: 800 !important;
  font-size: 13.5px !important;
  text-transform: uppercase !important;
  display: block !important;
  margin-bottom: 6px !important;
}

html body .stat-desc {
  color: #64748b !important;
  font-size: 12px !important;
  line-height: 1.5 !important;
  display: block !important;
}

/* Tech Showcase Overrides */
html body .about-tech-showcase {
  background-color: #ffffff !important;
}

html body .tech-tab-btn {
  background: #f1f5f9 !important;
  color: #475569 !important;
  border: 1px solid #e2e8f0 !important;
}

html body .tech-tab-btn.active {
  background: #10b981 !important;
  color: #ffffff !important;
  border-color: #10b981 !important;
}

html body .tech-panel-info span[style*="color: var(--color-primary)"] {
  color: #10b981 !important;
}

html body .tech-panel-info h3[style*="color: var(--color-text-white)"] {
  color: #0f172a !important;
}

html body .tech-panel-info p[style*="color: var(--color-text-muted)"] {
  color: #475569 !important;
}

html body .tech-panel-info span[style*="color: var(--color-text-white)"] {
  color: #334155 !important;
}

/* Blockquote Section Overrides */
html body .about-blockquote-sec {
  background-image: linear-gradient(rgba(241, 245, 249, 0.92), rgba(241, 245, 249, 0.92)), url('https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80') !important;
  border-top: 1px solid #e2e8f0 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .about-blockquote-container {
  max-width: 800px !important;
  margin: 0 auto !important;
  text-align: center !important;
  padding: 40px 20px !important;
}

html body .blockquote-text {
  color: #0f172a !important;
  font-size: clamp(16px, 2.2vw, 22px) !important;
  font-weight: 700 !important;
  line-height: 1.6 !important;
  margin-bottom: 20px !important;
}

html body .blockquote-author {
  color: #10b981 !important;
  font-weight: 800 !important;
  font-size: 14px !important;
}

html body .blockquote-author-title {
  color: #64748b !important;
  font-size: 12px !important;
}

/* Vehicle Lineup Product Cards Overrides (No Dark Styles) */
html body .about-showcase {
  background-color: #f1f5f9 !important;
}

html body .product-card {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  box-shadow: 0 10px 30px rgba(0,0,0,0.02) !important;
}

html body .product-card__title {
  color: #0f172a !important;
}

html body .product-card__desc {
  color: #475569 !important;
}

html body .product-card__price-val {
  color: #10b981 !important;
}

html body .spec-label {
  color: #64748b !important;
}

html body .spec-val {
  color: #334155 !important;
}

/* Fix product card buttons (remove black background) */
html body .product-card__btn {
  background: #ffffff !important;
  color: #10b981 !important;
  border: 1px solid #10b981 !important;
  font-weight: 700 !important;
  transition: all 0.3s ease !important;
}

html body .product-card__btn:hover {
  background: #10b981 !important;
  color: #ffffff !important;
  border-color: #10b981 !important;
  box-shadow: 0 5px 15px rgba(16, 185, 129, 0.2) !important;
}

/* Unify CTA buttons style */
html body .btn-about-cta {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  padding: 12px 28px !important;
  border-radius: 30px !important;
  font-size: 13px !important;
  font-weight: 700 !important;
  text-transform: uppercase !important;
  letter-spacing: 1px !important;
  text-decoration: none !important;
  transition: all 0.3s ease !important;
  width: 100% !important;
  box-sizing: border-box !important;
}

html body .btn-about-cta.btn-about-zalo,
html body .btn-about-cta.btn-about-gold,
html body .btn-about-cta.btn-about-outline {
  background: #10b981 !important;
  color: #ffffff !important;
  border: 1px solid #10b981 !important;
  box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15) !important;
}

html body .btn-about-cta.btn-about-zalo:hover,
html body .btn-about-cta.btn-about-gold:hover,
html body .btn-about-cta.btn-about-outline:hover {
  background: #0f52d9 !important;
  border-color: #0f52d9 !important;
  box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3) !important;
  transform: translateY(-2px) !important;
}

/* Premium Blue Tech Gradient CTA Cards Background Option B */
html body .cta-box {
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.03) 0%, #ffffff 100%) !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  box-shadow: 0 10px 30px rgba(16, 185, 129, 0.02) !important;
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
  padding: 40px 30px !important;
}

html body .cta-box:hover {
  background: #ffffff !important;
  border-color: #10b981 !important;
  box-shadow: 0 15px 35px rgba(16, 185, 129, 0.08) !important;
  transform: translateY(-5px) !important;
}

html body .cta-box-title {
  color: #0f172a !important;
  font-size: 19px !important;
  font-weight: 800 !important;
  margin-bottom: 12px !important;
}

html body .cta-box-desc {
  color: #475569 !important;
  font-size: 14px !important;
  line-height: 1.6 !important;
  margin-bottom: 24px !important;
}

/* Styling for address split box inside intro section */
html body .address-split-box {
  background: #f1f5f9 !important;
  border-left: 4px solid #10b981 !important;
  border-radius: 8px !important;
  padding: 16px 20px !important;
  margin: 20px 0 !important;
  display: flex !important;
  flex-direction: column !important;
  gap: 12px !important;
  text-align: left !important;
}

html body .address-row {
  display: flex !important;
  align-items: center !important;
  gap: 12px !important;
  font-size: 14.5px !important;
  line-height: 1.5 !important;
}

html body .address-badge {
  font-size: 10px !important;
  font-weight: 800 !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
  padding: 4px 8px !important;
  border-radius: 4px !important;
  white-space: nowrap !important;
  display: inline-block !important;
}

html body .old-badge {
  background: #cbd5e1 !important;
  color: #475569 !important;
}

html body .new-badge {
  background: rgba(16, 185, 129, 0.1) !important;
  color: #10b981 !important;
}

html body .address-detail {
  color: #0f172a !important;
  font-weight: 600 !important;
}

html body .about-intro-text p {
  margin-bottom: 16px !important;
  line-height: 1.7 !important;
  margin-bottom: 16px !important;
}

/* Glassmorphism Dark Banner Overlay for Space Gallery */
html body .gallery-slide {
  position: relative !important;
  overflow: hidden !important;
}

html body .gallery-caption {
  background: rgba(15, 23, 42, 0.85) !important;
  backdrop-filter: blur(12px) !important;
  -webkit-backdrop-filter: blur(12px) !important;
  position: absolute !important;
  bottom: 0 !important;
  left: 0 !important;
  right: 0 !important;
  padding: 24px 30px !important;
  border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
  transform: none !important;
  width: 100% !important;
  box-sizing: border-box !important;
}

html body .gallery-caption-title {
  color: #ffffff !important;
  font-size: 20px !important;
  font-weight: 800 !important;
  margin-bottom: 8px !important;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3) !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
}

html body .gallery-caption-desc {
  color: #cbd5e1 !important;
  font-size: 14px !important;
  line-height: 1.6 !important;
  margin: 0 !important;
  text-shadow: 0 1px 2px rgba(0,0,0,0.2) !important;
}

/* Styling for Maps, E-E-A-T and FAQ sections */
html body .about-trust-map-sec {
  background-color: #ffffff !important;
  padding: 40px 0 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .trust-grid {
  display: grid !important;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)) !important;
  gap: 30px !important;
  margin-bottom: 40px !important;
}

html body .map-container-box {
  background: #f1f5f9 !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  overflow: hidden !important;
  box-shadow: 0 10px 30px rgba(0,0,0,0.02) !important;
}

html body .map-container-box iframe {
  width: 100% !important;
  height: 380px !important;
  display: block !important;
  border: 0 !important;
}

html body .cert-container-box {
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  padding: 30px !important;
  box-shadow: 0 10px 30px rgba(16, 185, 129, 0.02) !important;
  display: flex !important;
  flex-direction: column !important;
  justify-content: center !important;
  position: relative !important;
  overflow: hidden !important;
}

html body .cert-container-box::before {
  content: '' !important;
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  width: 4px !important;
  height: 100% !important;
  background: #10b981 !important;
}

html body .cert-badge-wrapper {
  display: flex !important;
  align-items: center !important;
  gap: 15px !important;
  margin-bottom: 20px !important;
}

html body .cert-icon {
  width: 50px !important;
  height: 50px !important;
  background: rgba(16, 185, 129, 0.1) !important;
  color: #10b981 !important;
  border-radius: 12px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 24px !important;
}

html body .cert-title {
  color: #0f172a !important;
  font-size: 20px !important;
  font-weight: 800 !important;
  margin: 0 !important;
}

html body .cert-subtitle {
  color: #64748b !important;
  font-size: 13px !important;
  margin-top: 4px !important;
  text-transform: uppercase !important;
  letter-spacing: 0.5px !important;
}

html body .cert-list {
  list-style: none !important;
  padding: 0 !important;
  margin: 20px 0 0 0 !important;
}

html body .cert-list li {
  position: relative !important;
  padding-left: 25px !important;
  margin-bottom: 12px !important;
  color: #475569 !important;
  font-size: 14px !important;
  line-height: 1.5 !important;
}

html body .cert-list li::before {
  content: '✓' !important;
  position: absolute !important;
  left: 0 !important;
  top: 0 !important;
  color: #10b981 !important;
  font-weight: 900 !important;
}

/* FAQ Accordion Styling */
html body .about-faq-container {
  max-width: 900px !important;
  margin: 0 auto !important;
}

html body .about-faq-item {
  background: #f1f5f9 !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 12px !important;
  margin-bottom: 15px !important;
  overflow: hidden !important;
  transition: all 0.3s ease !important;
}

html body .about-faq-header {
  padding: 20px 24px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  cursor: pointer !important;
  user-select: none !important;
}

html body .about-faq-question {
  color: #0f172a !important;
  font-size: 16px !important;
  font-weight: 700 !important;
  margin: 0 !important;
}

html body .about-faq-icon {
  font-size: 18px !important;
  color: #10b981 !important;
  transition: transform 0.3s ease !important;
}

html body .about-faq-content {
  max-height: 0 !important;
  overflow: hidden !important;
  transition: max-height 0.3s ease !important;
  background: #ffffff !important;
}

html body .about-faq-content-inner {
  padding: 20px 24px !important;
  color: #475569 !important;
  font-size: 14.5px !important;
  line-height: 1.6 !important;
  border-top: 1px solid #e2e8f0 !important;
}

html body .about-faq-item.active {
  border-color: #10b981 !important;
  box-shadow: 0 10px 25px rgba(16, 185, 129, 0.03) !important;
}

html body .about-faq-item.active .about-faq-icon {
  transform: rotate(45deg) !important;
}

html body .about-faq-item.active .about-faq-content {
  max-height: 500px !important;
}

/* Headings consistency */
html body .section-title {
  color: #0f172a !important;
}

html body .section-desc {
  color: #475569 !important;
}

/* Font Consistency & Typography Hierarchy (High Specificity Overrides) */
html body,
html body [class],
html body [id],
html body *,
html body p,
html body span,
html body a,
html body div,
html body select,
html body input,
html body button {
  font-family: 'Montserrat', sans-serif !important;
}

html body h1,
html body h2,
html body h3,
html body h4,
html body h5,
html body h6,
html body strong,
html body blockquote,
html body .stat-number,
html body .about-hero-title,
html body .blockquote-text,
html body h1 [class],
html body h2 [class],
html body h3 [class],
html body h4 [class],
html body h5 [class],
html body h6 [class] {
  font-family: 'Montserrat', sans-serif !important;
}
</style>
<main>
<div class="about-page">

  <!-- SECTION 1: HERO BANNER -->
  <section class="about-hero" aria-label="Giới thiệu VinFast">
    <div class="about-hero-content">
      <span class="about-hero-tag"><?php echo htmlspecialchars($settings['about_hero_tag'] ?? 'Mãnh liệt tinh thần Việt Nam'); ?></span>
      <h1 class="about-hero-title"><?php echo $settings['about_hero_title'] ?? 'Khai phóng tương lai<br>bằng công nghệ'; ?></h1>
      <p class="about-hero-desc"><?php echo htmlspecialchars($settings['about_hero_desc'] ?? 'Hơn cả một thương hiệu, VinFast là niềm tự hào của trí tuệ Việt Nam, tiên phong kiến tạo tương lai di động xanh toàn cầu kể từ năm 2017.'); ?></p>
    </div>
  </section>

  <!-- SECTION 2: INTRO -->
  <section class="about-intro">
    <div class="container">
      <div class="<?php echo !empty($settings['about_image_url']) ? 'about-intro-grid' : 'about-intro-grid-full'; ?>">
        <div class="about-intro-left">
          <span class="about-intro-tag"><?php echo htmlspecialchars($settings['about_intro_tag'] ?? 'Chúng tôi là ai?'); ?></span>
          <h2 class="about-intro-heading"><?php echo htmlspecialchars($settings['about_title'] ?? 'Giới thiệu VinFast Việt Nam'); ?></h2>
          <blockquote class="about-intro-quote">
            "<?php echo htmlspecialchars($settings['about_intro_headline'] ?? 'Tiên phong trong công nghệ & Trải nghiệm xứng tầm'); ?>"
          </blockquote>
          <div class="about-intro-text" style="margin-top: 25px;">
            <?php echo $settings['about_intro_text'] ?? ''; ?>
          </div>
        </div>
        
        <?php if (!empty($settings['about_image_url'])): ?>
          <div class="about-intro-right" style="position: relative; z-index: 1;">
            <div class="about-intro-image-container">
               <img src="<?php echo htmlspecialchars($settings['about_image_url']); ?>" alt="Showroom VinFast Việt Nam" loading="lazy" width="600" height="400">
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- SECTION 3: INTERACTIVE SHOWROOM CAROUSEL -->
  <section class="about-gallery">
    <div class="container">
      <div class="section-header">
        <span class="section-tag"><?php echo htmlspecialchars($settings['about_gallery_tag'] ?? 'Không gian trải nghiệm'); ?></span>
        <h2 class="section-title"><?php echo htmlspecialchars($settings['about_gallery_title'] ?? 'VinFast Terminal & Charging Lounge'); ?></h2>
        <p class="section-desc"><?php echo htmlspecialchars($settings['about_gallery_desc'] ?? 'Không gian dịch vụ cao cấp chuẩn mực quốc tế kết hợp cùng phòng chờ sạc nhanh thuần điện sang trọng hàng đầu Việt Nam.'); ?></p>
      </div>

      <div class="gallery-wrapper">
        <div class="gallery-track">
          <?php
            $slidesJson = $settings['about_gallery_slides'] ?? '';
            $slides = json_decode($slidesJson, true);
            if (!is_array($slides) || empty($slides)) {
                $slides = [
                    ["image" => "https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80", "title" => "VinFast Charging Lounge", "desc" => "Phòng chờ sạc nhanh chuẩn mực luxury, nơi khách hàng thư giãn trong khi xe EV sạc điện."],
                    ["image" => "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80", "title" => "Trải nghiệm dịch vụ 5 sao", "desc" => "Không gian sang trọng với quầy bar phục vụ trà, cafe hảo hạng cùng đội ngũ nhân viên nhiệt tình, tận tâm."],
                    ["image" => "https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80", "title" => "Tiên phong hạ tầng điện hóa", "desc" => "Trạm sạc nhanh DC công suất lớn lên tới 180kW được lắp đặt trực tiếp tại showroom, sạc đầy 80% chỉ trong 20-30 phút."],
                    ["image" => "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80", "title" => "Khu vực trưng bày và bàn giao xe VIP", "desc" => "Mỗi chiếc xe giao tay khách hàng đều được chuẩn bị tinh tế trong không gian handover kín đáo, chuyên nghiệp."],
                    ["image" => "https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=1200&q=80", "title" => "VinFast Terminal Tôn Đức Thắng", "desc" => "Thiết kế nhận diện tòa nhà sang trọng độc quyền từ VinFast Việt Nam, tọa lạc tại trung tâm Quận 1 sầm uất."]
                ];
            }
            foreach ($slides as $slide):
          ?>
            <div class="gallery-slide">
              <img src="<?php echo htmlspecialchars($slide['image']); ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>" loading="lazy" width="800" height="500">
              <div class="gallery-caption">
                <h3 class="gallery-caption-title"><?php echo htmlspecialchars($slide['title']); ?></h3>
                <p class="gallery-caption-desc"><?php echo htmlspecialchars($slide['desc']); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Navigation Buttons -->
        <button class="gallery-btn prev" aria-label="Hình ảnh trước">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </button>
        <button class="gallery-btn next" aria-label="Hình ảnh tiếp theo">
          <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </button>
      </div>

      <!-- Pagination Dots -->
      <div class="gallery-dots"></div>
    </div>
  </section>

  <!-- SECTION 3.5: CINEMATIC TECH SHOWCASE -->
  <section class="about-tech-showcase" style="padding: 55px 0; background: var(--color-surface-dark); border-top: 1px solid var(--color-border);">
    <div class="container">
      <div class="section-header" style="margin-bottom: 40px;">
        <span class="section-tag"><?php echo htmlspecialchars($settings['about_tech_tag'] ?? 'Công nghệ xanh tiên phong'); ?></span>
        <h2 class="section-title"><?php echo htmlspecialchars($settings['about_tech_title'] ?? 'Ba trụ cột công nghệ tiên phong'); ?></h2>
        <p class="section-desc"><?php echo htmlspecialchars($settings['about_tech_desc'] ?? 'Khám phá các di sản kỹ thuật cơ khí đỉnh cao tạo nên linh hồn và sự khác biệt vượt bậc của mỗi chiếc xe VinFast.'); ?></p>
      </div>

      <?php
        $techsJson = $settings['about_tech_list'] ?? '';
        $techs = json_decode($techsJson, true);
        if (!is_array($techs) || empty($techs)) {
            $techs = [
                [
                    "name" => "AWD®",
                    "tag" => "Dẫn động bốn bánh toàn thời gian",
                    "title" => "Làm chủ mọi cung đường",
                    "desc" => "Hệ dẫn động AWD® huyền thoại phân bổ lực kéo thông minh đến từng bánh xe độc lập trong mili-giây, mang lại độ bám đường tuyệt đối, thăng hoa cảm giác lái và bảo vệ an toàn tối đa trong mọi điều kiện thời tiết.",
                    "features" => "Phản hồi lực kéo mili-giây; Kiểm soát lực bám cua chủ động; Phân bổ mô-men xoắn thích ứng",
                    "image" => "https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80"
                ],
                [
                    "name" => "Matrix LED",
                    "tag" => "Chiếu sáng kỹ thuật số thông minh",
                    "title" => "Tầm nhìn tương lai hội tụ",
                    "desc" => "Hệ thống đèn Matrix LED tiên phong chiếu sáng xa hàng trăm mét với độ sắc nét tuyệt đối, đồng thời tự động tắt các đi-ốt chiếu thẳng vào xe đối diện để chống chói mắt chủ động, kết hợp cùng hiệu ứng chào mừng độc bản.",
                    "features" => "Chống chói chủ động phân vùng; Chiếu sáng thông minh góc cua; Hiệu ứng LED chào mừng độc quyền",
                    "image" => "https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1200&q=80"
                ],
                [
                    "name" => "EV",
                    "tag" => "Hiệu suất động cơ thuần điện",
                    "title" => "Khai phóng kỷ nguyên điện hóa",
                    "desc" => "Động cơ thuần điện EV mang lại mô-men xoắn tức thời cực đại, tăng tốc không tiếng động, sạc đầy 80% chỉ trong 22 phút tại trạm sạc DC 180kW, hướng tới mục tiêu phát thải carbon trung hòa.",
                    "features" => "Mô-men xoắn tức thời 0s; Vận hành êm ái tuyệt đối; Công nghệ sạc siêu nhanh DC",
                    "image" => "https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=1200&q=80"
                ]
            ];
        }
      ?>

      <!-- Interactive Tab Selector Headers -->
      <div class="tech-tab-headers" style="display: flex; justify-content: center; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;">
        <?php foreach ($techs as $idx => $tech): ?>
          <button class="tech-tab-btn <?php echo $idx === 0 ? 'active' : ''; ?>" data-tech-tab="<?php echo $idx; ?>" style="padding: 12px 35px; border-radius: 30px; font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.4s ease; background: <?php echo $idx === 0 ? 'var(--color-primary)' : 'transparent'; ?>; color: #ffffff; border: 1px solid <?php echo $idx === 0 ? 'var(--color-primary)' : 'rgba(255,255,255,0.15)'; ?>;">
            <?php echo htmlspecialchars($tech['name']); ?>
          </button>
        <?php endforeach; ?>
      </div>

      <!-- Tab Content Panels -->
      <div class="tech-tab-contents" style="position: relative; min-height: 380px;">
        <?php foreach ($techs as $idx => $tech): ?>
          <div class="tech-tab-panel <?php echo $idx === 0 ? 'active' : ''; ?>" id="tech-panel-<?php echo $idx; ?>" style="display: <?php echo $idx === 0 ? 'grid' : 'none'; ?>; grid-template-columns: 1.1fr 1fr; gap: 50px; align-items: center; transition: all 0.5s ease;">
            <!-- Left Info Column -->
            <div class="tech-panel-info" style="display: flex; flex-direction: column; gap: 16px;">
              <span style="color: var(--color-primary); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">
                <?php echo htmlspecialchars($tech['tag']); ?>
              </span>
              <h3 style="font-family: 'Montserrat', sans-serif; font-size: clamp(22px, 2.5vw, 28px); font-weight: 800; text-transform: uppercase; color: var(--color-text-white); margin: 0;">
                <?php echo htmlspecialchars($tech['title']); ?>
              </h3>
              <p style="font-size: 14px; color: var(--color-text-muted); line-height: 1.7; margin: 0 0 10px 0;">
                <?php echo htmlspecialchars($tech['desc']); ?>
              </p>
              
              <!-- Key Features List -->
              <div style="display: flex; flex-direction: column; gap: 10px;">
                <?php 
                  $features = explode(';', $tech['features']);
                  foreach ($features as $feat):
                    if (trim($feat) !== ''):
                ?>
                  <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 6px; height: 6px; background: var(--color-primary); border-radius: 50%;"></div>
                    <span style="font-size: 13.5px; color: var(--color-text-white); font-weight: 500;"><?php echo htmlspecialchars(trim($feat)); ?></span>
                  </div>
                <?php 
                    endif;
                  endforeach; 
                ?>
              </div>
            </div>
            
            <!-- Right Visual Column -->
            <div class="tech-panel-visual" style="position: relative;">
              <div class="tech-panel-image-container">
                <img src="<?php echo htmlspecialchars($tech['image']); ?>" alt="<?php echo htmlspecialchars($tech['name']); ?>" style="width: 100%; height: 100%; object-fit: cover; aspect-ratio: 16/10; transition: transform 0.8s ease; border-radius: 12px;" loading="lazy" width="600" height="375">
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- SECTION 4: KEY BRAND NUMBERS -->
  <section class="about-stats">
    <div class="container">
      <div class="stats-grid">
        <?php
          $statsJson = $settings['about_stats'] ?? '';
          $stats = json_decode($statsJson, true);
          if (!is_array($stats) || empty($stats)) {
              $stats = [
                  ["number" => "150+", "label" => "Showroom & Đại lý", "desc" => "Hệ thống Showroom 3S đạt chuẩn dịch vụ và trải nghiệm khách hàng trên toàn quốc."],
                  ["number" => "150.000+", "label" => "Cổng sạc toàn quốc", "desc" => "Hạ tầng trạm sạc EV thông minh trải rộng khắp 63 tỉnh thành tại Việt Nam."],
                  ["number" => "10 Năm", "label" => "Bảo hành chính hãng", "desc" => "Đặc quyền bảo hành lâu nhất thị trường cho tất cả các dòng xe điện."],
                  ["number" => "24/7", "label" => "Cứu hộ khẩn cấp", "desc" => "Dịch vụ cứu hộ Roadside Assistance và sửa chữa lưu động Mobile Service chuyên nghiệp."]
              ];
          }
          foreach ($stats as $st):
        ?>
          <div class="stat-card">
            <span class="stat-number"><?php echo htmlspecialchars($st['number']); ?></span>
            <span class="stat-label"><?php echo htmlspecialchars($st['label']); ?></span>
            <span class="stat-desc"><?php echo htmlspecialchars($st['desc']); ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- SECTION 5: SIGNATURE BLOCKQUOTE -->
  <section class="about-blockquote-sec" style="background-image: linear-gradient(rgba(10, 14, 21, 0.88), rgba(10, 14, 21, 0.88)), url('<?php echo htmlspecialchars($settings['about_quote_bg_image'] ?? 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=1920&q=80'); ?>');">
    <div class="about-blockquote-container">
      <h3 class="blockquote-text">
        "<?php echo htmlspecialchars($settings['about_quote_text'] ?? 'Công nghệ chiếu sáng dẫn đầu hay hệ thống dẫn động AWD huyền thoại chỉ thực sự hoàn hảo khi chúng chạm đến cảm xúc người lái và kiến tạo những điều phi thường.'); ?>"
      </h3>
      <div class="blockquote-author"><?php echo htmlspecialchars($settings['about_quote_author'] ?? 'VinFast Design Studio'); ?></div>
      <div class="blockquote-author-title"><?php echo htmlspecialchars($settings['about_quote_author_title'] ?? 'Đội ngũ Thiết kế Toàn cầu (Hợp tác Pininfarina & Torino Design)'); ?></div>
    </div>
  </section>

  <!-- SECTION 6: THE CORE PILLARS -->
  <section class="about-pillars">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Giá trị cốt lõi</span>
        <h2 class="section-title">Trụ cột DNA di sản</h2>
        <p class="section-desc">Những triết lý bền bỉ tạo nên sự thành công vượt thời gian và vị thế thủ lĩnh công nghệ của VinFast trên bản đồ công nghiệp ô tô toàn cầu.</p>
      </div>

      <div class="about-pillars-grid">
        <?php 
        $about_values_data = json_decode($settings['about_values'] ?? '', true);
        if (is_array($about_values_data)) {
            foreach ($about_values_data as $pillar) {
                ?>
                <div class="pillar-card">
                  <div class="pillar-icon-wrapper" aria-hidden="true" style="display: flex; align-items: center; justify-content: center;">
                    <?php echo get_svg_icon($pillar['icon'] ?? 'fa-check', 28, 28, 'color: var(--color-primary); display: block;'); ?>
                  </div>
                  <h3 class="pillar-title"><?php echo htmlspecialchars($pillar['title'] ?? ''); ?></h3>
                  <p class="pillar-desc"><?php echo htmlspecialchars($pillar['desc'] ?? ''); ?></p>
                </div>
                <?php
            }
        }
        ?>
      </div>
    </div>
  </section>

  <!-- SECTION 7: HISTORICAL TIMELINE -->
  <section class="about-history">
    <div class="container">
      <div class="section-header">
        <span class="section-tag"><?php echo htmlspecialchars($settings['about_history_tag'] ?? 'Dòng chảy lịch sử'); ?></span>
        <h2 class="section-title"><?php echo htmlspecialchars($settings['about_history_title'] ?? 'Hành trình kiến tạo tương lai'); ?></h2>
        <p class="section-desc"><?php echo htmlspecialchars($settings['about_history_desc'] ?? 'Cùng nhìn lại các cột mốc lịch sử vĩ đại làm nền tảng cho sự phát triển công nghệ đột phá của VinFast ngày nay.'); ?></p>
      </div>

      <div class="timeline">
        <?php
          $timelineJson = $settings['about_history_timeline'] ?? '';
          $timeline = json_decode($timelineJson, true);
          if (!is_array($timeline) || empty($timeline)) {
              $timeline = [
                  ["year" => "2017", "title" => "Khởi đầu khát vọng Việt", "desc" => "Vingroup chính thức khởi công tổ hợp nhà máy sản xuất ô tô xe máy điện hiện đại hàng đầu thế giới tại Cát Hải, Hải Phòng, mở ra chương mới cho công nghiệp xe Việt."],
                  ["year" => "2018", "title" => "Ra mắt thế giới tại Paris Motor Show", "desc" => "VinFast công bố hai mẫu xe concept đầu tiên Lux A2.0 và Lux SA2.0 tại Triển lãm Paris, khẳng định niềm tự hào dân tộc và thu hút sự chú ý cực lớn từ truyền thông toàn cầu."],
                  ["year" => "2021", "title" => "Bắt đầu kỷ nguyên xe điện thông minh", "desc" => "Công bố chiến lược thuần điện và bàn giao những chiếc xe điện đầu tiên VF e34 tại Việt Nam, đánh dấu bước đi lịch sử hướng tới giải pháp di chuyển xanh."],
                  ["year" => "2022", "title" => "Chinh phục thị trường toàn cầu", "desc" => "VinFast chính thức xuất khẩu lô xe điện VF 8 đầu tiên sang thị trường Bắc Mỹ, khẳng định vị thế thương hiệu xe điện toàn cầu và niêm yết trên sàn chứng khoán Nasdaq."],
                  ["year" => "2026", "title" => "Phủ xanh Việt Nam & Hướng ra thế giới", "desc" => "Hoàn thành lắp đặt 150.000 cổng sạc trên toàn quốc, dẫn đầu thị phần xe điện thông minh và mở rộng mạng lưới đại lý phân phối rộng khắp toàn cầu."]
              ];
          }
          foreach ($timeline as $index => $item):
              $alignClass = ($index % 2 === 0) ? 'timeline-left' : 'timeline-right';
        ?>
          <div class="timeline-item <?php echo $alignClass; ?>">
            <div class="timeline-content">
              <span class="timeline-year"><?php echo htmlspecialchars($item['year']); ?></span>
              <h3 class="timeline-title"><?php echo htmlspecialchars($item['title']); ?></h3>
              <p class="timeline-desc"><?php echo htmlspecialchars($item['desc']); ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- SECTION 8: SERVICE COMMITMENT -->
  <section class="about-commitments">
    <div class="container">
      <div class="section-header">
        <span class="section-tag"><?php echo htmlspecialchars($settings['about_commitments_tag'] ?? 'Cam kết đại lý'); ?></span>
        <h2 class="section-title"><?php echo htmlspecialchars($settings['about_commitments_title'] ?? 'An tâm tuyệt đối khi đồng hành'); ?></h2>
        <p class="section-desc"><?php echo htmlspecialchars($settings['about_commitments_desc'] ?? 'Mọi khách hàng sở hữu xe VinFast chính hãng tại đại lý của chúng tôi đều nhận được lời cam kết vàng về chất lượng sản phẩm và dịch vụ tốt nhất.'); ?></p>
      </div>

      <div class="commitments-grid">
        <?php
          $commitmentsJson = $settings['about_commitments_list'] ?? '';
          $commitments = json_decode($commitmentsJson, true);
          if (!is_array($commitments) || count($commitments) < 3) {
              $commitments = [
                  ["icon" => "layers", "title" => "Nhà máy sản xuất hiện đại", "desc" => "Toàn bộ dải xe điện thông minh được sản xuất trực tiếp tại tổ hợp nhà máy hiện đại hàng đầu Đông Nam Á tại Hải Phòng với tiêu chuẩn kiểm định nghiêm ngặt."],
                  ["icon" => "lock", "title" => "Bảo hành 10 năm vượt trội", "desc" => "VinFast tự hào áp dụng chính sách bảo hành chính hãng cao nhất thị trường lên đến 10 năm hoặc 200.000 km, mang lại sự tin cậy trọn đời cho mọi hành trình."],
                  ["icon" => "wrench", "title" => "Mạng lưới xưởng dịch vụ rộng khắp", "desc" => "Hệ thống trạm bảo hành, sửa chữa chuyên nghiệp phủ sóng toàn quốc, sử dụng 100% linh phụ kiện chính hãng và đội ngũ kỹ thuật viên đạt chứng chỉ tiêu chuẩn cao."]
              ];
          }
          foreach ($commitments as $comm):
              $icon = $comm['icon'] ?? 'layers';
        ?>
          <div class="commitment-card">
            <div class="commitment-icon-wrapper" aria-hidden="true" style="display: flex; align-items: center; justify-content: center;">
              <?php if ($icon === 'layers'): ?>
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                </svg>
              <?php elseif ($icon === 'lock'): ?>
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
              <?php else: ?>
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                </svg>
              <?php endif; ?>
            </div>
            <h3 class="commitment-title"><?php echo htmlspecialchars($comm['title']); ?></h3>
            <p class="commitment-desc"><?php echo htmlspecialchars($comm['desc']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- SECTION 8.5: VinFast LINEUP SHOWCASE -->
  <section class="about-showcase">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Khám phá tuyệt tác</span>
        <h2 class="section-title">Các dòng xe đang bán tại VinFast</h2>
        <p class="section-desc">Hành trình trải nghiệm đẳng cấp thượng lưu cùng bộ sưu tập những tuyệt phẩm xe sang thể thao và thuần điện đột phá mới nhất từ VinFast Việt Nam.</p>
      </div>

      <div class="about-cars-grid">
        <?php
          try {
              $stmtCars = $db->query("SELECT * FROM cars ORDER BY id ASC LIMIT 3");
              $showcaseCars = $stmtCars->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $e) {
              $showcaseCars = [];
          }

          if (count($showcaseCars) > 0):
              foreach ($showcaseCars as $car):
                  // Classify dynamic engine types
                  $engineDesc = mb_strtolower($car['engine'] ?? '');
                  $fuelType = 'gasoline';
                  $fuelLabel = 'Động cơ Xăng';
                  if (str_contains($engineDesc, 'điện') || str_contains($engineDesc, 'electric') || str_contains($engineDesc, 'bev')) {
                      $fuelType = 'electric';
                      $fuelLabel = 'Thuần Điện';
                  }

                  // Dynamic LED Inventory Indicator
                  $stockQty = (int)($car['stock_qty'] ?? 0);
                  $stockStatus = $car['stock_status'] ?? 'Hết hàng';
                  
                  if ($stockQty > 0) {
                      $ledClass = 'stock-dot--in';
                      $ledText = 'Sẵn sàng bàn giao';
                  } elseif ($stockStatus === 'Nhận đặt hàng') {
                      $ledClass = 'stock-dot--order';
                      $ledText = 'Nhận đặt hàng';
                  } else {
                      $ledClass = 'stock-dot--contact';
                      $ledText = 'Liên hệ đại lý';
                  }

                  // Parse colors list: Glacier White|#ffffff, Mythos Black|#000000
                  $colorsRaw = trim($car['exterior_colors'] ?? '');
                  $colorsList = [];
                  if ($colorsRaw) {
                      $colorsArr = explode(',', $colorsRaw);
                      foreach ($colorsArr as $colorStr) {
                          $parts = explode('|', $colorStr);
                          if (count($parts) === 2) {
                              $colorsList[] = [
                                  'name' => trim($parts[0]),
                                  'hex' => trim($parts[1])
                              ];
                          }
                      }
                  }
        ?>
          <article class="product-card">
            <div class="product-card__img-holder">
              <!-- Dynamic LED stock indicator -->
              <div class="stock-indicator">
                <span class="stock-dot <?php echo $ledClass; ?>"></span>
                <span><?php echo htmlspecialchars($ledText); ?></span>
              </div>

              <!-- Vehicle Engine Badge -->
              <span class="product-card__badge <?php echo $fuelType === 'electric' ? 'product-card__badge--electric' : 'product-card__badge--gasoline'; ?>">
                <?php echo $fuelLabel; ?>
              </span>
              <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['model_name']); ?>" class="product-card__img" loading="lazy" width="400" height="250" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
              <div class="product-card__img-fallback" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at center, hsla(216, 20%, 15%, 0.9), #05070a); align-items: center; justify-content: center; text-align: center; padding: 24px; border: 1px solid rgba(25, 96, 215, 0.15); z-index: 1;">
                <span style="font-family: 'Montserrat', sans-serif !important; font-weight: 800 !important; font-size: 16px; letter-spacing: 2px; text-transform: uppercase; color: #1960d7; text-shadow: 0 0 10px rgba(25, 96, 215, 0.4); background: linear-gradient(135deg, #fff 30%, #1960d7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo htmlspecialchars($car['model_name']); ?></span>
              </div>
            </div>
            
            <div class="product-card__info">
              <span class="product-card__segment"><?php echo htmlspecialchars($car['segment'] ?? ''); ?></span>
              <h3 class="product-card__title"><?php echo htmlspecialchars($car['model_name'] ?? ''); ?></h3>
              <p class="product-card__desc">
                <?php echo htmlspecialchars($car['description'] ?? 'Mẫu xe sang đỉnh cao sở hữu DNA công nghệ và phong cách đột phá của VinFast.'); ?>
              </p>

              <!-- Dynamic Exterior Colors -->
              <?php if (count($colorsList) > 0): ?>
                <div class="color-swatches-wrap">
                  <span class="color-swatch-label">Ngoại thất:</span>
                  <?php foreach ($colorsList as $color): ?>
                    <span class="color-swatch" style="background: <?php echo htmlspecialchars($color['hex']); ?>;">
                      <span class="color-tooltip"><?php echo htmlspecialchars($color['name']); ?></span>
                    </span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              
              <!-- Specs grid -->
              <div class="product-card__specs">
                <!-- Spec 1: Công suất -->
                <div class="spec-item">
                  <div class="spec-icon-wrap" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41" />
                      <path d="M12 12l4-4" />
                      <circle cx="12" cy="12" r="1.5" />
                    </svg>
                  </div>
                  <div class="spec-text-wrap">
                    <span class="spec-label">Công suất</span>
                    <span class="spec-val"><?php echo htmlspecialchars($car['power'] ?? 'N/A'); ?></span>
                  </div>
                </div>

                <!-- Spec 2: Gia tốc -->
                <div class="spec-item">
                  <div class="spec-icon-wrap" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <circle cx="12" cy="12" r="10" />
                      <polyline points="12 6 12 12 16 14" />
                    </svg>
                  </div>
                  <div class="spec-text-wrap">
                    <span class="spec-label">Gia tốc (0-100)</span>
                    <span class="spec-val"><?php echo htmlspecialchars($car['acceleration'] ?? 'N/A'); ?></span>
                  </div>
                </div>

                <!-- Spec 3: Động cơ -->
                <div class="spec-item">
                  <div class="spec-icon-wrap" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                      <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                      <line x1="9" y1="9" x2="15" y2="9" />
                      <line x1="9" y1="13" x2="15" y2="13" />
                      <line x1="9" y1="17" x2="15" y2="17" />
                    </svg>
                  </div>
                  <div class="spec-text-wrap">
                    <span class="spec-label">Động cơ</span>
                    <span class="spec-val" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 90px;" title="<?php echo htmlspecialchars($car['engine'] ?? ''); ?>">
                      <?php echo htmlspecialchars($car['engine'] ?? 'N/A'); ?>
                    </span>
                  </div>
                </div>

                <!-- Spec 4: Tối đa -->
                <div class="spec-item">
                  <div class="spec-icon-wrap" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M3.34 19a10 10 0 1 1 17.32 0" />
                      <path d="M12 12L16 8" />
                      <circle cx="12" cy="12" r="2" />
                    </svg>
                  </div>
                  <div class="spec-text-wrap">
                    <span class="spec-label">Tối đa</span>
                    <span class="spec-val"><?php echo htmlspecialchars($car['top_speed'] ?? 'N/A'); ?></span>
                  </div>
                </div>
              </div>

              <div class="product-card__footer">
                <div class="product-card__price-block">
                  <span class="product-card__price-lbl">Giá khởi điểm</span>
                  <?php 
                    $displayPrice = $car['price'] ?? 'Liên hệ';
                    if (strpos($displayPrice, '/') !== false) {
                        $displayPrice = explode('/', $displayPrice)[0];
                    }
                    if (strpos($displayPrice, '(') !== false) {
                        $displayPrice = explode('(', $displayPrice)[0];
                    }
                    $displayPrice = trim($displayPrice);
                  ?>
                  <span class="product-card__price-val"><?php echo htmlspecialchars($displayPrice); ?></span>
                </div>
                <a href="<?php echo seo_url('xe-vinfast/' . $car['slug']); ?>" class="product-card__btn">
                  <span>Khám phá</span>
                </a>
              </div>
            </div>
          </article>
        <?php
              endforeach;
          else:
        ?>
          <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0; color: rgba(255,255,255,0.4);">
            <p>Hiện tại chưa có mẫu xe nào được đăng bán.</p>
          </div>
        <?php endif; ?>
      </div>

      <div class="showcase-action">
        <a href="cars.php" class="btn-showcase-all">
          <span>Xem tất cả danh mục xe</span>
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"></line>
            <polyline points="12 5 19 12 12 19"></polyline>
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- SECTION 8.5: MAPS, E-E-A-T TRUST & FAQ ACCORDION -->
  <section class="about-trust-map-sec">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Định vị & Cam kết uy tín</span>
        <h2 class="section-title">Bản đồ chỉ đường & Chứng nhận 3S chính hãng</h2>
        <p class="section-desc">Hành trình xanh thuận tiện cùng hệ thống định vị thực tế và chứng thực năng lực phục vụ tiêu chuẩn toàn cầu từ VinFast Việt Nam.</p>
      </div>

      <!-- Map & Certificate Grid -->
      <div class="trust-grid">
        <!-- Google Maps Embed Box -->
        <div class="map-container-box">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.827720977239!2d106.7303112!3d10.7478065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175258385311e3b%3A0xe54d9203eb65c404!2s516%20Hu%E1%BB%B3nh%20T%E1%BA%A5n%20Ph%C3%A1t%2C%20B%C3%ACnh%20Thu%E1%BA%ADn%2C%20Qu%E1%BA%ADn%2C%20H%E1%BB%93%20Ch%C3%AD%20Minh!5e0!3m2!1svi!2s!4v1723281000000!5m2!1svi!2s" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ showroom VinFast Tam Phong"></iframe>
        </div>

        <!-- E-E-A-T Certificate Trust Box -->
        <div class="cert-container-box">
          <div class="cert-badge-wrapper">
            <div class="cert-icon" aria-hidden="true">
              <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              </svg>
            </div>
            <div>
              <h3 class="cert-title">Đại lý ủy quyền 3S chính thức</h3>
              <div class="cert-subtitle">Bảo chứng bởi VinFast Việt Nam</div>
            </div>
          </div>
          <p style="font-size: 14px; color: #475569; line-height: 1.6; margin: 0 0 15px 0;">Showroom VinFast Tam Phong được cấp chứng nhận ủy quyền chính thức đạt tiêu chuẩn 3S toàn cầu, cung cấp trọn vẹn dịch vụ khép kín cho khách hàng:</p>
          <ul class="cert-list">
            <li><strong>Sales (Bán hàng):</strong> Phân phối chính hãng dải xe điện VF 3, VF 5, VF 6, VF 7, VF 8, VF 9 với mức giá ưu đãi và quà tặng độc quyền từ nhà máy.</li>
            <li><strong>Service (Dịch vụ):</strong> Bảo hành chính hãng 10 năm hoặc 200.000 km, cứu hộ 24/7 toàn quốc và chính sách hậu mãi hàng đầu Việt Nam.</li>
            <li><strong>Spare Parts (Phụ tùng):</strong> Cam kết cung cấp 100% linh kiện phụ tùng thay thế chính hãng trực tiếp từ kho tổng VinFast Hải Phòng.</li>
          </ul>
        </div>
      </div>

      <!-- FAQ Accordion Container -->
      <div class="section-header" style="margin-top: 50px; margin-bottom: 24px;">
        <span class="section-tag">Giải đáp thắc mắc</span>
        <h2 class="section-title">Câu hỏi thường gặp (FAQ)</h2>
      </div>

      <div class="about-faq-container">
        <!-- Question 1 -->
        <div class="about-faq-item">
          <div class="about-faq-header">
            <h3 class="about-faq-question">Showroom VinFast Tam Phong nằm ở địa chỉ nào?</h3>
            <span class="about-faq-icon" aria-hidden="true">+</span>
          </div>
          <div class="about-faq-content">
            <div class="about-faq-content-inner">
              Showroom VinFast Tam Phong tọa lạc tại địa chỉ: <strong>516 Huỳnh Tấn Phát, Phường Tân Thuận, TP. Hồ Chí Minh</strong> (Địa chỉ cũ là: 516 Huỳnh Tấn Phát, Phường Bình Thuận, Quận 7, TP. Hồ Chí Minh). Khách hàng có thể dễ dàng di chuyển và tìm thấy showroom nằm ngay trên trục đường chính Huỳnh Tấn Phát cực kỳ thuận tiện.
            </div>
          </div>
        </div>

        <!-- Question 2 -->
        <div class="about-faq-item">
          <div class="about-faq-header">
            <h3 class="about-faq-question">Chính sách bảo hành xe điện của đại lý là bao lâu?</h3>
            <span class="about-faq-icon" aria-hidden="true">+</span>
          </div>
          <div class="about-faq-content">
            <div class="about-faq-content-inner">
              Tất cả các dòng xe ô tô điện VinFast mua tại đại lý đều nhận được chính sách bảo hành chính hãng cao nhất thị trường lên tới <strong>10 năm hoặc 200.000 km</strong> (tùy điều kiện nào đến trước). Ngoài ra, pin cao áp đi kèm xe cũng được bảo hành đặc quyền từ 8 đến 10 năm không giới hạn số km.
            </div>
          </div>
        </div>

        <!-- Question 3 -->
        <div class="about-faq-item">
          <div class="about-faq-header">
            <h3 class="about-faq-question">Đại lý có hỗ trợ mua xe trả góp không? Thủ tục thế nào?</h3>
            <span class="about-faq-icon" aria-hidden="true">+</span>
          </div>
          <div class="about-faq-content">
            <div class="about-faq-content-inner">
              Có. VinFast Tam Phong liên kết cùng hệ thống các ngân hàng lớn hỗ trợ khách hàng mua xe trả góp tối đa lên đến <strong>80% giá trị xe</strong>, thời hạn vay linh hoạt đến 8 năm với mức lãi suất ưu đãi cố định cực tốt. Thủ tục xét duyệt hồ sơ cực kỳ nhanh chóng, nhận xe ngay trong ngày.
            </div>
          </div>
        </div>

        <!-- Question 4 -->
        <div class="about-faq-item">
          <div class="about-faq-header">
            <h3 class="about-faq-question">Chính sách thuê pin xe điện VinFast hoạt động như thế nào?</h3>
            <span class="about-faq-icon" aria-hidden="true">+</span>
          </div>
          <div class="about-faq-content">
            <div class="about-faq-content-inner">
              VinFast cung cấp chính sách thuê pin độc đáo giúp giảm giá thành mua xe ban đầu đáng kể. Khách hàng chỉ cần trả chi phí thuê pin cố định hàng tháng tùy theo quãng đường di chuyển thực tế. Trong suốt thời gian thuê, nếu dung lượng tối đa của pin giảm xuống dưới 70%, quý khách sẽ được <strong>đổi pin mới hoàn toàn miễn phí</strong> tại bất kỳ đại lý/xưởng dịch vụ ủy quyền nào trên toàn quốc.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SECTION 9: CTAs SECTION -->
  <section class="about-ctas">
    <div class="container">
      <div class="ctas-grid">
        <?php
          $ctasJson = $settings['about_ctas_list'] ?? '';
          $ctas = json_decode($ctasJson, true);
          if (!is_array($ctas) || count($ctas) < 3) {
              $ctas = [
                  ["title" => "Tư vấn trực tiếp Zalo", "desc" => "Anh cần tìm hiểu thêm về các chương trình ưu đãi chào hè hay báo giá xe lăn bánh chi tiết? Hãy chat Zalo trực tiếp với em nhé.", "link" => "https://zalo.me/0817777855?text=Chào%20VinFast,%20tôi%20muốn%20nhận%20thêm%20thông%20tin%20tư%20vấn%20và%20chương%20trình%20khuyến%20mãi%20đặc%20quyền", "btn_text" => "Liên hệ Chat Zalo", "btn_class" => "btn-about-zalo"],
                  ["title" => "Đăng ký trải nghiệm lái", "desc" => "Hãy trực tiếp cầm lái mẫu xe VinFast yêu thích của anh để cảm nhận công nghệ AWD bám đường cùng sự êm ái vượt bậc của động cơ EV.", "link" => "cars.php#booking-block", "btn_text" => "Đăng ký lái thử", "btn_class" => "btn-about-gold"],
                  ["title" => "Bảng giá xe chính hãng", "desc" => "Tham khảo ngay bảng báo giá chính thức tất cả các dòng xe VinFast đang được trưng bày tại các hệ thống Showroom trên toàn quốc.", "link" => "pricelist.php", "btn_text" => "Xem bảng giá xe", "btn_class" => "btn-about-outline"]
              ];
          }
          foreach ($ctas as $index => $cta):
              $btnClass = $cta['btn_class'] ?? 'btn-about-gold';
        ?>
          <div class="cta-box cta-box-<?php echo $index; ?>">
            <h3 class="cta-box-title"><?php echo htmlspecialchars($cta['title']); ?></h3>
            <p class="cta-box-desc"><?php echo htmlspecialchars($cta['desc']); ?></p>
            <a href="<?php echo htmlspecialchars($cta['link']); ?>" target="<?php echo (str_contains($cta['link'], 'zalo.me') ? '_blank' : '_self'); ?>" class="btn-about-cta <?php echo htmlspecialchars($btnClass); ?>">
              <?php echo htmlspecialchars($cta['btn_text']); ?>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>


</div>

<!-- CAROUSEL GALLERY JAVASCRIPT ENGINE -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".gallery-track");
    if (!track) return;
    
    const slides = Array.from(track.children);
    const nextBtn = document.querySelector(".gallery-btn.next");
    const prevBtn = document.querySelector(".gallery-btn.prev");
    const dotsNav = document.querySelector(".gallery-dots");
    
    // Dynamically generate navigation dots
    slides.forEach((_, index) => {
        const dot = document.createElement("button");
        dot.classList.add("gallery-dot");
        if (index === 0) dot.classList.add("active");
        dot.setAttribute("aria-label", `Xem hình ảnh ${index + 1}`);
        dotsNav.appendChild(dot);
    });
    
    const dots = Array.from(dotsNav.children);
    let currentIndex = 0;
    
    const updateSlide = (index) => {
        track.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach(dot => dot.classList.remove("active"));
        dots[index].classList.add("active");
        currentIndex = index;
    };
    
    nextBtn.addEventListener("click", () => {
        let index = currentIndex + 1;
        if (index >= slides.length) index = 0;
        updateSlide(index);
    });
    
    prevBtn.addEventListener("click", () => {
        let index = currentIndex - 1;
        if (index < 0) index = slides.length - 1;
        updateSlide(index);
    });
    
    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            updateSlide(index);
        });
    });
    
    // Auto rotation every 6 seconds
    let autoPlay = setInterval(() => {
        nextBtn.click();
    }, 6000);
    
    // Clear rotation interval upon user interaction
    const resetTimer = () => {
        clearInterval(autoPlay);
        autoPlay = setInterval(() => {
            nextBtn.click();
        }, 6000);
    };
    
    nextBtn.addEventListener("click", resetTimer);
    prevBtn.addEventListener("click", resetTimer);
    dots.forEach(dot => dot.addEventListener("click", resetTimer));

    // Swipe support for mobile touchscreen swipe-to-scroll
    let startX = 0;
    let endX = 0;
    
    track.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
    }, { passive: true });
    
    track.addEventListener("touchmove", (e) => {
        endX = e.touches[0].clientX;
    }, { passive: true });
    
    track.addEventListener("touchend", () => {
        const threshold = 50; // pixels swiped to trigger slide change
        const swipedDiff = startX - endX;
        
        if (Math.abs(swipedDiff) > threshold) {
            resetTimer();
            if (swipedDiff > 0) {
                // Swiped left -> show next
                nextBtn.click();
            } else {
                // Swiped right -> show prev
                prevBtn.click();
            }
        }
        // Reset coordinate markers
        startX = 0;
        endX = 0;
    });

    // SECTION 3.5: Interactive Tech Showcase Tabs Engine
    const tabBtns = document.querySelectorAll(".tech-tab-btn");
    const tabPanels = document.querySelectorAll(".tech-tab-panel");
    
    tabBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const targetIndex = btn.getAttribute("data-tech-tab");
            
            // Switch active buttons
            tabBtns.forEach(b => {
                b.classList.remove("active");
                b.style.background = "transparent";
                b.style.color = "var(--color-text-white)";
                b.style.borderColor = "rgba(255,255,255,0.15)";
            });
            btn.classList.add("active");
            btn.style.background = "var(--color-primary)";
            btn.style.color = "#ffffff";
            btn.style.borderColor = "var(--color-primary)";
            
            // Switch active panels with smooth fade-in
            tabPanels.forEach(panel => {
                panel.style.display = "none";
                panel.classList.remove("active");
            });
            
            const activePanel = document.getElementById(`tech-panel-${targetIndex}`);
            if (activePanel) {
                activePanel.style.display = "grid";
                // Trigger reflow for transition
                void activePanel.offsetWidth;
                activePanel.classList.add("active");
            }
        });
    });
    // SECTION 10: FAQ Accordion Toggle Action
    const faqItems = document.querySelectorAll(".about-faq-item");
    faqItems.forEach(item => {
        const header = item.querySelector(".about-faq-header");
        header.addEventListener("click", () => {
            const isActive = item.classList.contains("active");
            faqItems.forEach(i => i.classList.remove("active"));
            if (!isActive) {
                item.classList.add("active");
            }
        });
    });
});
</script>

<!-- PREMIUM JSON-LD STRUCTURAL SEO DATA FOR GOOGLE -->
<script type="application/ld+json">
[
  {
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "<?php echo htmlspecialchars($settings['about_title'] ?? 'Giới thiệu VinFast Việt Nam'); ?>",
    "description": "<?php echo htmlspecialchars($siteDesc ?? ''); ?>",
    "publisher": {
      "@type": "AutoDealer",
      "name": "<?php echo htmlspecialchars($settings['company_name'] ?? 'VinFast Việt Nam'); ?>",
      "telephone": "<?php echo htmlspecialchars($settings['contact_hotline'] ?? '081 7777 855'); ?>",
      "email": "<?php echo htmlspecialchars($settings['contact_email'] ?? 'info@VinFast.vn'); ?>",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Hồ Chí Minh",
        "addressCountry": "VN",
        "streetAddress": "516 Huỳnh Tấn Phát, Phường Tân Thuận"
      }
    }
  },
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "Showroom VinFast Tam Phong nằm ở địa chỉ nào?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Showroom VinFast Tam Phong tọa lạc tại địa chỉ: 516 Huỳnh Tấn Phát, Phường Tân Thuận, TP. Hồ Chí Minh (Địa chỉ cũ là: 516 Huỳnh Tấn Phát, Phường Bình Thuận, Quận 7, TP. Hồ Chí Minh)."
        }
      },
      {
        "@type": "Question",
        "name": "Chính sách bảo hành xe điện của đại lý là bao lâu?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Tất cả các dòng xe ô tô điện VinFast mua tại đại lý đều nhận được chính sách bảo hành chính hãng cao nhất thị trường lên tới 10 năm hoặc 200.000 km."
        }
      },
      {
        "@type": "Question",
        "name": "Đại lý có hỗ trợ mua xe trả góp không? Thủ tục thế nào?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Có. VinFast Tam Phong liên kết cùng hệ thống các ngân hàng lớn hỗ trợ khách hàng mua xe trả góp tối đa lên đến 80% giá trị xe, thời hạn vay linh hoạt đến 8 năm."
        }
      },
      {
        "@type": "Question",
        "name": "Chính sách thuê pin xe điện VinFast hoạt động như thế nào?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "VinFast cung cấp chính sách thuê pin độc đáo giúp giảm giá thành mua xe ban đầu đáng kể. Khách hàng chỉ cần trả chi phí thuê pin cố định hàng tháng và được đổi pin mới hoàn toàn miễn phí nếu dung lượng tối đa của pin giảm xuống dưới 70%."
        }
      }
    ]
  }
]
</script>

</main>




