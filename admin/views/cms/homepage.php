      <!-- 1. HOMEPAGE TAB CONTENT -->
      <div id="cms-tab-homepage" class="cms-tab-content">
        <div class="layout-split layout-split--wide-left">
          <div>
            <!-- Section 5 -->
            <div class="card">
              <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
                💎 Quản lý Đặc Quyền Sở Hữu VinFast (Phần 5)
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
                Tùy chỉnh 4 thẻ Đặc Quyền Sở Hữu hiển thị nổi bật trên Trang chủ. Mỗi thẻ gồm một chữ in mờ (Watermark), tiêu đề, mô tả và đường liên kết dẫn tới phân mục mong muốn.
              </p>
              
              <form method="POST" action="admin.php?p=cms">
                <input type="hidden" name="action" value="save_s5_privileges">
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                  <?php foreach ($s5_privileges_data as $i => $priv): ?>
                    <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 16px; border-radius: 6px;">
                      <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-border); padding-bottom: 8px; margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase;">Thẻ Đặc Quyền #<?php echo $i + 1; ?></span>
                      </div>
                      
                      <div class="form-group">
                        <label class="form-label" style="font-size:11px;">Chữ in mờ background (Watermark)</label>
                        <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s5_watermark[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($priv['watermark'] ?? ''); ?>" placeholder="Ví dụ: Warranty">
                      </div>
                      
                      <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label" style="font-size:11px;">Tiêu đề đặc quyền *</label>
                        <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s5_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($priv['title'] ?? ''); ?>" placeholder="Ví dụ: Bảo hành 3 năm vô hạn km">
                      </div>
                      
                      <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label" style="font-size:11px;">Mô tả ngắn đặc quyền *</label>
                        <textarea class="form-input" style="min-height: 60px; font-size:12px; padding: 6px 10px;" name="s5_desc[<?php echo $i; ?>]" required placeholder="Nhập mô tả chi tiết..."><?php echo htmlspecialchars($priv['desc'] ?? ''); ?></textarea>
                      </div>
                      
                      <div class="form-row" style="margin-top: 10px;">
                        <div class="form-group">
                          <label class="form-label" style="font-size:11px;">Chữ hiển thị link *</label>
                          <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s5_link_text[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($priv['link_text'] ?? ''); ?>" placeholder="Tìm hiểu chính sách">
                        </div>
                        <div class="form-group">
                          <label class="form-label" style="font-size:11px;">Neo liên kết *</label>
                          <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s5_link_href[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($priv['link_href'] ?? ''); ?>" placeholder="#catalog-block">
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                
                <button class="btn-gold" type="submit" style="margin-top: 20px; width: 100%;">
                  💾 Lưu cấu hình Đặc Quyền Sở Hữu (Phần 5)
                </button>
              </form>
            </div>
 
            <!-- Section 6 -->
            <div class="card" style="margin-top: 25px;">
              <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
                🌟 Quản lý Lý Do Chọn Đại Lý Ủy Quyền (Phần 6)
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
                Quản lý triết lý thông điệp thương hiệu cùng với 4 cột lý do cốt lõi thuyết phục khách hàng lựa chọn mua xe tại Đại lý Ủy quyền VinFast Việt Nam.
              </p>
              
              <form method="POST" action="admin.php?p=cms">
                <input type="hidden" name="action" value="save_s6_reasons">
                
                <div class="form-group" style="margin-bottom: 20px; background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 16px; border-radius: 6px;">
                  <label class="form-label" style="font-size: 12px; color: var(--color-primary); font-weight: bold; text-transform: uppercase;">
                    ❝ Thông điệp thương hiệu / Chữ ký đại diện
                  </label>
                  <textarea class="form-input" style="min-height: 80px; font-size: 13px; margin-top: 8px;" name="s6_signature_quote" required placeholder="Nhập câu trích dẫn triết lý bán hàng..."><?php echo htmlspecialchars($s6_signature_quote); ?></textarea>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
                  <?php foreach ($s6_reasons_data as $i => $reason): ?>
                    <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 16px; border-radius: 6px;">
                      <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-border); padding-bottom: 8px; margin-bottom: 12px;">
                        <span style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase;">Lý do chọn #0<?php echo $i + 1; ?></span>
                      </div>
                      
                      <div class="form-group">
                        <label class="form-label" style="font-size:11px;">Tiêu đề lý do *</label>
                        <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s6_reason_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($reason['title'] ?? ''); ?>" placeholder="Ví dụ: 100% Nhập khẩu">
                      </div>
                      
                      <div class="form-group" style="margin-top: 10px;">
                        <label class="form-label" style="font-size:11px;">Mô tả ngắn lý do *</label>
                        <textarea class="form-input" style="min-height: 80px; font-size:12px; padding: 6px 10px; line-height: 1.4;" name="s6_reason_desc[<?php echo $i; ?>]" required placeholder="Nhập chi tiết lý do..."><?php echo htmlspecialchars($reason['desc'] ?? ''); ?></textarea>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                
                <button class="btn-gold" type="submit" style="margin-top: 20px; width: 100%;">
                  💾 Lưu cấu hình Lý Do Chọn Đại Lý (Phần 6)
                </button>
              </form>
            </div>
 
            <!-- Section 7: Trade-in (Moved to Forms tab) -->
            <div class="card" style="margin-top: 25px; border: 1px dashed rgba(25, 96, 215, 0.3); background: rgba(20, 26, 40, 0.45);">
              <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary); font-size: 13px;">
                🚗 Quy trình Thu cũ đổi mới & Định giá xe cũ (Phần 7)
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin: 10px 0 15px 0;">
                Cấu hình cho Form Định giá xe cũ đã được gom nhóm và chuyển sang tab <strong>Form Đăng Ký & Popup</strong> để dễ dàng quản trị tập trung cùng các biểu mẫu khác.
              </p>
              <button type="button" class="btn-gold" style="font-size:11px; padding: 8px 16px;" onclick="switchCmsTab('forms')">📋 Đi tới Tab quản lý Form & Popup</button>
            </div>
 
            <!-- Section 8 -->
            <div class="card" style="margin-top: 25px;">
              <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
                👑 Quản lý Ưu Đãi Đặc Quyền Sân Khấu (Phần 8)
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
                Quản lý 4 cột mốc ưu đãi độc quyền trên giao diện sân khấu tối tân chuyển động. Mỗi ưu đãi bao gồm nhãn đỏ Tag, tiêu đề, mô tả và 3 dòng điểm nhấn bullet points chất lượng.
              </p>
              
              <form method="POST" action="admin.php?p=cms">
                <input type="hidden" name="action" value="save_s8_offers">
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                  <?php foreach ($s8_offers_data as $i => $offer): ?>
                    <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 20px; border-radius: 8px; position: relative;">
                       <div style="font-size: 13px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; margin-bottom: 15px;">
                        🎁 GÓI ƯU ĐÃI ĐẶC QUYỀN #0<?php echo $i + 1; ?>
                      </div>
                      
                      <div class="form-row">
                        <div class="form-group">
                          <label class="form-label" style="font-size:11px;">Nhãn thẻ tag nổi bật *</label>
                          <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s8_tag[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($offer['tag'] ?? ''); ?>" placeholder="Ví dụ: CHÀO HÈ 2026">
                        </div>
                        <div class="form-group">
                          <label class="form-label" style="font-size:11px;">Tiêu đề gói ưu đãi *</label>
                          <input class="form-input" style="height: 34px; font-size:12px;" type="text" name="s8_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($offer['title'] ?? ''); ?>" placeholder="Ví dụ: Hỗ trợ lệ phí trước bạ">
                        </div>
                      </div>
                      
                      <div class="form-group" style="margin-top: 12px;">
                        <label class="form-label" style="font-size:11px;">Mô tả ngắn giới thiệu gói ưu đãi *</label>
                        <textarea class="form-input" style="min-height: 60px; font-size:12px; padding: 6px 10px; line-height: 1.4;" name="s8_desc[<?php echo $i; ?>]" required placeholder="Nhập mô tả chi tiết ưu đãi..."><?php echo htmlspecialchars($offer['desc'] ?? ''); ?></textarea>
                      </div>
                      
                      <div style="margin-top: 15px; padding: 12px 16px; background: rgba(0,0,0,0.2); border-radius: 6px;">
                        <label class="form-label" style="font-size: 11px; color: var(--color-primary); font-weight: bold; margin-bottom: 8px; display: block;">
                          ✓ 3 Dòng điểm nhấn nổi bật (Bullet points)
                        </label>
                        
                        <div class="form-group">
                          <input class="form-input" style="height: 32px; font-size:11px; background: rgba(0,0,0,0.3);" type="text" name="s8_bullets[<?php echo $i; ?>][0]" required value="<?php echo htmlspecialchars($offer['bullets'][0] ?? ''); ?>" placeholder="Dòng điểm nhấn 1">
                        </div>
                        <div class="form-group" style="margin-top: 6px;">
                          <input class="form-input" style="height: 32px; font-size:11px; background: rgba(0,0,0,0.3);" type="text" name="s8_bullets[<?php echo $i; ?>][1]" required value="<?php echo htmlspecialchars($offer['bullets'][1] ?? ''); ?>" placeholder="Dòng điểm nhấn 2">
                        </div>
                        <div class="form-group" style="margin-top: 6px;">
                          <input class="form-input" style="height: 32px; font-size:11px; background: rgba(0,0,0,0.3);" type="text" name="s8_bullets[<?php echo $i; ?>][2]" required value="<?php echo htmlspecialchars($offer['bullets'][2] ?? ''); ?>" placeholder="Dòng điểm nhấn 3">
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                
                <button class="btn-gold" type="submit" style="margin-top: 20px; width: 100%;">
                  💾 Lưu cấu hình Ưu Đãi Sân Khấu (Phần 8)
                </button>
              </form>
            </div>
 
            <!-- Section 9: Dual Actions (Moved to Forms tab) -->
            <div class="card" style="margin-top: 25px; border: 1px dashed rgba(25, 96, 215, 0.3); background: rgba(20, 26, 40, 0.45);">
              <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary); font-size: 13px;">
                ⚡ Khối Hành Động Kép Chân Trang (Phần 9)
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin: 10px 0 15px 0;">
                Cấu hình cho Đăng ký Lái thử & Đặt lịch dịch vụ đã được gom nhóm và chuyển sang tab <strong>Form Đăng Ký & Popup</strong> để thuận tiện cho việc tải ảnh nền tùy biến.
              </p>
              <button type="button" class="btn-gold" style="font-size:11px; padding: 8px 16px;" onclick="switchCmsTab('forms')">📋 Đi tới Tab quản lý Form & Popup</button>
            </div>
 
            <!-- Section 11: Homepage FAQs -->
            <div class="card" style="margin-top: 25px;">
              <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
                ❓ Quản lý Câu Hỏi Thường Gặp (Phần 11)
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
                Quản lý danh sách các câu hỏi thường gặp (FAQ) hiển thị động ở phần chân Trang chủ. Có hỗ trợ thêm mới hoặc xóa câu hỏi tùy chỉnh.
              </p>
              
              <form method="POST" action="admin.php?p=cms">
                <input type="hidden" name="action" value="save_homepage_faqs">
                
                <div class="table-responsive" style="margin-bottom: 15px; overflow-x: auto;">
                  <table class="compare-table" id="homepage-faq-table" style="width: 100%; border-collapse: collapse; min-width: 500px;">
                    <thead>
                      <tr style="border-bottom: 1px solid var(--color-border); text-align: left;">
                        <th style="padding: 8px 4px; font-size: 11px; color: var(--color-primary);">Câu hỏi *</th>
                        <th style="padding: 8px 4px; font-size: 11px; color: var(--color-primary);">Câu trả lời *</th>
                        <th style="width: 50px;"></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($homepage_faqs_data as $index => $faq): ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.03);">
                          <td style="padding: 8px 4px;"><input class="form-input" style="height:32px; font-size:11px;" type="text" name="faq_question[]" required value="<?php echo htmlspecialchars($faq['question'] ?? ''); ?>" placeholder="Nhập câu hỏi..."></td>
                          <td style="padding: 8px 4px;"><textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4; padding: 4px 6px;" name="faq_answer[]" required placeholder="Nhập câu trả lời..."><?php echo htmlspecialchars($faq['answer'] ?? ''); ?></textarea></td>
                          <td style="padding: 8px 4px; text-align: center;"><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeHmFaqRow(this)">Xóa</button></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none;" onclick="addHmFaqRow()">+ Thêm câu hỏi FAQ mới</button>
                  <button class="btn-gold" type="submit" style="font-size: 11px; padding: 6px 16px;">💾 Lưu FAQ Trang Chủ</button>
                </div>
              </form>
            </div>
          </div>
 
          <div>
            <!-- Meta SEO Tags Configuration -->
            <div class="card">
              <div class="card__title">Thiết lập cấu hình On-Page SEO các trang chính</div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
                Cấu hình trực tiếp các thẻ tiêu đề (Title), mô tả (Description), từ khóa (Keywords), và đường dẫn gốc (Canonical) cho các trang tĩnh chính trên website để đạt thứ hạng tìm kiếm cao nhất trên Google.
              </p>
              <form method="POST" action="admin.php?p=cms">
                <input type="hidden" name="action" value="save_seo">
 
                <!-- SECTION 1: TRANG CHỦ -->
                <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                  <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin-bottom: 12px; display:flex; align-items:center; gap:6px;">
                    🏠 1. cấu hình seo trang chủ (home)
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="site_title">Tiêu đề SEO trang chủ (Meta Title)</label>
                    <input class="form-input" type="text" name="site_title" id="site_title" required value="<?php echo htmlspecialchars($settings['site_title'] ?? ''); ?>">
                  </div>
                  <div class="form-group" style="margin-top:12px;">
                    <label class="form-label" for="site_desc">Mô tả SEO trang chủ (Meta Description)</label>
                    <textarea class="form-input" name="site_desc" id="site_desc" required style="min-height:70px;"><?php echo htmlspecialchars($settings['site_desc'] ?? ''); ?></textarea>
                  </div>
                  <div class="form-row" style="margin-top:12px; display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div class="form-group" style="margin-bottom:0;">
                      <label class="form-label" for="site_keywords">Từ khóa SEO trang chủ</label>
                      <input class="form-input" type="text" name="site_keywords" id="site_keywords" required value="<?php echo htmlspecialchars($settings['site_keywords'] ?? ''); ?>">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                      <label class="form-label" for="site_canonical">Thẻ Canonical URL tùy biến</label>
                      <input class="form-input" type="text" name="site_canonical" id="site_canonical" value="<?php echo htmlspecialchars($settings['site_canonical'] ?? ''); ?>" placeholder="Để trống để tự động dùng URL gốc trang chủ">
                    </div>
                  </div>
                </div>
 
                <!-- SECTION 2: TRANG GIỚI THIỆU -->
                <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                  <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin-bottom: 12px; display:flex; align-items:center; gap:6px;">
                    📖 2. cấu hình seo trang giới thiệu (about)
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="about_seo_title">Tiêu đề SEO trang giới thiệu (Meta Title)</label>
                    <input class="form-input" type="text" name="about_seo_title" id="about_seo_title" value="<?php echo htmlspecialchars($settings['about_seo_title'] ?? ''); ?>" placeholder="Nếu để trống sẽ tự động lấy: [Tiêu đề trang giới thiệu] | Mãnh liệt Tinh thần Việt Nam">
                  </div>
                  <div class="form-group" style="margin-top:12px;">
                    <label class="form-label" for="about_seo_desc">Mô tả SEO trang giới thiệu (Meta Description)</label>
                    <textarea class="form-input" name="about_seo_desc" id="about_seo_desc" style="min-height:70px;" placeholder="Nếu để trống sẽ sử dụng mô tả mặc định của đại lý..."><?php echo htmlspecialchars($settings['about_seo_desc'] ?? ''); ?></textarea>
                  </div>
                  <div class="form-row" style="margin-top:12px; display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div class="form-group" style="margin-bottom:0;">
                      <label class="form-label" for="about_seo_keywords">Từ khóa SEO trang giới thiệu</label>
                      <input class="form-input" type="text" name="about_seo_keywords" id="about_seo_keywords" value="<?php echo htmlspecialchars($settings['about_seo_keywords'] ?? ''); ?>" placeholder="Ví dụ: gioi thieu VinFast, thuong hieu VinFast...">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                      <label class="form-label" for="about_seo_canonical">Thẻ Canonical URL tùy biến</label>
                      <input class="form-input" type="text" name="about_seo_canonical" id="about_seo_canonical" value="<?php echo htmlspecialchars($settings['about_seo_canonical'] ?? ''); ?>" placeholder="Để trống để tự động dùng URL gốc /about.php">
                    </div>
                  </div>
                </div>
 
                <!-- SECTION 3: TRANG MUA XE TRẢ GÓP -->
                <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 8px; padding: 16px; margin-bottom: 20px;">
                  <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin-bottom: 12px; display:flex; align-items:center; gap:6px;">
                    💳 3. cấu hình seo trang mua xe trả góp (installment)
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="installment_seo_title">Tiêu đề SEO trang trả góp (Meta Title)</label>
                    <input class="form-input" type="text" name="installment_seo_title" id="installment_seo_title" value="<?php echo htmlspecialchars($settings['installment_seo_title'] ?? ''); ?>" placeholder="Nếu để trống sẽ tự động lấy: Mua xe VinFast trả góp lãi suất thấp | Dự toán hạn mức vay">
                  </div>
                  <div class="form-group" style="margin-top:12px;">
                    <label class="form-label" for="installment_seo_desc">Mô tả SEO trang trả góp (Meta Description)</label>
                    <textarea class="form-input" name="installment_seo_desc" id="installment_seo_desc" style="min-height:70px;" placeholder="Nếu để trống sẽ sử dụng mô tả mặc định của công cụ tính lãi suất trả góp..."><?php echo htmlspecialchars($settings['installment_seo_desc'] ?? ''); ?></textarea>
                  </div>
                  <div class="form-row" style="margin-top:12px; display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                    <div class="form-group" style="margin-bottom:0;">
                      <label class="form-label" for="installment_seo_keywords">Từ khóa SEO trang trả góp</label>
                      <input class="form-input" type="text" name="installment_seo_keywords" id="installment_seo_keywords" value="<?php echo htmlspecialchars($settings['installment_seo_keywords'] ?? ''); ?>" placeholder="Ví dụ: mua xe VinFast tra gop, lai suat tra gop...">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                      <label class="form-label" for="installment_seo_canonical">Thẻ Canonical URL tùy biến</label>
                      <input class="form-input" type="text" name="installment_seo_canonical" id="installment_seo_canonical" value="<?php echo htmlspecialchars($settings['installment_seo_canonical'] ?? ''); ?>" placeholder="Để trống để tự động dùng URL gốc /installment.php">
                    </div>
                  </div>
                </div>
 
                <button class="btn-gold" type="submit" style="margin-top:10px; width:100%; font-weight: 700; text-transform: uppercase;">Lưu toàn bộ cấu hình SEO trang chính</button>
              </form>
            </div>
 
            <!-- Promo banners configurations -->
            <div class="card">
              <div class="card__title">Cấu hình Banner & Hình ảnh trang chủ</div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5;">
                Cấu hình các tiêu đề và quản lý hình ảnh tĩnh hiển thị tại trang chủ. Nếu tải lên tệp ảnh mới, hệ thống sẽ tự động thay đổi ảnh cũ.
              </p>
              <div style="margin: 10px 0 15px 0; padding: 12px 16px; background: var(--color-primary-glow); border-left: 3px solid var(--color-primary); font-size: 12px; line-height: 1.6; color: var(--color-text-white); border-radius: 0 4px 4px 0;">
                <strong style="color: var(--color-primary); display: block; margin-bottom: 4px;">💡 LƯU Ý QUAN TRỌNG KHI TẢI TỆP ẢNH:</strong>
                - Mỗi file tải lên nên có dung lượng <strong>dưới 2MB</strong> (giới hạn mặc định phổ biến của các máy chủ PHP/Laragon khi chưa tăng cấu hình `upload_max_filesize`).<br>
                - Nếu ảnh chụp điện thoại của anh quá nặng (3MB - 8MB), hãy giảm kích thước/nén ảnh trước khi tải lên hoặc dán link ảnh ngoài vào ô tương ứng.
              </div>
              <form method="POST" action="admin.php?p=cms" enctype="multipart/form-data">
                <input type="hidden" name="action" value="save_settings">
                
                <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 15px 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">NỘI DUNG HERO BANNER CHÍNH</div>
                
                <div class="form-group">
                  <label class="form-label" for="hero_headline">Tiêu đề banner lớn</label>
                  <input class="form-input" type="text" name="hero_headline" id="hero_headline" required value="<?php echo htmlspecialchars($settings['hero_headline'] ?? ''); ?>">
                </div>
                <div class="form-group" style="margin-top:12px;">
                  <label class="form-label" for="hero_subline">Tiêu đề phụ / Mô tả banner</label>
                  <input class="form-input" type="text" name="hero_subline" id="hero_subline" required value="<?php echo htmlspecialchars($settings['hero_subline'] ?? ''); ?>">
                </div>
                <div class="form-row" style="margin-top:12px;">
                  <div class="form-group">
                    <label class="form-label" for="hero_btn1">Nhãn nút 1</label>
                    <input class="form-input" type="text" name="hero_btn1" id="hero_btn1" required value="<?php echo htmlspecialchars($settings['hero_btn1'] ?? ''); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="hero_btn2">Nhãn nút 2</label>
                    <input class="form-input" type="text" name="hero_btn2" id="hero_btn2" required value="<?php echo htmlspecialchars($settings['hero_btn2'] ?? ''); ?>">
                  </div>
                </div>
 
                <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 25px 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">QUẢN LÝ HÌNH ẢNH GIAO DIỆN CHÍNH</div>
 
                <div class="form-group" style="margin-top:12px;">
                  <label class="form-label" for="hero_banner_file">1. Hình nền Hero Banner chính</label>
                  <?php if (!empty($settings['hero_banner_image'])): ?>
                    <div style="margin: 6px 0;">
                      <img src="<?php echo htmlspecialchars($settings['hero_banner_image']); ?>" style="max-width: 150px; max-height: 90px; border-radius: 4px; border: 1px solid var(--color-border); object-fit: cover; display: block;">
                    </div>
                  <?php endif; ?>
                  <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
                    <input type="file" name="hero_banner_file" id="hero_banner_file" accept="image/*" style="font-size: 12px; flex: 1;">
                  </div>
                  <input class="form-input" type="text" name="hero_banner_image" style="margin-top:6px;" value="<?php echo htmlspecialchars($settings['hero_banner_image'] ?? ''); ?>" placeholder="Đường dẫn ảnh nền ngoài (ví dụ: https://...)">
                </div>
 
                <div class="form-group" style="margin-top:16px;">
                  <label class="form-label" for="spotlight_file">2. Hình ảnh Kỷ nguyên điện hóa (Spotlight)</label>
                  <?php if (!empty($settings['spotlight_image'])): ?>
                    <div style="margin: 6px 0;">
                      <img src="<?php echo htmlspecialchars($settings['spotlight_image']); ?>" style="max-width: 150px; max-height: 90px; border-radius: 4px; border: 1px solid var(--color-border); object-fit: cover; display: block;">
                    </div>
                  <?php endif; ?>
                  <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
                    <input type="file" name="spotlight_file" id="spotlight_file" accept="image/*" style="font-size: 12px; flex: 1;">
                  </div>
                  <input class="form-input" type="text" name="spotlight_image" style="margin-top:6px;" value="<?php echo htmlspecialchars($settings['spotlight_image'] ?? ''); ?>" placeholder="Đường dẫn ảnh spotlight ngoài (ví dụ: https://...)">
                </div>
 
                <div class="form-group" style="margin-top:16px;">
                  <label class="form-label" for="dealer_file">3. Hình ảnh Đại lý Ủy quyền (Showroom)</label>
                  <?php if (!empty($settings['dealer_image'])): ?>
                    <div style="margin: 6px 0;">
                      <img src="<?php echo htmlspecialchars($settings['dealer_image']); ?>" style="max-width: 150px; max-height: 90px; border-radius: 4px; border: 1px solid var(--color-border); object-fit: cover; display: block;">
                    </div>
                  <?php endif; ?>
                  <div style="display: flex; gap: 10px; align-items: center; margin-top: 5px;">
                    <input type="file" name="dealer_file" id="dealer_file" accept="image/*" style="font-size: 12px; flex: 1;">
                  </div>
                  <input class="form-input" type="text" name="dealer_image" style="margin-top:6px;" value="<?php echo htmlspecialchars($settings['dealer_image'] ?? ''); ?>" placeholder="Đường dẫn ảnh showroom ngoài (ví dụ: https://...)">
                </div>
 
                <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 25px 0 8px 0; border-bottom: 1px solid var(--color-border); padding-bottom: 4px;">NỘI DUNG NỔI BẬT THƯƠNG HIỆU (BRAND SPOTLIGHT - PHẦN 2)</div>
                
                <div class="form-group">
                  <label class="form-label" for="s6_headline">Tiêu đề công bố (Brand Spotlight Headline) *</label>
                  <input class="form-input" type="text" name="s6_headline" id="s6_headline" required value="<?php echo htmlspecialchars($s6_headline); ?>">
                </div>
                
                <div class="form-group" style="margin-top:12px; margin-bottom: 15px;">
                  <label class="form-label" for="s6_desc">Nội dung chi tiết giới thiệu (Hỗ trợ cấu trúc thẻ HTML/H2/H3/P...) *</label>
                  <textarea class="form-input" name="s6_desc" id="s6_desc" style="min-height: 120px;" required><?php echo htmlspecialchars($s6_desc); ?></textarea>
                </div>
 
                <button class="btn-gold" type="submit" style="margin-top:20px; width:100%;">Cập nhật Banner & Hình ảnh</button>
              </form>
            </div>
          </div>
        </div>
      </div>





