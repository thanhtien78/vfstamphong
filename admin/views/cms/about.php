<!-- 2. ABOUT US TAB CONTENT -->
<div id="cms-tab-about" class="cms-tab-content" style="display: none;">
  <form method="POST" action="admin.php?p=cms" enctype="multipart/form-data" id="about-cms-unified-form">
    <input type="hidden" name="action" value="save_about">
    
    <div class="layout-split layout-split--wide-left">
      <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- PHẦN 1: BANNER HERO ĐẦU TRANG -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            🏠 Phần 1: Banner Hero Đầu Trang
          </div>
          <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
            Cấu hình hình ảnh nền và nội dung chữ hiển thị trên khối Banner Hero trang trọng đầu trang Giới thiệu.
          </p>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="about_hero_tag">Nhãn phụ Hero Tag *</label>
              <input class="form-input" type="text" name="about_hero_tag" id="about_hero_tag" required value="<?php echo htmlspecialchars($about_hero_tag); ?>" placeholder="Ví dụ: Mãnh liệt Tinh thần Việt Nam">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_hero_title">Tiêu đề chính Hero Title (Hỗ trợ &lt;br&gt;) *</label>
              <input class="form-input" type="text" name="about_hero_title" id="about_hero_title" required value="<?php echo htmlspecialchars($about_hero_title); ?>" placeholder="Ví dụ: Khai phóng tương lai<br>bằng công nghệ">
            </div>
          </div>

          <div class="form-group" style="margin-top: 15px;">
            <label class="form-label" for="about_hero_desc">Mô tả ngắn Hero Description *</label>
            <textarea class="form-input" name="about_hero_desc" id="about_hero_desc" style="min-height: 80px; font-size:12px; line-height:1.5;" required><?php echo htmlspecialchars($about_hero_desc); ?></textarea>
          </div>

          <div class="form-group" style="margin-top: 15px;">
            <label class="form-label" for="about_hero_image_file">Ảnh nền Banner Hero (Ảnh Ngang)</label>
            <?php if (!empty($about_hero_image_url)): ?>
              <div style="margin: 8px 0;">
                <img src="<?php echo htmlspecialchars($about_hero_image_url); ?>" style="max-width: 100%; border-radius: 6px; border: 1px solid var(--color-border); max-height: 150px; object-fit: cover;">
              </div>
            <?php endif; ?>
            <input type="file" name="about_hero_image_file" id="about_hero_image_file" accept="image/*" style="font-size: 12px; margin-top: 5px; display: block;">
            <input class="form-input" type="text" name="about_hero_image_url" style="margin-top: 8px;" value="<?php echo htmlspecialchars($about_hero_image_url); ?>" placeholder="Hoặc dán URL ảnh ngoài...">
          </div>
        </div>

        <!-- PHẦN 2: GIỚI THIỆU TỔNG QUAN -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            ℹ️ Phần 2: Giới thiệu & Sứ mệnh Tổng quan
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="about_title">Tiêu đề chính trang Giới thiệu *</label>
              <input class="form-input" type="text" name="about_title" id="about_title" required value="<?php echo htmlspecialchars($about_title); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_intro_tag">Thẻ nhãn Intro Tag *</label>
              <input class="form-input" type="text" name="about_intro_tag" id="about_intro_tag" required value="<?php echo htmlspecialchars($about_intro_tag); ?>" placeholder="Ví dụ: Chúng tôi là ai?">
            </div>
          </div>

          <div class="form-group" style="margin-top: 15px;">
            <label class="form-label" for="about_intro_headline">Dòng Slogan / Tiêu đề trích dẫn nổi bật *</label>
            <input class="form-input" type="text" name="about_intro_headline" id="about_intro_headline" required value="<?php echo htmlspecialchars($about_intro_headline); ?>">
          </div>

          <div class="form-group" style="margin-top: 15px;">
            <label class="form-label" for="about_intro_text">Văn bản chi tiết giới thiệu (Hỗ trợ HTML/Paragraphs) *</label>
            <textarea class="form-input" name="about_intro_text" id="about_intro_text" style="min-height: 180px; font-family: inherit; line-height: 1.6;" required><?php echo htmlspecialchars($about_intro_text); ?></textarea>
          </div>
        </div>

        <!-- PHẦN 3: CAROUSEL KHÔNG GIAN SHOWROOM -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            🖼️ Phần 3: Không gian trải nghiệm (Showroom Slides)
          </div>
          <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
            Quản lý hình ảnh và văn bản giới thiệu không gian đẳng cấp 5 sao tại VinFast Terminal (Phòng chờ sạc DC, Handover,...).
          </p>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="about_gallery_tag">Thẻ nhãn Gallery Tag *</label>
              <input class="form-input" type="text" name="about_gallery_tag" id="about_gallery_tag" required value="<?php echo htmlspecialchars($about_gallery_tag); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_gallery_title">Tiêu đề chính Gallery Title *</label>
              <input class="form-input" type="text" name="about_gallery_title" id="about_gallery_title" required value="<?php echo htmlspecialchars($about_gallery_title); ?>">
            </div>
          </div>
          
          <div class="form-group" style="margin-top: 15px; margin-bottom: 20px;">
            <label class="form-label" for="about_gallery_desc">Mô tả ngắn Gallery Description *</label>
            <input class="form-input" type="text" name="about_gallery_desc" id="about_gallery_desc" required value="<?php echo htmlspecialchars($about_gallery_desc); ?>">
          </div>

          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="slides-editor-table">
              <thead>
                <tr>
                  <th>Tên slide/Khu vực *</th>
                  <th>Hình ảnh slide *</th>
                  <th>Mô tả chi tiết slide *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($about_gallery_slides_data as $idx => $slide): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_gallery_slide_title[]" required value="<?php echo htmlspecialchars($slide['title']); ?>" placeholder="Tiêu đề slide"></td>
                    <td>
                      <?php if (!empty($slide['image'])): ?>
                        <div style="margin-bottom: 5px;">
                          <img src="<?php echo htmlspecialchars($slide['image']); ?>" style="max-height: 40px; border-radius: 4px; border: 1px solid var(--color-border); display: block;">
                        </div>
                      <?php endif; ?>
                      <input type="file" name="about_gallery_slide_file[]" accept="image/*" style="font-size:10px; display:block; margin-bottom:4px;">
                      <input class="form-input" style="height:28px; font-size:11px; padding: 2px 6px;" type="text" name="about_gallery_slide_image[]" value="<?php echo htmlspecialchars($slide['image']); ?>" placeholder="Hoặc dán URL ảnh ngoài...">
                    </td>
                    <td><textarea class="form-input" style="height:55px; font-size:12px; font-family:inherit; line-height:1.4; resize:vertical;" name="about_gallery_slide_desc[]" required><?php echo htmlspecialchars($slide['desc']); ?></textarea></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeSlideRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none;" onclick="addSlideRow()">+ Thêm Slide không gian Showroom</button>
        </div>

        <!-- PHẦN 3.5: BA TRỤ CỘT CÔNG NGHỆ TIÊN PHONG -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            ⚡ Phần 3.5: Ba trụ cột công nghệ tiên phong (AWD, Matrix LED, EV)
          </div>
          <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
            Biên tập nội dung giới thiệu 3 đại diện tinh hoa kỹ nghệ cốt lõi của thương hiệu VinFast.
          </p>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="about_tech_tag">Thẻ nhãn Tech Tag *</label>
              <input class="form-input" type="text" name="about_tech_tag" id="about_tech_tag" required value="<?php echo htmlspecialchars($about_tech_tag); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_tech_title">Tiêu đề chính Tech Title *</label>
              <input class="form-input" type="text" name="about_tech_title" id="about_tech_title" required value="<?php echo htmlspecialchars($about_tech_title); ?>">
            </div>
          </div>
          
          <div class="form-group" style="margin-top: 15px; margin-bottom: 20px;">
            <label class="form-label" for="about_tech_desc">Mô tả ngắn Tech Description *</label>
            <input class="form-input" type="text" name="about_tech_desc" id="about_tech_desc" required value="<?php echo htmlspecialchars($about_tech_desc); ?>">
          </div>

          <div style="display: flex; flex-direction: column; gap: 15px;">
            <?php foreach ($about_tech_list_data as $i => $tech): ?>
              <div style="background: rgba(255,255,255,0.012); border: 1px solid var(--color-border); padding: 14px; border-radius: 6px;">
                <div style="font-weight: 700; font-size: 11px; color: var(--color-primary); margin-bottom: 8px; text-transform: uppercase;">
                  CÔNG NGHỆ #<?php echo $i + 1; ?>: <input type="text" name="about_tech_name[<?php echo $i; ?>]" style="background:transparent; border:none; border-bottom:1px dashed var(--color-primary); color:var(--color-primary); font-weight:bold; font-size:11px; padding: 0 4px; width:100px;" value="<?php echo htmlspecialchars($tech['name']); ?>" required>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Thẻ nhãn tagline phụ *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_tech_tagline[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($tech['tag']); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Tiêu đề nổi bật *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_tech_heading[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($tech['title']); ?>">
                  </div>
                </div>
                
                <div class="form-group" style="margin-top: 8px;">
                  <label class="form-label" style="font-size: 10px;">Đoạn văn miêu tả chi tiết *</label>
                  <textarea class="form-input" style="min-height:60px; font-size: 12px; font-family:inherit; line-height:1.4;" name="about_tech_description[<?php echo $i; ?>]" required><?php echo htmlspecialchars($tech['desc']); ?></textarea>
                </div>
                
                <div class="form-row" style="margin-top: 8px;">
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Đặc điểm nổi bật (Phân tách bằng dấu chấm phẩy ;) *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_tech_features_list[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($tech['features']); ?>" placeholder="Đặc điểm 1; Đặc điểm 2; Đặc điểm 3">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">URL hình ảnh minh họa công nghệ *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_tech_image_url[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($tech['image']); ?>">
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- PHẦN 7: DÒNG CHẢY LỊCH SỬ (TIMELINE) -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            📅 Phần 7: Cột mốc Lịch sử & Dòng chảy thời gian
          </div>
          <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
            Quản lý hành trình di sản phát triển của VinFast thông qua các năm cột mốc đặc trưng, hiển thị dạng dòng chảy thời gian (Timeline).
          </p>
          
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="about_history_tag">Thẻ nhãn History Tag *</label>
              <input class="form-input" type="text" name="about_history_tag" id="about_history_tag" required value="<?php echo htmlspecialchars($about_history_tag); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_history_title">Tiêu đề chính History Title *</label>
              <input class="form-input" type="text" name="about_history_title" id="about_history_title" required value="<?php echo htmlspecialchars($about_history_title); ?>">
            </div>
          </div>
          
          <div class="form-group" style="margin-top: 15px; margin-bottom: 20px;">
            <label class="form-label" for="about_history_desc">Mô tả ngắn History Description *</label>
            <input class="form-input" type="text" name="about_history_desc" id="about_history_desc" required value="<?php echo htmlspecialchars($about_history_desc); ?>">
          </div>

          <div class="table-container" style="margin-bottom: 15px;">
            <table class="cms-table" id="timeline-editor-table">
              <thead>
                <tr>
                  <th style="width: 120px;">Năm mốc *</th>
                  <th style="width: 250px;">Tiêu đề cột mốc *</th>
                  <th>Nội dung chi tiết cột mốc lịch sử *</th>
                  <th style="width: 50px;"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($about_history_timeline_data as $idx => $milestone): ?>
                  <tr>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_history_year[]" required value="<?php echo htmlspecialchars($milestone['year']); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_history_milestone_title[]" required value="<?php echo htmlspecialchars($milestone['title']); ?>"></td>
                    <td><input class="form-input" style="height:32px; font-size:12px;" type="text" name="about_history_milestone_desc[]" required value="<?php echo htmlspecialchars($milestone['desc']); ?>"></td>
                    <td><button type="button" class="btn-danger" style="padding:4px 8px; font-size:10px;" onclick="removeTimelineRow(this)">Xóa</button></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <button type="button" class="btn-gold" style="font-size: 11px; padding: 6px 12px; box-shadow:none;" onclick="addTimelineRow()">+ Thêm cột mốc Lịch sử</button>
        </div>
      </div>

      <!-- CỘT PHẢI: PHẦN STATS, GIÁ TRỊ, BLOCKQUOTE, CAM KẾT & MAPS -->
      <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- PHẦN 4: SỐ LIỆU ẤN TƯỢNG (STATS) -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            📊 Phần 4: Số liệu Ấn tượng (Stats)
          </div>
          <div style="display: flex; flex-direction: column; gap: 14px;">
            <?php foreach ($about_stats_data as $i => $st): ?>
              <div style="background: rgba(255,255,255,0.01); border: 1px solid var(--color-border); padding: 12px; border-radius: 6px;">
                <div style="font-weight: 700; font-size: 11px; color: var(--color-primary); margin-bottom: 6px;">CHỈ SỐ STATS #<?php echo $i + 1; ?></div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Số/Đơn vị *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_stat_number[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($st['number']); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Thẻ nhãn chỉ chỉ số *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_stat_label[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($st['label']); ?>">
                  </div>
                </div>
                <div class="form-group" style="margin-top: 6px;">
                  <label class="form-label" style="font-size: 10px;">Mô tả ngắn gọn chỉ số stats *</label>
                  <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_stat_desc[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($st['desc']); ?>">
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- PHẦN 5: CÂU NÓI TRUYỀN CẢM HỨNG (QUOTE) -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            💬 Phần 5: Câu nói / Trích dẫn nổi tiếng
          </div>
          <div class="form-group">
            <label class="form-label" for="about_quote_text">Nội dung câu nói trích dẫn *</label>
            <textarea class="form-input" name="about_quote_text" id="about_quote_text" style="min-height: 80px; font-size:12px; line-height: 1.5;" required><?php echo htmlspecialchars($about_quote_text); ?></textarea>
          </div>
          <div class="form-row" style="margin-top: 10px;">
            <div class="form-group">
              <label class="form-label" for="about_quote_author">Tác giả câu nói *</label>
              <input class="form-input" style="height:34px; font-size:12px;" type="text" name="about_quote_author" id="about_quote_author" required value="<?php echo htmlspecialchars($about_quote_author); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_quote_author_title">Chức vụ tác giả *</label>
              <input class="form-input" style="height:34px; font-size:12px;" type="text" name="about_quote_author_title" id="about_quote_author_title" required value="<?php echo htmlspecialchars($about_quote_author_title); ?>">
            </div>
          </div>
          <div class="form-group" style="margin-top: 15px;">
            <label class="form-label" for="about_quote_bg_image">Ảnh nền khối trích dẫn (Quote Background Image)</label>
            <input class="form-input" style="height:34px; font-size:12px;" type="text" name="about_quote_bg_image" id="about_quote_bg_image" value="<?php echo htmlspecialchars($about_quote_bg_image); ?>" placeholder="Đường dẫn URL ảnh nền hoặc chọn dưới đây">
            <input class="form-input" type="file" name="about_quote_bg_image_file" id="about_quote_bg_image_file" accept="image/*" style="margin-top:8px;">
          </div>
        </div>

        <!-- PHẦN 6: 3 GIÁ TRỊ CỐT LÕI (PILLARS) -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            ✨ Phần 6: 3 Giá trị cốt lõi di sản DNA
          </div>
          <div style="display: flex; flex-direction: column; gap: 15px;">
            <?php foreach ($about_values_data as $i => $val): ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 14px; border-radius: 6px;">
                <div style="font-weight: 700; font-size: 11px; color: var(--color-primary); margin-bottom: 8px; text-transform: uppercase;">Giá trị cốt lõi #<?php echo $i + 1; ?></div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Tiêu đề *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_val_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($val['title'] ?? ''); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Icon Class FontAwesome *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_val_icon[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($val['icon'] ?? 'fas fa-check'); ?>">
                  </div>
                </div>
                <div class="form-group" style="margin-top: 8px;">
                  <label class="form-label" style="font-size: 10px;">Mô tả ngắn *</label>
                  <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_val_desc[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($val['desc'] ?? ''); ?>">
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- PHẦN 8: CAM KẾT ĐẠI LÝ -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            🛡️ Phần 8: Cam kết Đại lý & Dịch vụ hậu mãi
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="about_commitments_tag">Thẻ nhãn Cam kết *</label>
              <input class="form-input" type="text" name="about_commitments_tag" id="about_commitments_tag" required value="<?php echo htmlspecialchars($about_commitments_tag); ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="about_commitments_title">Tiêu đề chính Cam kết *</label>
              <input class="form-input" type="text" name="about_commitments_title" id="about_commitments_title" required value="<?php echo htmlspecialchars($about_commitments_title); ?>">
            </div>
          </div>
          <div class="form-group" style="margin-top: 10px; margin-bottom: 15px;">
            <label class="form-label" for="about_commitments_desc">Mô tả ngắn cam kết *</label>
            <input class="form-input" type="text" name="about_commitments_desc" id="about_commitments_desc" required value="<?php echo htmlspecialchars($about_commitments_desc); ?>">
          </div>

          <div style="display: flex; flex-direction: column; gap: 12px;">
            <?php foreach ($about_commitments_list_data as $i => $comm): ?>
              <div style="background: rgba(255,255,255,0.01); border: 1px solid var(--color-border); padding: 12px; border-radius: 6px;">
                <div style="font-weight: 700; font-size: 11px; color: var(--color-primary); margin-bottom: 6px;">CAM KẾT DỊCH VỤ #<?php echo $i + 1; ?></div>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Tiêu đề *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_commitment_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($comm['title']); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Icon Class/SVG (layers/lock/wrench) *</label>
                    <select class="form-input" style="height:32px; font-size: 12px;" name="about_commitment_icon[<?php echo $i; ?>]">
                      <option value="layers" <?php echo ($comm['icon'] === 'layers') ? 'selected' : ''; ?>>Lớp bảo vệ (Layers)</option>
                      <option value="lock" <?php echo ($comm['icon'] === 'lock') ? 'selected' : ''; ?>>Khóa an tâm (Lock)</option>
                      <option value="wrench" <?php echo ($comm['icon'] === 'wrench') ? 'selected' : ''; ?>>Cơ khí/Sửa chữa (Wrench)</option>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="margin-top: 6px;">
                  <label class="form-label" style="font-size: 10px;">Mô tả chi tiết cam kết dịch vụ *</label>
                  <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_commitment_desc[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($comm['desc']); ?>">
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- PHẦN 9: HÀNH ĐỘNG KÊU GỌI (CTAS) -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            📞 Phần 9: Thẻ Hành Động Kêu Gọi (CTAs)
          </div>
          <p style="font-size: 11px; color: var(--color-text-muted); margin-bottom: 15px;">
            Cấu hình 3 hộp kêu gọi hành động (ví dụ: Chat Zalo, Đăng ký lái thử, Bảng giá xe) ở chân trang Giới thiệu.
          </p>
          <div style="display: flex; flex-direction: column; gap: 15px;">
            <?php foreach ($about_ctas_list_data as $i => $cta): ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); padding: 12px; border-radius: 6px;">
                <div style="font-weight: 700; font-size: 11px; color: var(--color-primary); margin-bottom: 6px;">HỘP CTA #<?php echo $i + 1; ?></div>
                <div class="form-row">
                  <div class="form-row">
                    <div class="form-group">
                      <label class="form-label" style="font-size: 10px;">Tiêu đề *</label>
                      <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_cta_title[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($cta['title']); ?>">
                    </div>
                    <div class="form-group">
                      <label class="form-label" style="font-size: 10px;">Text Nút bấm *</label>
                      <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_cta_btn_text[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($cta['btn_text']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-row" style="margin-top: 6px;">
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Đường dẫn (Link) *</label>
                    <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_cta_link[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($cta['link']); ?>">
                  </div>
                  <div class="form-group">
                    <label class="form-label" style="font-size: 10px;">Loại Button Class *</label>
                    <select class="form-input" style="height:32px; font-size: 12px;" name="about_cta_btn_class[<?php echo $i; ?>]">
                      <option value="btn-about-zalo" <?php echo ($cta['btn_class'] === 'btn-about-zalo') ? 'selected' : ''; ?>>Xanh Dương (Zalo)</option>
                      <option value="btn-about-gold" <?php echo ($cta['btn_class'] === 'btn-about-gold') ? 'selected' : ''; ?>>Vàng Gold (Primary)</option>
                      <option value="btn-about-outline" <?php echo ($cta['btn_class'] === 'btn-about-outline') ? 'selected' : ''; ?>>Viền trắng (Outline)</option>
                    </select>
                  </div>
                </div>
                <div class="form-group" style="margin-top: 6px;">
                  <label class="form-label" style="font-size: 10px;">Mô tả ngắn gọn CTA *</label>
                  <input class="form-input" style="height:32px; font-size: 12px;" type="text" name="about_cta_desc[<?php echo $i; ?>]" required value="<?php echo htmlspecialchars($cta['desc']); ?>">
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- PHẦN 10: HÌNH ẢNH ĐẠI DIỆN SHOWROOM -->
        <div class="card">
          <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary);">
            🖼️ Ảnh Đại diện Showroom (Khối Giới thiệu)
          </div>
          <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px;">
            Tải lên hình ảnh showroom chính để hiển thị bên cạnh đoạn văn kể chuyện giới thiệu tổng quan ở đầu trang.
          </p>
          
          <div class="form-group">
            <label class="form-label" for="about_image_file">Hình ảnh chính diện Showroom</label>
            <?php if (!empty($about_image_url)): ?>
              <div style="margin: 8px 0;">
                <img src="<?php echo htmlspecialchars($about_image_url); ?>" style="max-width: 100%; border-radius: 6px; border: 1px solid var(--color-border); max-height: 120px; object-fit: cover;">
              </div>
            <?php endif; ?>
            <input type="file" name="about_image_file" id="about_image_file" accept="image/*" style="font-size: 12px; margin-top: 5px; display: block;">
            <input class="form-input" type="text" name="about_image_url" style="margin-top: 8px;" value="<?php echo htmlspecialchars($about_image_url); ?>" placeholder="Hoặc dán URL liên kết ảnh ngoài...">
          </div>
        </div>
      </div>
    </div>

    <!-- STICKY BOTTOM PUBLISH BAR -->
    <div style="position: sticky; bottom: 20px; z-index: 10; margin-top: 30px; display: flex; justify-content: center; width: 100%;">
      <button class="btn-gold" type="submit" style="width: 80%; padding: 16px 32px; font-size: 14px; font-weight: 800; border-radius: 30px; box-shadow: 0 10px 30px rgba(56, 189, 248, 0.25); text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease;">
        💾 Lưu toàn bộ thay đổi trang Giới Thiệu
      </button>
    </div>
  </form>
</div>





