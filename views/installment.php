<style>
/* Installment Hero Background Fix */
.installment-hero {
  background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.85)), url("https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=1920&q=80") no-repeat center center / cover !important;
}

/* Premium EV Light Theme Section Alternating Backgrounds Rhythm */
html body .roadmap-section {
  background-color: #ffffff !important;
  background: #ffffff !important;
}

html body .loan-specs-section {
  background-color: #f1f5f9 !important;
  background: #f1f5f9 !important;
  border-top: 1px solid #e2e8f0 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .checklist-section {
  background-color: #ffffff !important;
  background: #ffffff !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .banks-section {
  background-color: #f1f5f9 !important;
  background: #f1f5f9 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .loan-showcase-section {
  background-color: #ffffff !important;
  background: radial-gradient(circle at center, rgba(20, 100, 244, 0.02) 0%, #ffffff 100%) !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .calculator-section {
  background-color: #f1f5f9 !important;
  background: #f1f5f9 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .faq-section {
  background-color: #ffffff !important;
  background: #ffffff !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

/* Section Title Blue Accent Bars */
html body .section-title {
  position: relative !important;
  padding-bottom: 16px !important;
  margin-bottom: 16px !important;
  display: block !important;
}

html body .section-title::after {
  content: '' !important;
  position: absolute !important;
  bottom: 0 !important;
  left: 50% !important;
  transform: translateX(-50%) !important;
  width: 60px !important;
  height: 4px !important;
  background: #1464f4 !important;
  border-radius: 2px !important;
}

/* Premium Tech Cards Overrides */
html body .quick-lead-card,
html body .calc-card,
html body .calc-results-card,
html body .roadmap-step,
html body .checklist-card,
html body .bank-card,
html body .faq-acc-item,
html body .schedule-wrapper {
  background-color: #ffffff !important;
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 10px 30px rgba(20, 100, 244, 0.02), 0 1px 3px rgba(0, 0, 0, 0.01) !important;
}

html body .quick-lead-card:hover,
html body .calc-card:hover,
html body .calc-results-card:hover,
html body .roadmap-step:hover,
html body .checklist-card:hover,
html body .bank-card:hover,
html body .faq-acc-item:hover,
html body .schedule-wrapper:hover {
  border-color: rgba(20, 100, 244, 0.25) !important;
  box-shadow: 0 20px 40px rgba(20, 100, 244, 0.06), 0 1px 3px rgba(0, 0, 0, 0.01) !important;
  transform: translateY(-5px) !important;
}

/* High Contrast Text Color System Overrides */
html body .installment-hero .hero-headline {
  color: #ffffff !important;
  text-shadow: none !important;
}

html body .installment-hero .hero-subline {
  color: #e2e8f0 !important;
}

html body .section-title {
  color: #0f172a !important;
}

html body .section-desc {
  color: #475569 !important;
}

html body .roadmap-step__title,
html body .checklist-card h4,
html body .bank-name,
html body .calc-card h4,
html body .schedule-title,
html body .faq-acc-trigger {
  color: #0f172a !important;
  font-weight: 700 !important;
}

html body .roadmap-step__desc,
html body .checklist-card p,
html body .bank-term,
html body .calc-slider-label,
html body .results-main-label,
html body .results-row-label {
  color: #475569 !important;
  font-weight: 500 !important;
}

html body .form-label {
  color: #334155 !important;
  font-weight: 600 !important;
}

html body .amort-table th {
  background-color: #f1f5f9 !important;
  color: #1e293b !important;
  font-weight: 700 !important;
}

html body .amort-table td {
  color: #334155 !important;
}

/* High Contrast Form Input Control Overrides */
html body .form-control,
html body select.form-control,
html body input.form-control {
  background-color: #ffffff !important;
  background: #ffffff !important;
  color: #334155 !important;
  border: 1px solid #cbd5e1 !important;
  border-radius: 8px !important;
  padding: 10px 16px !important;
  font-size: 14px !important;
  font-weight: 600 !important;
  height: 48px !important;
  box-shadow: none !important;
}

html body .form-control::placeholder {
  color: #94a3b8 !important;
}

html body .form-control:focus {
  border-color: #1464f4 !important;
  box-shadow: 0 0 0 3px rgba(20, 100, 244, 0.15) !important;
  outline: none !important;
  background: #ffffff !important;
  background-color: #ffffff !important;
  color: #334155 !important;
}

html body select.form-control option {
  background-color: #ffffff !important;
  color: #334155 !important;
}

/* Premium Counselors Compact Card Light Theme Overrides */
html body .counselors-compact-card {
  background: #ffffff !important;
  background-color: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: 0 10px 30px rgba(20, 100, 244, 0.02), 0 1px 3px rgba(0, 0, 0, 0.01) !important;
  border-radius: 12px !important;
  backdrop-filter: none !important;
  -webkit-backdrop-filter: none !important;
}

html body .counselors-compact-card h4 {
  color: #1464f4 !important;
  font-weight: 800 !important;
  font-size: 14px !important;
  border-bottom: 1px solid #e2e8f0 !important;
  padding-bottom: 10px !important;
}

html body .counselor-compact-row {
  background: #ffffff !important;
  background-color: #ffffff !important;
  border: 1px solid #cbd5e1 !important;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01) !important;
  border-radius: 10px !important;
}

html body .counselor-compact-row:hover {
  background: #f8fafc !important;
  border-color: #1464f4 !important;
  box-shadow: 0 8px 16px rgba(20, 100, 244, 0.06) !important;
}

html body .counselor-name-txt {
  color: #0f172a !important;
  font-weight: 700 !important;
  font-size: 15px !important;
}

html body .counselor-status-txt {
  color: #475569 !important;
  font-weight: 500 !important;
  font-size: 11.5px !important;
}

/* Counselor VIP Zalo & Call Action Buttons Overrides */
html body .counselor-btn-call {
  background-color: rgba(20, 100, 244, 0.06) !important;
  color: #1464f4 !important;
  border: 1px solid rgba(20, 100, 244, 0.2) !important;
  font-weight: 700 !important;
}

html body .counselor-btn-call:hover {
  background-color: #1464f4 !important;
  color: #ffffff !important;
  border-color: #1464f4 !important;
  box-shadow: 0 4px 12px rgba(20, 100, 244, 0.2) !important;
}

html body .counselor-btn-zalo {
  background-color: #0066ff !important;
  color: #ffffff !important;
  border: 1px solid #0066ff !important;
  font-weight: 700 !important;
}

html body .counselor-btn-zalo:hover {
  background-color: #0052cc !important;
  border-color: #0052cc !important;
  box-shadow: 0 4px 12px rgba(0, 102, 255, 0.3) !important;
}

/* Premium Loan Specifications Grid & Checklist Overrides */
html body .loan-specs-grid > div {
  background-color: #ffffff !important;
  background: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 16px !important;
  padding: 35px 30px !important;
  box-shadow: 0 10px 30px rgba(20, 100, 244, 0.02) !important;
}

html body .loan-specs-grid h3 {
  color: #1464f4 !important;
  font-weight: 800 !important;
  border-bottom: 1px solid #e2e8f0 !important;
}

html body .checklist-item {
  display: flex !important;
  align-items: flex-start !important;
  gap: 12px !important;
  margin-bottom: 18px !important;
  line-height: 1.6 !important;
}

html body .checklist-item svg {
  color: #1464f4 !important;
  background-color: rgba(20, 100, 244, 0.08) !important;
  border-radius: 50% !important;
  padding: 4px !important;
  width: 22px !important;
  height: 22px !important;
  flex-shrink: 0 !important;
}

html body .checklist-item span {
  color: #334155 !important;
  font-size: 14.5px !important;
  font-weight: 500 !important;
}

html body .checklist-item strong {
  color: #0f172a !important;
  font-weight: 700 !important;
}

/* Savings Calculator Custom Responsive & Keyframes Style */
@keyframes savingsPulse {
  0% { transform: scale(0.98); }
  50% { transform: scale(1.02); }
  100% { transform: scale(0.98); }
}

@media (max-width: 992px) {
  html body .savings-grid {
    grid-template-columns: 1fr !important;
    gap: 24px !important;
  }
  }
}

/* Upgraded Savings Calculator Visual Overrides */
html body .savings-calculator-section {
  background: radial-gradient(circle at 50% 15%, rgba(20, 100, 244, 0.02) 0%, #ffffff 75%) !important;
}

html body #savings-distance-range {
  -webkit-appearance: none !important;
  appearance: none !important;
  width: 100% !important;
  height: 8px !important;
  border-radius: 6px !important;
  background: linear-gradient(to right, #1464f4 0%, #cbd5e1 0%) !important;
  outline: none !important;
  transition: background 0.1s ease !important;
}

html body #savings-distance-range::-webkit-slider-thumb {
  -webkit-appearance: none !important;
  appearance: none !important;
  width: 22px !important;
  height: 22px !important;
  border-radius: 50% !important;
  background: #ffffff !important;
  border: 4px solid #1464f4 !important;
  box-shadow: 0 0 10px rgba(20, 100, 244, 0.4) !important;
  cursor: pointer !important;
  transition: transform 0.15s ease, background-color 0.15s !important;
}

html body #savings-distance-range::-webkit-slider-thumb:hover {
  transform: scale(1.2) !important;
  background-color: #1464f4 !important;
}

html body .savings-display-panel {
  text-align: center !important;
  background: linear-gradient(135deg, rgba(20, 100, 244, 0.02) 0%, rgba(0, 210, 255, 0.02) 100%) !important;
  border: 1px solid rgba(20, 100, 244, 0.12) !important;
  border-radius: 16px !important;
  padding: 28px 20px !important;
  box-shadow: 0 15px 35px rgba(20, 100, 244, 0.03), inset 0 1px 1px rgba(255,255,255,0.6) !important;
  backdrop-filter: blur(10px) !important;
  position: relative !important;
  overflow: hidden !important;
}

html body .savings-display-panel::before {
  content: '' !important;
  position: absolute !important;
  top: -50% !important;
  left: -50% !important;
  width: 200% !important;
  height: 200% !important;
  background: radial-gradient(circle, rgba(20, 100, 244, 0.05) 0%, transparent 70%) !important;
  pointer-events: none !important;
}

html body .savings-gradient-text {
  font-size: 38px !important;
  font-weight: 900 !important;
  font-family: 'Outfit', 'Montserrat', sans-serif !important;
  background: linear-gradient(135deg, #1464f4 0%, #00b0ff 100%) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  display: inline-block !important;
  margin: 10px 0 !important;
  letter-spacing: -0.5px !important;
}

html body .meter-bar-container {
  height: 14px !important;
  background: #f1f5f9 !important;
  border-radius: 10px !important;
  overflow: hidden !important;
  width: 100% !important;
  border: 1px solid #e2e8f0 !important;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.02) !important;
}

html body #savings-bar-gas {
  height: 100% !important;
  background: linear-gradient(90deg, #94a3b8 0%, #64748b 100%) !important;
  border-radius: 10px !important;
  transition: width 0.5s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
}

html body #savings-bar-ev {
  height: 100% !important;
  background: linear-gradient(90deg, #1464f4 0%, #00d2ff 100%) !important;
  border-radius: 10px !important;
  box-shadow: 0 0 10px rgba(0, 210, 255, 0.3) !important;
  transition: width 0.5s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
}

/* Scroll Reveal Animations Style */
html body .reveal-on-scroll {
  opacity: 0 !important;
  transform: translateY(50px) !important;
  transition: opacity 1.2s cubic-bezier(0.25, 0.8, 0.25, 1), transform 1.2s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
}

html body .reveal-on-scroll.revealed {
  opacity: 1 !important;
  transform: translateY(0) !important;
}

/* Disable all text shadows on text elements globally for clean flat design */
html body h1,
html body h2,
html body h3,
html body h4,
html body h5,
html body h6,
html body span,
html body strong,
html body div,
html body p,
html body a {
  text-shadow: none !important;
}

/* Ensure global font-family consistency using default web theme fonts */
html body,
html body h1,
html body h2,
html body h3,
html body h4,
html body h5,
html body h6,
html body p,
html body span,
html body a,
html body strong,
html body select,
html body input,
html body button {
  font-family: 'Montserrat', sans-serif !important;
}

/* High Contrast FAQ Accordion Overrides */
html body .faq-acc-item {
  background-color: #ffffff !important;
  border: 1px solid #e2e8f0 !important;
  border-radius: 12px !important;
}

html body .faq-acc-trigger {
  color: #0f172a !important;
  font-weight: 700 !important;
  font-size: 15px !important;
  background-color: #ffffff !important;
}

html body .faq-acc-trigger:hover {
  color: #1464f4 !important;
}

html body .faq-acc-content {
  color: #334155 !important;
  font-size: 14px !important;
  font-weight: 500 !important;
  line-height: 1.65 !important;
  background-color: #ffffff !important;
  padding-top: 8px !important;
}

html body .faq-acc-content p {
  color: #334155 !important;
  margin: 0 !important;
  line-height: 1.65 !important;
}

/* Compact Section Spacings & Margins Overrides */
html body section:not(.installment-hero) {
  padding: 30px 0 !important;
}

/* Reduce margin-bottom of all section headers */
html body section .container > div[style*="margin-bottom"] {
  margin-bottom: 24px !important;
}
</style>

<!-- 1. HERO SECTION -->
  <section class="installment-hero">
    <div class="container">
      <div class="installment-hero__grid">
        <div class="hero-left-info">
          <span class="section-tag" style="color: #ffffff; background: rgba(20, 100, 244, 0.2); border: 1px solid rgba(255, 255, 255, 0.1); padding: 4px 12px; border-radius: 12px; font-weight: 700;">ĐẶC QUYỀN TÀI CHÍNH VIP</span>
          <h1 class="hero-headline">MUA XE VinFast TRẢ GÓP LÃI SUẤT ƯU ĐÃI 2026</h1>
          <p class="hero-subline">Chỉ từ 20% giá trị xe nhận ngay dòng xe điện thông minh VinFast thời thượng. Ngân hàng liên kết phê duyệt hồ sơ bảo lãnh chỉ trong 4 giờ làm việc, thủ tục nhanh chóng, bảo mật thông tin.</p>
          <div style="display: flex; gap: 16px; flex-wrap: wrap;">
            <a href="#loan-calculator" class="btn-primary">Tính lãi suất trực quan</a>
            <a href="#checklist" class="btn-secondary">Checklist hồ sơ thủ tục</a>
          </div>
        </div>
        
        <div class="hero-right-form">
          <div class="quick-lead-card">
            <h3 class="lead-card-title">Nhận báo giá &amp; Gói trả góp</h3>
            <form onsubmit="handleLeadSubmit(event)">
              <!-- Anti-spam HoneyPot field -->
              <input type="text" id="lead-website_url" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">
              
              <div class="form-group">
                <label class="form-label" for="lead-name">Họ và Tên</label>
                <input class="form-control" type="text" id="lead-name" placeholder="Nguyễn Văn A" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="lead-phone">Số điện thoại / Zalo</label>
                <input class="form-control" type="tel" id="lead-phone" placeholder="0901234567" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="lead-car">Chọn dòng xe mong muốn</label>
                <select class="form-control" id="lead-car">
                  <?php foreach ($cars as $car): ?>
                    <option value="<?php echo htmlspecialchars($car['id']); ?>">
                      <?php echo htmlspecialchars($car['model_name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button class="btn-primary btn-submit-lead" type="submit">Gửi yêu cầu dự toán</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- 3. INSTALLMENT ROADMAP -->
  <section class="roadmap-section reveal-on-scroll">
    <div class="container">
      <div style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">DỊCH VỤ CHUYÊN NGHIỆP TRỌN GÓI</span>
        <h2 class="section-title">QUY TRÌNH MUA XE TRẢ GÓP 4 BƯỚC TINH GỌN</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Sở hữu ngay các dòng xe trong <a href="<?php echo seo_url('dong-xe-vinfast'); ?>" style="color: #1464f4; text-decoration: underline; font-weight: 700;">bảng dòng xe VinFast</a> thời thượng với lộ trình duyệt vay tài chính và đăng ký lăn bánh diễn ra nhanh chóng, thông thoáng.</p>
      </div>

      <div class="roadmap-grid">
        <?php 
        $stepsJson = $settings['installment_steps'] ?? '';
        $steps = json_decode($stepsJson, true);
        if (!is_array($steps) || count($steps) < 4) {
            $steps = [
                ["title" => "Chọn xe & Làm hồ sơ", "desc" => "Chuyên viên tư vấn tài chính VinFast hỗ trợ quý khách chọn cấu hình xe và thu thập hồ sơ vay tối thiểu phù hợp nhất."],
                ["title" => "Ngân hàng phê duyệt", "desc" => "Hệ thống ngân hàng liên kết đối tác sẽ thẩm định và phát hành thông báo đồng ý tài trợ cho vay tối đa trong vòng 4-8 giờ."],
                ["title" => "Nộp đối ứng & Đăng ký", "desc" => "Khách hàng hoàn tất phần thanh toán đối ứng ban đầu, đại lý VinFast tiến hành đăng ký lăn bánh biển số xe hoàn tất."],
                ["title" => "Giải ngân & Nhận xe", "desc" => "Ngân hàng thực hiện giải ngân thanh toán nốt phần còn lại, quý khách đến nhận xe bàn giao kèm đầy đủ hồ sơ lăn bánh."]
            ];
        }
        $icons = [
            '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10,9 9,9 8,9"></polyline></svg>',
            '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>',
            '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
            '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22,4 12,14.01 9,11.01"></polyline></svg>'
        ];
        foreach ($steps as $index => $step):
        ?>
          <div class="roadmap-step">
            <span class="roadmap-step__num">0<?php echo $index + 1; ?></span>
            <div class="roadmap-step__icon">
              <?php echo $icons[$index] ?? $icons[0]; ?>
            </div>
            <h3 class="roadmap-step__title"><?php echo htmlspecialchars($step['title']); ?></h3>
            <p class="roadmap-step__desc"><?php echo htmlspecialchars($step['desc']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <!-- 3.5. LOAN SPECIFICATIONS & TERMS (VIETCOMBANK ALIGNED) -->
  <section class="loan-specs-section reveal-on-scroll" style="border-bottom: 1px solid var(--color-border);">
    <div class="container">
      <div style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">TIÊU CHUẨN TÀI CHÍNH QUỐC TẾ</span>
        <h2 class="section-title">ĐẶC ĐIỂM &amp; ĐIỀU KIỆN VAY MUA XE CHI TIẾT</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Thông tin minh bạch về gói tín dụng theo <a href="<?php echo seo_url('bang-gia-xe-vinfast'); ?>" style="color: #1464f4; text-decoration: underline; font-weight: 700;">bảng giá xe VinFast trả góp</a> và quy chuẩn hệ thống ngân hàng liên kết đối tác lớn.</p>
      </div>

      <div class="loan-specs-grid">
        <!-- Column 1: Đặc điểm gói vay (Loan Features) -->
        <div style="background: var(--color-bg-card); border: 1px solid var(--color-border); border-radius: 12px; padding: 32px;">
          <h3 style="font-size: 16px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 24px; border-bottom: 1px solid var(--color-border); padding-bottom: 12px; display: flex; align-items: center; gap: 10px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            Đặc điểm sản phẩm vay mua xe
          </h3>
          <ul class="checklist-items">
            <?php 
            $featuresText = $settings['installment_features'] ?? '';
            if (empty($featuresText)) {
                $featuresText = "Hạn mức cho vay: Hỗ trợ lên tới 80% - 85% giá trị xe trên hóa đơn mua bán thực tế. Khách hàng chỉ cần chuẩn bị trước 15% - 20% đối ứng.\nThời gian vay vốn: Linh hoạt kéo dài từ 1 năm (12 tháng) tới tối đa 8 năm (96 tháng) giúp dàn đều chi phí gốc lãi hàng tháng.\nPhương thức tính lãi: Tính lãi trên dư nợ thực tế giảm dần (không tính trên dư nợ ban đầu), số tiền trả lãi sẽ giảm cực kỳ mạnh qua các năm tiếp theo.\nTài sản bảo đảm: Chính chiếc xe VinFast quý khách dự định mua, hoặc bất động sản khác thuộc quyền sở hữu hợp pháp của quý khách.";
            }
            $features = explode("\n", $featuresText);
            foreach ($features as $feat):
                $feat = trim($feat);
                if (empty($feat)) continue;
                
                if (strpos($feat, ':') !== false) {
                    list($title, $desc) = explode(':', $feat, 2);
                    $itemHtml = "<strong>" . htmlspecialchars($title) . ":</strong>" . htmlspecialchars($desc);
                } else {
                    $itemHtml = htmlspecialchars($feat);
                }
            ?>
              <li class="checklist-item">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20,6 9,17 4,12"></polyline></svg>
                <span><?php echo $itemHtml; ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Column 2: Điều kiện vay vốn (Loan Eligibility) -->
        <div style="background: var(--color-bg-card); border: 1px solid var(--color-border); border-radius: 12px; padding: 32px;">
          <h3 style="font-size: 16px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 24px; border-bottom: 1px solid var(--color-border); padding-bottom: 12px; display: flex; align-items: center; gap: 10px;">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22,4 12,14.01 9,11.01"></polyline></svg>
            Điều kiện đối với khách hàng vay
          </h3>
          <ul class="checklist-items">
            <?php 
            $eligibilityText = $settings['installment_eligibility'] ?? '';
            if (empty($eligibilityText)) {
                $eligibilityText = "Độ tuổi người vay: Tại thời điểm nộp hồ sơ vay từ đủ 18 tuổi và không quá 65 tuổi tại thời điểm tất toán toàn bộ khoản vay ngân hàng.\nLịch sử CIC tín dụng: Không có nợ nhóm 3, 4, 5 tại Trung tâm Thông tin Tín dụng Quốc gia (CIC) trong 2 năm gần nhất.\nNguồn thu nhập tối thiểu: Tổng thu nhập ổn định từ lương chuyển khoản ngân hàng tối thiểu 10 triệu/tháng (đối với cá nhân), hoặc có dòng tiền ổn định từ kinh doanh/cho thuê tài sản.\nNơi cư trú hợp pháp: Có hộ khẩu thường trú hoặc đăng ký tạm trú dài hạn (KT3) tại tỉnh/thành phố có chi nhánh giao dịch của ngân hàng liên kết vay.";
            }
            $eligibility = explode("\n", $eligibilityText);
            foreach ($eligibility as $elig):
                $elig = trim($elig);
                if (empty($elig)) continue;
                
                if (strpos($elig, ':') !== false) {
                    list($title, $desc) = explode(':', $elig, 2);
                    $itemHtml = "<strong>" . htmlspecialchars($title) . ":</strong>" . htmlspecialchars($desc);
                } else {
                    $itemHtml = htmlspecialchars($elig);
                }
            ?>
              <li class="checklist-item">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20,6 9,17 4,12"></polyline></svg>
                <span><?php echo $itemHtml; ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- 4. ELIGIBILITY TABBED CHECKLIST -->
  <section id="checklist" class="checklist-section reveal-on-scroll">
    <div class="container">
      <div style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">THỦ TỤC VAY MINH BẠCH</span>
        <h2 class="section-title">HỒ SƠ CẦN CHUẨN BỊ MUA XE TRẢ GÓP</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Để quá trình duyệt vay diễn ra thuận tiện và rút ngắn thời gian giải ngân nhận xe, quý khách có thể chuẩn bị trước các giấy tờ cơ bản dưới đây.</p>
      </div>

      <div class="tabs-nav-row">
        <button class="tab-btn tab-btn--active" onclick="switchChecklistTab('personal', this)">Khách hàng Cá Nhân</button>
        <button class="tab-btn" onclick="switchChecklistTab('business', this)">Khách hàng Doanh Nghiệp</button>
      </div>

      <!-- PERSONAL CHECKLIST -->
      <div class="tab-content-panel tab-content-panel--active" id="tab-personal">
        <?php 
        $personalText = $settings['installment_docs_personal'] ?? '';
        if (empty($personalText)) {
            $personalText = "Hồ sơ pháp lý: CCCD gắn chip (hoặc định danh VNeID mức độ 2), Giấy xác nhận độc thân hoặc Giấy đăng ký kết hôn của cả hai vợ chồng.\nHồ sơ chứng minh thu nhập: Hợp đồng lao động còn thời hạn hiệu lực, Bảng lương hoặc Sao kê lương ngân hàng 3 - 6 tháng gần nhất.\nThu nhập khác (nếu có): Hợp đồng cho thuê nhà, thuê xe ô tô, hoặc sổ tiết kiệm, giấy tờ sở hữu cổ phần kinh doanh.\nHồ sơ mục đích vay: Hợp đồng mua bán xe ô tô VinFast ký với đại lý chính hãng, Phiếu thu tiền đặt cọc xe.";
        }
        $personalLines = array_filter(array_map('trim', explode("\n", $personalText)));
        $mid = ceil(count($personalLines) / 2);
        $personalPart1 = array_slice($personalLines, 0, $mid);
        $personalPart2 = array_slice($personalLines, $mid);
        
        $renderDocCard = function($title, $items, $iconSvg) {
        ?>
          <div class="checklist-card">
            <h3 class="checklist-card-title">
              <?php echo $iconSvg; ?>
              <?php echo htmlspecialchars($title); ?>
            </h3>
            <ul class="checklist-items">
              <?php foreach ($items as $item): 
                  if (strpos($item, ':') !== false) {
                      list($lbl, $val) = explode(':', $item, 2);
                      $html = "<strong>" . htmlspecialchars($lbl) . ":</strong>" . htmlspecialchars($val);
                  } else {
                      $html = htmlspecialchars($item);
                  }
              ?>
                <li class="checklist-item">
                  <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20,6 9,17 4,12"></polyline></svg>
                  <span><?php echo $html; ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php
        };
        
        $personalIcon1 = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>';
        $personalIcon2 = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>';
        
        $renderDocCard("Giấy tờ Pháp lý / Nhân thân", $personalPart1, $personalIcon1);
        $renderDocCard("Chứng minh Thu nhập & Tài sản", $personalPart2, $personalIcon2);
        ?>
      </div>

      <!-- BUSINESS CHECKLIST -->
      <div class="tab-content-panel" id="tab-business">
        <?php 
        $businessText = $settings['installment_docs_business'] ?? '';
        if (empty($businessText)) {
            $businessText = "Hồ sơ pháp lý doanh nghiệp: Giấy chứng nhận đăng ký doanh nghiệp (GPKD), Điều lệ công ty, Biên bản họp bổ nhiệm người đại diện pháp luật.\nGiấy tờ tùy thân người đại diện: CCCD/Hộ chiếu người đại diện pháp luật ký kết hợp đồng vay vốn.\nHồ sơ tài chính doanh nghiệp: Báo cáo tài chính nội bộ, Báo cáo thuế tối thiểu 1 - 2 năm gần nhất, Sao kê tài khoản ngân hàng công ty 6 tháng qua.\nHồ sơ mục đích vay: Hợp đồng mua bán xe ô tô ký giữa công ty và đại lý VinFast, Phiếu thu/Ủy nhiệm chi tiền đặt cọc xe.";
        }
        $businessLines = array_filter(array_map('trim', explode("\n", $businessText)));
        $midBus = ceil(count($businessLines) / 2);
        $businessPart1 = array_slice($businessLines, 0, $midBus);
        $businessPart2 = array_slice($businessLines, $midBus);
        
        $businessIcon1 = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14,2 14,8 20,8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10,9 9,9 8,9"></polyline></svg>';
        $businessIcon2 = '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>';
        
        $renderDocCard("Hồ sơ Pháp lý Doanh nghiệp", $businessPart1, $businessIcon1);
        $renderDocCard("Báo cáo Tài chính & Nguồn thu", $businessPart2, $businessIcon2);
        ?>
      </div>
    </div>
  </section>
  <!-- 5. PARTNER BANKS -->
  <section class="banks-section reveal-on-scroll">
    <div class="container">
      <div style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">ĐỐI TÁC TÀI CHÍNH LIÊN KẾT</span>
        <h2 class="section-title">HỆ THỐNG NGÂN HÀNG LIÊN KẾT ĐẠI LÝ</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Chúng tôi liên kết chặt chẽ với các ngân hàng uy tín nhất tại đại lý <a href="/" style="color: #1464f4; text-decoration: underline; font-weight: 700;">VinFast Tam Phong</a> nhằm đem lại mức lãi suất ưu đãi vượt trội.</p>
      </div>

      <!-- Mobile swipe hint for Partner Banks -->
      <div class="mobile-banks-hint-wrapper" style="display: none; justify-content: center; margin-bottom: 20px;">
        <div class="mobile-table-hint-pill" style="font-size: 10px; padding: 8px 18px;">
          <span class="pulse-dot"></span>
          VUỐT NGANG XEM ĐỐI TÁC
        </div>
      </div>

      <div class="bank-grid">
        <?php
          $banksJson = $settings['installment_banks'] ?? '';
          $banks = json_decode($banksJson, true) ?: [];
          if (!empty($banks)):
            foreach ($banks as $bank):
        ?>
          <div class="bank-card">
            <span class="bank-name"><?php echo htmlspecialchars($bank['name']); ?></span>
            <span class="bank-rate"><?php echo htmlspecialchars($bank['rate']); ?>%</span>
            <span class="bank-term">Cố định <?php echo htmlspecialchars($bank['max_years'] ?? '1'); ?> năm</span>
          </div>
        <?php 
            endforeach;
          else:
        ?>
          <div class="bank-card">
            <span class="bank-name">Vietcombank</span>
            <span class="bank-rate">6.9%</span>
            <span class="bank-term">Cố định 8 năm</span>
          </div>
          <div class="bank-card">
            <span class="bank-name">Techcombank</span>
            <span class="bank-rate">7.5%</span>
            <span class="bank-term">Cố định 8 năm</span>
          </div>
          <div class="bank-card">
            <span class="bank-name">Shinhan Bank</span>
            <span class="bank-rate">6.5%</span>
            <span class="bank-term">Cố định 8 năm</span>
          </div>
          <div class="bank-card">
            <span class="bank-name">MB Bank</span>
            <span class="bank-rate">7.2%</span>
            <span class="bank-term">Cố định 8 năm</span>
          </div>
          <div class="bank-card">
            <span class="bank-name">VIB</span>
            <span class="bank-rate">7.9%</span>
            <span class="bank-term">Cố định 8 năm</span>
          </div>
          <div class="bank-card">
            <span class="bank-name">Sacombank</span>
            <span class="bank-rate">7.0%</span>
            <span class="bank-term">Cố định 8 năm</span>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- DYNAMIC LOAN SEGMENT SHOWCASE SECTION -->
  <section class="loan-showcase-section reveal-on-scroll" style="padding: 64px 0 32px 0; border-top: 1px solid var(--color-border);">
    <div class="container">
      <div style="text-align: center; margin-bottom: 40px;">
        <span class="section-tag">Dự toán hạn mức tối ưu</span>
        <h2 class="section-title" style="font-size: 28px;">PHÂN KHÚC VAY MUA XE TIÊU BIỂU</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto; margin-bottom: 0 !important;">Lựa chọn dòng xe phù hợp với ngân sách tài chính của bạn và bấm "Áp dụng bảng tính ⚡" để xem ngay chi tiết phân kỳ dư nợ.</p>
      </div>

      <div class="showcase-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        <?php 
        $showcasesJson = $settings['installment_showcases'] ?? '';
        $showcases = json_decode($showcasesJson, true);
        if (!is_array($showcases) || empty($showcases)) {
            $showcases = [
                [
                    "tag" => "SUV MINI CÁ TÍNH",
                    "title" => "VinFast VF 3",
                    "desc" => "Trải nghiệm dòng xe điện mini quốc dân thời thượng với chi phí đầu tư ban đầu siêu tiết kiệm.",
                    "image" => "https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&w=600&q=80",
                    "prepay" => "Chỉ từ 68 Triệu",
                    "monthly" => "3.5 Triệu / tháng",
                    "preset" => "VinFast VF 3"
                ],
                [
                    "tag" => "SUV ĐÔ THỊ THÔNG MINH",
                    "title" => "VinFast VF 8",
                    "desc" => "Không gian sang trọng, an toàn vượt trội tích hợp hệ thống trợ lái nâng cao ADAS thông minh.",
                    "image" => "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80",
                    "prepay" => "Chỉ từ 218 Triệu",
                    "monthly" => "11 Triệu / tháng",
                    "preset" => "VinFast VF 8"
                ],
                [
                    "tag" => "SUV LI-MO VIP ĐẲNG CẤP",
                    "title" => "VinFast VF 9",
                    "desc" => "Mẫu SUV cỡ E sang trọng 7 chỗ dành cho giới chủ chủ tịch, khẳng định vị thế dẫn đầu.",
                    "image" => "https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=600&q=80",
                    "prepay" => "Chỉ từ 312 Triệu",
                    "monthly" => "16 Triệu / tháng",
                    "preset" => "VinFast VF 9"
                ]
            ];
        }
        foreach ($showcases as $sc):
            // Dynamically synchronize with current cars database if found!
            $matchedCar = null;
            foreach ($cars as $car) {
                $dbModel = strtolower(trim($car['model_name']));
                $presetModel = strtolower(trim($sc['preset']));
                if (strcasecmp($dbModel, $presetModel) === 0 || 
                    strpos($presetModel, $dbModel) === 0 || 
                    strpos($dbModel, $presetModel) === 0) {
                    $matchedCar = $car;
                    break;
                }
            }

            if ($matchedCar) {
                $sc['title'] = $matchedCar['model_name'];
                $sc['image'] = $matchedCar['image'];
                
                $priceNum = (int)preg_replace('/[^0-9]/', '', explode('/', $matchedCar['price'])[0]);
                if ($priceNum > 0) {
                    // Prepay: 20% down payment
                    $prepayVal = $priceNum * 0.20;
                    if ($prepayVal >= 1000000000) {
                        $sc['prepay'] = 'Chỉ từ ' . number_format($prepayVal / 1000000000, 1, ',', '.') . ' Tỷ';
                    } else {
                        $sc['prepay'] = 'Chỉ từ ' . number_format($prepayVal / 1000000, 0, ',', '.') . ' Triệu';
                    }
                    
                    // Monthly: remaining 80% loan amortized over 8 years (96 months) at 7.5% annual rate
                    $loanAmt = $priceNum * 0.80;
                    $monthlyInterestRate = 0.075 / 12;
                    $months = 96;
                    $monthlyPayment = $loanAmt * ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $months)) / (pow(1 + $monthlyInterestRate, $months) - 1);
                    
                    if ($monthlyPayment >= 1000000000) {
                        $sc['monthly'] = number_format($monthlyPayment / 1000000000, 1, ',', '.') . ' Tỷ / tháng';
                    } else {
                        $sc['monthly'] = number_format($monthlyPayment / 1000000, 0, ',', '.') . ' Triệu / tháng';
                    }
                }
            }
            
            $isETron = (strpos(strtolower($sc['tag']), 'điện') !== false || strpos(strtolower($sc['title']), 'EV') !== false);
        ?>
          <div class="showcase-card" style="background: var(--color-bg-card); border: 1px solid var(--color-border); border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; box-shadow: 0 10px 30px rgba(0,0,0,0.3); transition: transform 0.4s ease, border-color 0.4s ease;">
            <div style="height: 180px; overflow: hidden; position: relative;">
              <img src="<?php echo htmlspecialchars($sc['image']); ?>" alt="<?php echo htmlspecialchars($sc['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease;" loading="lazy" width="400" height="250">
              <div style="position: absolute; top: 12px; left: 12px; background: #1464f4; padding: 5px 12px; border-radius: 20px; box-shadow: 0 4px 10px rgba(20, 100, 244, 0.25);">
                <span style="font-size: 9px; font-weight: 800; color: #ffffff; letter-spacing: 1.5px; text-transform: uppercase;"><?php echo htmlspecialchars($sc['tag']); ?></span>
              </div>
            </div>
            <div style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1; gap: 12px;">
              <h3 style="font-size: 16px; font-weight: 700; color: var(--color-text-main); margin: 0; text-transform: uppercase;"><?php echo htmlspecialchars($sc['title']); ?></h3>
              <p style="font-size: 13px; color: var(--color-text-muted); line-height: 1.6; margin: 0;"><?php echo htmlspecialchars($sc['desc']); ?></p>
              <div style="background: rgba(25, 96, 215,0.03); border: 1px solid rgba(25, 96, 215,0.1); border-radius: 8px; padding: 12px; margin-top: auto;">
                <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 6px;"><span style="color: var(--color-text-muted);">Trả trước:</span><strong style="color: #1464f4; font-weight: 700;"><?php echo htmlspecialchars($sc['prepay']); ?></strong></div>
                <div style="display: flex; justify-content: space-between; font-size: 12px;"><span style="color: var(--color-text-muted);">Hàng tháng từ:</span><strong style="color: var(--color-text-main); font-weight: 700;"><?php echo htmlspecialchars($sc['monthly']); ?></strong></div>
              </div>
              <button onclick="applyShowcaseCar('<?php echo htmlspecialchars($sc['preset']); ?>')" class="btn-primary" style="padding: 10px 16px; font-size: 10px; margin-top: 8px; width: 100%;"><?php echo $isETron ? 'Khởi động máy tính điện ⚡' : 'Áp dụng bảng tính ⚡'; ?></button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<!-- 2. DYNAMIC LIVE LOAN CALCULATOR -->
  <section id="loan-calculator" class="calculator-section reveal-on-scroll">
    <div class="container">
      <div style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">BỘ TÍNH TOÁN DƯ NỢ GIẢM DẦN</span>
        <h2 class="section-title">BẢNG TÍNH LÃI SUẤT TRẢ GÓP VinFast TRỰC QUAN</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Thay đổi giá trị xe, tỷ lệ trả trước và thời gian vay để xem ngay số tiền cần chuẩn bị ban đầu, số gốc lãi chi trả hàng tháng và in bảng lịch phân kỳ thanh toán.</p>
      </div>

      <div class="calculator-grid">
        <!-- Left Column Container: Stacks Sliders & Compact Counselors -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
          <!-- Input fields panel -->
          <div class="calc-card" style="margin-bottom: 0;">
            <!-- Car dropdown -->
            <div class="calc-slider-group">
              <label class="form-label">Chọn phiên bản xe VinFast</label>
              <select class="form-control" id="calc-car-select" onchange="updateCalculator()">
                <?php foreach ($cars as $idx => $car): ?>
                  <?php $numericPrice = (int)preg_replace('/[^0-9]/', '', explode('/', $car['price'])[0]); ?>
                  <option value="<?php echo $numericPrice; ?>" data-name="<?php echo htmlspecialchars($car['model_name']); ?>" data-image="<?php echo htmlspecialchars($car['image']); ?>" <?php echo $idx === 0 ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($car['model_name']); ?> - <?php echo number_format($numericPrice / 1000000, 0, ',', '.'); ?> triệu VNĐ
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Downpayment % Slider -->
            <div class="calc-slider-group">
              <div class="calc-slider-header">
                <span class="calc-slider-label">Tỷ lệ Trả Trước</span>
                <span class="calc-slider-val" id="val-dp-pct">30%</span>
              </div>
              <div class="slider-control-row">
                <input class="calc-range" type="range" id="range-dp-pct" min="20" max="80" step="5" value="30" oninput="updateCalculator()">
              </div>
            </div>

            <!-- Loan Term Slider -->
            <div class="calc-slider-group">
              <div class="calc-slider-header">
                <span class="calc-slider-label">Thời Gian Vay</span>
                <span class="calc-slider-val" id="val-term">60 tháng (5 năm)</span>
              </div>
              <div class="slider-control-row">
                <input class="calc-range" type="range" id="range-term" min="12" max="96" step="12" value="60" oninput="updateCalculator()">
              </div>
            </div>

            <!-- Interest Rate Slider -->
            <div class="calc-slider-group">
              <div class="calc-slider-header">
                <span class="calc-slider-label">Lãi Suất Áp Dụng</span>
                <span class="calc-slider-val" id="val-rate"><?php echo htmlspecialchars($settings['installment_interest_default'] ?? '6.9'); ?>% / năm</span>
              </div>
              <div class="slider-control-row">
                <input class="calc-range" type="range" id="range-rate" min="5" max="15" step="0.1" value="<?php echo htmlspecialchars($settings['installment_interest_default'] ?? '6.9'); ?>" oninput="updateCalculator()">
              </div>
            </div>
          </div>

          <!-- Compact Counselor VIP Widget Style & Markup -->

          <div class="counselors-compact-card">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 10px;">
              <h4 style="font-size: 13.5px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1px; margin: 0; display: flex; align-items: center; gap: 8px;">
                <span class="counselor-online-badge" style="position: static; display: inline-block; width: 8px; height: 8px; margin: 0; animation: counselorPulse 1.8s infinite !important;"></span>
                Kết Nối Trực Tuyến
              </h4>
              <span style="font-size: 9px; font-weight: 700; color: #2ecc71; text-transform: uppercase; letter-spacing: 0.5px;">Trực ban hỗ trợ 24/7</span>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 12px;">
              <?php
                $stmtCounselors = $db->query("SELECT * FROM counselors WHERE status = 'ONLINE' LIMIT 2");
                $activeCounselors = $stmtCounselors->fetchAll();
                
                if (empty($activeCounselors)):
              ?>
                <!-- Fallback Counselor -->
                <div class="counselor-compact-row">
                  <div style="display: flex; align-items: center; gap: 14px; min-width: 0;">
                    <div class="counselor-avatar-container">
                      <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=70&fm=webp" alt="VinFast Representative" class="counselor-avatar-img" loading="lazy" width="80" height="80">
                      <span class="counselor-online-badge"></span>
                    </div>
                    <div class="counselor-info-col">
                      <span class="counselor-name-txt">Cố vấn VinFast</span>
                      <span class="counselor-status-txt">Đang trực ban hỗ trợ</span>
                    </div>
                  </div>
                  <div class="counselor-action-btns">
                    <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" class="counselor-btn counselor-btn-call">Gọi</a>
                    <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>" target="_blank" class="counselor-btn counselor-btn-zalo" rel="noopener">Zalo</a>
                  </div>
                </div>
              <?php else: ?>
                <?php foreach ($activeCounselors as $cs): ?>
                  <div class="counselor-compact-row">
                    <div style="display: flex; align-items: center; gap: 14px; min-width: 0;">
                      <div class="counselor-avatar-container">
                        <img src="<?php echo htmlspecialchars($cs['avatar'] ?: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80'); ?>" alt="<?php echo htmlspecialchars($cs['fullname']); ?>" class="counselor-avatar-img" loading="lazy" width="80" height="80">
                        <span class="counselor-online-badge"></span>
                      </div>
                      <div class="counselor-info-col">
                        <span class="counselor-name-txt"><?php echo htmlspecialchars($cs['fullname']); ?></span>
                        <span class="counselor-status-txt">Đang trực ban hỗ trợ</span>
                      </div>
                    </div>
                    <div class="counselor-action-btns">
                      <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $cs['phone']); ?>" class="counselor-btn counselor-btn-call">Gọi</a>
                      <a href="<?php echo htmlspecialchars($cs['zalo']); ?>" target="_blank" class="counselor-btn counselor-btn-zalo" rel="noopener">Zalo</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Output fields panel -->
        <div class="calc-results-card">
          <!-- Dynamic Car Live Preview -->
          <div class="calc-car-preview-wrap" style="margin-bottom: 16px; border-radius: 12px; overflow: hidden; border: 1px solid var(--color-border); position: relative; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; height: 180px; box-shadow: inset 0 0 25px rgba(0,0,0,0.85);">
            <img id="calc-car-image" src="" alt="VinFast preview" style="width: 100%; height: 100%; object-fit: contain; padding: 12px; transition: opacity 0.4s ease, transform 0.4s ease; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.6));" loading="lazy" width="400" height="250">
            <div style="position: absolute; top: 12px; right: 12px; background: rgba(10,14,22,0.85); padding: 4px 10px; border-radius: 20px; border: 1px solid rgba(25, 96, 215,0.4); backdrop-filter: blur(10px);">
              <span id="calc-car-badge" style="font-size: 8px; font-weight: 700; color: var(--color-primary); text-transform: uppercase; letter-spacing: 1.5px;">VinFast AWD</span>
            </div>
            <div class="car-halo" style="position: absolute; width: 80%; height: 60%; background: radial-gradient(circle, rgba(25, 96, 215,0.06) 0%, transparent 70%); z-index: 1;"></div>
          </div>

          <div class="results-main-value">
            <p class="results-main-label">Tháng Đầu Tiên Trả (Gốc + Lãi)</p>
            <p class="results-main-val" id="res-monthly-first">0 VNĐ</p>
          </div>

          <div style="display: flex; flex-direction: column; gap: 14px;">
            <div class="results-row">
              <span class="results-row-label">Giá niêm yết xe:</span>
              <span class="results-row-val" id="res-car-price">0 VNĐ</span>
            </div>
            <div class="results-row">
              <span class="results-row-label">Đối ứng trả trước ban đầu:</span>
              <span class="results-row-val results-row-val--gold" id="res-dp-amount">0 VNĐ</span>
            </div>
            <div class="results-row">
              <span class="results-row-label">Tổng số tiền cần vay:</span>
              <span class="results-row-val" id="res-loan-amount">0 VNĐ</span>
            </div>
            <div class="results-row">
              <span class="results-row-label">Tiền gốc trả đều hàng tháng:</span>
              <span class="results-row-val" id="res-monthly-principal">0 VNĐ</span>
            </div>
            <div class="results-row">
              <span class="results-row-label">Tiền lãi tháng đầu (dư nợ giảm dần):</span>
              <span class="results-row-val" id="res-monthly-interest-first">0 VNĐ</span>
            </div>
          </div>

          <a href="javascript:void(0)" onclick="exportPaymentSchedulePDF()" class="btn-primary btn-print-schedule" style="display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            Xuất Bảng Tiến Độ Đóng Nợ (PDF)
          </a>
        </div>
      </div>

      <!-- Amortization Payment Table schedule -->
      <div class="schedule-wrapper" id="amortization-table-block">
        <!-- Mobile Table horizontal scroll pulsing visual hint badge -->
        <div class="mobile-table-hint-wrapper" style="display: none; justify-content: center; margin-bottom: 20px;">
          <div class="mobile-table-hint-pill">
            <span class="pulse-dot"></span>
            VUỐT ĐỂ XEM TIẾN ĐỘ
          </div>
        </div>

        <div class="schedule-header-row">
          <h3 class="schedule-title" id="amort-title-model">Bảng lịch thanh toán chi tiết (Dư nợ giảm dần)</h3>
          <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: var(--color-primary);">*Tiền lãi sẽ giảm dần theo số nợ gốc thực tế</span>
        </div>
        <div class="table-scroll-container">
          <table class="amort-table" id="schedule-table">
            <thead>
              <tr>
                <th>Tháng</th>
                <th>Tiền gốc (VNĐ)</th>
                <th>Tiền lãi (VNĐ)</th>
                <th>Tổng trả gốc + lãi (VNĐ)</th>
                <th>Dư nợ gốc còn lại (VNĐ)</th>
              </tr>
            </thead>
            <tbody>
              <!-- Generated Dynamically by JS -->
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Financial Calculator Disclaimer (Settings-driven) -->
      <div style="margin-top: 24px; background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255, 255, 255, 0.04); border-radius: 12px; padding: 18px 24px; font-size: 13px; line-height: 1.6; color: var(--color-text-muted);">
        <p style="margin: 0; display: flex; align-items: flex-start; gap: 8px;">
          <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--color-primary); flex-shrink: 0; margin-top: 2px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
          <span><strong>Lưu ý pháp lý:</strong> <?php echo htmlspecialchars($settings['installment_disclaimer'] ?? 'Bảng tính lãi suất trả góp chỉ mang tính chất tham khảo...'); ?></span>
        </p>
      </div>
    </div>
  </section>

  <!-- 5. EV VS GAS SAVINGS CALCULATOR SECTION -->
  <section class="savings-calculator-section" style="padding: 80px 0; border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
    <div class="container">
      <div style="text-align: center; margin-bottom: 54px;" class="reveal-on-scroll">
        <span class="section-tag" style="color: #1464f4 !important; font-weight: 700; background: rgba(20, 100, 244, 0.06); padding: 6px 16px; border-radius: 20px;">Đặc Quyền Xe Điện VinFast ⚡</span>
        <h2 class="section-title" style="color: #0f172a !important; margin-top: 16px;">BỘ TÍNH TOÁN TIẾT KIỆM NHIÊN LIỆU</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto; color: #475569 !important; max-width: 650px;">So sánh trực quan chi phí vận hành hàng tháng & tổng số tiền tiết kiệm được khi sử dụng xe điện VinFast so với xe xăng truyền thống tương đương.</p>
      </div>

      <div class="savings-grid reveal-on-scroll" style="display: grid; grid-template-columns: 1.1fr 1fr; gap: 40px; align-items: start;">
        
        <!-- Cột 1: Sliders & Cấu hình -->
        <div class="savings-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 40px 35px; box-shadow: 0 15px 35px rgba(20, 100, 244, 0.02);">
          <h3 style="font-size: 19px; font-weight: 800; color: #0f172a; margin-bottom: 30px; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; display: flex; align-items: center; gap: 12px;">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#1464f4" stroke-width="2.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            Cấu Hình Vận Hành Hàng Tháng
          </h3>
          
          <!-- Slider 1: Quãng đường di chuyển hàng tháng -->
          <div style="margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
              <span style="color: #334155; font-weight: 700; font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#64748b" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12,6 12,12 16,14"></polyline></svg>
                Quãng đường di chuyển:
              </span>
              <strong id="savings-distance-val" style="color: #1464f4; font-size: 18px; font-weight: 800; font-family: 'Outfit', sans-serif;">2.000 km</strong>
            </div>
            <input type="range" id="savings-distance-range" min="500" max="5000" step="100" value="2000" oninput="updateSavings()">
            <div style="display: flex; justify-content: space-between; font-size: 11px; color: #64748b; margin-top: 8px; font-weight: 600;">
              <span>500 km</span>
              <span>2.500 km</span>
              <span>5.000 km</span>
            </div>
          </div>

          <!-- Select 2: Phân khúc xe so sánh -->
          <div style="margin-bottom: 32px;">
            <label class="form-label" style="margin-bottom: 12px; color: #334155; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#64748b" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22,4 12,14.01 9,11.01"></polyline></svg>
              Dòng xe đối chiếu:
            </label>
            <select class="form-control" id="savings-segment-select" onchange="updateSavings()" style="width: 100%; background: #ffffff; color: #334155; border: 1px solid #cbd5e1; border-radius: 8px; height: 48px; padding: 0 16px; font-weight: 600; cursor: pointer;">
              <option value="A" selected>SUV Hạng A - Đô thị (VinFast VF 3 / VF 5 Plus)</option>
              <option value="B">SUV Hạng B - Thời thượng (VinFast VF 6)</option>
              <option value="C">SUV Hạng C - Crossover (VinFast VF 7)</option>
              <option value="D">SUV Hạng D/E - Flagship (VinFast VF 8 / VF 9)</option>
            </select>
          </div>
          
          <!-- Note -->
          <div style="background: rgba(20, 100, 244, 0.03); border-left: 4px solid #1464f4; padding: 16px; border-radius: 8px; font-size: 12px; color: #475569; line-height: 1.6; border-top: 1px solid rgba(20, 100, 244, 0.05); border-right: 1px solid rgba(20, 100, 244, 0.05); border-bottom: 1px solid rgba(20, 100, 244, 0.05);">
            💡 <strong>Phương án sạc:</strong> Đơn giá sạc của hệ thống <a href="<?php echo seo_url('tram-sac-vinfast'); ?>" style="color: #1464f4; text-decoration: underline; font-weight: 700;">trạm sạc VinFast toàn quốc</a> là <strong>3.850 VNĐ/kWh</strong>. 
            Phương án xăng tính theo giá xăng RON 95 hiện hành là <strong>23.000 VNĐ/Lít</strong>.
          </div>

          <!-- Dynamic Carbon Footprint Offset (Eco Blue Dashboard Card) -->
          <div style="margin-top: 24px; padding: 20px; background: linear-gradient(135deg, rgba(20, 100, 244, 0.02) 0%, rgba(20, 100, 244, 0.06) 100%); border: 1px solid rgba(20, 100, 244, 0.12); border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
              <span style="font-size: 16px; line-height: 1;">⚡</span>
              <h4 style="font-size: 12.5px; font-weight: 800; color: #1464f4; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Chỉ số Bảo vệ Môi trường</h4>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; border-top: 1px dashed rgba(20, 100, 244, 0.15); padding-top: 12px;">
              <div>
                <span style="display: block; font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">CO2 Giảm Thiểu</span>
                <strong style="font-size: 20px; font-weight: 900; color: #1464f4; font-family: 'Outfit', sans-serif;"><span id="savings-co2-val">240</span> kg</strong>
                <span style="display: block; font-size: 10px; color: #64748b; margin-top: 2px;">phát thải / tháng</span>
              </div>
              <div style="border-left: 1px solid rgba(20, 100, 244, 0.15); padding-left: 16px;">
                <span style="display: block; font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 4px;">Trồng Mới</span>
                <strong style="font-size: 20px; font-weight: 900; color: #1464f4; font-family: 'Outfit', sans-serif;"><span id="savings-trees-val">12</span> cây</strong>
                <span style="display: block; font-size: 10px; color: #64748b; margin-top: 2px;">xanh tự nhiên</span>
              </div>
            </div>
          </div>

        </div>

        <!-- Cột 2: Bảng so sánh & Kết quả -->
        <div class="savings-results-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: 40px 35px; box-shadow: 0 15px 35px rgba(20, 100, 244, 0.02); display: flex; flex-direction: column; gap: 28px; position: sticky; top: 100px;">
          
          <!-- Hộp kết quả to tiết kiệm 5 năm -->
          <div class="savings-display-panel">
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 4px;">
              <span class="pulse-dot" style="width: 8px; height: 8px; background-color: #2ecc71; border-radius: 50%; display: inline-block; box-shadow: 0 0 8px #2ecc71;"></span>
              <span style="font-size: 10px; font-weight: 800; color: #1464f4; text-transform: uppercase; letter-spacing: 2px;">TỔNG CHI PHÍ TIẾT KIỆM SAU 5 NĂM (60 THÁNG)</span>
            </div>
            <div id="savings-total-5yr" class="savings-gradient-text" style="animation: savingsPulse 2.5s infinite;">
              112.500.000 VNĐ
            </div>
            <p style="font-size: 12.5px; color: #475569; margin: 4px 0 0 0; line-height: 1.5; font-weight: 500;">Số tiền tiết kiệm dư sức sở hữu thêm một chiếc xe máy điện VinFast thông minh hoặc làm quỹ đầu tư cho gia đình!</p>
          </div>

          <!-- Biểu đồ chi phí hàng tháng dạng thanh -->
          <div>
            <h4 style="font-size: 13.5px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 20px; letter-spacing: 0.5px; display: flex; align-items: center; gap: 8px;">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#1464f4" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
              Chi Phí Vận Hành Hàng Tháng
            </h4>
            
            <!-- Thanh Xe Xăng -->
            <div style="margin-bottom: 20px;">
              <div style="display: flex; justify-content: space-between; font-size: 12px; color: #475569; margin-bottom: 8px; font-weight: 600;">
                <span style="display: flex; align-items: center; gap: 6px;">⛽ Chi phí Xe Xăng truyền thống:</span>
                <strong id="savings-monthly-gas" style="color: #475569; font-weight: 700;">3.490.000 VNĐ</strong>
              </div>
              <div class="meter-bar-container">
                <div id="savings-bar-gas"></div>
              </div>
            </div>

            <!-- Thanh Xe Điện VinFast -->
            <div>
              <div style="display: flex; justify-content: space-between; font-size: 12px; color: #475569; margin-bottom: 8px; font-weight: 600;">
                <span style="display: flex; align-items: center; gap: 6px; color: #1464f4; font-weight: 700;">⚡ Chi phí Xe điện VinFast:</span>
                <strong id="savings-monthly-ev" style="color: #1464f4; font-weight: 800;">1.615.000 VNĐ</strong>
              </div>
              <div class="meter-bar-container">
                <div id="savings-bar-ev"></div>
              </div>
            </div>
          </div>

          <!-- Chi tiết bảng số liệu phụ -->
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; font-size: 12.5px; color: #475569; display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; justify-content: space-between;"><span>Cước thuê pin cố định:</span><strong id="savings-detail-rental" style="color: #0f172a; font-weight: 700;">900.000 VNĐ / tháng</strong></div>
            <div style="display: flex; justify-content: space-between;"><span>Tiền điện sạc ước tính:</span><strong id="savings-detail-charging" style="color: #0f172a; font-weight: 700;">615.000 VNĐ / tháng</strong></div>
            <div style="display: flex; justify-content: space-between; border-top: 1px dashed #cbd5e1; padding-top: 10px; align-items: center;">
              <span style="font-weight: 700; color: #0f172a;">Tiết kiệm ròng hàng tháng:</span>
              <span style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 4px 10px; border-radius: 12px; font-weight: 800; font-size: 13px;" id="savings-monthly-net">1.875.000 VNĐ</span>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>
  <!-- 6. FAQ ACCORDION SECTION -->
  <section class="faq-section reveal-on-scroll">
    <div class="container">
      <div style="text-align: center; margin-bottom: 48px;">
        <span class="section-tag">FAQ - GIẢI ĐÁP THẮC MẮC</span>
        <h2 class="section-title">CÁC CÂU HỎI THƯỜNG GẶP KHI MUA TRẢ GÓP</h2>
        <p class="section-desc" style="margin-left: auto; margin-right: auto;">Giải đáp các câu hỏi phổ biến giúp quý khách nắm rõ thông tin vay mua xe trả góp chính xác nhất.</p>
      </div>

      <div class="faq-acc-container">
        <?php 
        // Streamlined: Using the pre-decoded global $faqs array from the top of the file
        foreach ($faqs as $faq):
        ?>
          <div class="faq-acc-item">
            <button class="faq-acc-trigger" onclick="toggleFaq(this)">
              <?php echo htmlspecialchars($faq['question']); ?>
              <svg class="faq-acc-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6,9 12,15 18,9"></polyline></svg>
            </button>
            <div class="faq-acc-panel">
              <div class="faq-acc-content">
                <?php echo htmlspecialchars($faq['answer']); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>


  <!-- CALCULATOR & UTILITIES JAVASCRIPT -->
  <script>
    // Automatically apply selected car to the calculator and smooth scroll to it
    function applyShowcaseCar(carName) {
      const selectEl = document.getElementById('calc-car-select');
      if (!selectEl) return;
      
      let foundIndex = -1;
      for (let i = 0; i < selectEl.options.length; i++) {
        const optText = selectEl.options[i].text.toLowerCase();
        const optName = selectEl.options[i].getAttribute('data-name').toLowerCase();
        if (optText.includes(carName.toLowerCase()) || 
            optName.includes(carName.toLowerCase()) || 
            carName.toLowerCase().includes(optText) || 
            carName.toLowerCase().includes(optName)) {
          foundIndex = i;
          break;
        }
      }
      
      if (foundIndex !== -1) {
        selectEl.selectedIndex = foundIndex;
        updateCalculator();
        
        // Smooth scroll to calculator section
        document.getElementById('loan-calculator').scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }

    // Scroll Reveal & Fuel Savings Counter Roll Animation
    document.addEventListener('DOMContentLoaded', function() {
      const revealElements = document.querySelectorAll('.reveal-on-scroll');
      
      const observerOptions = {
        root: null,
        threshold: 0.1,
        rootMargin: '0px 0px -40px 0px'
      };
      
      const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
            
            // If the savings grid is revealed, trigger the animated count-up
            if (entry.target.classList.contains('savings-grid')) {
              triggerSavingsCountUp();
            }
            
            observer.unobserve(entry.target);
          }
        });
      }, observerOptions);
      
      revealElements.forEach(el => {
        revealObserver.observe(el);
      });
    });

    let savingsCountedUp = false;
    function triggerSavingsCountUp() {
      if (savingsCountedUp) return;
      savingsCountedUp = true;
      
      const totalDisplay = document.getElementById('savings-total-5yr');
      if (!totalDisplay) return;

      const distanceInput = document.getElementById('savings-distance-range');
      const segmentInput = document.getElementById('savings-segment-select');
      if (!distanceInput || !segmentInput) return;

      const distance = parseInt(distanceInput.value);
      const segment = segmentInput.value;

      const gasConsumption = { 'A': 6.5, 'B': 7.5, 'C': 8.5, 'D': 9.5 };
      const evConsumption = { 'A': 12, 'B': 14, 'C': 16, 'D': 18 };
      const evRental = { 'A': 900000, 'B': 1400000, 'C': 1800000, 'D': 2200000 };
      const gasPrice = 23000;
      const electricityPrice = 3850;

      const gasCostPerKm = (gasConsumption[segment] * gasPrice) / 100;
      const totalGasMonthly = distance * (gasCostPerKm + 300);

      const evCostPerKm = (evConsumption[segment] * electricityPrice) / 100;
      const totalEvMonthly = distance * (evCostPerKm + 100) + evRental[segment];

      const monthlySavings = Math.max(0, totalGasMonthly - totalEvMonthly);
      const finalTarget = monthlySavings * 60;

      // Animate rolling number from 0 to target
      let startTimestamp = null;
      const duration = 1500; // 1.5 seconds
      
      function step(timestamp) {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const currentVal = Math.floor(progress * finalTarget);
        
        totalDisplay.innerText = currentVal.toLocaleString('vi-VN') + ' VNĐ';
        
        if (progress < 1) {
          window.requestAnimationFrame(step);
        } else {
          totalDisplay.innerText = finalTarget.toLocaleString('vi-VN') + ' VNĐ';
        }
      }
      
      window.requestAnimationFrame(step);
    }

    // Interactive Fuel Savings Calculator Logic
    function updateSavings() {
      const distanceInput = document.getElementById('savings-distance-range');
      const segmentInput = document.getElementById('savings-segment-select');
      if (!distanceInput || !segmentInput) return;

      const distance = parseInt(distanceInput.value);
      const segment = segmentInput.value;

      // Update distance label display
      document.getElementById('savings-distance-val').innerText = distance.toLocaleString('vi-VN') + ' km';

      // Update slider track background fill dynamically
      const sliderPct = ((distance - 500) / (5000 - 500)) * 100;
      distanceInput.style.background = `linear-gradient(to right, #1464f4 0%, #1464f4 ${sliderPct}%, #cbd5e1 ${sliderPct}%, #cbd5e1 100%)`;

      // Consumption ratios (Gas consumption L/100km, EV consumption kWh/100km, Battery Rental VND/month)
      const gasConsumption = { 'A': 6.5, 'B': 7.5, 'C': 8.5, 'D': 9.5 };
      const evConsumption = { 'A': 12, 'B': 14, 'C': 16, 'D': 18 };
      const evRental = { 'A': 900000, 'B': 1400000, 'C': 1800000, 'D': 2200000 };

      const gasPrice = 23000;       // RON 95 Petrol Price VND/L
      const electricityPrice = 3850; // VinFast Charging Price VND/kWh

      // 1. Gas cost calculation (fuel cost + maintenance/oil check factor)
      const gasCostPerKm = (gasConsumption[segment] * gasPrice) / 100;
      const gasMaintenance = 300; // Extra maintenance factor for petrol engines
      const totalGasMonthly = distance * (gasCostPerKm + gasMaintenance);

      // 2. EV cost calculation (charging cost + battery rental + low maintenance factor)
      const evCostPerKm = (evConsumption[segment] * electricityPrice) / 100;
      const evMaintenance = 100; // EV maintenance is extremely low
      const evChargingMonthly = distance * (evCostPerKm + evMaintenance);
      const evRentalMonthly = evRental[segment];
      const totalEvMonthly = evChargingMonthly + evRentalMonthly;

      // 3. Difference and Savings calculations
      const monthlySavings = Math.max(0, totalGasMonthly - totalEvMonthly);
      const fiveYearSavings = monthlySavings * 60;

      // Helper function to format currency VND
      function formatVndSimple(val) {
        return Math.round(val).toLocaleString('vi-VN') + ' VNĐ';
      }

      // Update UI elements
      document.getElementById('savings-monthly-gas').innerText = formatVndSimple(totalGasMonthly);
      document.getElementById('savings-monthly-ev').innerText = formatVndSimple(totalEvMonthly);
      document.getElementById('savings-detail-rental').innerText = formatVndSimple(evRentalMonthly) + ' / tháng';
      document.getElementById('savings-detail-charging').innerText = formatVndSimple(evChargingMonthly) + ' / tháng';
      document.getElementById('savings-monthly-net').innerText = formatVndSimple(monthlySavings);
      document.getElementById('savings-total-5yr').innerText = formatVndSimple(fiveYearSavings);

      // Update comparison bars
      const maxVal = Math.max(totalGasMonthly, totalEvMonthly);
      const gasPct = (totalGasMonthly / maxVal) * 100;
      const evPct = (totalEvMonthly / maxVal) * 100;

      document.getElementById('savings-bar-gas').style.width = gasPct + '%';
      document.getElementById('savings-bar-ev').style.width = evPct + '%';

      // Update environmental offsets dynamically
      const co2Val = Math.round(distance * 0.12);
      const treesVal = Math.round(co2Val / 20);
      const co2El = document.getElementById('savings-co2-val');
      const treesEl = document.getElementById('savings-trees-val');
      if (co2El) co2El.innerText = co2Val.toLocaleString('vi-VN');
      if (treesEl) treesEl.innerText = Math.max(1, treesVal).toLocaleString('vi-VN');
    }

    // Run calculations once DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
      updateSavings();
    });

    // Format numbers as VND currency format
    function formatVnd(num) {
      return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(num).replace('₫', 'VNĐ');
    }

    // Toggle FAQ Accordion Panels
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

    // Switch Checklist Tab
    function switchChecklistTab(tabName, btn) {
      // Toggle button classes
      const btns = btn.parentElement.querySelectorAll('.tab-btn');
      btns.forEach(b => b.classList.remove('tab-btn--active'));
      btn.classList.add('tab-btn--active');

      // Toggle content panels
      const panels = document.querySelectorAll('.tab-content-panel');
      panels.forEach(p => p.classList.remove('tab-content-panel--active'));
      
      if (tabName === 'personal') {
        document.getElementById('tab-personal').classList.add('tab-content-panel--active');
      } else {
        document.getElementById('tab-business').classList.add('tab-content-panel--active');
      }
    }

    // Dynamic Financial Calculator logic (Gốc chia đều, Lãi tính trên dư nợ giảm dần)
    function updateCalculator() {
      const selectEl = document.getElementById('calc-car-select');
      const carPrice = parseFloat(selectEl.value);
      const activeOption = selectEl.options[selectEl.selectedIndex];
      const carName = activeOption.getAttribute('data-name');
      
      // Get values from inputs
      const dpPct = parseFloat(document.getElementById('range-dp-pct').value);
      const termMonths = parseInt(document.getElementById('range-term').value);
      const annualRate = parseFloat(document.getElementById('range-rate').value);

      // Update dynamic car preview image
      const carImage = activeOption.getAttribute('data-image');
      const imgEl = document.getElementById('calc-car-image');
      if (imgEl && carImage) {
        if (imgEl.src !== carImage) {
          imgEl.style.opacity = 0;
          imgEl.style.transform = 'scale(0.92) translateY(5px)';
          setTimeout(() => {
            imgEl.src = carImage;
            imgEl.style.opacity = 1;
            imgEl.style.transform = 'scale(1) translateY(0)';
          }, 150);
        } else {
          imgEl.style.opacity = 1;
          imgEl.style.transform = 'scale(1) translateY(0)';
        }
      }
      
      // Update dynamic car badge based on fuel type (EV pure electric vs gasoline engine)
      const badgeEl = document.getElementById('calc-car-badge');
      if (badgeEl) {
        if (carName.toLowerCase().includes('EV')) {
          badgeEl.innerText = 'Pure Electric EV';
          badgeEl.style.color = '#00e5ff';
          badgeEl.style.borderColor = 'rgba(0, 229, 255, 0.4)';
        } else {
          badgeEl.innerText = 'VinFast Động cơ Xăng AWD';
          badgeEl.style.color = 'var(--color-primary)';
          badgeEl.style.borderColor = 'rgba(25, 96, 215, 0.4)';
        }
      }

      // Update dynamic range input track backgrounds
      const dpPctSlider = document.getElementById('range-dp-pct');
      const termSlider = document.getElementById('range-term');
      const rateSlider = document.getElementById('range-rate');
      
      const updateTrack = (slider) => {
        const percentage = ((slider.value - slider.min) / (slider.max - slider.min)) * 100;
        slider.style.background = `linear-gradient(to right, var(--color-primary) 0%, var(--color-primary) ${percentage}%, var(--color-border) ${percentage}%, var(--color-border) 100%)`;
      };
      
      updateTrack(dpPctSlider);
      updateTrack(termSlider);
      updateTrack(rateSlider);

      // Update labels dynamically
      document.getElementById('val-dp-pct').innerText = dpPct + "%";
      document.getElementById('val-term').innerText = termMonths + " tháng (" + (termMonths/12) + " năm)";
      document.getElementById('val-rate').innerText = annualRate.toFixed(1) + "% / năm";

      // Math calculations
      const dpAmount = carPrice * (dpPct / 100);
      const loanAmount = carPrice - dpAmount;
      const monthlyPrincipal = loanAmount / termMonths;
      const monthlyRate = (annualRate / 100) / 12;
      const interestFirstMonth = loanAmount * monthlyRate;
      const totalFirstMonth = monthlyPrincipal + interestFirstMonth;

      // Update UI panel fields
      document.getElementById('res-car-price').innerText = formatVnd(carPrice);
      document.getElementById('res-dp-amount').innerText = formatVnd(dpAmount);
      document.getElementById('res-loan-amount').innerText = formatVnd(loanAmount);
      document.getElementById('res-monthly-principal').innerText = formatVnd(monthlyPrincipal);
      document.getElementById('res-monthly-interest-first').innerText = formatVnd(interestFirstMonth);
      document.getElementById('res-monthly-first').innerText = formatVnd(totalFirstMonth);

      // Update table title
      document.getElementById('amort-title-model').innerText = "Bảng tiến độ đóng nợ: " + carName;

      // Populate Amortization table dynamically
      const tbody = document.querySelector('#schedule-table tbody');
      tbody.innerHTML = ''; // Reset

      let remainingBalance = loanAmount;
      
      for (let i = 1; i <= termMonths; i++) {
        const monthlyInterest = remainingBalance * monthlyRate;
        const totalPayment = monthlyPrincipal + monthlyInterest;
        remainingBalance -= monthlyPrincipal;
        if (remainingBalance < 0) remainingBalance = 0;

        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>Tháng thứ ${i}</td>
          <td>${formatVnd(monthlyPrincipal)}</td>
          <td>${formatVnd(monthlyInterest)}</td>
          <td style="color: var(--color-primary); font-weight: 600;">${formatVnd(totalPayment)}</td>
          <td>${formatVnd(remainingBalance)}</td>
        `;
        tbody.appendChild(tr);
      }
    }

    // Quick Form submit handler
    function handleLeadSubmit(event) {
      event.preventDefault();
      const name = document.getElementById('lead-name').value;
      const phone = document.getElementById('lead-phone').value;
      const carSelect = document.getElementById('lead-car');
      const carId = carSelect.value;
      const carName = carSelect.options[carSelect.selectedIndex].text;
      const websiteUrl = document.getElementById('lead-website_url').value;
      
      const submitBtn = event.target.querySelector('.btn-submit-lead');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerText = "Đang xử lý...";
      }

      // Send to ajax lead handler
      const formData = new FormData();
      formData.append('fullname', name);
      formData.append('phone', phone);
      formData.append('car_id', carId);
      formData.append('loc_name', 'Trang trả góp');
      formData.append('loc_slug', 'tra-gop');
      formData.append('website_url', websiteUrl);

      fetch('<?php echo seo_url("ajax-vip-lead.php"); ?>', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerText = "Gửi yêu cầu dự toán";
        }
        if (data.success) {
          alert("Cám ơn quý khách " + name + "! Yêu cầu lập dự toán trả góp cho dòng xe " + carName + " đã được gửi thành công. Đội ngũ chuyên viên tài chính đại lý VinFast sẽ gửi bảng chiết tính lãi suất qua Zalo/SĐT: " + phone + " trong ít phút.");
          document.getElementById('lead-name').value = '';
          document.getElementById('lead-phone').value = '';
        } else {
          alert(data.message || "Có lỗi xảy ra, vui lòng thử lại.");
        }
      })
      .catch(err => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerText = "Gửi yêu cầu dự toán";
        }
        alert("Không thể kết nối máy chủ. Vui lòng thử lại sau!");
      });
    }

    // Populate print template and trigger high-fidelity browser PDF print
    function exportPaymentSchedulePDF() {
      const selectEl = document.getElementById('calc-car-select');
      const carPrice = parseFloat(selectEl.value);
      const activeOption = selectEl.options[selectEl.selectedIndex];
      const carName = activeOption.getAttribute('data-name');
      
      const dpPct = parseFloat(document.getElementById('range-dp-pct').value);
      const termMonths = parseInt(document.getElementById('range-term').value);
      const annualRate = parseFloat(document.getElementById('range-rate').value);

      const dpAmount = carPrice * (dpPct / 100);
      const loanAmount = carPrice - dpAmount;
      const monthlyPrincipal = loanAmount / termMonths;
      const monthlyRate = (annualRate / 100) / 12;
      const interestFirstMonth = loanAmount * monthlyRate;
      const totalFirstMonth = monthlyPrincipal + interestFirstMonth;

      const agencyName = "<?php echo htmlspecialchars($agencyName); ?>";
      const agencyAddress = "<?php echo htmlspecialchars($agencyAddress); ?>";
      const agencyPhone = "<?php echo htmlspecialchars($agencyPhone); ?>";

      // 1. Populate dynamic branded details
      document.getElementById('print-agency-name').innerText = agencyName;
      document.getElementById('print-agency-address').innerText = agencyAddress;
      document.getElementById('print-agency-phone').innerText = agencyPhone;

      document.getElementById('print-car-name').innerText = carName;
      document.getElementById('print-car-price').innerText = formatVnd(carPrice);
      document.getElementById('print-dp-pct').innerText = dpPct + "%";
      document.getElementById('print-dp-amount').innerText = formatVnd(dpAmount);
      document.getElementById('print-loan-amount').innerText = formatVnd(loanAmount);
      document.getElementById('print-term').innerText = termMonths + " tháng (" + (termMonths/12) + " năm)";
      document.getElementById('print-rate').innerText = annualRate.toFixed(1) + "% / năm";
      document.getElementById('print-monthly-principal').innerText = formatVnd(monthlyPrincipal);
      document.getElementById('print-monthly-first').innerHTML = `${formatVnd(totalFirstMonth)} <span style="font-size: 10px; font-weight: 500; color: #4b5563;">(Gốc: ${formatVnd(monthlyPrincipal)} + Lãi đầu: ${formatVnd(interestFirstMonth)})</span>`;

      // 2. Generate table rows for the printable vector table
      const tbody = document.querySelector('#print-schedule-table tbody');
      tbody.innerHTML = ''; // Reset
      
      let remainingBalance = loanAmount;
      for (let i = 1; i <= termMonths; i++) {
        const monthlyInterest = remainingBalance * monthlyRate;
        const totalPayment = monthlyPrincipal + monthlyInterest;
        remainingBalance -= monthlyPrincipal;
        if (remainingBalance < 0) remainingBalance = 0;

        const tr = document.createElement('tr');
        tr.style.borderBottom = '1px solid #e5e7eb';
        if (i % 2 === 0) {
          tr.style.backgroundColor = '#f9fafb';
        }
        
        tr.innerHTML = `
          <td style="padding: 9px 12px; font-size: 11px; text-align: center; color: #374151; font-weight: 600;">Tháng ${i}</td>
          <td style="padding: 9px 12px; font-size: 11px; text-align: right; color: #1f2937;">${formatVnd(monthlyPrincipal)}</td>
          <td style="padding: 9px 12px; font-size: 11px; text-align: right; color: #1f2937;">${formatVnd(monthlyInterest)}</td>
          <td style="padding: 9px 12px; font-size: 11px; text-align: right; color: #b78a28; font-weight: 700;">${formatVnd(totalPayment)}</td>
          <td style="padding: 9px 12px; font-size: 11px; text-align: right; color: #4b5563;">${formatVnd(remainingBalance)}</td>
        `;
        tbody.appendChild(tr);
      }

      // 3. Trigger native print dialog which provides perfect, vector PDF export (Save as PDF)
      window.print();
    }

    // Initialize calculator
    window.addEventListener('DOMContentLoaded', () => {
      updateCalculator();
    });
  </script>

  <!-- DEDICATED VECTOR A4 PRINT / PDF BLOCK -->

  <div id="print-schedule-a4-block">
    <!-- PDF Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #b78a28; padding-bottom: 18px; margin-bottom: 24px;">
      <div>
        <h2 style="font-size: 22px; font-weight: 800; letter-spacing: 2px; color: #000000; margin: 0; text-transform: uppercase;">VinFast VIỆT NAM</h2>
        <p style="font-size: 11px; color: #4b5563; margin: 4px 0 0 0; font-weight: 600;">Đại lý ủy quyền chính thức - <span id="print-agency-name"></span></p>
        <p style="font-size: 10px; color: #6b7280; margin: 2px 0 0 0; line-height: 1.4;">Địa chỉ: <span id="print-agency-address"></span></p>
      </div>
      <div style="text-align: right; min-width: 140px;">
        <div style="font-size: 11px; font-weight: 700; color: #b78a28; text-transform: uppercase; letter-spacing: 1px;">HOTLINE HỖ TRỢ</div>
        <div style="font-size: 17px; font-weight: 800; color: #000000; margin-top: 3px;" id="print-agency-phone"></div>
        <div style="font-size: 9px; color: #6b7280; margin-top: 2px; font-style: italic;">Hỗ trợ tư vấn giải ngân 24/7</div>
      </div>
    </div>

    <!-- Document Title -->
    <div style="text-align: center; margin-bottom: 25px;">
      <h2 style="font-size: 22px; font-weight: 800; color: #000000; margin: 0; letter-spacing: 1.5px; text-transform: uppercase;">BẢNG TIẾN ĐỘ ĐÓNG NỢ XE VinFast</h2>
      <p style="font-size: 11px; color: #4b5563; margin: 6px 0 0 0; font-weight: 500; font-style: italic;">(Bảng dự toán chi tiết phương án trả góp lãi suất ưu đãi ngân hàng)</p>
    </div>

    <!-- Overview Details Table -->
    <div style="margin-bottom: 28px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px;">
      <h3 style="font-size: 13.5px; font-weight: 700; color: #000000; margin: 0 0 15px 0; border-left: 3px solid #b78a28; padding-left: 10px; text-transform: uppercase; letter-spacing: 0.5px;">THÔNG TIN PHƯƠNG ÁN TÀI CHÍNH</h3>
      
      <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
        <tr>
          <td style="width: 25%; padding: 8px 0; color: #4b5563; font-weight: 500;">Dòng xe chọn mua:</td>
          <td style="width: 25%; padding: 8px 0; color: #000000; font-weight: 700;" id="print-car-name"></td>
          <td style="width: 25%; padding: 8px 0; color: #4b5563; font-weight: 500;">Giá niêm yết xe:</td>
          <td style="width: 25%; padding: 8px 0; color: #000000; font-weight: 700; text-align: right;" id="print-car-price"></td>
        </tr>
        <tr style="border-top: 1px dashed #e5e7eb;">
          <td style="padding: 8px 0; color: #4b5563; font-weight: 500;">Tỷ lệ trả trước ban đầu:</td>
          <td style="padding: 8px 0; color: #000000; font-weight: 700;" id="print-dp-pct"></td>
          <td style="padding: 8px 0; color: #4b5563; font-weight: 500;">Đối ứng trả trước:</td>
          <td style="padding: 8px 0; color: #b78a28; font-weight: 700; text-align: right;" id="print-dp-amount"></td>
        </tr>
        <tr style="border-top: 1px dashed #e5e7eb;">
          <td style="padding: 8px 0; color: #4b5563; font-weight: 500;">Hạn mức vay ngân hàng:</td>
          <td style="padding: 8px 0; color: #2563eb; font-weight: 700;" id="print-loan-amount"></td>
          <td style="padding: 8px 0; color: #4b5563; font-weight: 500;">Thời gian vay góp:</td>
          <td style="padding: 8px 0; color: #000000; font-weight: 700; text-align: right;" id="print-term"></td>
        </tr>
        <tr style="border-top: 1px dashed #e5e7eb;">
          <td style="padding: 8px 0; color: #4b5563; font-weight: 500;">Lãi suất áp dụng:</td>
          <td style="padding: 8px 0; color: #000000; font-weight: 700;" id="print-rate"></td>
          <td style="padding: 8px 0; color: #4b5563; font-weight: 500;">Tiền gốc đóng hàng tháng:</td>
          <td style="padding: 8px 0; color: #000000; font-weight: 700; text-align: right;" id="print-monthly-principal"></td>
        </tr>
        <tr style="border-top: 1px dashed #e5e7eb; background-color: #eff6ff;">
          <td style="padding: 10px 8px; color: #000000; font-weight: 700;">Thanh toán tháng đầu tiên:</td>
          <td colspan="3" style="padding: 10px 8px; color: #b78a28; font-weight: 800; text-align: right; font-size: 13.5px;" id="print-monthly-first"></td>
        </tr>
      </table>
    </div>

    <!-- Schedule Title inside PDF -->
    <h3 style="font-size: 13.5px; font-weight: 700; color: #000000; margin: 0 0 10px 0; border-left: 3px solid #b78a28; padding-left: 10px; text-transform: uppercase; letter-spacing: 0.5px;">BẢNG CHI TIẾT TIẾN ĐỘ THANH TOÁN (DƯ NỢ GIẢM DẦN)</h3>
    <p style="font-size: 10px; color: #6b7280; margin: -5px 0 16px 0; font-style: italic;">*Tiền lãi sẽ được ngân hàng giảm trừ dần theo số dư nợ gốc thực tế còn lại.</p>

    <!-- Dynamic Amortization Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;" id="print-schedule-table">
      <thead>
        <tr style="background-color: #111827; color: #ffffff; border-bottom: 2px solid #b78a28;">
          <th style="padding: 11px 8px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; width: 15%;">Kỳ Trả Nợ</th>
          <th style="padding: 11px 8px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 20%;">Tiền Gốc (A)</th>
          <th style="padding: 11px 8px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 20%;">Tiền Lãi (B)</th>
          <th style="padding: 11px 8px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 25%; color: #f59e0b;">Thanh Toán (A+B)</th>
          <th style="padding: 11px 8px; font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 20%;">Dư Nợ Còn Lại</th>
        </tr>
      </thead>
      <tbody>
        <!-- JS injected rows -->
      </tbody>
    </table>

    <!-- Luxury Footer & Disclaimers -->
    <div style="border-top: 1px solid #e5e7eb; padding-top: 18px; font-size: 9.5px; color: #4b5563; line-height: 1.6;">
      <p style="margin: 0 0 6px 0; font-weight: bold; color: #111827; text-transform: uppercase; letter-spacing: 0.5px;">* QUY ĐỊNH & PHƯƠNG ÁN GIAO DỊCH:</p>
      <p style="margin: 0 0 5px 0;">1. <?php echo htmlspecialchars($settings['installment_disclaimer'] ?? 'Bảng tiến độ đóng nợ trên đây mang tính chất dự toán lập kế hoạch dòng tiền. Lãi suất ưu đãi và các kỳ hạn cụ thể sẽ theo quy chuẩn và sự chấp thuận chính thức từ ngân hàng đối tác liên kết tại thời điểm giải ngân hồ sơ.'); ?></p>
      <p style="margin: 0 0 15px 0;">2. Để cập nhật báo giá lăn bánh hoàn chỉnh bao gồm bảo hiểm, phí biển số và nhận các chương trình ưu đãi lãi suất độc quyền hiện hành, Quý khách vui lòng liên hệ Hotline tư vấn: <strong style="color: #000000;"><?php echo htmlspecialchars($agencyPhone); ?></strong> hoặc kết nối trực tiếp với Cố vấn trực tuyến.</p>
      
      <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px dashed #e5e7eb; padding-top: 12px;">
        <div>
          <span style="font-size: 10px; font-weight: 800; color: #000000; letter-spacing: 1px;">VinFast VIỆT NAM</span>
        </div>
        <div>
          <span style="font-size: 10px; color: #b78a28; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Sự hài lòng của Quý khách là sứ mệnh của chúng tôi</span>
        </div>
      </div>
    </div>
  </div>





