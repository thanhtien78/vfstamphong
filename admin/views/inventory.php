      <?php
        $carIdToEdit = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : 0;
        $editCar = null;
        if ($carIdToEdit > 0) {
            $stmt = $db->prepare("SELECT * FROM cars WHERE id = ?");
            $stmt->execute([$carIdToEdit]);
            $editCar = $stmt->fetch();
        }

        // Pre-fill specification templates for dynamic editing
        $brochure_url = $editCar ? htmlspecialchars($editCar['brochure_url'] ?? '') : '';

        $core_features_arr = [];
        if ($editCar && !empty($editCar['core_features'])) {
            $core_features_arr = json_decode($editCar['core_features'], true);
        }
        if (!is_array($core_features_arr) || count($core_features_arr) < 3) {
            $core_features_arr = [
                [
                    "image" => "https://images.unsplash.com/photo-1606016159991-dfe4f2746ad5?auto=format&fit=crop&w=600&q=80",
                    "tag" => "Legendary Drivetrain",
                    "title" => "Hệ dẫn động bốn bánh AWD®",
                    "desc" => "Biểu tượng làm nên danh tiếng toàn cầu của VinFast. Hệ thống tự động phân bổ mô-men xoắn linh hoạt đến từng bánh xe trong mili giây, mang lại khả năng bám đường tối đa và độ ổn định vô song trên mọi điều kiện địa hình."
                ],
                [
                    "image" => "https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?auto=format&fit=crop&w=600&q=80",
                    "tag" => "Intelligent Light",
                    "title" => "Đèn pha Matrix LED đỉnh cao",
                    "desc" => "Công nghệ chiếu sáng thông minh mang tính cách mạng của VinFast. Hệ thống diode phát quang độc lập tự động điều chỉnh luồng sáng, né tránh luồng sáng trực tiếp chiếu vào phương tiện đối diện để chống chói mắt, đồng thời tối ưu tầm nhìn toàn diện."
                ],
                [
                    "image" => "https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=600&q=80",
                    "tag" => "Mechanical Prowess",
                    "title" => "Trái tim Hiệu suất Động cơ xăng / EV",
                    "desc" => "Dù là động cơ xăng tăng áp mạnh mẽ hay khối pin EV điện hóa tiên phong, mỗi cỗ máy của VinFast đều là một kiệt tác cơ khí chính xác và công nghệ pin/động cơ tiên phong, đem lại phản hồi ga tức thời và gia tốc xé gió đầy xúc cảm."
                ]
            ];
        }

        $tech_highlights_arr = [];
        if ($editCar && !empty($editCar['tech_highlights'])) {
            $tech_highlights_arr = json_decode($editCar['tech_highlights'], true);
        }
        if (!is_array($tech_highlights_arr) || count($tech_highlights_arr) < 8) {
            $modelLower = $editCar ? mb_strtolower($editCar['model_name']) : '';
            if (strpos($modelLower, 'EV') !== false) {
                $tech_highlights_arr = [
                    ["icon" => "🔋", "title" => "Pin Lithium-ion 800V", "desc" => "Kiến trúc điện áp 800V tiên phong giúp duy trì dòng sạc cực đại lâu hơn và giảm thiểu tối đa sinh nhiệt."],
                    ["icon" => "⚡", "title" => "Hệ sạc siêu nhanh DC 270kW", "desc" => "Đặc quyền sạc siêu nhanh công suất lớn tại hệ thống đại lý VinFast, sạc đầy từ 10% lên 80% chỉ trong 22 phút."],
                    ["icon" => "🌀", "title" => "Thu hồi năng lượng phanh", "desc" => "Hệ thống phanh tái sinh thông minh chuyển đổi động năng thừa khi giảm tốc thành điện năng sạc ngược lại vào pin."],
                    ["icon" => "🔇", "title" => "Cabin tĩnh lặng tuyệt đối", "desc" => "Cabin tĩnh lặng tối đa nhờ cách âm 2 lớp dày dặn và triệt tiêu hoàn toàn rung chấn cơ học động cơ đốt trong."],
                    ["icon" => "📐", "title" => "Khí động học chủ động (Cd 0.24)", "desc" => "Hệ số cản gió cực thấp nhờ thiết kế gầm phẳng, khe hút gió biến thiên và cánh gió sau tự động nâng hạ."],
                    ["icon" => "🔗", "title" => "Dẫn động AWD điện hóa", "desc" => "Hai mô-tơ điện độc lập phân bổ lực kéo nhanh gấp 5 lần hệ dẫn động cơ học, bám đường vô song."],
                    ["icon" => "🔮", "title" => "Buồng lái Virtual Cockpit EV", "desc" => "Giao diện ảo hiển thị chuyên biệt dòng chảy năng lượng, trạng thái pin, công suất sạc và bản đồ thông minh."],
                    ["icon" => "🔊", "title" => "Bang & Olufsen 3D EV", "desc" => "Trải nghiệm âm thanh vòm 3D trung thực hòa quyện cùng tiếng rít cơ học điện tử EV độc quyền sinh động."]
                ];
            } else {
                $tech_highlights_arr = [
                    ["icon" => "⚙️", "title" => "Động cơ tăng áp mạnh mẽ", "desc" => "Công nghệ tăng áp cuộn kép tiên tiến giúp loại bỏ hoàn toàn độ trễ ga, đem lại mô-men xoắn tối đa ở vòng tua thấp cho trải nghiệm thể thao."],
                    ["icon" => "⚡", "title" => "Hộp số tự động ZF 8 cấp", "desc" => "Hộp số tự động 8 cấp ZF danh tiếng thế giới cho phép chuyển cấp số cực kỳ êm ái, mượt mà và tiết kiệm nhiên liệu."],
                    ["icon" => "☁️", "title" => "Hệ thống treo thích ứng", "desc" => "Tự động điều chỉnh độ cứng giảm chấn độc lập theo bề mặt địa hình thực tế để mang lại sự êm ái tối đa."],
                    ["icon" => "🛡️", "title" => "Khung gầm tiêu chuẩn Châu Âu", "desc" => "Cấu trúc khung xe vững chắc gia cố bằng thép cường lực hấp thụ lực va chạm, bảo vệ khoang hành khách an toàn tối đa."],
                    ["icon" => "🛋️", "title" => "Nội thất da sang trọng VIP", "desc" => "Hàng ghế bọc da cao cấp chỉnh điện đa hướng, tích hợp bộ nhớ vị trí, sưởi và thông gió đẳng cấp."],
                    ["icon" => "🌡️", "title" => "Điều hòa tự động lọc bụi mịn", "desc" => "Hệ thống kiểm soát chất lượng không khí tích hợp màng lọc PM2.5 mang lại không gian trong lành nhất."],
                    ["icon" => "🔮", "title" => "Màn hình giải trí cảm ứng lớn", "desc" => "Màn hình cảm ứng kích thước lớn sắc nét kết hợp kết nối Apple CarPlay và Android Auto không dây tiện lợi."],
                    ["icon" => "🔊", "title" => "Âm thanh vòm sống động", "desc" => "Trải nghiệm âm thanh cao cấp trung thực tái tạo sống động như một rạp hát thu nhỏ ngay trong cabin."]
                ];
            }
        }

        $owner_benefits_arr = [];
        if ($editCar && !empty($editCar['owner_benefits'])) {
            $owner_benefits_arr = json_decode($editCar['owner_benefits'], true);
        }
        if (!is_array($owner_benefits_arr) || count($owner_benefits_arr) < 4) {
            $owner_benefits_arr = [
                ["title" => "Trợ lý ảo tiếng Việt thông minh ViVi", "desc" => "Trải nghiệm rảnh tay vượt trội với trợ lý ảo tiếng Việt ViVi hỗ trợ khẩu lệnh đa vùng miền, giúp điều khiển điều hòa, giải trí và giải đáp thông tin nhanh chóng."],
                ["title" => "Tấm khiên an toàn ASEAN NCAP 5 sao", "desc" => "Tuyệt đối an tâm bảo vệ gia đình nhờ cấu trúc khung gầm thép chịu lực cao kết hợp các gói trợ lái thông minh chủ động ADAS đạt chứng nhận an toàn hàng đầu."],
                ["title" => "Tiên phong chuyển đổi xanh bền vững", "desc" => "Việc sở hữu dòng xe thuần điện thông minh khẳng định vị thế dẫn đầu xu hướng, thức thời và đóng góp trực tiếp vào mục tiêu bảo vệ môi trường bền vững."],
                ["title" => "Chính sách bảo hành 10 năm vượt trội", "desc" => "Đặc quyền bảo hành xe chính hãng lên tới 10 năm hoặc 200.000 km độc bản, đi kèm dịch vụ cứu hộ khẩn cấp 24/7 chuyên nghiệp trên toàn quốc."]
            ];
        }
      ?>

      <!-- Insert / Update form inline panel -->
      <div class="card inline-action-card">
        <div class="card__title"><?php echo $editCar ? 'Cập nhật thông số kỹ thuật xe #' . $editCar['id'] : 'Thêm dòng xe mới vào kho đại lý'; ?></div>
        <form method="POST" action="admin.php?p=inventory" enctype="multipart/form-data">
          <input type="hidden" name="action" value="<?php echo $editCar ? 'edit' : 'create'; ?>">
          <?php if ($editCar): ?>
            <input type="hidden" name="id" value="<?php echo $editCar['id']; ?>">
          <?php endif; ?>

          <!-- Premium Tab Navigation -->
          <div class="form-tabs" style="display: flex; gap: 8px; margin-bottom: 25px; border-bottom: 1px solid var(--color-border); padding-bottom: 8px; overflow-x: auto;">
            <button type="button" class="form-tab-btn form-tab-btn--active" onclick="switchFormTab('basic', this)" style="background: transparent; border: none; color: var(--color-primary); font-weight: 600; padding: 10px 16px; cursor: pointer; border-bottom: 2px solid var(--color-primary); transition: all 0.3s ease; white-space: nowrap; font-size: 13px;">1. Thông số & Động cơ</button>
            <button type="button" class="form-tab-btn" onclick="switchFormTab('technology', this)" style="background: transparent; border: none; color: var(--color-text-muted); font-weight: 600; padding: 10px 16px; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.3s ease; white-space: nowrap; font-size: 13px;">2. Công nghệ Cốt lõi (3 phần)</button>
            <button type="button" class="form-tab-btn" onclick="switchFormTab('highlights', this)" style="background: transparent; border: none; color: var(--color-text-muted); font-weight: 600; padding: 10px 16px; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.3s ease; white-space: nowrap; font-size: 13px;">3. 8 Tính năng nổi bật</button>
            <button type="button" class="form-tab-btn" onclick="switchFormTab('benefits', this)" style="background: transparent; border: none; color: var(--color-text-muted); font-weight: 600; padding: 10px 16px; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.3s ease; white-space: nowrap; font-size: 13px;">4. Đặc quyền & Brochure PDF</button>
            <button type="button" class="form-tab-btn" onclick="switchFormTab('seo', this)" style="background: transparent; border: none; color: var(--color-text-muted); font-weight: 600; padding: 10px 16px; cursor: pointer; border-bottom: 2px solid transparent; transition: all 0.3s ease; white-space: nowrap; font-size: 13px;">5. Tối ưu hóa SEO</button>
          </div>

          <!-- Hidden Textareas to hold compiled JSON arrays -->
          <textarea name="core_features" id="core_features_input" style="display:none;"></textarea>
          <textarea name="tech_highlights" id="tech_highlights_input" style="display:none;"></textarea>
          <textarea name="owner_benefits" id="owner_benefits_input" style="display:none;"></textarea>

          <!-- TAB 1: BASIC SPECS -->
          <div id="form-tab-basic" class="form-tab-content">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="model_name">Tên dòng xe *</label>
                <input class="form-input" type="text" name="model_name" id="model_name" required value="<?php echo $editCar ? htmlspecialchars($editCar['model_name']) : ''; ?>" placeholder="Ví dụ: VinFast VF 9 AWD">
              </div>
              <div class="form-group">
                <label class="form-label" for="segment">Phân khúc xe</label>
                <input class="form-input" type="text" name="segment" id="segment" value="<?php echo $editCar ? htmlspecialchars($editCar['segment']) : ''; ?>" placeholder="Ví dụ: Sedan điện hạng sang">
              </div>
            </div>

            <div class="form-row--triple" style="margin-top: 15px;">
              <div class="form-group">
                <label class="form-label" for="engine">Động cơ</label>
                <input class="form-input" type="text" name="engine" id="engine" value="<?php echo $editCar ? htmlspecialchars($editCar['engine']) : ''; ?>" placeholder="Ví dụ: Hai động cơ điện">
              </div>
              <div class="form-group">
                <label class="form-label" for="power">Công suất tối đa</label>
                <input class="form-input" type="text" name="power" id="power" value="<?php echo $editCar ? htmlspecialchars($editCar['power']) : ''; ?>" placeholder="Ví dụ: 530 mã lực">
              </div>
              <div class="form-group">
                <label class="form-label" for="torque">Mô-men xoắn</label>
                <input class="form-input" type="text" name="torque" id="torque" value="<?php echo $editCar ? htmlspecialchars($editCar['torque']) : ''; ?>" placeholder="Ví dụ: 640 Nm">
              </div>
            </div>

            <div class="form-row--triple" style="margin-top: 15px;">
              <div class="form-group">
                <label class="form-label" for="acceleration">Gia tốc (0-100 km/h)</label>
                <input class="form-input" type="text" name="acceleration" id="acceleration" value="<?php echo $editCar ? htmlspecialchars($editCar['acceleration']) : ''; ?>" placeholder="Ví dụ: 4.1 giây">
              </div>
              <div class="form-group">
                <label class="form-label" for="top_speed">Tốc độ tối đa</label>
                <input class="form-input" type="text" name="top_speed" id="top_speed" value="<?php echo $editCar ? htmlspecialchars($editCar['top_speed']) : ''; ?>" placeholder="Ví dụ: 245 km/h">
              </div>
              <div class="form-group">
                <label class="form-label" for="range_wltp">Tầm hoạt động (WLTP)</label>
                <input class="form-input" type="text" name="range_wltp" id="range_wltp" value="<?php echo $editCar ? htmlspecialchars($editCar['range_wltp']) : ''; ?>" placeholder="Ví dụ: 488 km">
              </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
              <div class="form-group">
                <label class="form-label" for="price">Giá niêm yết công bố *</label>
                <input class="form-input" type="text" name="price" id="price" required value="<?php echo $editCar ? htmlspecialchars($editCar['price']) : ''; ?>" placeholder="Ví dụ: Từ 4.800.000.000 VNĐ">
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label" for="stock_status">Tình trạng tồn kho</label>
                  <select class="form-input" name="stock_status" id="stock_status">
                    <option value="Còn hàng" <?php echo ($editCar && $editCar['stock_status'] === 'Còn hàng') ? 'selected' : ''; ?>>Còn hàng</option>
                    <option value="Đặt trước" <?php echo ($editCar && $editCar['stock_status'] === 'Đặt trước') ? 'selected' : ''; ?>>Đặt trước (Chờ nhập)</option>
                    <option value="Hết hàng" <?php echo ($editCar && $editCar['stock_status'] === 'Hết hàng') ? 'selected' : ''; ?>>Tạm hết hàng</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label" for="stock_qty">Số lượng trong kho *</label>
                  <input class="form-input" type="number" name="stock_qty" id="stock_qty" required value="<?php echo $editCar ? (int)$editCar['stock_qty'] : '5'; ?>">
                </div>
              </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
              <div class="form-group">
                <label class="form-label" for="image">Hình ảnh đại diện xe (URL hoặc Tải ảnh lên) *</label>
                <input class="form-input" type="text" name="image" id="image" value="<?php echo $editCar ? htmlspecialchars($editCar['image']) : ''; ?>" placeholder="Nhập đường dẫn URL ảnh hoặc chọn tệp dưới đây">
                <input class="form-input" type="file" name="image_file" id="image_file" accept="image/*" style="margin-top:8px;">
              </div>
              <div class="form-group">
                <label class="form-label" for="video_url">Đường dẫn video (YouTube Embed URL)</label>
                <input class="form-input" type="text" name="video_url" id="video_url" value="<?php echo $editCar ? htmlspecialchars($editCar['video_url']) : ''; ?>" placeholder="https://www.youtube.com/embed/...">
              </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
              <div class="form-group">
                <label class="form-label" for="image_exterior">Ảnh Ngoại thất xe (Các URL cách nhau bằng dấu phẩy hoặc Tải lên nhiều ảnh)</label>
                <input class="form-input" type="text" name="image_exterior" id="image_exterior" value="<?php echo $editCar ? htmlspecialchars($editCar['image_exterior']) : ''; ?>" placeholder="Đường dẫn URL (phân cách bằng dấu phẩy nếu có nhiều ảnh) hoặc tải lên dưới đây">
                <input class="form-input" type="file" name="image_exterior_file[]" id="image_exterior_file" accept="image/*" multiple style="margin-top:8px;">
                <div class="image-preview-container" id="preview_exterior_container">
                  <?php 
                  if ($editCar && !empty($editCar['image_exterior'])) {
                      $ext_list = array_filter(explode(',', $editCar['image_exterior']));
                      foreach ($ext_list as $img) {
                          $img_trim = trim($img);
                          if (!empty($img_trim)) {
                              echo '<div class="image-preview-item">';
                              echo '<img src="' . htmlspecialchars($img_trim) . '?v=' . time() . '">';
                              echo '<button type="button" class="remove-btn" onclick="removePreviewImage(\'image_exterior\', \'' . addslashes($img_trim) . '\', this)">×</button>';
                              echo '</div>';
                          }
                      }
                  } else {
                      echo '<span style="font-size:11px; color:var(--color-text-muted);">Chưa có ảnh ngoại thất nào</span>';
                  }
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label" for="image_interior">Ảnh Nội thất xe (Các URL cách nhau bằng dấu phẩy hoặc Tải lên nhiều ảnh)</label>
                <input class="form-input" type="text" name="image_interior" id="image_interior" value="<?php echo $editCar ? htmlspecialchars($editCar['image_interior']) : ''; ?>" placeholder="Đường dẫn URL (phân cách bằng dấu phẩy nếu có nhiều ảnh) hoặc tải lên dưới đây">
                <input class="form-input" type="file" name="image_interior_file[]" id="image_interior_file" accept="image/*" multiple style="margin-top:8px;">
                <div class="image-preview-container" id="preview_interior_container">
                  <?php 
                  if ($editCar && !empty($editCar['image_interior'])) {
                      $int_list = array_filter(explode(',', $editCar['image_interior']));
                      foreach ($int_list as $img) {
                          $img_trim = trim($img);
                          if (!empty($img_trim)) {
                              echo '<div class="image-preview-item">';
                              echo '<img src="' . htmlspecialchars($img_trim) . '?v=' . time() . '">';
                              echo '<button type="button" class="remove-btn" onclick="removePreviewImage(\'image_interior\', \'' . addslashes($img_trim) . '\', this)">×</button>';
                              echo '</div>';
                          }
                      }
                  } else {
                      echo '<span style="font-size:11px; color:var(--color-text-muted);">Chưa có ảnh nội thất nào</span>';
                  }
                  ?>
                </div>
              </div>
            </div>

            <div class="form-row" style="margin-top: 15px;">
              <div class="form-group">
                <label class="form-label" for="image_engine">Ảnh Động cơ & Công nghệ (Các URL cách nhau bằng dấu phẩy hoặc Tải lên nhiều ảnh)</label>
                <input class="form-input" type="text" name="image_engine" id="image_engine" value="<?php echo $editCar ? htmlspecialchars($editCar['image_engine']) : ''; ?>" placeholder="Đường dẫn URL (phân cách bằng dấu phẩy nếu có nhiều ảnh) hoặc tải lên dưới đây">
                <input class="form-input" type="file" name="image_engine_file[]" id="image_engine_file" accept="image/*" multiple style="margin-top:8px;">
                <div class="image-preview-container" id="preview_engine_container">
                  <?php 
                  if ($editCar && !empty($editCar['image_engine'])) {
                      $tech_list = array_filter(explode(',', $editCar['image_engine']));
                      foreach ($tech_list as $img) {
                          $img_trim = trim($img);
                          if (!empty($img_trim)) {
                              echo '<div class="image-preview-item">';
                              echo '<img src="' . htmlspecialchars($img_trim) . '?v=' . time() . '">';
                              echo '<button type="button" class="remove-btn" onclick="removePreviewImage(\'image_engine\', \'' . addslashes($img_trim) . '\', this)">×</button>';
                              echo '</div>';
                          }
                      }
                  } else {
                      echo '<span style="font-size:11px; color:var(--color-text-muted);">Chưa có ảnh động cơ/công nghệ nào</span>';
                  }
                  ?>
                </div>
              </div>
              <div class="form-group">
                <label class="form-label" for="image_specs">Ảnh Thông số / Chi tiết (URL hoặc Tải lên)</label>
                <input class="form-input" type="text" name="image_specs" id="image_specs" value="<?php echo $editCar ? htmlspecialchars($editCar['image_specs']) : ''; ?>" placeholder="Đường dẫn URL hoặc tải lên dưới đây">
                <input class="form-input" type="file" name="image_specs_file" id="image_specs_file" accept="image/*" style="margin-top:8px;">
              </div>
            </div>

            <div class="form-group" style="margin-top: 15px;">
              <label class="form-label" for="exterior_colors">Màu sơn ngoại thất (Định dạng: Tên màu|Mã hex, cách nhau bằng dấu phẩy)</label>
              <input class="form-input" type="text" name="exterior_colors" id="exterior_colors" value="<?php echo $editCar ? htmlspecialchars($editCar['exterior_colors']) : 'Trắng Brahminy|#ffffff,Đen Jet Black|#121212,Xám Neptune|#4a4e52,Xanh VinFast Blue|#10b981'; ?>" placeholder="Đen Jet Black|#000000,Trắng Brahminy|#ffffff">
            </div>

            <div class="form-group" style="margin-top: 15px;">
              <label class="form-label" for="description">Mô tả tóm tắt dòng xe</label>
              <textarea class="form-input" name="description" id="description" placeholder="Nhập giới thiệu chi tiết dòng xe..."><?php echo $editCar ? htmlspecialchars($editCar['description']) : ''; ?></textarea>
            </div>
          </div>

          <!-- TAB 2: CORE TECHNOLOGY SHOWCASES -->
          <div id="form-tab-technology" class="form-tab-content" style="display: none;">
            <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px; border-left: 2px solid var(--color-primary); padding-left: 8px;">
              💡 <strong>Thiết kế Storytelling:</strong> Phần này hiển thị tại mục "Nghệ thuật & Công nghệ Cốt lõi" với cấu trúc so le bất đối xứng sang trọng. Nhập 3 đặc tính ấn tượng nhất về cơ học/động cơ của xe.
            </p>
            <?php for ($i = 0; $i < 3; $i++): 
                $feat = $core_features_arr[$i] ?? ['image' => '', 'tag' => '', 'title' => '', 'desc' => ''];
            ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 6px; padding: 15px; margin-bottom: 15px;">
                <h4 style="color: var(--color-primary); margin-bottom: 12px; font-size: 13px; text-transform: uppercase; font-weight: 600;">Mục <?php echo ($i + 1); ?>: Banner Trình chiếu Cốt lõi</h4>
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Nhãn Tiêu đề Phụ (Tag, ví dụ: Legendary Drivetrain)</label>
                    <input class="form-input core-feat-tag" type="text" data-index="<?php echo $i; ?>" value="<?php echo htmlspecialchars($feat['tag'] ?? ''); ?>" placeholder="Ví dụ: Legendary Drivetrain">
                  </div>
                  <div class="form-group">
                    <label class="form-label">Tiêu đề Chính *</label>
                    <input class="form-input core-feat-title" type="text" data-index="<?php echo $i; ?>" required value="<?php echo htmlspecialchars($feat['title'] ?? ''); ?>" placeholder="Ví dụ: Hệ dẫn động bốn bánh AWD®">
                  </div>
                </div>
                <div class="form-row" style="margin-top: 10px;">
                  <div class="form-group">
                    <label class="form-label">Hình ảnh nghệ thuật cốt lõi (URL hoặc Tải ảnh lên)</label>
                    <input class="form-input core-feat-image" type="text" data-index="<?php echo $i; ?>" id="core_feat_image_<?php echo $i; ?>" value="<?php echo htmlspecialchars($feat['image'] ?? ''); ?>" placeholder="Nhập đường dẫn URL ảnh hoặc chọn tệp dưới đây">
                    <input class="form-input" type="file" name="core_feat_image_file_<?php echo $i; ?>" accept="image/*" style="margin-top:8px;">
                  </div>
                </div>
                <div class="form-group" style="margin-top: 10px;">
                  <label class="form-label">Nội dung mô tả chi tiết *</label>
                  <textarea class="form-input core-feat-desc" data-index="<?php echo $i; ?>" rows="3" required placeholder="Nhập mô tả sâu về giá trị mang lại..."><?php echo htmlspecialchars($feat['desc'] ?? ''); ?></textarea>
                </div>
              </div>
            <?php endfor; ?>
          </div>

          <!-- TAB 3: 8 TECH HIGHLIGHTS -->
          <div id="form-tab-highlights" class="form-tab-content" style="display: none;">
            <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px; border-left: 2px solid var(--color-primary); padding-left: 8px;">
              💡 <strong>Ma trận Công nghệ 8 Điểm:</strong> Tổng hợp 8 thông số/tính năng nổi trội nhất. Hệ thống đã tối ưu sẵn bộ biểu tượng luxury dành riêng cho dòng xe xăng và xe điện (EV).
            </p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
              <button type="button" class="btn-gold" style="font-size: 10.5px; padding: 6px; box-shadow: none;" onclick="loadTechTemplate('etron')">⚡ Tải mẫu Xe điện EV</button>
              <button type="button" class="btn-gold" style="font-size: 10.5px; padding: 6px; box-shadow: none; border-color:#aaa; color:#aaa;" onclick="loadTechTemplate('petrol')">⚙️ Tải mẫu Xe động cơ xăng</button>
            </div>

            <?php for ($i = 0; $i < 8; $i++): 
                $hl = $tech_highlights_arr[$i] ?? ['icon' => '⚙️', 'title' => '', 'desc' => ''];
                $hlIcon = $hl['icon'] ?? ($hl[0] ?? '⚙️');
                $hlTitle = $hl['title'] ?? ($hl[1] ?? '');
                $hlDesc = $hl['desc'] ?? ($hl[2] ?? '');
            ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 6px; padding: 12px; margin-bottom: 12px; display: grid; grid-template-columns: 90px 1fr; gap: 12px; align-items: start;">
                <div>
                  <label class="form-label" style="text-align: center; display: block; margin-bottom: 4px; font-size: 11px;">Biểu tượng</label>
                  <select class="form-input tech-hl-icon" data-index="<?php echo $i; ?>" style="text-align: center; padding: 8px 0; font-size: 16px;">
                    <option value="🔋" <?php echo $hlIcon === '🔋' ? 'selected' : ''; ?>>🔋 Pin</option>
                    <option value="⚡" <?php echo $hlIcon === '⚡' ? 'selected' : ''; ?>>⚡ Điện sạc</option>
                    <option value="⚙️" <?php echo $hlIcon === '⚙️' ? 'selected' : ''; ?>>⚙️ Động cơ</option>
                    <option value="🌀" <?php echo $hlIcon === '🌀' ? 'selected' : ''; ?>>🌀 Thu hồi</option>
                    <option value="🔇" <?php echo $hlIcon === '🔇' ? 'selected' : ''; ?>>🔇 Cách âm</option>
                    <option value="📐" <?php echo $hlIcon === '📐' ? 'selected' : ''; ?>>📐 Khí động</option>
                    <option value="🔗" <?php echo $hlIcon === '🔗' ? 'selected' : ''; ?>>🔗 AWD</option>
                    <option value="🔮" <?php echo $hlIcon === '🔮' ? 'selected' : ''; ?>>🔮 Buồng lái</option>
                    <option value="🔊" <?php echo $hlIcon === '🔊' ? 'selected' : ''; ?>>🔊 B&O 3D</option>
                    <option value="☁️" <?php echo $hlIcon === '☁️' ? 'selected' : ''; ?>>☁️ Treo khí</option>
                    <option value="🛡️" <?php echo $hlIcon === '🛡️' ? 'selected' : ''; ?>>🛡️ Khung vỏ</option>
                    <option value="🛋️" <?php echo $hlIcon === '🛋️' ? 'selected' : ''; ?>>🛋️ Ghế VIP</option>
                    <option value="🌡️" <?php echo $hlIcon === '🌡️' ? 'selected' : ''; ?>>🌡️ Khí hậu</option>
                  </select>
                </div>
                <div>
                  <div class="form-row">
                    <div class="form-group" style="margin-bottom: 8px;">
                      <label class="form-label" style="font-weight:600; font-size: 11px;">Tính năng <?php echo ($i + 1); ?> *</label>
                      <input class="form-input tech-hl-title" type="text" data-index="<?php echo $i; ?>" required value="<?php echo htmlspecialchars($hlTitle); ?>" placeholder="Tên công nghệ/tính năng">
                    </div>
                  </div>
                  <div class="form-group">
                    <textarea class="form-input tech-hl-desc" data-index="<?php echo $i; ?>" rows="2" required placeholder="Mô tả tóm tắt giá trị đỉnh cao của tính năng này..."><?php echo htmlspecialchars($hlDesc); ?></textarea>
                  </div>
                </div>
              </div>
            <?php endfor; ?>
          </div>

          <!-- TAB 4: OWNERSHIP BENEFITS & E-BROCHURE -->
          <div id="form-tab-benefits" class="form-tab-content" style="display: none;">
            <!-- E-Brochure Section -->
            <div style="background: var(--color-primary-glow); border: 1px solid var(--color-border); border-radius: 6px; padding: 15px; margin-bottom: 20px;">
              <h4 style="color: var(--color-primary); margin-bottom: 12px; font-size: 13px; text-transform: uppercase; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                📄 TÀI LIỆU BROCHURE & CATALOG PDF ĐỘC QUYỀN
              </h4>
              <div class="form-group">
                <label class="form-label" for="brochure_url">Đường dẫn tệp PDF thông số kỹ thuật (Ví dụ: /assets/pdf/VinFast-vf9.pdf)</label>
                <input class="form-input" type="text" name="brochure_url" id="brochure_url" value="<?php echo htmlspecialchars($brochure_url); ?>" placeholder="Ví dụ: /assets/pdf/VinFast-vf9.pdf hoặc đường dẫn tải từ Google Drive">
                <p style="font-size: 11px; color: var(--color-text-muted); margin-top: 6px;">💡 Khi điền đường dẫn này, trang chi tiết xe sẽ tự động hiển thị nút <strong>"Tải xuống E-Brochure kỹ thuật số (PDF)"</strong> đẳng cấp.</p>
              </div>
            </div>

            <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 20px; border-left: 2px solid var(--color-primary); padding-left: 8px;">
              💡 <strong>4 Đặc quyền sở hữu xe sang:</strong> Giới thiệu những dịch vụ hậu mãi, an tâm tuyệt đối hoặc vị thế đặc trưng mà khách hàng sở hữu VinFast sẽ được hưởng.
            </p>
            <?php for ($i = 0; $i < 4; $i++): 
                $benefit = $owner_benefits_arr[$i] ?? ['title' => '', 'desc' => ''];
                $bTitle = $benefit['title'] ?? ($benefit[0] ?? '');
                $bDesc = $benefit['desc'] ?? ($benefit[1] ?? '');
            ?>
              <div style="background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 6px; padding: 12px; margin-bottom: 12px;">
                <div class="form-row">
                  <div class="form-group" style="margin-bottom: 8px;">
                    <label class="form-label" style="font-weight:600; font-size:11px;">Quyền lợi <?php echo ($i + 1); ?> *</label>
                    <input class="form-input owner-benefit-title" type="text" data-index="<?php echo $i; ?>" required value="<?php echo htmlspecialchars($bTitle); ?>" placeholder="Bảo hành VIP / Dịch vụ 24/7 / Cảm xúc thể thao...">
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-input owner-benefit-desc" data-index="<?php echo $i; ?>" rows="2" required placeholder="Mô tả chi tiết quyền lợi..."><?php echo htmlspecialchars($bDesc); ?></textarea>
                </div>
              </div>
            <?php endfor; ?>
          </div>

          <!-- 5. TỐI ƯU HÓA SEO TAB -->
          <div id="form-tab-seo" class="form-tab-content" style="display: none;">
            <?php
            $carFocusKeyword = $editCar ? ($editCar['focus_keyword'] ?? '') : '';
            $carSeoTitle = $editCar ? ($editCar['seo_title'] ?? '') : '';
            $carSeoDesc = $editCar ? ($editCar['seo_desc'] ?? '') : '';
            $carSeoCanonical = $editCar ? ($editCar['seo_canonical'] ?? '') : '';
            $carSlug = $editCar ? ($editCar['slug'] ?? '') : '';
            ?>
            <div style="background: var(--color-primary-glow); border: 1px solid var(--color-border); border-radius: 6px; padding: 15px; margin-bottom: 20px;">
              <h4 style="color: var(--color-primary); margin-top:0; margin-bottom: 12px; font-size: 13px; text-transform: uppercase; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                🔍 CẤU HÌNH ON-PAGE SEO CHUYÊN NGHIỆP (SIÊU TỐC ĐỘ)
              </h4>
              <p style="font-size: 12px; color: var(--color-text-muted); margin-bottom: 15px;">
                💡 <strong>Lợi thế vượt trội:</strong> Không giống như WordPress sử dụng bảng <code>wp_postmeta</code> chậm chạp với hàng chục phép JOIN, hệ thống lưu trữ SEO của VinFast CMS được ghi trực tiếp vào các cột chuyên dụng trong bảng dữ liệu sản phẩm chính. Tốc độ tải trang đạt mức tuyệt đối <strong>0ms database overhead!</strong>
              </p>
            </div>

            <!-- Focus Keyword & URL Slug -->
            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="focus_keyword">Từ khóa tập trung (Focus Keyword)</label>
                <input class="form-input" type="text" name="focus_keyword" id="focus_keyword" value="<?php echo htmlspecialchars($carFocusKeyword); ?>" placeholder="Ví dụ: VinFast VF 9, giá xe VinFast VF 9...">
              </div>
              <div class="form-group" style="margin-bottom:0;">
                <label class="form-label" for="slug">Đường dẫn tĩnh (URL Slug) *</label>
                <input class="form-input" type="text" name="slug" id="slug" value="<?php echo htmlspecialchars($carSlug); ?>" placeholder="Ví dụ: VinFast-s-EV-gt-2026" oninput="sanitizeSlug(this)">
                <p style="font-size: 11px; color: var(--color-text-muted); margin-top: 4px; margin-bottom:0;">💡 Để trống để tự động tạo từ tên xe. Chỉ chấp nhận chữ thường không dấu, số và gạch ngang.</p>
              </div>
            </div>

            <!-- Meta Title & Meta Description -->
            <div class="form-group" style="margin-bottom: 15px;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 6px;">
                <label class="form-label" style="margin-bottom:0;" for="seo_title">Thẻ tiêu đề SEO (Meta Title)</label>
                <span id="title-char-count" style="font-size:11px; color:var(--color-text-muted);">0 / 60 ký tự</span>
              </div>
              <input class="form-input" type="text" name="seo_title" id="seo_title" value="<?php echo htmlspecialchars($carSeoTitle); ?>" placeholder="Để trống sẽ tự động lấy tên dòng xe..." oninput="updateGooglePreview()">
            </div>

            <div class="form-group" style="margin-bottom: 15px;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 6px;">
                <label class="form-label" style="margin-bottom:0;" for="seo_desc">Thẻ mô tả SEO (Meta Description)</label>
                <span id="desc-char-count" style="font-size:11px; color:var(--color-text-muted);">0 / 160 ký tự</span>
              </div>
              <textarea class="form-input" name="seo_desc" id="seo_desc" rows="3" placeholder="Để trống sẽ tự động lấy mô tả ngắn của xe..." oninput="updateGooglePreview()"><?php echo htmlspecialchars($carSeoDesc); ?></textarea>
            </div>

            <!-- Canonical Tag -->
            <div class="form-group" style="margin-bottom: 15px;">
              <label class="form-label" for="seo_canonical">Thẻ Canonical URL tùy biến</label>
              <input class="form-input" type="text" name="seo_canonical" id="seo_canonical" value="<?php echo htmlspecialchars($carSeoCanonical); ?>" placeholder="Ví dụ: https://VinFast.vn/dong-xe/VinFast-EV.html">
              <p style="font-size: 11px; color: var(--color-text-muted); margin-top: 4px; margin-bottom:0;">💡 Để trống để tự động nhận đường dẫn tĩnh tuyệt đối của trang sản phẩm hiện tại (Khuyên dùng để chống trùng lặp nội dung).</p>
            </div>

            <!-- Interactive Live Google Search Preview -->
            <div style="background: #151a24; border: 1px solid rgba(255,255,255,0.05); border-radius: 8px; padding: 18px; margin-top: 25px;">
              <h5 style="margin-top:0; margin-bottom:12px; font-size:12px; color:var(--color-primary); text-transform:uppercase; font-weight:600; letter-spacing:0.5px; display:flex; align-items:center; gap:6px;">
                🌐 GOOGLE SEARCH REAL-TIME SNIPPET PREVIEW
              </h5>
              
              <!-- Desktop Google Result Mockup -->
              <div style="background:#ffffff; border-radius:8px; padding:15px; color:#1a0dab; font-family:arial, sans-serif; font-size:14px; line-height:1.3; box-shadow:0 2px 5px rgba(0,0,0,0.05);">
                <div style="font-size:12px; color:#202124; margin-bottom:4px; display:flex; align-items:center; gap:4px; font-weight:normal; text-decoration:none; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                  <span style="background:#f1f3f4; border-radius:50%; width:18px; height:18px; display:inline-flex; align-items:center; justify-content:center; font-size:10px; color:#5f6368; font-weight:bold; margin-right:4px;">A</span>
                  <span>https://VinFastvn.com</span>
                  <span style="color:#5f6368;">› san-pham › <span id="preview-url-slug" style="color:#5f6368; font-weight:normal;"><?php echo $carSlug ?: 'VinFast-model-name'; ?></span></span>
                </div>
                <h3 id="preview-title" style="margin:0; font-size:20px; font-weight:normal; color:#1a0dab; line-height:1.3; cursor:pointer; text-decoration:none; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                  <?php echo $carSeoTitle ?: 'VinFast Model - Thông số kỹ thuật & Ưu đãi đặc quyền | VinFast VN'; ?>
                </h3>
                <p id="preview-desc" style="margin:4px 0 0 0; font-size:14px; color:#4d5156; font-weight:normal; line-height:1.58; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                  <?php echo $carSeoDesc ?: 'Khám phá thông số kỹ thuật chi tiết của xe chính hãng. Trải nghiệm hệ thống động cơ xăng tăng áp hoặc EV thuần điện đột phá và nhận gói ưu đãi chào hè đặc quyền...'; ?>
                </p>
              </div>
            </div>

            <script>
              function sanitizeSlug(input) {
                let val = input.value;
                val = val.toLowerCase();
                val = val.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
                val = val.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
                val = val.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
                val = val.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
                val = val.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
                val = val.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
                val = val.replace(/(đ)/g, 'd');
                val = val.replace(/[^a-z0-9-\s]/g, '');
                val = val.replace(/([\s]+)/g, '-');
                val = val.replace(/^-+|-+$/g, '');
                input.value = val;
                
                // Update preview URL slug
                document.getElementById('preview-url-slug').textContent = val || 'VinFast-model-name';
              }

              function updateGooglePreview() {
                const titleInput = document.getElementById('seo_title');
                const descInput = document.getElementById('seo_desc');
                
                if (!titleInput || !descInput) return;
                
                const titleVal = titleInput.value.trim();
                const descVal = descInput.value.trim();
                
                const titleCharCount = document.getElementById('title-char-count');
                const descCharCount = document.getElementById('desc-char-count');
                
                titleCharCount.textContent = titleVal.length + ' / 60 ký tự';
                descCharCount.textContent = descVal.length + ' / 160 ký tự';
                
                // Update Google Preview
                const modelNameVal = document.getElementById('model_name') ? document.getElementById('model_name').value.trim() : '';
                const fallbackTitle = (modelNameVal || 'VinFast Model') + ' - Thông số kỹ thuật & Ưu đãi đặc quyền | VinFast VN';
                const fallbackDesc = 'Khám phá thông số kỹ thuật chi tiết của xe chính hãng. Trải nghiệm hệ thống động cơ xăng tăng áp hoặc EV thuần điện đột phá và nhận gói ưu đãi chào hè đặc quyền...';
                
                document.getElementById('preview-title').textContent = titleVal || fallbackTitle;
                document.getElementById('preview-desc').textContent = descVal || fallbackDesc;
                
                // Set text colors depending on safe bounds
                if (titleVal.length > 60) {
                  titleCharCount.style.color = '#ff6b6b';
                } else if (titleVal.length >= 50) {
                  titleCharCount.style.color = '#2ecc71';
                } else {
                  titleCharCount.style.color = 'var(--color-text-muted)';
                }
                
                if (descVal.length > 160) {
                  descCharCount.style.color = '#ff6b6b';
                } else if (descVal.length >= 120) {
                  descCharCount.style.color = '#2ecc71';
                } else {
                  descCharCount.style.color = 'var(--color-text-muted)';
                }
              }

              // Trigger initial preview update
              setTimeout(updateGooglePreview, 200);
            </script>
          </div>

          <!-- JavaScript Form controller and JSON compiler -->
          <script>
            function switchFormTab(tabId, btnEl) {
              // Hide all tabs
              document.querySelectorAll('.form-tab-content').forEach(tab => {
                tab.style.display = 'none';
              });
              // Show selected tab
              document.getElementById('form-tab-' + tabId).style.display = 'block';

              // Reset buttons active classes
              document.querySelectorAll('.form-tab-btn').forEach(btn => {
                btn.classList.remove('form-tab-btn--active');
                btn.style.color = 'var(--color-text-muted)';
                btn.style.borderBottomColor = 'transparent';
              });

              // Set active button
              btnEl.classList.add('form-tab-btn--active');
              btnEl.style.color = 'var(--color-primary)';
              btnEl.style.borderBottomColor = 'var(--color-primary)';
            }

            // Quick templates loader for highlights matrix
            function loadTechTemplate(type) {
              if (!confirm('Bạn có muốn ghi đè danh sách công nghệ hiện tại bằng mẫu tương ứng không?')) return;
              
              const templates = {
                etron: [
                  {icon: "🔋", title: "Pin Lithium-ion 800V", desc: "Kiến trúc điện áp 800V tiên phong giúp duy trì dòng sạc cực đại lâu hơn và giảm thiểu tối đa sinh nhiệt."},
                  {icon: "⚡", title: "Hệ sạc siêu nhanh DC 270kW", desc: "Đặc quyền sạc siêu nhanh công suất lớn tại hệ thống đại lý VinFast, sạc đầy từ 10% lên 80% chỉ trong 22 phút."},
                  {icon: "🌀", title: "Thu hồi năng lượng phanh", desc: "Hệ thống phanh tái sinh thông minh chuyển đổi động năng thừa khi giảm tốc thành điện năng sạc ngược lại vào pin."},
                  {icon: "🔇", title: "Cabin tĩnh lặng tuyệt đối", desc: "Cabin tĩnh lặng tối đa nhờ cách âm 2 lớp dày dặn và triệt tiêu hoàn toàn rung chấn cơ học động cơ đốt trong."},
                  {icon: "📐", title: "Khí động học chủ động (Cd 0.24)", desc: "Hệ số cản gió cực thấp nhờ thiết kế gầm phẳng, khe hút gió biến thiên và cánh gió sau tự động nâng hạ."},
                  {icon: "🔗", title: "Dẫn động AWD điện hóa", desc: "Hai mô-tơ điện độc lập phân bổ lực kéo nhanh gấp 5 lần hệ dẫn động cơ học, bám đường vô song."},
                  {icon: "🔮", title: "Buồng lái Virtual Cockpit EV", desc: "Giao diện ảo hiển thị chuyên biệt dòng chảy năng lượng, trạng thái pin, công suất sạc và bản đồ thông minh."},
                  {icon: "🔊", title: "Bang & Olufsen 3D EV", desc: "Trải nghiệm âm thanh vòm 3D trung thực hòa quyện cùng tiếng rít cơ học điện tử EV độc quyền sinh động."}
                ],
                petrol: [
                  {icon: "⚙️", title: "Động cơ tăng áp mạnh mẽ", desc: "Công nghệ tăng áp cuộn kép tiên tiến giúp loại bỏ hoàn toàn độ trễ ga, đem lại mô-men xoắn tối đa ở vòng tua thấp cho trải nghiệm thể thao."},
                  {icon: "⚡", title: "Hộp số tự động ZF 8 cấp", desc: "Hộp số tự động 8 cấp ZF danh tiếng thế giới cho phép chuyển cấp số cực kỳ êm ái, mượt mà và tiết kiệm nhiên liệu."},
                  {icon: "☁️", title: "Hệ thống treo thích ứng", desc: "Tự động điều chỉnh độ cứng giảm chấn độc lập theo bề mặt địa hình thực tế để mang lại sự êm ái tối đa."},
                  {icon: "🛡️", title: "Khung gầm tiêu chuẩn Châu Âu", desc: "Cấu trúc khung xe vững chắc gia cố bằng thép cường lực hấp thụ lực va chạm, bảo vệ khoang hành khách an toàn tối đa."},
                  {icon: "🛋️", title: "Nội thất da sang trọng VIP", desc: "Hàng ghế bọc da cao cấp chỉnh điện đa hướng, tích hợp bộ nhớ vị trí, sưởi và thông gió đẳng cấp."},
                  {icon: "🌡️", title: "Điều hòa tự động lọc bụi mịn", desc: "Hệ thống kiểm soát chất lượng không khí tích hợp màng lọc PM2.5 mang lại không gian trong lành nhất."},
                  {icon: "🔮", title: "Màn hình giải trí cảm ứng lớn", desc: "Màn hình cảm ứng kích thước lớn sắc nét kết hợp kết nối Apple CarPlay và Android Auto không dây tiện lợi."},
                  {icon: "🔊", title: "Âm thanh vòm sống động", desc: "Trải nghiệm âm thanh cao cấp trung thực tái tạo sống động như một rạp hát thu nhỏ ngay trong cabin."}
                ]
              };

              const list = templates[type];
              for (let i = 0; i < 8; i++) {
                document.querySelector(`.tech-hl-icon[data-index="${i}"]`).value = list[i].icon;
                document.querySelector(`.tech-hl-title[data-index="${i}"]`).value = list[i].title;
                document.querySelector(`.tech-hl-desc[data-index="${i}"]`).value = list[i].desc;
              }
            }

            // Premium Image preview deletion helper
            function removePreviewImage(inputId, imagePath, el) {
              if (confirm("Bạn có chắc chắn muốn xóa ảnh này khỏi danh sách?")) {
                const inputEl = document.getElementById(inputId);
                if (inputEl) {
                  let paths = inputEl.value.split(',').map(s => s.trim()).filter(Boolean);
                  paths = paths.filter(p => p !== imagePath);
                  inputEl.value = paths.join(',');
                  
                  // Animate and remove from DOM
                  const previewItem = el.closest('.image-preview-item');
                  if (previewItem) {
                    previewItem.style.opacity = 0;
                    setTimeout(() => { 
                      previewItem.remove(); 
                      // If no children left, show empty indicator
                      const container = document.getElementById('preview_' + inputId.replace('image_', '') + '_container');
                      if (container && container.querySelectorAll('.image-preview-item').length === 0) {
                        container.innerHTML = '<span style="font-size:11px; color:var(--color-text-muted);">Chưa có ảnh nào</span>';
                      }
                    }, 200);
                  }
                }
              }
            }

            function syncPreviews(inputId, containerId) {
              const inputEl = document.getElementById(inputId);
              const container = document.getElementById(containerId);
              if (!inputEl || !container) return;
              
              const update = () => {
                const val = inputEl.value.trim();
                if (!val) {
                  container.innerHTML = `<span style="font-size:11px; color:var(--color-text-muted);">Chưa có ảnh nào</span>`;
                  return;
                }
                const paths = val.split(',').map(s => s.trim()).filter(Boolean);
                container.innerHTML = '';
                paths.forEach(path => {
                  const item = document.createElement('div');
                  item.className = 'image-preview-item';
                  item.innerHTML = `
                    <img src="${path}" style="width:100%; height:100%; object-fit:cover;">
                    <button type="button" class="remove-btn" onclick="removePreviewImage('${inputId}', '${path.replace(/'/g, "\\'")}', this)">×</button>
                  `;
                  container.appendChild(item);
                });
              };
              
              inputEl.addEventListener('input', update);
              inputEl.addEventListener('change', update);
            }

            syncPreviews('image_exterior', 'preview_exterior_container');
            syncPreviews('image_interior', 'preview_interior_container');
            syncPreviews('image_engine', 'preview_engine_container');

            // Sync Visual Form inputs to Hidden fields as JSON before submit
            document.querySelector('form[action="admin.php?p=inventory"]').addEventListener('submit', function(e) {
              // 1. Core features (3 items)
              const coreFeatures = [];
              for (let i = 0; i < 3; i++) {
                const tag = document.querySelector(`.core-feat-tag[data-index="${i}"]`).value;
                const title = document.querySelector(`.core-feat-title[data-index="${i}"]`).value;
                const image = document.querySelector(`.core-feat-image[data-index="${i}"]`).value;
                const desc = document.querySelector(`.core-feat-desc[data-index="${i}"]`).value;
                coreFeatures.push({ image, tag, title, desc });
              }
              document.getElementById('core_features_input').value = JSON.stringify(coreFeatures);

              // 2. Tech highlights (8 items)
              const techHighlights = [];
              for (let i = 0; i < 8; i++) {
                const icon = document.querySelector(`.tech-hl-icon[data-index="${i}"]`).value;
                const title = document.querySelector(`.tech-hl-title[data-index="${i}"]`).value;
                const desc = document.querySelector(`.tech-hl-desc[data-index="${i}"]`).value;
                techHighlights.push({ icon, title, desc });
              }
              document.getElementById('tech_highlights_input').value = JSON.stringify(techHighlights);

              // 3. Owner benefits (4 items)
              const ownerBenefits = [];
              for (let i = 0; i < 4; i++) {
                const title = document.querySelector(`.owner-benefit-title[data-index="${i}"]`).value;
                const desc = document.querySelector(`.owner-benefit-desc[data-index="${i}"]`).value;
                ownerBenefits.push({ title, desc });
              }
              document.getElementById('owner_benefits_input').value = JSON.stringify(ownerBenefits);
            });
          </script>

          <div style="margin-top: 25px; display: flex; gap: 12px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px;">
            <button class="btn-gold" type="submit"><?php echo $editCar ? 'Cập nhật dòng xe' : 'Thêm vào kho hàng'; ?></button>
            <?php if ($editCar): ?>
              <a href="admin.php?p=inventory" class="btn-gold" style="border-color:#aaa; color:#aaa; box-shadow:none;">Hủy sửa đổi</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <!-- Inventory Table -->
      <div class="card">
        <div class="card__title">Danh sách dòng xe trong kho hàng</div>
        <div style="margin-top: 10px; margin-bottom: 15px;">
          <input class="form-input" type="text" id="search_inventory" placeholder="🔍 Nhập tên dòng xe hoặc phân khúc để lọc nhanh..." onkeyup="filterInventoryTable()">
        </div>
        <script>
          function filterInventoryTable() {
            const query = document.getElementById('search_inventory').value.toLowerCase();
            const rows = document.querySelectorAll('.cms-table tbody tr');
            rows.forEach(row => {
              const model = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
              const segment = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
              if (model.includes(query) || segment.includes(query)) {
                row.style.display = '';
              } else {
                row.style.display = 'none';
              }
            });
          }
        </script>
        <div class="table-container">
          <table class="cms-table">
            <thead>
              <tr>
                <th>Ảnh xe</th>
                <th>Tên dòng xe</th>
                <th>Phân khúc</th>
                <th>Giá bán</th>
                <th>Tồn kho</th>
                <th>Số lượng</th>
                <th>Video</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $stmtCarsList = $db->query("SELECT * FROM cars ORDER BY id DESC");
                $carsList = $stmtCarsList->fetchAll();
                foreach ($carsList as $c) {
                    $stockBadge = 'status-badge--success';
                    if ($c['stock_status'] === 'Đặt trước') $stockBadge = 'status-badge--contacting';
                    elseif ($c['stock_status'] === 'Hết hàng') $stockBadge = 'status-badge--failed';

                    echo '<tr>';
                    echo '<td><img src="' . htmlspecialchars($c['image']) . '" style="height: 40px; border-radius:4px; border:1px solid var(--color-border); background:#000;" alt=""></td>';
                    echo '<td><strong>' . htmlspecialchars($c['model_name']) . '</strong></td>';
                    echo '<td>' . htmlspecialchars($c['segment']) . '</td>';
                    echo '<td style="color:var(--color-primary); font-weight:600;">' . htmlspecialchars($c['price']) . '</td>';
                    echo '<td><span class="status-badge ' . $stockBadge . '">' . htmlspecialchars($c['stock_status']) . '</span></td>';
                    echo '<td>' . (int)$c['stock_qty'] . ' chiếc</td>';
                    echo '<td>' . ($c['video_url'] ? '<span style="color:#a5d6a7;">Có Link</span>' : '<span style="color:var(--color-text-muted);">Trống</span>') . '</td>';
                    echo '<td>';
                    echo '<a href="admin.php?p=inventory&edit_id=' . $c['id'] . '" class="btn-gold" style="padding:6px 12px; font-size:10px; box-shadow:none; margin-right:8px;">Sửa</a>';
                    echo '<form method="POST" action="admin.php?p=inventory" style="display:inline-block;" onsubmit="return confirm(\'Xác nhận xóa hoàn toàn dòng xe này?\')">';
                    echo '<input type="hidden" name="action" value="delete">';
                    echo '<input type="hidden" name="id" value="' . $c['id'] . '">';
                    echo '<button type="submit" class="btn-danger">Xóa</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    <!-- ==================================================== -->
    <!-- VIEW: 3. APPOINTMENTS & TEST DRIVE -->





