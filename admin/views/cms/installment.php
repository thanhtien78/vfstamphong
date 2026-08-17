<!-- 3. INSTALLMENT TAB CONTENT -->
<div id="cms-tab-installment" class="cms-tab-content" style="display: none;">
  <div class="layout-split layout-split--wide-left">
    <div>
      <div class="card">
        <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
          💰 Quản lý Toàn diện Cấu hình & Nội dung trang Trả Góp
        </div>
        <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
          Cấu hình toàn bộ nội dung hiển thị trên trang MUA XE TRẢ GÓP, từ thông số lãi suất mặc định, danh sách ngân hàng liên kết, quy trình 4 bước, hồ sơ thủ tục, phân khúc vay cho tới khoảnh khắc giao xe thực tế và FAQ giải đáp.
        </p>
        
        <form method="POST" action="admin.php?p=cms">
          <input type="hidden" name="action" value="save_installment_info">

          <!-- PHẦN 1: THÔNG SỐ LÃI SUẤT & NGÂN HÀNG -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>🏦 PHẦN 1: Lãi suất & Ngân hàng liên kết đối tác</span>
          </div>

          <div class="form-group" style="max-width: 250px; margin-bottom: 20px;">
            <label class="form-label" for="installment_interest_default">Lãi suất ưu đãi cố định mặc định (%) *</label>
            <input class="form-input" type="number" step="0.01" name="installment_interest_default" id="installment_interest_default" required value="<?php echo htmlspecialchars($installment_interest_default); ?>">
          </div>

          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="banks-editor-table">
              <thead>
                <tr>
                  <th>Tên Ngân hàng đối tác *</th>
                  <th>Lãi suất ưu đãi (%/năm) *</th>
                  <th>Vay tối đa (%) *</th>
                  <th>Thời hạn vay tối đa (Năm) *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($installment_banks_data as $index => $bank): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="bank_name[]" required value="<?php echo htmlspecialchars($bank['name'] ?? ''); ?>" placeholder="Ví dụ: Shinhan Bank Việt Nam"></td>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="number" step="0.01" name="bank_rate[]" required value="<?php echo htmlspecialchars($bank['rate'] ?? '0'); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="number" name="bank_max_loan[]" required value="<?php echo htmlspecialchars($bank['max_loan'] ?? '80'); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="number" name="bank_max_years[]" required value="<?php echo htmlspecialchars($bank['max_years'] ?? '8'); ?>"></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeBankRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addBankRow()">+ Thêm Ngân hàng đối tác</button>


          <!-- PHẦN 2: QUY TRÌNH MUA XE 4 BƯỚC -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>📋 PHẦN 2: Quy trình mua xe 4 bước tinh gọn</span>
          </div>
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 30px;">
            <?php for ($i = 0; $i < 4; $i++): 
                $step = $installment_steps_data[$i] ?? ['title' => '', 'desc' => ''];
            ?>
              <div style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 15px; border-radius: 8px;">
                <div style="font-weight: bold; color: var(--color-primary); font-size: 11px; margin-bottom: 10px;">BƯỚC <?php echo $i+1; ?></div>
                <div class="form-group" style="margin-bottom: 10px;">
                  <label class="form-label" style="font-size: 10px;">Tiêu đề bước *</label>
                  <input class="form-input" style="height:32px; font-size:12px;" type="text" name="step_title[]" required value="<?php echo htmlspecialchars($step['title']); ?>">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                  <label class="form-label" style="font-size: 10px;">Mô tả bước *</label>
                  <textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4;" name="step_desc[]" required><?php echo htmlspecialchars($step['desc']); ?></textarea>
                </div>
              </div>
            <?php endfor; ?>
          </div>


          <!-- PHẦN 3: ĐẶC ĐIỂM & ĐIỀU KIỆN VAY MUA XE -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>🛡️ PHẦN 3: Đặc điểm & Điều kiện vay vốn chi tiết</span>
          </div>
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
            <div class="form-group">
              <label class="form-label" for="installment_features">Đặc điểm gói vay (Mỗi tiêu chuẩn một dòng) *</label>
              <textarea class="form-input" name="installment_features" id="installment_features" style="min-height: 140px; font-size:12px; line-height: 1.6;" required placeholder="Ví dụ: Hạn mức cho vay: Hỗ trợ lên tới 80% - 85% giá trị xe..."><?php 
                if (!empty($installment_features)) {
                    echo htmlspecialchars($installment_features);
                } else {
                    echo "Hạn mức cho vay: Hỗ trợ lên tới 80% - 85% giá trị xe trên hóa đơn mua bán thực tế. Khách hàng chỉ cần chuẩn bị trước 15% - 20% đối ứng.\nThời gian vay vốn: Linh hoạt kéo dài từ 1 năm (12 tháng) tới tối đa 8 năm (96 tháng) giúp dàn đều chi phí gốc lãi hàng tháng.\nPhương thức tính lãi: Tính lãi trên dư nợ thực tế giảm dần (không tính trên dư nợ ban đầu), số tiền trả lãi sẽ giảm cực kỳ mạnh qua các năm tiếp theo.\nTài sản bảo đảm: Chính chiếc xe VinFast quý khách dự định mua, hoặc bất động sản khác thuộc quyền sở hữu hợp pháp của quý khách.";
                }
              ?></textarea>
            </div>
            <div class="form-group">
              <label class="form-label" for="installment_eligibility">Điều kiện vay vốn (Mỗi điều kiện một dòng) *</label>
              <textarea class="form-input" name="installment_eligibility" id="installment_eligibility" style="min-height: 140px; font-size:12px; line-height: 1.6;" required placeholder="Ví dụ: Độ tuổi người vay: Từ đủ 18 tuổi đến không quá 65 tuổi..."><?php 
                if (!empty($installment_eligibility)) {
                    echo htmlspecialchars($installment_eligibility);
                } else {
                    echo "Độ tuổi người vay: Tại thời điểm nộp hồ sơ vay từ đủ 18 tuổi và không quá 65 tuổi tại thời điểm tất toán toàn bộ khoản vay ngân hàng.\nLịch sử CIC tín dụng: Không có nợ nhóm 3, 4, 5 tại Trung tâm Thông tin Tín dụng Quốc gia (CIC) trong 2 năm gần nhất.\nNguồn thu nhập tối thiểu: Tổng thu nhập ổn định từ lương chuyển khoản ngân hàng tối thiểu 10 triệu/tháng (đối với cá nhân), hoặc có dòng tiền ổn định từ kinh doanh/cho thuê tài sản.\nNơi cư trú hợp pháp: Có hộ khẩu thường trú hoặc đăng ký tạm trú dài hạn (KT3) tại tỉnh/thành phố có chi nhánh giao dịch của ngân hàng liên kết vay.";
                }
              ?></textarea>
            </div>
          </div>


          <!-- PHẦN 4: HỒ SƠ THỦ TỤC CẦN CHUẨP BỊ -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>📂 PHẦN 4: Hồ sơ cần chuẩn bị mua xe trả góp</span>
          </div>
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
            <div class="form-group">
              <label class="form-label" for="installment_docs_personal">Hồ sơ khách hàng cá nhân (Mỗi loại giấy tờ một dòng) *</label>
              <textarea class="form-input" name="installment_docs_personal" id="installment_docs_personal" style="min-height: 140px; font-size:12px; line-height: 1.6;" required placeholder="Ví dụ: CCCD gắn chip của người vay..."><?php 
                if (!empty($installment_docs_personal)) {
                    echo htmlspecialchars($installment_docs_personal);
                } else {
                    echo "Hồ sơ pháp lý: CCCD gắn chip (hoặc định danh VNeID mức độ 2), Giấy xác nhận độc thân hoặc Giấy đăng ký kết hôn của cả hai vợ chồng.\nHồ sơ chứng minh thu nhập: Hợp đồng lao động còn thời hạn hiệu lực, Bảng lương hoặc Sao kê lương ngân hàng 3 - 6 tháng gần nhất.\nThu nhập khác (nếu có): Hợp đồng cho thuê nhà, thuê xe ô tô, hoặc sổ tiết kiệm, giấy tờ sở hữu cổ phần kinh doanh.\nHồ sơ mục đích vay: Hợp đồng mua bán xe ô tô VinFast ký với đại lý chính hãng, Phiếu thu tiền đặt cọc xe.";
                }
              ?></textarea>
            </div>
            <div class="form-group">
              <label class="form-label" for="installment_docs_business">Hồ sơ khách hàng doanh nghiệp (Mỗi loại giấy tờ một dòng) *</label>
              <textarea class="form-input" name="installment_docs_business" id="installment_docs_business" style="min-height: 140px; font-size:12px; line-height: 1.6;" required placeholder="Ví dụ: Giấy đăng ký kinh doanh của công ty..."><?php 
                if (!empty($installment_docs_business)) {
                    echo htmlspecialchars($installment_docs_business);
                } else {
                    echo "Hồ sơ pháp lý doanh nghiệp: Giấy chứng nhận đăng ký doanh nghiệp (GPKD), Điều lệ công ty, Biên bản họp bổ nhiệm người đại diện pháp luật.\nGiấy tờ tùy thân người đại diện: CCCD/Hộ chiếu người đại diện pháp luật ký kết hợp đồng vay vốn.\nHồ sơ tài chính doanh nghiệp: Báo cáo tài chính nội bộ, Báo cáo thuế tối thiểu 1 - 2 năm gần nhất, Sao kê tài khoản ngân hàng công ty 6 tháng qua.\nHồ sơ mục đích vay: Hợp đồng mua bán xe ô tô ký giữa công ty và đại lý VinFast, Phiếu thu/Ủy nhiệm chi tiền đặt cọc xe.";
                }
              ?></textarea>
            </div>
          </div>


          <!-- PHẦN 5: PHÂN KHÚC VAY MUA XE TIÊU BIỂU -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>🚗 PHẦN 5: Các Phân khúc vay mua xe tiêu biểu (3 Phân khúc hiển thị)</span>
          </div>
          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="showcases-editor-table">
              <thead>
                <tr>
                  <th>Nhãn phân khúc *</th>
                  <th>Dòng xe đại diện *</th>
                  <th>Mô tả ngắn gọn *</th>
                  <th>Đường dẫn ảnh minh họa *</th>
                  <th>Mức trả trước *</th>
                  <th>Trả góp gốc + lãi tháng *</th>
                  <th>Cú pháp máy tính trả góp *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($installment_showcases_data as $index => $sc): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_tag[]" required value="<?php echo htmlspecialchars($sc['tag'] ?? ''); ?>" placeholder="Ví dụ: SEDAN SANG TRỌNG"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_title[]" required value="<?php echo htmlspecialchars($sc['title'] ?? ''); ?>" placeholder="Ví dụ: VinFast VF 5 / VF 8"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_desc[]" required value="<?php echo htmlspecialchars($sc['desc'] ?? ''); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_image[]" required value="<?php echo htmlspecialchars($sc['image'] ?? ''); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_prepay[]" required value="<?php echo htmlspecialchars($sc['prepay'] ?? ''); ?>" placeholder="Ví dụ: Chỉ từ 360 Triệu"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="showcase_monthly[]" required value="<?php echo htmlspecialchars($sc['monthly'] ?? ''); ?>" placeholder="Ví dụ: 18 Triệu / tháng"></td>
                    <td>
                      <select class="form-input" style="height:32px; font-size:11px; padding: 4px;" name="showcase_preset[]" required>
                        <?php foreach ($allCarsForSettings as $carModel): ?>
                          <option value="<?php echo htmlspecialchars($carModel); ?>" <?php echo (isset($sc['preset']) && $sc['preset'] === $carModel) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($carModel); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeShowcaseRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addShowcaseRow()">+ Thêm phân khúc vay mới</button>


          <!-- PHẦN 6: KHOẢNH KHẮC BÀN GIAO XE VIP -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>📸 PHẦN 6: Album ảnh & Cảm nghĩ bàn giao xe VIP thực tế</span>
          </div>
          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="gallery-editor-table">
              <thead>
                <tr>
                  <th>Nhãn phân khúc *</th>
                  <th>Tên dòng bàn giao *</th>
                  <th>Trích dẫn cảm nghĩ *</th>
                  <th>Ảnh bàn giao thực tế *</th>
                  <th>Tên Khách hàng *</th>
                  <th>Chức danh / Nghề nghiệp *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($installment_gallery_data as $index => $g): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_tag[]" required value="<?php echo htmlspecialchars($g['tag'] ?? ''); ?>" placeholder="Ví dụ: KHÁCH HÀNG DOANH NHÂN"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_title[]" required value="<?php echo htmlspecialchars($g['title'] ?? ''); ?>" placeholder="Ví dụ: Bàn giao VinFast VF 9"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_desc[]" required value="<?php echo htmlspecialchars($g['desc'] ?? ''); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_image[]" required value="<?php echo htmlspecialchars($g['image'] ?? ''); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_customer_name[]" required value="<?php echo htmlspecialchars($g['customer_name'] ?? ''); ?>" placeholder="Ví dụ: Anh Trần Minh H."></td>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="gallery_customer_role[]" required value="<?php echo htmlspecialchars($g['customer_role'] ?? ''); ?>" placeholder="Ví dụ: CEO Công nghệ xanh"></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeGalleryRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addGalleryRow()">+ Thêm slide bàn giao xe</button>


          <!-- PHẦN 7: CÁC CÂU HỎI THƯỜNG GẶP (FAQs) -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>❓ PHẦN 7: Giải đáp thắc mắc thường gặp (FAQ)</span>
          </div>
          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="faqs-editor-table">
              <thead>
                <tr>
                  <th>Câu hỏi thường gặp *</th>
                  <th>Câu trả lời chi tiết chuẩn hãng *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($installment_faqs_data as $index => $faq): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:11px;" type="text" name="faq_question[]" required value="<?php echo htmlspecialchars($faq['question'] ?? ''); ?>" placeholder="Ví dụ: Thủ tục mua xe trả góp gồm những gì?"></td>
                    <td><textarea class="form-input" style="min-height: 50px; font-size:11px; line-height: 1.4; padding: 4px 6px;" name="faq_answer[]" required><?php echo htmlspecialchars($faq['answer'] ?? ''); ?></textarea></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeFaqRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none; margin-bottom: 30px;" onclick="addFaqRow()">+ Thêm câu hỏi FAQ mới</button>


          <!-- PHẦN TỔNG HỢP: KHUYẾN CÁO TÀI CHÍNH -->
          <div style="font-size: 12px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; display: flex; align-items: center; gap: 8px;">
            <span>⚠️ PHẦN CUỐI: Lưu ý tài chính & Khuyến cáo</span>
          </div>
          <div class="form-group">
            <label class="form-label" for="installment_disclaimer">Khuyến cáo / Lưu ý tài chính (Disclaimer) *</label>
            <textarea class="form-input" name="installment_disclaimer" id="installment_disclaimer" style="min-height: 80px; font-size:12px; line-height: 1.5;" required><?php echo htmlspecialchars($installment_disclaimer); ?></textarea>
          </div>

          <button class="btn-gold" type="submit" style="margin-top: 20px; width: 100%;">💾 Lưu toàn bộ Cấu hình & Nội dung trang Trả Góp</button>
        </form>
      </div>
    </div>
  </div>
</div>





