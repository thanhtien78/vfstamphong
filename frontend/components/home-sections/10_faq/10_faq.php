<!-- SECTION 11: DIGITAL FAQ ACCORDION (Đã đẩy xuống vị trí 11) - DUAL COLUMN EDITORIAL GRID -->
<section class="faq-section" id="faq-block">
  <style>
    /* Luxury Light Porcelain Theme for FAQ Section matching overall luxury aesthetics */
    .faq-section {
      border-top: none;
      margin-top: 0;
      background: radial-gradient(circle at 50% 20%, #ecfdf5 0%, #ffffff 80%) !important; /* Bottom spotlight aura */
      padding: 80px 0;
    }
    .faq-split-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: stretch; /* Stretch columns to align bottoms perfectly */
    }
    .faq-editorial-block {
      display: flex;
      flex-direction: column;
      gap: 24px;
      height: 100%;
      justify-content: space-between; /* Stretches left block to balance the height of right FAQs */
    }
    .faq-editorial-title {
      font-size: 32px;
      font-weight: 850;
      color: #059669 !important; /* Rich green titles */
      line-height: 1.2;
      font-family: 'Montserrat', sans-serif;
    }
    .faq-editorial-desc {
      font-size: 14.5px;
      line-height: 1.65;
      color: #475569 !important; /* Readable charcoal gray */
      font-family: 'Montserrat', sans-serif;
      margin: 0;
    }
    .faq-editorial-visual {
      background: rgba(255, 255, 255, 0.88) !important; /* Glass container */
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(16, 185, 129, 0.15) !important;
      border-radius: 16px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      gap: 24px;
      box-shadow: 0 15px 35px rgba(15, 23, 42, 0.02) !important;
      flex-grow: 1; /* Stretch to fill space */
      justify-content: center;
    }
    .faq-radar-container {
      background: rgba(16, 185, 129, 0.03) !important; /* Light tech screen background */
      border: 1px solid rgba(16, 185, 129, 0.15) !important;
      border-radius: 12px;
      position: relative;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      overflow: hidden;
      box-shadow: inset 0 0 20px rgba(16, 185, 129, 0.05) !important;
    }
    .faq-radar-svg {
      position: relative;
      z-index: 2;
      animation: faq-radar-pulse 4s ease-in-out infinite;
      height: 200px; /* Taller on desktop for perfect vertical balance */
    }
    @keyframes faq-radar-pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.02); }
    }
    .radar-sweep-line {
      transform-origin: 100px 100px;
      animation: radar-sweep 6s linear infinite;
    }
    @keyframes radar-sweep {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .radar-orbit-1 {
      transform-origin: 100px 100px;
      animation: radar-spin-reverse 12s linear infinite;
    }
    @keyframes radar-spin-reverse {
      from { transform: rotate(360deg); }
      to { transform: rotate(0deg); }
    }
    .radar-orbit-2 {
      transform-origin: 100px 100px;
      animation: radar-spin-forward 16s linear infinite;
    }
    @keyframes radar-spin-forward {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .faq-radar-readout {
      display: flex;
      justify-content: space-between;
      width: 100%;
      margin-top: 12px;
      padding: 0 5px;
    }
    .readout-item {
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .faq-editorial-visual .readout-label {
      color: #059669 !important; /* Rich Green Tech */
      font-weight: 700 !important;
      font-size: 9px;
      letter-spacing: 0.5px;
      opacity: 1 !important;
      font-family: monospace;
    }
    .readout-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      display: inline-block;
    }
    .pulse-green {
      background: #10b981;
      box-shadow: 0 0 8px #10b981;
      animation: faq-core-pulse 1.8s infinite;
    }
    @keyframes faq-core-pulse {
      0%, 100% { transform: scale(1); opacity: 0.8; }
      50% { transform: scale(1.3); opacity: 1; box-shadow: 0 0 14px #10b981; }
    }
    .faq-visual-icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(16, 185, 129, 0.06);
      border: 1px solid rgba(16, 185, 129, 0.2);
      color: #059669;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .faq-cta-row {
      display: flex;
      gap: 16px;
      width: 100%;
    }
    .faq-btn-hotline, .faq-btn-zalo {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 12px 20px;
      border-radius: 30px; /* Pill layout matching design themes */
      font-size: 12px;
      font-weight: 800;
      text-decoration: none;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: all 0.3s ease;
      flex: 1;
      font-family: 'Montserrat', sans-serif;
    }
    .faq-btn-hotline {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      color: #ffffff !important;
      border: none !important;
      box-shadow: 0 4px 15px -3px rgba(16, 185, 129, 0.3) !important;
    }
    .faq-btn-hotline:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
      transform: translateY(-2px) !important;
      box-shadow: 0 8px 20px -3px rgba(16, 185, 129, 0.5) !important;
    }
    .faq-btn-zalo {
      background: linear-gradient(135deg, #0066ff 0%, #0099ff 100%) !important;
      color: #ffffff !important;
      border: none !important;
      box-shadow: 0 4px 15px -3px rgba(0, 102, 255, 0.3) !important;
    }
    .faq-btn-zalo:hover {
      background: linear-gradient(135deg, #059669 0%, #0088ff 100%) !important;
      transform: translateY(-2px) !important;
      box-shadow: 0 8px 20px -3px rgba(0, 102, 255, 0.5) !important;
    }
    
    /* FAQ Accordion list style */
    .faq-list-block {
      display: flex;
      flex-direction: column;
      gap: 16px;
      justify-content: space-between;
    }
    .faq-item {
      background: rgba(255, 255, 255, 0.88) !important;
      backdrop-filter: blur(10px) !important;
      -webkit-backdrop-filter: blur(10px) !important;
      border: 1px solid rgba(16, 185, 129, 0.1) !important;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(15, 23, 42, 0.01) !important;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .faq-item:hover {
      border-color: #10b981 !important;
      box-shadow: 0 8px 24px rgba(16, 185, 129, 0.05) !important;
    }
    .faq-item--active {
      background: #ffffff !important;
      border-color: #10b981 !important;
      box-shadow: 0 15px 35px rgba(16, 185, 129, 0.06) !important;
    }
    .faq-trigger {
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 22px 28px;
      background: transparent;
      border: none;
      outline: none;
      cursor: pointer;
      text-align: left;
      transition: background-color 0.25s ease;
    }
    .faq-question-wrap {
      display: flex;
      align-items: center;
      gap: 16px;
      font-size: 15px;
      font-weight: 750;
      color: #0f172a !important; /* Crisp deep slate questions */
      font-family: 'Montserrat', sans-serif;
    }
    .faq-num-badge {
      font-family: 'Montserrat', sans-serif;
      color: #059669 !important;
      font-size: 12px;
      font-weight: 800;
      background: rgba(16, 185, 129, 0.06) !important;
      border: 1px solid rgba(16, 185, 129, 0.2) !important;
      padding: 3px 8px;
      border-radius: 6px;
    }
    .faq-icon-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: rgba(16, 185, 129, 0.05) !important;
      border: 1px solid rgba(16, 185, 129, 0.15) !important;
      color: #059669 !important;
      transition: all 0.3s ease;
    }
    .faq-item--active .faq-icon-wrap {
      background: #10b981 !important;
      border-color: #10b981 !important;
      color: #ffffff !important;
      transform: rotate(45deg);
    }
    .faq-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .faq-item--active .faq-content {
      max-height: 500px;
    }
    .faq-content-inner {
      padding: 0 28px 24px 28px;
      font-size: 14px;
      line-height: 1.7;
      color: #475569 !important; /* High-contrast readable gray */
      font-weight: 600 !important;
      font-family: 'Montserrat', sans-serif;
    }
    
    /* FAQ Mobile Split Fix */
    @media (max-width: 768px) {
      .faq-section {
        padding: 40px 15px !important;
      }
      .faq-split-container {
        display: flex !important;
        flex-direction: column !important;
        gap: 30px !important;
        width: 100% !important;
      }
      .faq-editorial-block,
      .faq-list-block {
        width: 100% !important;
        max-width: 100% !important;
      }
      .faq-editorial-title {
        font-size: 24px !important;
        line-height: 1.3 !important;
        text-align: center !important;
      }
      .faq-editorial-desc {
        font-size: 13.5px !important;
        line-height: 1.6 !important;
        text-align: center !important;
      }
      .faq-radar-svg {
        height: 160px !important; /* Mobile friendly height */
      }
      .faq-trigger {
        padding: 18px 18px !important;
      }
      .faq-question-wrap {
        font-size: 14px !important;
      }
      .faq-content-inner {
        padding: 0 18px 18px 18px !important;
        font-size: 13px !important;
        line-height: 1.6 !important;
      }
      .faq-cta-row {
        flex-direction: column !important;
        gap: 12px !important;
      }
    }
  </style>

  <div class="container">
    <div class="faq-split-container">
      
      <!-- Cột trái: Brand Editorial info + Radar Scanner (Correct position!) -->
      <div class="faq-editorial-block">
        <div class="section-header faq-mobile-center-header" style="margin-bottom: 0; padding-bottom: 0; text-align: left;">
          <span class="section-tag" style="background: #c5a059 !important; border: 1px solid rgba(197, 160, 89, 0.3) !important; color: #ffffff !important; box-shadow: 0 2px 10px rgba(197, 160, 89, 0.1) !important;">Góc tư vấn</span>
          <h2 class="faq-editorial-title">Giải Đáp Câu Hỏi Về<br>Đại lý VinFast Tam Phong</h2>
        </div>
        <p class="faq-editorial-desc">
          Đội ngũ cố vấn kỹ thuật và chuyên viên tư vấn của Đại lý VinFast Tam Phong luôn sẵn sàng giải thích cặn kẽ mọi câu hỏi thường gặp của anh/chị về các dòng xe ô tô điện VinFast, bảng giá xe VinFast, chế độ sạc nhanh, chính sách bảo hành dài hạn và hỗ trợ tài chính trả góp ưu đãi.
        </p>
        <div class="faq-editorial-visual">
          <!-- Animated Futuristic Radar Scanner -->
          <div class="faq-radar-container">
            <svg class="faq-radar-svg" viewBox="0 0 200 200" width="100%">
              <!-- Grid background -->
              <line x1="0" y1="100" x2="200" y2="100" stroke="rgba(16, 185, 129, 0.08)" stroke-width="1" />
              <line x1="100" y1="0" x2="100" y2="200" stroke="rgba(16, 185, 129, 0.08)" stroke-width="1" />
              
              <!-- Rotating concentric rings -->
              <circle cx="100" cy="100" r="80" stroke="rgba(16, 185, 129, 0.15)" stroke-width="1" fill="none" />
              <circle class="radar-orbit-1" cx="100" cy="100" r="65" stroke="rgba(16, 185, 129, 0.25)" stroke-width="1" stroke-dasharray="4 8" fill="none" />
              <circle class="radar-orbit-2" cx="100" cy="100" r="45" stroke="rgba(16, 185, 129, 0.3)" stroke-width="1" stroke-dasharray="12 6" fill="none" />
              <circle cx="100" cy="100" r="25" stroke="rgba(16, 185, 129, 0.2)" stroke-width="1" fill="none" />
              
              <!-- Pulsing scanning radar line -->
              <line class="radar-sweep-line" x1="100" y1="100" x2="100" y2="20" stroke="#10b981" stroke-width="1.8" stroke-linecap="round" opacity="0.8" />
              
              <!-- Core pulsing glowing dot -->
              <circle class="radar-core-glow" cx="100" cy="100" r="5" fill="#10b981" />
            </svg>
            
            <!-- Tech overlay readouts (Telemetry and System Online) -->
            <div class="faq-radar-readout">
              <div class="readout-item">
                <span class="readout-dot pulse-green"></span>
                <span class="readout-label">SYSTEM ONLINE</span>
              </div>
              <div class="readout-item">
                <span class="readout-label">TELEMETRY SECURE</span>
              </div>
            </div>
          </div>
          
          <div class="faq-visual-item" style="border-top: 1px solid rgba(16, 185, 129, 0.1); padding-top: 20px; display: flex; flex-direction: column; align-items: flex-start; gap: 20px; width: 100%;">
            <div style="display: flex; gap: 15px; align-items: center; width: 100%;">
              <div class="faq-visual-icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                </svg>
              </div>
              <div style="flex-grow: 1;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 4px;">
                  <strong style="color: #0f172a; font-size: 14.5px; font-weight: 800; letter-spacing: 0.5px;">TƯ VẤN KỸ THUẬT 24/7</strong>
                  <span style="display: inline-flex; align-items: center; gap: 4px; background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2); padding: 2px 8px; border-radius: 12px; font-size: 9px; color: #059669; font-weight: 700; letter-spacing: 0.5px;">
                    <span style="width: 5px; height: 5px; background: #10b981; border-radius: 50%; display: inline-block; box-shadow: 0 0 8px #10b981; animation: faq-core-pulse 1.5s ease-in-out infinite;"></span>
                    ONLINE
                  </span>
                </div>
                <span class="faq-visual-desc" style="color: #475569; font-size: 12.5px; line-height: 1.5; display: block;">Liên hệ trực tiếp với Cố vấn kỹ thuật của VinFast qua Hotline hoặc Zalo để được giải đáp tức thì.</span>
              </div>
            </div>
            
            <div class="faq-cta-row">
              <a href="tel:<?php echo htmlspecialchars($agencyPhone); ?>" class="faq-btn-hotline">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 0 1-7.108-7.108c-.155-.44.011-.927.387-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                <span>Hotline: <?php echo htmlspecialchars($agencyPhone); ?></span>
              </a>
              <a href="https://zalo.me/<?php echo preg_replace('/[^0-9]/', '', $agencyPhone); ?>?text=Tôi%20muốn%20nhận%20báo%20giá%20và%20tư%20vấn%20xe%20VinFast" target="_blank" class="faq-btn-zalo" rel="noopener">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="color: #fff;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                </svg>
                <span>Nhắn tin Zalo</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Cột phải: Accordion list (Dynamic CMS FAQs - Correct position!) -->
      <div class="faq-list-block">
        <?php foreach ($faqSchemaData as $index => $faq): ?>
          <div class="faq-item">
            <button class="faq-trigger" onclick="toggleFaq(this)">
              <span class="faq-question-wrap">
                <span class="faq-num-badge">Q.<?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                <span><?php echo htmlspecialchars($faq['question']); ?></span>
              </span>
              <span class="faq-icon-wrap">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
              </span>
            </button>
            <div class="faq-content">
              <div class="faq-content-inner">
                <?php echo htmlspecialchars($faq['answer']); ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>