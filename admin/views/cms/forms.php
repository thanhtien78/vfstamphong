<?php
  // Fetch VIP popup settings directly
  $vip_popup_cover_image = $settings['vip_popup_cover_image'] ?? 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?auto=format&fit=crop&w=800&q=80';
  $vip_popup_cover_badge = $settings['vip_popup_cover_badge'] ?? 'Đặc quyền VIP';
  $vip_popup_cover_title = $settings['vip_popup_cover_title'] ?? 'VinFast VF 9';
  $vip_popup_cover_desc = $settings['vip_popup_cover_desc'] ?? 'Kiệt tác thiết kế thuần điện EV. Nhận gói đặc quyền ưu đãi chào hè trị giá tới 300 triệu đồng chính hãng.';
  $vip_popup_form_tag = $settings['vip_popup_form_tag'] ?? 'Ưu đãi độc quyền 2026';
  $vip_popup_form_title = $settings['vip_popup_form_title'] ?? 'Nhận Báo Giá & Ưu Đãi Đặc Biệt';
  $vip_popup_form_subtitle = $settings['vip_popup_form_subtitle'] ?? 'Để lại thông tin để chuyên viên VinFast liên hệ tư vấn dòng xe yêu thích cùng đặc quyền đăng ký lái thử VIP tại nhà riêng.';
?>

<!-- 6. REGISTRATION FORMS & POPUPS TAB CONTENT -->
<div id="cms-tab-forms" class="cms-tab-content" style="display: none;">
  <!-- Informational Flow Chart Card -->
  <div class="card" style="border: 1px solid var(--color-border); background: linear-gradient(135deg, rgba(20, 26, 40, 0.98) 0%, rgba(10, 14, 22, 0.98) 100%); margin-bottom: 25px;">
    <div style="display: flex; gap: 16px; align-items: flex-start;">
      <div style="background: var(--color-primary-glow); border: 1px solid var(--color-primary); color: var(--color-primary); width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 20px;">
        💡
      </div>
      <div>
        <h4 style="color: var(--color-primary); margin: 0 0 6px 0; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Hướng dẫn luồng thông tin đăng ký (Lead Flow Guide)</h4>
        <p style="font-size: 12.5px; color: rgba(255,255,255,0.75); line-height: 1.6; margin: 0;">
          Tất cả thông tin đăng ký của khách hàng từ <strong>VIP Popup</strong>, <strong>Form Định giá xe cũ (Trade-in)</strong>, <strong>Nút Nhận báo giá</strong>, và <strong>Form Đăng ký lái thử</strong> đều được hệ thống tự động ghi nhận vào cơ sở dữ liệu (Bảng <code>leads</code>) và hiển thị trực tiếp tại hai phân mục quản trị:
        </p>
        <ul style="font-size: 12px; color: var(--color-text-muted); line-height: 1.6; margin: 10px 0 0 20px; padding: 0; list-style-type: square;">
          <li style="margin-bottom: 6px;">
            <strong style="color: #fff;">Lịch Hẹn Lái Thử</strong> (<a href="admin.php?p=appointments" style="color: var(--color-primary); text-decoration: underline;">admin.php?p=appointments</a>): Thích hợp để quản lý và theo dõi các ngày hẹn mong muốn của khách lái thử xe.
          </li>
          <li>
            <strong style="color: #fff;">Khách Hàng CRM</strong> (<a href="admin.php?p=crm" style="color: var(--color-primary); text-decoration: underline;">admin.php?p=crm</a>): Dành cho đội ngũ Sales chăm sóc chuyên sâu. Các lead mới sẽ xuất hiện ở bảng <strong>"Khách hàng từ Landing Page / pSEO"</strong> ở trạng thái <em>Chưa liên hệ</em>. Nhân viên có thể thêm nhật ký chăm sóc và nhấn <strong>[Chuyển đổi CRM]</strong> để lưu trữ lâu dài.
          </li>
        </ul>
      </div>
    </div>
  </div>

  <form method="POST" action="admin.php?p=cms" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_forms_config">

    <div class="layout-split layout-split--wide-left">
      <div>
        <!-- 1. VIP Popup Config -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            🎁 Cấu hình Hộp thoại Khuyến mãi (VIP Popup Modal)
          </div>
          <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
            Hộp thoại popup tự động hiển thị sau 4 giây khi khách hàng lướt xem trang chủ, mời nhận báo giá và đăng ký đặc quyền.
          </p>

          <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 0 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">NỘI DUNG MÔ TẢ GIAO DIỆN (CỘT TRÁI - ẢNH BÌA)</div>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="vip_popup_cover_badge">Huy hiệu góc trái (Cover Badge) *</label>
              <input class="form-input" type="text" name="vip_popup_cover_badge" id="vip_popup_cover_badge" required value="<?php echo htmlspecialchars($vip_popup_cover_badge); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="vip_popup_cover_title">Tiêu đề ảnh bìa (Cover Title) *</label>
              <input class="form-input" type="text" name="vip_popup_cover_title" id="vip_popup_cover_title" required value="<?php echo htmlspecialchars($vip_popup_cover_title); ?>">
            </div>
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="vip_popup_cover_desc">Mô tả ảnh bìa (Cover Description) *</label>
            <textarea class="form-input" name="vip_popup_cover_desc" id="vip_popup_cover_desc" rows="2" required><?php echo htmlspecialchars($vip_popup_cover_desc); ?></textarea>
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="vip_popup_cover_file">Hình nền ảnh bìa Popup (Background Image) *</label>
            <?php if (!empty($vip_popup_cover_image)): ?>
              <div style="margin: 6px 0;">
                <img src="<?php echo htmlspecialchars($vip_popup_cover_image); ?>" style="max-width: 150px; max-height: 90px; border-radius: 4px; border: 1px solid var(--color-border); object-fit: cover; display: block;">
              </div>
            <?php endif; ?>
            <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
              <input type="file" name="vip_popup_cover_file" id="vip_popup_cover_file" accept="image/*" style="font-size: 12px; flex: 1;">
            </div>
            <input class="form-input" type="text" name="vip_popup_cover_image" style="margin-top:6px;" value="<?php echo htmlspecialchars($vip_popup_cover_image); ?>" placeholder="Hoặc nhập đường dẫn ảnh / Chọn từ thư viện">
          </div>

          <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 25px 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">NỘI DUNG BIỂU MẪU ĐĂNG KÝ (CỘT PHẢI - FORM)</div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="vip_popup_form_tag">Nhãn Form (Form Tag) *</label>
              <input class="form-input" type="text" name="vip_popup_form_tag" id="vip_popup_form_tag" required value="<?php echo htmlspecialchars($vip_popup_form_tag); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="vip_popup_form_title">Tiêu đề chính Form (Form Title) *</label>
              <input class="form-input" type="text" name="vip_popup_form_title" id="vip_popup_form_title" required value="<?php echo htmlspecialchars($vip_popup_form_title); ?>">
            </div>
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="vip_popup_form_subtitle">Đoạn phụ đề Form (Form Subtitle) *</label>
            <textarea class="form-input" name="vip_popup_form_subtitle" id="vip_popup_form_subtitle" rows="2" required><?php echo htmlspecialchars($vip_popup_form_subtitle); ?></textarea>
          </div>
        </div>

        <!-- 2. Section 9: Dual Actions CTAs (Test Drive & Service Appointment) -->
        <div class="card" style="margin-top: 25px;">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            ⚡ Cấu hình Khối Hành Động Kép Chân Trang (Phần 9)
          </div>
          <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
            Thiết lập 2 khối hành động lớn hiển thị song song ở phía trên chân trang (Đăng ký Lái thử & Đặt lịch hẹn bảo dưỡng). Bạn có thể tải ảnh nền mới lên để cá nhân hóa hoàn toàn giao diện.
          </p>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
            <?php foreach ($s9_dual_actions_data as $i => $item): ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 16px; border-radius: 6px;">
                <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; margin-bottom: 12px;">
                  Khối Hành Động #<?php echo $i + 1; ?>
                </div>

                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Nhãn phụ Tag *</label>
                    <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s9_tag[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($item['tag'] ?? ''); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Tiêu đề khối *</label>
                    <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s9_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($item['title'] ?? ''); ?>">
                  </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                  <label class="form-label" style="font-size:11px;">Mô tả ngắn hành động *</label>
                  <textarea class="form-input" style="min-height: 60px; font-size:12px; padding: 6px 10px; line-height: 1.4;" name="s9_desc[<?php echo $i; ?>]" required><?php echo htmlspecialchars($item['desc'] ?? ''); ?></textarea>
                </div>

                <div class="form-row" style="margin-top: 10px;">
                  <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Nhãn trên nút nhấn *</label>
                    <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s9_btn_text[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($item['btn_text'] ?? ''); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size:11px;">Đường dẫn liên kết *</label>
                    <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s9_btn_href[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($item['btn_href'] ?? ''); ?>">
                  </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                  <label class="form-label" style="font-size:11px;">Class CSS mặc định (Dành cho nhà phát triển)</label>
                  <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s9_bg_class[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($item['bg_class'] ?? ''); ?>">
                </div>

                <!-- Background Image Upload -->
                <div class="form-group" style="margin-top: 15px; border-top: 1px dashed rgba(255,255,255,0.08); padding-top: 15px;">
                  <label class="form-label" style="font-size:11px; color: var(--color-primary); font-weight: bold;">🌅 Ảnh nền tùy biến (Background Image override)</label>
                  <?php if (!empty($item['bg_image'])): ?>
                    <div style="margin: 6px 0;">
                      <img src="<?php echo htmlspecialchars($item['bg_image']); ?>" style="max-width: 150px; max-height: 90px; border-radius: 4px; border: 1px solid var(--color-border); object-fit: cover; display: block;">
                    </div>
                  <?php endif; ?>
                  <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
                    <input type="file" name="s9_bg_file_<?php echo $i; ?>" accept="image/*" style="font-size: 11px; flex: 1;">
                  </div>
                  <input class="form-input" type="text" name="s9_bg_image[<?php echo $i; ?>]" style="margin-top:6px; height: 30px; font-size: 11px;" value="<?php echo htmlspecialchars($item['bg_image'] ?? ''); ?>" placeholder="Hoặc nhập đường dẫn ảnh nền / Chọn từ thư viện">
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Right Column Settings -->
      <div>
        <!-- 3. Section 7: Trade-in / Valuation process config -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            🚗 Form Định Giá Xe Cũ (Thu Cũ Đổi Mới - Phần 7)
          </div>
          <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
            Quản lý phần tiêu đề giới thiệu chương trình thẩm định, thông tin cố vấn VIP và các bước quy trình.
          </p>

          <div class="form-group">
            <label class="form-label" style="font-size:11px;">Tiêu đề chính Section 7 *</label>
            <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s7_tradein_title" required value="<?php echo htmlspecialchars($s7_tradein_title); ?>">
          </div>
          
          <div class="form-group" style="margin-top: 12px;">
            <label class="form-label" style="font-size:11px;">Mô tả / Slogan giới thiệu Section 7 *</label>
            <textarea class="form-input" name="s7_tradein_desc" required style="min-height: 50px; font-size: 12px; line-height: 1.4;"><?php echo htmlspecialchars($s7_tradein_desc); ?></textarea>
          </div>

          <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 20px 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">CỐ VẤN VIP MẶC ĐỊNH</div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" style="font-size:11px;">Tên Cố vấn *</label>
              <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s7_default_counselor_name" required value="<?php echo htmlspecialchars($s7_default_counselor_name); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" style="font-size:11px;">Chức danh *</label>
              <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s7_default_counselor_title" required value="<?php echo htmlspecialchars($s7_default_counselor_title); ?>">
            </div>
          </div>

          <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 25px 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">3 BƯỚC QUY TRÌNH THẨM ĐỊNH</div>
          <div style="display: flex; flex-direction: column; gap: 15px;">
            <?php foreach ($s7_tradein_steps_data as $i => $step): ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 12px; border-radius: 6px;">
                <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
                  <span style="font-size: 11px; font-weight: bold; color: var(--color-primary);">Bước</span>
                  <input class="form-input" style="height: 28px; width: 45px; font-size: 11px; text-align: center; padding: 2px;" type="text" name="s7_step_num[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($step['num'] ?? '0' . ($i + 1)); ?>">
                  <input class="form-input" style="height: 28px; font-size: 11px; padding: 2px 8px;" type="text" name="s7_step_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($step['title'] ?? ''); ?>" placeholder="Tiêu đề bước...">
                </div>
                <textarea class="form-input" style="min-height: 45px; font-size:11px; padding: 4px 8px; line-height: 1.4;" name="s7_step_desc[<?php echo $i; ?>]" required placeholder="Mô tả bước..."><?php echo htmlspecialchars($step['desc'] ?? ''); ?></textarea>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <button class="btn-gold" type="submit" style="margin-top: 25px; width: 100%; font-weight: 700; font-size: 13px; padding: 12px;">
          💾 LƯU TOÀN BỘ CẤU HÌNH FORM & POPUP
        </button>
      </div>
    </div>
  </form>
</div>





