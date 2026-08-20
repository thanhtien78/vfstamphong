<!-- SECTION 7: TRADE-IN VALUATION (Thu cũ đổi mới) -->
  <section class="tradein-section" id="tradein-block">
    <div class="container">
      <div class="section-header">
        <span class="section-tag">Dịch vụ đặc quyền</span>
        <h2 class="section-title">Thu cũ đổi mới - Lên đời xe VinFast chính hãng</h2>
      </div>

      <div class="tradein-grid">
        
        <!-- Cột trái: Thông điệp & Các bước Đặc quyền lên đời -->
        <div class="tradein-promo-card">
          <h3 class="tradein-promo-title">Đặc quyền lên đời xe</h3>
          <p style="font-size: 13.5px; color: var(--color-text-muted); line-height: 1.7; margin: 0;">
            Chương trình hỗ trợ độc quyền của đại lý VinFast dành cho quý khách hàng đang sở hữu bất kỳ hãng xe nào muốn đổi sang dòng xe VinFast mới đẳng cấp.          </p>

          <div class="tradein-steps">
                          <div class="tradein-step-row">
                <div class="tradein-step-num">01</div>
                <div class="tradein-step-content">
                  <h4 class="tradein-step-title">Gửi Thông Tin Trực Tuyến</h4>
                  <p class="tradein-step-desc">Điền thông số xe hiện tại và cách liên hệ của anh/chị tại biểu mẫu bên cạnh chỉ trong 1 phút.</p>
                </div>
              </div>
                          <div class="tradein-step-row">
                <div class="tradein-step-num">02</div>
                <div class="tradein-step-content">
                  <h4 class="tradein-step-title">Thẩm Định Tại Nhà Miễn Phí</h4>
                  <p class="tradein-step-desc">Đội ngũ kỹ sư VinFast Certified sẽ liên hệ trực tiếp và đến tận nhà thẩm định xe của anh/chị hoàn toàn miễn phí.</p>
                </div>
              </div>
                          <div class="tradein-step-row">
                <div class="tradein-step-num">03</div>
                <div class="tradein-step-content">
                  <h4 class="tradein-step-title">Lên Đời Xe Giao Tận Nơi</h4>
                  <p class="tradein-step-desc">Hưởng ưu đãi thu mua xe cũ giá cao nhất thị trường, khấu trừ trực tiếp vào giá xe VinFast mới và hỗ trợ giao xe tận nhà chu đáo.</p>
                </div>
              </div>
                      </div>

          <!-- Trade-in VIP Concierge Card -->
          <div class="tradein-concierge-card">
            <div class="tradein-concierge-profile">
              <div class="tradein-concierge-avatar">
                <?php
                $counselorAvatar = $homeCounselor['avatar'] ?? 'assets/uploads/7eee3cd930cbc32ffc8f791f8315a18c.webp';
                $counselorName = $homeCounselor['fullname'] ?? 'Nguyễn Thanh Hương';
                $counselorAvatarUrl = preg_match('#^(https?://|//)#i', $counselorAvatar) ? $counselorAvatar : seo_url($counselorAvatar);
                ?>
                <img src="<?php echo htmlspecialchars($counselorAvatarUrl); ?>" alt="<?php echo htmlspecialchars($counselorName); ?>" style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 50%;" loading="lazy" width="80" height="80">
              </div>
              <div class="tradein-concierge-info">
                <span class="tradein-concierge-tag">Cố vấn chuyên nghiệp</span>
                <span class="tradein-concierge-name"><?php echo htmlspecialchars($counselorName); ?></span>
                <span class="tradein-concierge-status">
                  <span class="pulse-dot"></span>
                  ĐANG TRỰC TUYẾN
                </span>
              </div>
            </div>
            
            <div class="tradein-concierge-actions">
              <a href="tel:<?php echo htmlspecialchars(!empty($homeCounselor['phone']) ? $homeCounselor['phone'] : $agencyPhone); ?>" class="btn-tradein-action-hotline">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink: 0;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.387a12.035 12.035 0 0 1-7.108-7.108c-.155-.44.011-.927.387-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                <span>Hotline định giá</span>
              </a>
              <a href="<?php echo htmlspecialchars(!empty($homeCounselor['zalo']) ? $homeCounselor['zalo'] : 'https://zalo.me/' . preg_replace('/[^0-9]/', '', $agencyPhone)); ?>" target="_blank" class="btn-tradein-action-zalo" rel="noopener">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" style="flex-shrink: 0;">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" />
                </svg>
                <span>Nhắn tin Zalo</span>
              </a>
            </div>
          </div>

          <div class="tradein-badge-box">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" style="color: var(--color-primary); flex-shrink: 0; margin-top: 2px;">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
            <div class="tradein-badge-text">
              <strong style="color: #0f172a; font-size: 14.5px; font-weight: 800; letter-spacing: 0.5px;">TƯ VẤN KỸ THUẬT 24/7</strong><br>
              Đảm bảo quy trình minh bạch tuyệt đối, định giá khách quan, thủ tục hồ sơ bảo mật toàn diện.
            </div>
          </div>
        </div>

        <!-- Cột phải: Form nhập thông tin định giá trực tuyến -->
        <div class="tradein-form-card">
          <?php if (!empty($successTradeIn)): ?>
            <div style="background: rgba(46, 196, 182, 0.1); border: 1.5px solid rgba(46, 196, 182, 0.3); color: #2ec4b6; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; text-align: left;">
              <span style="font-size: 18px; line-height: 1;">✓</span>
              <span>Đăng ký định giá thành công! Cố vấn VinFast sẽ liên hệ lại với anh/chị sau ít phút để hỗ trợ định giá xe cũ.</span>
            </div>
          <?php endif; ?>

          <?php if (!empty($errorTradeIn)): ?>
            <div style="background: rgba(239, 83, 80, 0.1); border: 1.5px solid rgba(239, 83, 80, 0.3); color: #ef5350; padding: 12px 16px; border-radius: 8px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; gap: 8px; margin-bottom: 16px; text-align: left;">
              <span style="font-size: 18px; line-height: 1;">⚠️</span>
              <span><?php echo htmlspecialchars($errorTradeIn); ?></span>
            </div>
          <?php endif; ?>
                      
            <form method="POST" action="index.php#tradein-block" style="display: grid; grid-template-columns: 1fr; gap: 24px;">
              <input type="hidden" name="action" value="submit_trade_in">
              <!-- Anti-spam HoneyPot field -->
              <input type="text" name="website_url" style="display:none;" tabindex="-1" autocomplete="off">
              
              <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                <h3 style="color: var(--color-primary); font-size: 15px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px;">1. Thông tin xe cũ của anh/chị</h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                  <div class="calc-group">
                    <label class="calc-label" for="old_brand">Hãng xe hiện tại *</label>
                    <select class="calc-input-select" name="old_brand" id="old_brand" required>
                      <option value="">-- Chọn hãng xe --</option>
                      <option value="VinFast">VinFast</option>
                      <option value="Mercedes-Benz">Mercedes-Benz</option>
                      <option value="BMW">BMW</option>
                      <option value="Lexus">Lexus</option>
                      <option value="Porsche">Porsche</option>
                      <option value="Toyota">Toyota</option>
                      <option value="Honda">Honda</option>
                      <option value="Mazda">Mazda</option>
                      <option value="Hyundai">Hyundai</option>
                      <option value="Kia">Kia</option>
                      <option value="Khác">Hãng khác...</option>
                    </select>
                  </div>
                  
                  <div class="calc-group">
                    <label class="calc-label" for="old_model">Dòng xe & Phiên bản *</label>
                    <input class="calc-input-select" type="text" name="old_model" id="old_model" required placeholder="Ví dụ: C200 Exclusive, 320i Sportline">
                  </div>
                  
                  <div class="calc-group">
                    <label class="calc-label" for="old_year">Năm sản xuất</label>
                    <select class="calc-input-select" name="old_year" id="old_year">
                                              <option value="2026">2026</option>
                                              <option value="2025">2025</option>
                                              <option value="2024">2024</option>
                                              <option value="2023">2023</option>
                                              <option value="2022">2022</option>
                                              <option value="2021">2021</option>
                                              <option value="2020">2020</option>
                                              <option value="2019">2019</option>
                                              <option value="2018">2018</option>
                                              <option value="2017">2017</option>
                                              <option value="2016">2016</option>
                                              <option value="2015">2015</option>
                                              <option value="2014">2014</option>
                                              <option value="2013">2013</option>
                                              <option value="2012">2012</option>
                                              <option value="2011">2011</option>
                                              <option value="2010">2010</option>
                                              <option value="2009">2009</option>
                                              <option value="2008">2008</option>
                                          </select>
                  </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-top: 4px;">
                  <div class="calc-group">
                    <label class="calc-label" for="old_odo">Số km đã đi (Odo) *</label>
                    <input class="calc-input-select" type="text" name="old_odo" id="old_odo" required placeholder="Ví dụ: 45,000 km">
                  </div>
                  
                  <div class="calc-group">
                    <label class="calc-label" for="old_status">Tình trạng xe hiện tại</label>
                    <select class="calc-input-select" name="old_status" id="old_status">
                      <option value="Hoàn hảo như mới (Không đâm đụng, thủy kích)">Hoàn hảo như mới (Không đâm đụng, ngập nước)</option>
                      <option value="Rất đẹp (Bảo dưỡng hãng đầy đủ, sơn zin nhiều)">Rất đẹp (Bảo dưỡng đầy đủ)</option>
                      <option value="Bình thường (Trầy xước nhẹ ngoại thất)">Bình thường (Trầy xước nhẹ)</option>
                      <option value="Cần tân trang (Nội ngoại thất cũ theo thời gian)">Cần tân trang lại nội/ngoại thất</option>
                    </select>
                  </div>

                  <div class="calc-group">
                    <label class="calc-label" for="target_car_id">Dòng xe VinFast muốn lên đời *</label>
                    <select class="calc-input-select" name="target_car_id" id="target_car_id" required>
                      <option value="">-- Chọn mẫu VinFast mong muốn --</option>
                      <?php if (isset($compareCars) && is_array($compareCars)): ?>
                        <?php foreach ($compareCars as $c): ?>
                          <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['model_name']); ?> (<?php echo htmlspecialchars($c['price']); ?>)</option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Dynamic Valuation Feedback Card -->
              <div id="valuation-live-card" class="valuation-live-panel" style="display: none; margin-top: 8px; margin-bottom: 4px;">
                <div class="val-pulse-indicator"></div>
                <div style="display: flex; flex-direction: column; gap: 4px; text-align: left;">
                  <div style="font-size: 11px; text-transform: uppercase; color: var(--color-primary); font-weight: 700; letter-spacing: 1px;">
                    Ước tính trợ giá lên đời đặc quyền (Live)
                  </div>
                  <div id="valuation-estimated-text" style="font-size: 13px; color: #fff; font-weight: 400; line-height: 1.5;">
                    Vui lòng chọn hãng xe và dòng xe muốn lên đời để hiển thị dự toán...
                  </div>
                </div>
              </div>

              <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 10px;">
                <h3 style="color: var(--color-primary); font-size: 15px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px;">2. Thông tin liên hệ của anh/chị</h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                  <div class="calc-group">
                    <label class="calc-label" for="trade_fullname">Họ và tên của anh/chị *</label>
                    <input class="calc-input-select" type="text" name="fullname" id="trade_fullname" required placeholder="Ví dụ: Nguyễn Văn A">
                  </div>
                  
                  <div class="calc-group">
                    <label class="calc-label" for="trade_phone">Số điện thoại liên hệ *</label>
                    <input class="calc-input-select" type="text" name="phone" id="trade_phone" required placeholder="Ví dụ: 0912345678">
                  </div>
                  
                  <div class="calc-group">
                    <label class="calc-label" for="trade_email">Địa chỉ Email</label>
                    <input class="calc-input-select" type="email" name="email" id="trade_email" placeholder="Ví dụ: a.nguyen@gmail.com">
                  </div>
                </div>
              </div>

              <div style="text-align: center; margin-top: 15px;">
                <button type="submit" class="btn-tradein-submit">Gửi yêu cầu định giá xe cũ</button>
                <p style="color: var(--color-text-muted); font-size: 11px; margin-top: 12px; line-height: 1.5;">
                  * Cam kết bảo mật hoàn toàn thông tin. Định giá minh bạch dựa trên biểu giá thị trường thực tế. 
                  <br>Chúng tôi hỗ trợ thu mua lại mọi hãng xe với mức giá tốt nhất để anh/chị lên đời xe VinFast chính hãng.
                </p>
              </div>
            </form>
                  </div>
    </div>
  </section>