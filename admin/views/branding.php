      <?php
        // Fetch settings for branding
        $stmt = $db->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }
      ?>
      <div class="layout-split layout-split--wide-left">
        <!-- Left Column: Header, SEO, Socials & VIP Cover -->
        <div>
          <!-- SEO & Meta Card -->
          <div class="card">
            <div class="card__title" style="display: flex; align-items: center; gap: 8px; color: var(--color-primary); font-size: 14px; font-weight: 700;">
              <span>🌐 THIẾT LẬP HEADER & SEO META TỐI ƯU</span>
            </div>
            <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
              💡 <strong>Lợi thế SEO 2026:</strong> Thay đổi tiêu đề, mô tả và từ khóa khai báo Meta để tìm kiếm Google định dạng tối đa nội dung showroom của bạn.
            </p>
            <form method="POST" action="admin.php?p=branding" id="branding-left-form" onsubmit="event.preventDefault(); submitBrandingForms();">
              <input type="hidden" name="action" value="save_branding">
              
              <!-- Copy variables from right form dynamically before submit -->
              <input type="hidden" name="agency_name" id="hidden_agency_name">
              <input type="hidden" name="agency_email" id="hidden_agency_email">
              <input type="hidden" name="agency_address" id="hidden_agency_address">
              <input type="hidden" name="agency_hours" id="hidden_agency_hours">
              <input type="hidden" name="footer_tagline" id="hidden_footer_tagline">
              <input type="hidden" name="footer_copyright" id="hidden_footer_copyright">
              <input type="hidden" name="policy_privacy_link" id="hidden_policy_privacy_link">
              <input type="hidden" name="policy_terms_link" id="hidden_policy_terms_link">
              <input type="hidden" name="portal_cms_link" id="hidden_portal_cms_link">

              <!-- Footer Column 2 Links -->
              <input type="hidden" name="footer_col2_title" id="hidden_footer_col2_title">
              <input type="hidden" name="footer_col2_link1_text" id="hidden_footer_col2_link1_text">
              <input type="hidden" name="footer_col2_link1_url" id="hidden_footer_col2_link1_url">
              <input type="hidden" name="footer_col2_link2_text" id="hidden_footer_col2_link2_text">
              <input type="hidden" name="footer_col2_link2_url" id="hidden_footer_col2_link2_url">
              <input type="hidden" name="footer_col2_link3_text" id="hidden_footer_col2_link3_text">
              <input type="hidden" name="footer_col2_link3_url" id="hidden_footer_col2_link3_url">
              <input type="hidden" name="footer_col2_link4_text" id="hidden_footer_col2_link4_text">
              <input type="hidden" name="footer_col2_link4_url" id="hidden_footer_col2_link4_url">

              <!-- Footer Column 3 Links -->
              <input type="hidden" name="footer_col3_title" id="hidden_footer_col3_title">
              <input type="hidden" name="footer_col3_link1_text" id="hidden_footer_col3_link1_text">
              <input type="hidden" name="footer_col3_link1_url" id="hidden_footer_col3_link1_url">
              <input type="hidden" name="footer_col3_link2_text" id="hidden_footer_col3_link2_text">
              <input type="hidden" name="footer_col3_link2_url" id="hidden_footer_col3_link2_url">
              <input type="hidden" name="footer_col3_link3_text" id="hidden_footer_col3_link3_text">
              <input type="hidden" name="footer_col3_link3_url" id="hidden_footer_col3_link3_url">
              <input type="hidden" name="footer_col3_link4_text" id="hidden_footer_col3_link4_text">
              <input type="hidden" name="footer_col3_link4_url" id="hidden_footer_col3_link4_url">

              <div class="form-group">
                <label class="form-label" for="site_title">Tiêu đề Website chính (SEO Meta Title) *</label>
                <input class="form-input" type="text" name="site_title" id="site_title" required value="<?php echo htmlspecialchars($settings['site_title'] ?? 'VinFast Việt Nam - Cổng thông tin chính thức'); ?>" placeholder="Tiêu đề hiển thị trên thanh tab trình duyệt">
              </div>
              
              <div class="form-group" style="margin-top:15px;">
                <label class="form-label" for="site_desc">Mô tả Website (SEO Meta Description) *</label>
                <textarea class="form-input" name="site_desc" id="site_desc" rows="4" required placeholder="Nhập mô tả ngắn gọn tóm tắt website phục vụ tìm kiếm Google..."><?php echo htmlspecialchars($settings['site_desc'] ?? 'Khám phá các mẫu xe VinFast sang trọng, EV thuần điện và xe xăng đẳng cấp chính hãng.'); ?></textarea>
              </div>

              <div class="form-row" style="margin-top:15px;">
                <div class="form-group">
                  <label class="form-label" for="site_keywords">Từ khóa Website (SEO Keywords)</label>
                  <input class="form-input" type="text" name="site_keywords" id="site_keywords" value="<?php echo htmlspecialchars($settings['site_keywords'] ?? 'VinFast, VinFast vietnam, VinFast EV, VinFast VF 9, VinFast a5'); ?>" placeholder="Các từ khóa cách nhau bằng dấu phẩy">
                </div>
                <div class="form-group">
                  <label class="form-label" for="agency_phone">Hotline Header chính *</label>
                  <input class="form-input" type="text" name="agency_phone" id="agency_phone" required value="<?php echo htmlspecialchars($settings['agency_phone'] ?? '081.7777.855'); ?>" placeholder="Nhập số điện thoại hotline">
                </div>
              </div>

              <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 30px 0 10px 0;">ĐƯỜNG DẪN MẠNG XÃ HỘI CHÂN TRANG</div>
              
              <div class="form-row--triple">
                <div class="form-group">
                  <label class="form-label" for="footer_facebook">Facebook URL</label>
                  <input class="form-input" type="text" name="footer_facebook" id="footer_facebook" value="<?php echo htmlspecialchars($settings['footer_facebook'] ?? '#'); ?>" placeholder="https://facebook.com/...">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_instagram">Instagram URL</label>
                  <input class="form-input" type="text" name="footer_instagram" id="footer_instagram" value="<?php echo htmlspecialchars($settings['footer_instagram'] ?? '#'); ?>" placeholder="https://instagram.com/...">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_youtube">YouTube URL</label>
                  <input class="form-input" type="text" name="footer_youtube" id="footer_youtube" value="<?php echo htmlspecialchars($settings['footer_youtube'] ?? '#'); ?>" placeholder="https://youtube.com/...">
                </div>
              </div>

              <button class="btn-gold" type="button" onclick="submitBrandingForms()" style="margin-top:35px; width: 100%; font-weight: 700; font-size: 13px; padding: 12px;">💾 LƯU TOÀN BỘ CẤU HÌNH BRANDING</button>
            </form>
          </div>
        </div>

        <!-- Right Column: Footer Slogan, Showroom details, Legal links & VIP Modal -->
        <div>
          <!-- Footer Branding Card -->
          <div class="card">
            <div class="card__title" style="display: flex; align-items: center; gap: 8px; color: var(--color-primary); font-size: 14px; font-weight: 700;">
              <span>🏢 CẤU HÌNH FOOTER & THÔNG TIN SHOWROOM</span>
            </div>
            <form id="branding-right-form" onsubmit="event.preventDefault(); submitBrandingForms();">
              <!-- Physical Showroom -->
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="branding_agency_name">Tên Showroom / Đại lý *</label>
                  <input class="form-input" type="text" id="branding_agency_name" required value="<?php echo htmlspecialchars($settings['agency_name'] ?? 'VinFast Việt Nam - Chi nhánh Tp. Hồ Chí Minh'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="branding_agency_email">Email liên hệ đại lý *</label>
                  <input class="form-input" type="email" id="branding_agency_email" required value="<?php echo htmlspecialchars($settings['agency_email'] ?? 'info@VinFastvn.com'); ?>">
                </div>
              </div>

              <div class="form-row" style="margin-top:15px;">
                <div class="form-group">
                  <label class="form-label" for="branding_agency_address">Địa chỉ Showroom vật lý *</label>
                  <input class="form-input" type="text" id="branding_agency_address" required value="<?php echo htmlspecialchars($settings['agency_address'] ?? '6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1, Tp. Hồ Chí Minh'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="branding_agency_hours">Thời gian mở cửa làm việc *</label>
                  <input class="form-input" type="text" id="branding_agency_hours" required value="<?php echo htmlspecialchars($settings['agency_hours'] ?? 'Thứ 2 - Thứ 7: 8:00 - 18:00 | Chủ Nhật: 9:00 - 17:00'); ?>">
                </div>
              </div>

              <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 30px 0 10px 0;">LIÊN KẾT PHÁP LÝ & PORTAL HỆ THỐNG</div>
              
              <div class="form-row--triple">
                <div class="form-group">
                  <label class="form-label" for="policy_privacy_link">Chính sách bảo mật (URL)</label>
                  <input class="form-input" type="text" id="policy_privacy_link" value="<?php echo htmlspecialchars($settings['policy_privacy_link'] ?? '#'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="policy_terms_link">Điều khoản sử dụng (URL)</label>
                  <input class="form-input" type="text" id="policy_terms_link" value="<?php echo htmlspecialchars($settings['policy_terms_link'] ?? '#'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="portal_cms_link">Portal CMS Login Link</label>
                  <input class="form-input" type="text" id="portal_cms_link" value="<?php echo htmlspecialchars($settings['portal_cms_link'] ?? 'login.php'); ?>">
                </div>
              </div>

              <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 30px 0 10px 0;">SLOGAN & BẢN QUYỀN CHÂN TRANG (HỖ TRỢ HTML)</div>

              <div class="form-group">
                <label class="form-label" for="footer_tagline">Slogan / Tagline Chân trang (Cột 1)</label>
                <textarea class="form-input" id="footer_tagline" rows="3" placeholder="Nhập câu slogan thương hiệu..."><?php echo htmlspecialchars($settings['footer_tagline'] ?? '<strong>Mãnh liệt tinh thần Việt Nam</strong><br>Tiên phong trong công nghệ điện hóa EV, nâng tầm trải nghiệm lái thể thao và dịch vụ đẳng cấp 5 sao toàn cầu.'); ?></textarea>
              </div>

              <div class="form-group" style="margin-top:15px;">
                <label class="form-label" for="footer_copyright">Thông tin bản quyền Copyright dưới đáy</label>
                <textarea class="form-input" id="footer_copyright" rows="3" placeholder="Nhập bản quyền tác giả..."><?php echo htmlspecialchars($settings['footer_copyright'] ?? 'Bản quyền © 2026 VinFast Việt Nam. Tất cả quyền được bảo lưu. <br>Các thông số kỹ thuật, hình ảnh và trang bị thực tế có thể thay đổi bởi nhà sản xuất mà không báo trước.'); ?></textarea>
              </div>

              <div style="font-size: 11.5px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 35px 0 10px 0; border-top: 1px dashed var(--color-border); padding-top: 20px; display: flex; align-items: center; gap: 8px;">
                <span>🔗 CẤU HÌNH LIÊN KẾT NHANH CHÂN TRANG (FOOTER QUICK LINKS)</span>
              </div>
              <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
                💡 <strong>Quản lý liên kết chân trang:</strong> Thay đổi tiêu đề cột, nhãn hiển thị và đường dẫn URL của tất cả liên kết cột 2 và cột 3 ở chân trang.
              </p>

              <!-- Cột 2 Chân trang -->
              <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 15px 0 10px 0;">CỘT 2: DÒNG XE NỔI BẬT</div>
              <div class="form-group">
                <label class="form-label" for="footer_col2_title">Tiêu đề Cột 2 *</label>
                <input class="form-input" type="text" id="footer_col2_title" required value="<?php echo htmlspecialchars($settings['footer_col2_title'] ?? 'Dòng xe nổi bật'); ?>">
              </div>
              
              <!-- Cột 2: Link 1 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link1_text">Liên kết 1: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col2_link1_text" required value="<?php echo htmlspecialchars($settings['footer_col2_link1_text'] ?? 'VinFast VF 3 (Xe điện quốc dân)'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link1_url">Liên kết 1: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col2_link1_url" required value="<?php echo htmlspecialchars($settings['footer_col2_link1_url'] ?? 'cars.php'); ?>">
                </div>
              </div>

              <!-- Cột 2: Link 2 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link2_text">Liên kết 2: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col2_link2_text" required value="<?php echo htmlspecialchars($settings['footer_col2_link2_text'] ?? 'VinFast VF 9 (SUV thuần điện)'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link2_url">Liên kết 2: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col2_link2_url" required value="<?php echo htmlspecialchars($settings['footer_col2_link2_url'] ?? 'cars.php'); ?>">
                </div>
              </div>

              <!-- Cột 2: Link 3 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link3_text">Liên kết 3: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col2_link3_text" required value="<?php echo htmlspecialchars($settings['footer_col2_link3_text'] ?? 'VinFast VF 8 (SUV thuần điện)'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link3_url">Liên kết 3: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col2_link3_url" required value="<?php echo htmlspecialchars($settings['footer_col2_link3_url'] ?? 'cars.php'); ?>">
                </div>
              </div>

              <!-- Cột 2: Link 4 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link4_text">Liên kết 4: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col2_link4_text" required value="<?php echo htmlspecialchars($settings['footer_col2_link4_text'] ?? 'Định giá xe & Lên đời'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col2_link4_url">Liên kết 4: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col2_link4_url" required value="<?php echo htmlspecialchars($settings['footer_col2_link4_url'] ?? 'index.php#tradein-block'); ?>">
                </div>
              </div>

              <!-- Cột 3 Chân trang -->
              <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin: 25px 0 10px 0;">CỘT 3: LIÊN KẾT DỊCH VỤ</div>
              <div class="form-group">
                <label class="form-label" for="footer_col3_title">Tiêu đề Cột 3 *</label>
                <input class="form-input" type="text" id="footer_col3_title" required value="<?php echo htmlspecialchars($settings['footer_col3_title'] ?? 'Liên kết dịch vụ'); ?>">
              </div>
              
              <!-- Cột 3: Link 1 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link1_text">Liên kết 1: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col3_link1_text" required value="<?php echo htmlspecialchars($settings['footer_col3_link1_text'] ?? 'Đặc quyền chính hãng'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link1_url">Liên kết 1: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col3_link1_url" required value="<?php echo htmlspecialchars($settings['footer_col3_link1_url'] ?? 'index.php#privileges-block'); ?>">
                </div>
              </div>

              <!-- Cột 3: Link 2 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link2_text">Liên kết 2: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col3_link2_text" required value="<?php echo htmlspecialchars($settings['footer_col3_link2_text'] ?? 'Gói ưu đãi chào hè'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link2_url">Liên kết 2: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col3_link2_url" required value="<?php echo htmlspecialchars($settings['footer_col3_link2_url'] ?? 'index.php#offers-block'); ?>">
                </div>
              </div>

              <!-- Cột 3: Link 3 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link3_text">Liên kết 3: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col3_link3_text" required value="<?php echo htmlspecialchars($settings['footer_col3_link3_text'] ?? 'Trang quản trị CRM'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link3_url">Liên kết 3: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col3_link3_url" required value="<?php echo htmlspecialchars($settings['footer_col3_link3_url'] ?? 'admin.php'); ?>">
                </div>
              </div>

              <!-- Cột 3: Link 4 -->
              <div class="form-row" style="margin-top:10px;">
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link4_text">Liên kết 4: Nhãn hiển thị *</label>
                  <input class="form-input" type="text" id="footer_col3_link4_text" required value="<?php echo htmlspecialchars($settings['footer_col3_link4_text'] ?? 'Đặt lịch hẹn lái thử'); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label" for="footer_col3_link4_url">Liên kết 4: URL / Đường dẫn *</label>
                  <input class="form-input" type="text" id="footer_col3_link4_url" required value="<?php echo htmlspecialchars($settings['footer_col3_link4_url'] ?? 'cars.php#booking-block'); ?>">
                </div>
              </div>

               <!-- VIP Popup Card (Moved to CMS Forms Tab) -->
              <div style="margin-top: 30px; border: 1px dashed var(--color-border); background: rgba(20,26,40,0.45); padding: 16px; border-radius: 8px;">
                <div style="font-size: 11.5px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; letter-spacing:0.5px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                  <span>🎁 HỘP THOẠI KHUYẾN MÃI DỰ PHÒNG (VIP MODAL POPUP)</span>
                </div>
                <p style="font-size: 12px; color: var(--color-text-muted); line-height: 1.5; margin: 0 0 12px 0;">
                  Thiết lập cho Hộp thoại Khuyến mãi VIP (Popup nhận báo giá) đã được gom nhóm và chuyển sang tab <strong>Form Đăng Ký & Popup</strong> trong phần Quản lý Nội dung (CMS) để quản lý tập trung.
                </p>
                <a href="admin.php?p=cms" class="btn-gold" style="font-size: 10.5px; padding: 6px 12px; text-decoration: none; display: inline-block;">📋 Đi tới Quản lý Form & Popup (CMS)</a>
              </div>
              
              <!-- Double Save button at the bottom of the right column form -->
              <button class="btn-gold" type="button" onclick="submitBrandingForms()" style="margin-top:35px; width: 100%; font-weight: 700; font-size: 13px; padding: 12px;">💾 LƯU TOÀN BỘ CẤU HÌNH BRANDING</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Sync right form inputs to left form hidden fields to submit together -->
      <script>
        function submitBrandingForms() {
          // Sync rich editors content back to textareas if TinyMCE is active
          if (typeof tinymce !== "undefined") {
            tinymce.triggerSave();
          }

          // Sync basic showroom & email fields
          document.getElementById('hidden_agency_name').value = document.getElementById('branding_agency_name').value;
          document.getElementById('hidden_agency_email').value = document.getElementById('branding_agency_email').value;
          document.getElementById('hidden_agency_address').value = document.getElementById('branding_agency_address').value;
          document.getElementById('hidden_agency_hours').value = document.getElementById('branding_agency_hours').value;
          
          // Sync legal links
          document.getElementById('hidden_policy_privacy_link').value = document.getElementById('policy_privacy_link').value;
          document.getElementById('hidden_policy_terms_link').value = document.getElementById('policy_terms_link').value;
          document.getElementById('hidden_portal_cms_link').value = document.getElementById('portal_cms_link').value;
          

          // Sync textareas
          document.getElementById('hidden_footer_tagline').value = document.getElementById('footer_tagline').value;
          document.getElementById('hidden_footer_copyright').value = document.getElementById('footer_copyright').value;

          // Sync Footer Column 2 Links
          document.getElementById('hidden_footer_col2_title').value = document.getElementById('footer_col2_title').value;
          document.getElementById('hidden_footer_col2_link1_text').value = document.getElementById('footer_col2_link1_text').value;
          document.getElementById('hidden_footer_col2_link1_url').value = document.getElementById('footer_col2_link1_url').value;
          document.getElementById('hidden_footer_col2_link2_text').value = document.getElementById('footer_col2_link2_text').value;
          document.getElementById('hidden_footer_col2_link2_url').value = document.getElementById('footer_col2_link2_url').value;
          document.getElementById('hidden_footer_col2_link3_text').value = document.getElementById('footer_col2_link3_text').value;
          document.getElementById('hidden_footer_col2_link3_url').value = document.getElementById('footer_col2_link3_url').value;
          document.getElementById('hidden_footer_col2_link4_text').value = document.getElementById('footer_col2_link4_text').value;
          document.getElementById('hidden_footer_col2_link4_url').value = document.getElementById('footer_col2_link4_url').value;

          // Sync Footer Column 3 Links
          document.getElementById('hidden_footer_col3_title').value = document.getElementById('footer_col3_title').value;
          document.getElementById('hidden_footer_col3_link1_text').value = document.getElementById('footer_col3_link1_text').value;
          document.getElementById('hidden_footer_col3_link1_url').value = document.getElementById('footer_col3_link1_url').value;
          document.getElementById('hidden_footer_col3_link2_text').value = document.getElementById('footer_col3_link2_text').value;
          document.getElementById('hidden_footer_col3_link2_url').value = document.getElementById('footer_col3_link2_url').value;
          document.getElementById('hidden_footer_col3_link3_text').value = document.getElementById('footer_col3_link3_text').value;
          document.getElementById('hidden_footer_col3_link3_url').value = document.getElementById('footer_col3_link3_url').value;
          document.getElementById('hidden_footer_col3_link4_text').value = document.getElementById('footer_col3_link4_text').value;
          document.getElementById('hidden_footer_col3_link4_url').value = document.getElementById('footer_col3_link4_url').value;

          // Perform native validation check on both forms and submit
          const leftForm = document.getElementById('branding-left-form');
          const rightForm = document.getElementById('branding-right-form');
          
          if (leftForm.checkValidity() && rightForm.checkValidity()) {
            leftForm.submit();
          } else {
            // Trigger browser standard tooltip messages
            leftForm.reportValidity();
            rightForm.reportValidity();
          }
        }

        // Initialize TinyMCE for Tagline & Copyright textareas
        document.addEventListener("DOMContentLoaded", function() {
          if (typeof tinymce !== "undefined" && document.getElementById('footer_tagline') && document.getElementById('footer_copyright')) {
            tinymce.init({
              selector: '#footer_tagline, #footer_copyright',
              height: 180,
              menubar: false,
              plugins: [
                'advlist', 'autolink', 'lists', 'link', 'code', 'help', 'wordcount'
              ],
              toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | link code | removeformat',
              content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:13px; background-color:#141a26; color:#fff; }' +
                             'body.mce-content-body { background-color: #141a26; color: #fff; }' +
                             'a { color: #38bdf8 !important; text-decoration: underline !important; } a:hover { color: #fff !important; }',
              skin: 'oxide-dark',
              content_css: 'dark',
              setup: function(editor) {
                editor.on('change keyup input', function() {
                  editor.save();
                });
              }
            });
          }
        });
      </script>





