<!-- 4. PRICELIST TAB CONTENT -->
<div id="cms-tab-pricelist" class="cms-tab-content" style="display: none;">
  <div class="layout-split layout-split--wide-left">
    <div>
      <div class="card">
        <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
          🏷️ Quản lý Toàn diện Cấu hình & Nội dung trang Bảng Giá
        </div>
        <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
          Cấu hình toàn bộ các thông tin của trang BẢNG GIÁ XE VinFast bao gồm lời mở đầu bảng giá xe, bộ tài liệu PDF tải xuống, chương trình khuyến mãi & quà tặng đặc quyền cho từng dòng xe, FAQ giải đáp và cẩm nang mua xe chuẩn SEO.
        </p>
        
        <form method="POST" action="admin.php?p=cms">
          <input type="hidden" name="action" value="save_pricelist_info">

          <!-- PHẦN 1: LỜI MỞ ĐẦU & TIÊU ĐỀ -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">🌐 PHẦN 1: Tiêu đề & Lời giới thiệu Bảng Giá</div>
          
          <div class="form-row" style="margin-bottom: 15px;">
            <div class="form-group">
              <label class="form-label" for="pricelist_intro_headline">Lời mở đầu / Tiêu đề chính *</label>
              <input class="form-input" type="text" name="pricelist_intro_headline" id="pricelist_intro_headline" required value="<?php echo htmlspecialchars($pricelist_intro_headline); ?>">
            </div>
          </div>

          <div class="form-group" style="margin-bottom: 30px;">
            <label class="form-label" for="pricelist_intro_desc">Mô tả ngắn gọn giới thiệu bảng giá *</label>
            <textarea class="form-input" name="pricelist_intro_desc" id="pricelist_intro_desc" style="min-height: 70px;" required><?php echo htmlspecialchars($pricelist_intro_desc); ?></textarea>
          </div>


          <!-- PHẦN 2: CHƯƠNG TRÌNH KHUYẾN MÃI & QUÀ TẶNG CHO TỪNG DÒNG XE -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">🎁 PHẦN 2: Cấu hình Khuyến mãi & Quà tặng Đặc quyền theo dòng xe</div>
          <p style="font-size: 11px; color: var(--color-text-muted); margin-bottom: 12px;">
            Thiết lập gói khuyến mãi và các quà tặng hiện vật đặc quyền hiển thị ở khối chi tiết bảng giá. Quà tặng phân cách nhau bằng dấu gạch đứng (<code>|</code>) để hiển thị dạng danh sách gạch đầu dòng ngoài trang chủ.
          </p>
          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="promos-editor-table">
              <thead>
                <tr>
                  <th>Tên Dòng xe VinFast *</th>
                  <th>Chương trình Khuyến mãi (Promo Text) *</th>
                  <th>Gói Quà tặng Đặc quyền (Phân cách bằng |) *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pricelist_promos_data as $index => $promo): ?>
                  <tr>
                    <td>
                      <input class="form-input" style="height:32px; font-size:12px;" type="text" name="promo_model_name[]" required value="<?php echo htmlspecialchars($promo['model_name'] ?? ''); ?>" placeholder="Ví dụ: VinFast VF 9 AWD">
                    </td>
                    <td>
                      <input class="form-input" style="height:32px; font-size:12px;" type="text" name="promo_text[]" required value="<?php echo htmlspecialchars($promo['promo'] ?? ''); ?>" placeholder="Ưu đãi tiền mặt, trước bạ...">
                    </td>
                    <td>
                      <input class="form-input" style="height:32px; font-size:12px;" type="text" name="promo_gifts[]" required value="<?php echo htmlspecialchars($promo['gifts'] ?? ''); ?>" placeholder="Quà tặng 1 | Quà tặng 2...">
                    </td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removePromoRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addPromoRow()">+ Thêm cấu hình ưu đãi xe</button>


          <!-- PHẦN 3: DOWNLOAD CENTER (Brochure / Catalog PDF) -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">📂 PHẦN 3: Trung tâm tải tài liệu PDF (Download Center)</div>
          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="downloads-editor-table">
              <thead>
                <tr>
                  <th>Tên Tài liệu Catalog/Bảng giá PDF *</th>
                  <th>Đường dẫn tải file / Neo liên kết *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pricelist_downloads_data as $index => $dl): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="dl_title[]" required value="<?php echo htmlspecialchars($dl['title'] ?? ''); ?>" placeholder="Ví dụ: Catalog thông số kỹ thuật xe VinFast VF 9"></td>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="dl_url[]" required value="<?php echo htmlspecialchars($dl['url'] ?? '#'); ?>"></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeDownloadRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addDownloadRow()">+ Thêm File tài liệu PDF</button>


          <!-- PHẦN 4: FAQs CHO TRANG BẢNG GIÁ -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">❓ PHẦN 4: Giải đáp thắc mắc thường gặp (FAQ) Bảng Giá</div>
          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="pr-faqs-editor-table">
              <thead>
                <tr>
                  <th>Câu hỏi thường gặp *</th>
                  <th>Câu trả lời chi tiết *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($pricelist_faqs_data as $index => $faq): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="faq_question[]" required value="<?php echo htmlspecialchars($faq['question'] ?? ''); ?>" placeholder="Ví dụ: Phí lăn bánh gồm những gì?"></td>
                    <td><textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4; padding: 4px 6px;" name="faq_answer[]" required><?php echo htmlspecialchars($faq['answer'] ?? ''); ?></textarea></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removePrFaqRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addPrFaqRow()">+ Thêm câu hỏi FAQ mới</button>


          <!-- PHẦN 5: CẨM NANG MUA XE CHUẨN SEO -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">✍️ PHẦN 5: Cẩm nang mua xe & Phân tích bảng giá (SEO Editorial)</div>
          <div class="form-group" style="margin-bottom: 25px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <label class="form-label" for="pricelist_editorial" style="margin:0;">Bài viết Phân tích & Hướng dẫn (Hỗ trợ cấu trúc thẻ HTML/H2/H3/P...) *</label>
              <button type="button" class="btn-gold" id="btn-add-media-pricelist-editorial" style="padding:4px 10px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:6px; box-shadow:none; border-radius:4px; height:auto; line-height:1.2;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:2px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                Thêm Media
              </button>
            </div>
            <textarea class="form-input" name="pricelist_editorial" id="pricelist_editorial" style="min-height: 200px; font-size: 12px; line-height: 1.6;" required><?php 
              if (!empty($pricelist_editorial)) {
                  echo htmlspecialchars($pricelist_editorial);
              } else {
                  echo "<h2>Cẩm nang Mua xe & Phân tích Bảng giá xe VinFast tại Việt Nam</h2>\n<p>Thương hiệu xe điện thông minh VinFast Việt Nam luôn là biểu tượng của sự kết hợp hoàn hảo giữa công nghệ tiên phong (Mãnh liệt tinh thần Việt Nam), hiệu suất vận hành mạnh mẽ và chính sách hậu mãi độc bản...</p>";
              }
            ?></textarea>
          </div>


          <!-- LƯU Ý THUẾ PHÁP LÝ -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px;">⚠️ PHẦN TỔNG HỢP: Ghi chú Thuế & Đăng kiểm</div>
          <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="pricelist_tax_note">Lưu ý về thuế VAT & Chi phí lăn bánh bắt buộc *</label>
            <textarea class="form-input" name="pricelist_tax_note" id="pricelist_tax_note" style="min-height: 80px;" required><?php echo htmlspecialchars($pricelist_tax_note); ?></textarea>
          </div>

          <button class="btn-gold" type="submit" style="margin-top: 20px; width: 100%;">💾 Lưu toàn bộ Cấu hình & Nội dung trang Bảng Giá</button>
        </form>
      </div>
    </div>
  </div>
</div>





