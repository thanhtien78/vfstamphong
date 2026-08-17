<!-- 5. NEWS TAB CONTENT -->
<div id="cms-tab-news" class="cms-tab-content" style="display: none;">
  <div class="layout-split layout-split--wide-left">
    <div>
      <!-- News & Promotions CRUD -->
      <div class="card inline-action-card">
        <div class="card__title"><?php echo $editPost ? 'Sửa bài viết #' . $editPost['id'] : 'Tạo mới tin tức / Chương trình ưu đãi'; ?></div>
        <form method="POST" action="admin.php?p=cms" enctype="multipart/form-data">
          <input type="hidden" name="action" value="<?php echo $editPost ? 'edit_post' : 'create_post'; ?>">
          <?php if ($editPost): ?>
            <input type="hidden" name="id" value="<?php echo $editPost['id']; ?>">
          <?php endif; ?>

          <div class="form-group">
            <label class="form-label" for="post_title">Tiêu đề bài viết *</label>
            <input class="form-input" type="text" name="title" id="post_title" required value="<?php echo $editPost ? htmlspecialchars($editPost['title']) : ''; ?>" placeholder="Ví dụ: Chương trình ưu đãi chào hè đặc biệt trị giá 300 triệu">
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="post_focus_keyword">Từ khóa chính (Focus Keyword) - Hỗ trợ phân tích SEO trực tiếp</label>
            <input class="form-input" type="text" name="focus_keyword" id="post_focus_keyword" value="<?php echo $editPost ? htmlspecialchars($editPost['focus_keyword'] ?? '') : ''; ?>" placeholder="Ví dụ: VF 9, khuyen mai VinFast, xe sang VinFast">
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="post_image">Hình ảnh đại diện bài viết (URL hoặc Tải ảnh lên)</label>
            <input class="form-input" type="text" name="image" id="post_image" value="<?php echo $editPost ? htmlspecialchars($editPost['image']) : ''; ?>" placeholder="Nhập đường dẫn URL ảnh hoặc chọn tệp dưới đây">
            <input class="form-input" type="file" name="image_file" id="post_image_file" accept="image/*" style="margin-top:8px;">
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="post_category">Chuyên mục tin tức *</label>
            <select class="form-input" name="category" id="post_category" required>
              <option value="Thế giới VinFast" <?php echo ($editPost && ($editPost['category'] ?? '') === 'Thế giới VinFast') ? 'selected' : ''; ?>>Thế giới VinFast</option>
              <option value="Chương trình khuyến mãi" <?php echo ($editPost && ($editPost['category'] ?? '') === 'Chương trình khuyến mãi') ? 'selected' : ''; ?>>Chương trình khuyến mãi</option>
              <option value="Bảo dưỡng & Bảo hành" <?php echo ($editPost && ($editPost['category'] ?? '') === 'Bảo dưỡng & Bảo hành') ? 'selected' : ''; ?>>Bảo dưỡng & Bảo hành</option>
              <option value="Tin tuyển dụng" <?php echo ($editPost && ($editPost['category'] ?? '') === 'Tin tuyển dụng') ? 'selected' : ''; ?>>Tin tuyển dụng</option>
              <option value="Báo giá theo địa phương" <?php echo ($editPost && ($editPost['category'] ?? '') === 'Báo giá theo địa phương') ? 'selected' : ''; ?>>Báo giá theo địa phương</option>
            </select>
          </div>

          <div class="form-group" style="margin-top:12px;">
            <label class="form-label" for="post_summary">Tóm tắt ngắn (Thẻ mô tả Meta Description)</label>
            <input class="form-input" type="text" name="summary" id="post_summary" value="<?php echo $editPost ? htmlspecialchars($editPost['summary']) : ''; ?>" placeholder="Nhập tóm tắt hiển thị ở thẻ danh sách...">
          </div>

          <div class="form-group" style="margin-top:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
              <label class="form-label" for="post_content" style="margin:0;">Nội dung chi tiết bài viết</label>
              <button type="button" class="btn-gold" id="btn-add-media-tinymce" style="padding:4px 10px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:6px; box-shadow:none; border-radius:4px; height:auto; line-height:1.2;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:2px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                Thêm Media
              </button>
            </div>
            <textarea class="form-input" name="content" id="post_content" style="min-height:180px;" placeholder="Soạn thảo nội dung bài viết tin tức khuyến mãi..."><?php echo $editPost ? htmlspecialchars($editPost['content']) : ''; ?></textarea>
          </div>

          <!-- HIGH-PERFORMANCE ON-PAGE SEO OVERRIDES CARD -->
          <div style="margin-top:20px; background:var(--color-primary-glow); border:1px solid var(--color-border); border-radius:12px; padding:20px;">
            <div style="border-bottom:1px solid var(--color-border); padding-bottom:10px; margin-bottom:15px; display:flex; align-items:center; gap:8px;">
              <span style="font-size:18px;">⚙️</span>
              <h4 class="form-label" style="margin:0; font-weight:700; color:var(--color-primary); text-transform:uppercase; letter-spacing:0.5px;">Tùy biến On-Page SEO nâng cao (Ăn đứt WordPress)</h4>
            </div>
            
            <?php
            $postSeoTitle = $editPost ? ($editPost['seo_title'] ?? '') : '';
            $postSeoDesc = $editPost ? ($editPost['seo_desc'] ?? '') : '';
            $postSeoCanonical = $editPost ? ($editPost['seo_canonical'] ?? '') : '';
            $postSlug = $editPost ? ($editPost['slug'] ?? '') : '';
            ?>

            <!-- Dynamic URL Slug custom edit -->
            <div class="form-group" style="margin-bottom:15px;">
              <label class="form-label" for="post_slug">Đường dẫn tĩnh tùy chỉnh (URL Slug)</label>
              <input class="form-input" type="text" name="slug" id="post_slug" value="<?php echo htmlspecialchars($postSlug); ?>" placeholder="Để trống hệ thống sẽ tự sinh slug từ tiêu đề..." oninput="sanitizePostSlug(this)">
              <p style="font-size: 11px; color: var(--color-text-muted); margin-top:4px; margin-bottom:0;">💡 Khuyên dùng: Đường dẫn ngắn gọn chứa từ khóa chính, phân cách bằng dấu gạch ngang (Ví dụ: <code>uu-dai-vinfast-vf9-he-2026</code>).</p>
            </div>

            <!-- Custom Meta Title custom edit -->
            <div class="form-group" style="margin-bottom:15px;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <label class="form-label" style="margin-bottom:0;" for="post_seo_title">Tiêu đề SEO tùy biến (Meta Title Override)</label>
                <span id="post-title-char-count" style="font-size:11px; color:var(--color-text-muted);">0 / 60 ký tự</span>
              </div>
              <input class="form-input" type="text" name="seo_title" id="post_seo_title" value="<?php echo htmlspecialchars($postSeoTitle); ?>" placeholder="Nếu để trống sẽ tự động dùng: [Tiêu đề bài viết] | VinFast Việt Nam" oninput="updatePostGooglePreview()">
            </div>

            <!-- Custom Meta Description custom edit -->
            <div class="form-group" style="margin-bottom:15px;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                <label class="form-label" style="margin-bottom:0;" for="post_seo_desc">Mô tả SEO tùy biến (Meta Description Override)</label>
                <span id="post-desc-char-count" style="font-size:11px; color:var(--color-text-muted);">0 / 160 ký tự</span>
              </div>
              <textarea class="form-input" name="seo_desc" id="post_seo_desc" rows="3" placeholder="Nếu để trống sẽ tự động trích xuất từ nội dung tóm tắt ngắn hoặc bài viết..." oninput="updatePostGooglePreview()"><?php echo htmlspecialchars($postSeoDesc); ?></textarea>
            </div>

            <!-- Custom Canonical Tag custom edit -->
            <div class="form-group" style="margin-bottom:15px;">
              <label class="form-label" for="post_seo_canonical">Thẻ Canonical URL tùy biến</label>
              <input class="form-input" type="text" name="seo_canonical" id="post_seo_canonical" value="<?php echo htmlspecialchars($postSeoCanonical); ?>" placeholder="Thường để trống trừ khi bài viết này được sao chép/dịch từ trang gốc khác...">
              <p style="font-size: 11px; color: var(--color-text-muted); margin-top:4px; margin-bottom:0;">💡 Khuyên dùng: Để trống để tự động lấy liên kết tuyệt đối của bài viết này.</p>
            </div>

            <!-- Live Google snippet preview -->
            <div style="background: #11151d; border: 1px solid rgba(255,255,255,0.03); border-radius: 8px; padding: 15px; margin-top: 15px;">
              <h5 style="margin-top:0; margin-bottom:10px; font-size:11px; color:var(--color-primary); text-transform:uppercase; font-weight:600; letter-spacing:0.5px;">
                🌐 GOOGLE SNIPPET LIVE PREVIEW
              </h5>
              <!-- Desktop result preview -->
              <div style="background:#ffffff; border-radius:6px; padding:12px; color:#1a0dab; font-family:arial, sans-serif; font-size:13px; line-height:1.24; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="font-size:11px; color:#202124; margin-bottom:3px; display:flex; align-items:center; gap:3px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                  <span style="background:#f1f3f4; border-radius:50%; width:16px; height:16px; display:inline-flex; align-items:center; justify-content:center; font-size:9px; color:#5f6368; font-weight:bold;">A</span>
                  <span>https://VinFastvn.com</span>
                  <span style="color:#5f6368;">› tin-tuc › <span id="post-preview-slug" style="color:#5f6368;"><?php echo $postSlug ?: 'post-url-slug'; ?></span></span>
                </div>
                <h3 id="post-preview-title" style="margin:0; font-size:18px; font-weight:normal; color:#1a0dab; line-height:1.24; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                  <?php echo $postSeoTitle ?: 'Tiêu đề bài viết tin tức khuyến mãi sự kiện | VinFast VN'; ?>
                </h3>
                <p id="post-preview-desc" style="margin:3px 0 0 0; font-size:13px; color:#4d5156; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                  <?php echo $postSeoDesc ?: 'Tóm tắt bài viết sự kiện ô tô hoặc chương trình ưu đãi chào hè đặc biệt mới nhất của VinFast Việt Nam. Đăng ký lái thử VIP xe EV...'; ?>
                </p>
              </div>
            </div>
          </div>

          <script>
            function sanitizePostSlug(input) {
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
              
              document.getElementById('post-preview-slug').textContent = val || 'post-url-slug';
            }

            function updatePostGooglePreview() {
              const titleInput = document.getElementById('post_seo_title');
              const descInput = document.getElementById('post_seo_desc');
              
              if (!titleInput || !descInput) return;
              
              const titleVal = titleInput.value.trim();
              const descVal = descInput.value.trim();
              
              const titleCharCount = document.getElementById('post-title-char-count');
              const descCharCount = document.getElementById('post-desc-char-count');
              
              titleCharCount.textContent = titleVal.length + ' / 60 ký tự';
              descCharCount.textContent = descVal.length + ' / 160 ký tự';
              
              const articleTitleVal = document.getElementById('post_title') ? document.getElementById('post_title').value.trim() : '';
              const fallbackTitle = (articleTitleVal || 'Tiêu đề bài viết tin tức') + ' | VinFast Việt Nam';
              const fallbackDesc = 'Tóm tắt bài viết sự kiện ô tô hoặc chương trình ưu đãi chào hè đặc biệt mới nhất của VinFast Việt Nam. Đăng ký lái thử VIP xe EV...';
              
              document.getElementById('post-preview-title').textContent = titleVal || fallbackTitle;
              document.getElementById('post-preview-desc').textContent = descVal || fallbackDesc;
              
              // Set colors
              if (titleVal.length > 60) {
                titleCharCount.style.color = '#ff6b6b';
              } else if (titleVal.length >= 45) {
                titleCharCount.style.color = '#2ecc71';
              } else {
                titleCharCount.style.color = 'var(--color-text-muted)';
              }
              
              if (descVal.length > 160) {
                descCharCount.style.color = '#ff6b6b';
              } else if (descVal.length >= 110) {
                descCharCount.style.color = '#2ecc71';
              } else {
                descCharCount.style.color = 'var(--color-text-muted)';
              }
            }

            // Register text input listeners for real-time tracking
            document.addEventListener('DOMContentLoaded', function() {
              const articleTitle = document.getElementById('post_title');
              if (articleTitle) {
                articleTitle.addEventListener('keyup', updatePostGooglePreview);
              }
              setTimeout(updatePostGooglePreview, 500);
            });
          </script>

          <!-- VinFast Premium On-Page SEO Live Analyzer -->
          <div class="seo-analyzer-card" style="margin-top:20px; background:var(--color-primary-glow); border:1px solid var(--color-border); border-radius:12px; padding:20px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:1px solid var(--color-border); padding-bottom:10px;">
              <div style="display:flex; align-items:center; gap:8px;">
                <span style="font-size:18px;">🎯</span>
                <h4 class="form-label" style="margin:0; font-weight:700; color:var(--color-primary); text-transform:uppercase; letter-spacing:0.5px;">VinFast Premium SEO Live Analyzer</h4>
              </div>
              <div style="display:flex; align-items:center; gap:10px;">
                <span style="font-size:11px; color:var(--color-text-muted);">ĐIỂM SEO:</span>
                <span id="seo-score-badge" style="background:#dc3545; color:#fff; font-weight:700; font-size:13px; padding:3px 10px; border-radius:20px; min-width:45px; text-align:center; transition:all 0.3s ease;">0/100</span>
              </div>
            </div>

            <!-- SEO Progress Bar -->
            <div style="background:rgba(255,255,255,0.05); height:6px; border-radius:3px; margin-bottom:20px; overflow:hidden;">
              <div id="seo-score-bar" style="background:#dc3545; width:0%; height:100%; transition:all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);"></div>
            </div>

            <div class="seo-checklist-grid" style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
              <!-- Cột trái: Tiêu đề & Mô tả -->
              <div>
                <h5 style="margin:0 0 10px 0; font-size:12px; font-weight:700; color:#fff; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid rgba(255,255,255,0.05); padding-bottom:4px;">Tiêu đề & Tóm tắt</h5>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                  <li id="seo-check-title-keyword" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Tiêu đề chứa từ khóa chính.</span>
                  </li>
                  <li id="seo-check-title-length" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Độ dài tiêu đề chuẩn SEO (40 - 65 ký tự).</span>
                  </li>
                  <li id="seo-check-summary-keyword" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Tóm tắt ngắn chứa từ khóa chính.</span>
                  </li>
                  <li id="seo-check-summary-length" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Độ dài tóm tắt chuẩn SEO (110 - 160 ký tự).</span>
                  </li>
                </ul>
              </div>

              <!-- Cột phải: Nội dung bài viết -->
              <div>
                <h5 style="margin:0 0 10px 0; font-size:12px; font-weight:700; color:#fff; text-transform:uppercase; letter-spacing:0.5px; border-bottom:1px solid rgba(255,255,255,0.05); padding-bottom:4px;">Nội dung bài viết</h5>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                  <li id="seo-check-first-100" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Từ khóa xuất hiện trong 100 từ đầu tiên.</span>
                  </li>
                  <li id="seo-check-word-count" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Độ dài bài viết tối thiểu 500 từ.</span>
                  </li>
                  <li id="seo-check-density" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Mật độ từ khóa đạt chuẩn (0.5% - 2.5%).</span>
                  </li>
                  <li id="seo-check-headings" style="display:flex; align-items:flex-start; gap:8px; font-size:12px; color:var(--color-text-muted);">
                    <span class="seo-icon" style="color:#dc3545;">❌</span>
                    <span>Chứa ít nhất một tiêu đề con (H2, H3, H4).</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div style="margin-top:20px; display:flex; gap:10px;">
            <button class="btn-gold" type="submit"><?php echo $editPost ? 'Cập nhật tin tức' : 'Đăng tải bài viết'; ?></button>
            <?php if ($editPost): ?>
              <a href="admin.php?p=cms" class="btn-gold" style="border-color:#aaa; color:#aaa; box-shadow:none;">Hủy</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <!-- News posts table list -->
      <div class="card" style="margin-top:25px;">
        <div class="card__title">Danh sách bài viết & Tin khuyến mãi</div>
        <div class="table-container">
          <table class="cms-table">
            <thead>
              <tr>
                <th>Ảnh bìa</th>
                <th>Tiêu đề bài viết</th>
                <th>Tóm tắt</th>
                <th>Ngày đăng tải</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $stmtAllPosts = $db->query("SELECT * FROM posts ORDER BY id DESC");
                while ($post = $stmtAllPosts->fetch()) {
                    echo '<tr>';
                    echo '<td><img src="' . htmlspecialchars($post['image'] ?: 'https://images.unsplash.com/photo-1614162692292-7ac56d7f7f1e?auto=format&fit=crop&w=150&q=80') . '" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px; border:1px solid var(--color-border);"></td>';
                    echo '<td><strong>' . htmlspecialchars($post['title']) . '</strong></td>';
                    echo '<td style="font-size:12px; color:var(--color-text-muted); max-width:250px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">' . htmlspecialchars($post['summary']) . '</td>';
                    echo '<td style="font-size:11px; color:var(--color-text-muted);">' . date('d/m/Y', strtotime($post['created_at'])) . '</td>';
                    echo '<td>';
                    echo '<a href="admin.php?p=cms&edit_post_id=' . $post['id'] . '" class="btn-gold" style="padding:4px 8px; font-size:10px; box-shadow:none; margin-right:5px;">Sửa</a>';
                    echo '<form method="POST" action="admin.php?p=cms" style="display:inline-block;" onsubmit="return confirm(\'Xác nhận xóa hoàn toàn bài viết này?\')">';
                    echo '<input type="hidden" name="action" value="delete_post">';
                    echo '<input type="hidden" name="id" value="' . $post['id'] . '">';
                    echo '<button type="submit" class="btn-danger" style="font-size:10px;">Xóa</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- COLUMN 2: RIGHT (TRỢ LÝ TỐI ƯU SEO & SERP PREVIEW) -->
    <div>
      <div class="card" style="position: sticky; top: 90px; border: 1px solid var(--color-border); box-shadow: 0 15px 35px rgba(0,0,0,0.5); background: rgba(18,18,18,0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
        <div class="card__title" style="color: var(--color-primary); border-left-color: var(--color-primary); display: flex; align-items: center; justify-content: space-between;">
          <span>🎯 Trợ lý Tối ưu SEO Pro</span>
          <span id="seo-score-badge" style="font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 800; background: rgba(239, 83, 80, 0.15); border: 1px solid #ef5350; color: #ff8a80; transition: all 0.3s ease;">ĐIỂM: 0/100</span>
        </div>
        <p style="font-size: 11px; color: var(--color-text-muted); margin-bottom: 20px;">
          Hệ thống kiểm định thời gian thực gồm 20 tiêu chuẩn On-Page chuyên sâu chuẩn thuật toán Google Search 2026 & E-E-A-T.
        </p>

        <!-- GOOGLE SERP PREVIEW -->
        <div style="font-size: 10px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;">Xem trước Kết quả Tìm kiếm (Google SERP)</div>
        <div style="background: #ffffff; color: #202124; padding: 18px; border-radius: 12px; font-family: 'Arial', sans-serif !important; border: 1px solid #e0e0e0; margin-bottom: 25px; box-shadow: inset 0 2px 6px rgba(0,0,0,0.05); text-align: left;">
          <!-- Favicon & URL -->
          <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; font-size: 12px; line-height: 1.2;">
            <div style="width: 26px; height: 26px; border-radius: 50%; background: #f1f3f4; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; color: #5f6368; border: 1px solid #dadce0;">A</div>
            <div style="display: flex; flex-direction: column;">
              <span style="font-weight: 500; color: #202124; font-size: 12px;">VinFast Việt Nam</span>
              <span style="color: #4d5156; font-size: 11px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;">https://VinFastvietnam.vn › tin-tuc › <span id="seo-preview-slug" style="color: #4d5156;">tieu-de-tin-tuc</span></span>
            </div>
          </div>
          <!-- Title Link -->
          <a href="#" onclick="return false;" id="seo-preview-title" style="font-size: 18px; color: #1a0dab; text-decoration: none; font-weight: 400; line-height: 1.3; margin-top: 4px; display: block; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; min-height: 24px;">Tiêu đề bài viết của anh... | VinFast Việt Nam</a>
          <!-- Snippet Description -->
          <p id="seo-preview-snippet" style="font-size: 13px; color: #4d5156; margin: 4px 0 0 0; line-height: 1.4; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; min-height: 36px;">
            Nhập tóm tắt ngắn cho bài viết tin tức hoặc chương trình ưu đãi để Google hiển thị mô tả bài viết tại đây...
          </p>
        </div>

        <!-- TARGET KEYWORD INPUT -->
        <div style="margin-bottom: 20px; background: var(--color-primary-glow); border: 1px dashed rgba(52, 211, 153, 0.25); padding: 14px; border-radius: 8px;">
          <label style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; display: block; margin-bottom: 6px; letter-spacing: 0.5px;">🎯 Từ khóa tập trung (Focus Keyword)</label>
          <input type="text" id="seo_focus_keyword" placeholder="Nhập từ khóa chính cần tối ưu SEO (vd: EV, VinFast q8)..." style="width: 100%; padding: 8px 12px; font-size: 12px; border-radius: 6px; border: 1px solid rgba(52, 211, 153, 0.3); background: rgba(0,0,0,0.3); color: #fff; outline: none; transition: border-color 0.2s;" oninput="window.updateSeoAnalysis()">
        </div>

        <!-- SEO REALTIME CHECKLIST -->
        <div style="font-size: 10px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.5px;">Tiêu chuẩn On-page bài viết chuẩn SEO 2026</div>
        <div style="display: flex; flex-direction: column; gap: 16px; font-size: 12px;">
          
          <!-- PILLAR 1: SEO TIÊU ĐỀ & URL -->
          <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); padding: 12px; border-radius: 8px;">
            <div style="font-weight: bold; color: var(--color-primary); font-size: 11px; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
              <span>📌 1. Tiêu Đề & Đường Dẫn</span>
              <span id="score-pillar-basic" style="color: var(--color-text-muted); font-size: 10px;">0/5 Đạt</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-title-len-icon">🔴</span>
                <span id="rule-title-len-text" style="font-size: 11px; color: var(--color-text-muted);">Độ dài tiêu đề tối ưu (50 - 65 ký tự).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-title-kw-icon">🔴</span>
                <span id="rule-title-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Từ khóa xuất hiện trong Tiêu đề.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-title-start-kw-icon">🔴</span>
                <span id="rule-title-start-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Từ khóa xuất hiện ở phần đầu Tiêu đề.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-slug-kw-icon">🔴</span>
                <span id="rule-slug-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Từ khóa chính xuất hiện trong Slug (URL).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-title-power-icon">🔴</span>
                <span id="rule-title-power-text" style="font-size: 11px; color: var(--color-text-muted);">Tiêu đề chứa số hoặc từ khóa thu hút click (CTR).</span>
              </div>
            </div>
          </div>

          <!-- PILLAR 2: TỐI ƯU TÓM TẮT & NỘI DUNG -->
          <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); padding: 12px; border-radius: 8px;">
            <div style="font-weight: bold; color: var(--color-primary); font-size: 11px; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
              <span>✍️ 2. Tóm tắt & Nội dung chính</span>
              <span id="score-pillar-content" style="color: var(--color-text-muted); font-size: 10px;">0/5 Đạt</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-desc-len-icon">🔴</span>
                <span id="rule-desc-len-text" style="font-size: 11px; color: var(--color-text-muted);">Độ dài tóm tắt / Mô tả (120 - 165 ký tự).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-desc-kw-icon">🔴</span>
                <span id="rule-desc-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Từ khóa xuất hiện trong Tóm tắt.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-words-icon">🔴</span>
                <span id="rule-words-text" style="font-size: 11px; color: var(--color-text-muted);">Độ dài bài viết tối thiểu 600 từ.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-density-icon">🔴</span>
                <span id="rule-density-text" style="font-size: 11px; color: var(--color-text-muted);">Mật độ từ khóa lý tưởng (0.8% - 2.5%).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-intro-kw-icon">🔴</span>
                <span id="rule-intro-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Từ khóa xuất hiện trong 100 từ đầu mở bài.</span>
              </div>
            </div>
          </div>

          <!-- PILLAR 3: CẤU TRÚC & ĐỘ DỄ ĐỌC -->
          <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); padding: 12px; border-radius: 8px;">
            <div style="font-weight: bold; color: var(--color-primary); font-size: 11px; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
              <span>📊 3. Bố Cấu Trúc & Độ Dễ Đọc</span>
              <span id="score-pillar-structure" style="color: var(--color-text-muted); font-size: 10px;">0/5 Đạt</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-conclusion-kw-icon">🔴</span>
                <span id="rule-conclusion-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Từ khóa xuất hiện trong đoạn kết bài (150 từ cuối).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-headings-icon">🔴</span>
                <span id="rule-headings-text" style="font-size: 11px; color: var(--color-text-muted);">Sử dụng các tiêu đề phụ (H2, H3).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-heading-kw-icon">🔴</span>
                <span id="rule-heading-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Có từ khóa trong tiêu đề phụ H2/H3.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-bolding-icon">🔴</span>
                <span id="rule-bolding-text" style="font-size: 11px; color: var(--color-text-muted);">Bôi đậm (strong/b) từ khóa chính trong bài.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-readability-icon">🔴</span>
                <span id="rule-readability-text" style="font-size: 11px; color: var(--color-text-muted);">Các đoạn văn ngắn gọn, dễ đọc (dưới 150 từ).</span>
              </div>
            </div>
          </div>

          <!-- PILLAR 4: LIÊN KẾT & HÌNH ẢNH -->
          <div style="background: rgba(255,255,255,0.01); border: 1px solid rgba(255,255,255,0.05); padding: 12px; border-radius: 8px;">
            <div style="font-weight: bold; color: var(--color-primary); font-size: 11px; text-transform: uppercase; margin-bottom: 10px; display: flex; align-items: center; justify-content: space-between;">
              <span>🔗 4. Liên Kết & Hình Ảnh</span>
              <span id="score-pillar-links" style="color: var(--color-text-muted); font-size: 10px;">0/5 Đạt</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-img-presence-icon">🔴</span>
                <span id="rule-img-presence-text" style="font-size: 11px; color: var(--color-text-muted);">Có hình ảnh minh họa trong bài viết.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-img-alt-icon">🔴</span>
                <span id="rule-img-alt-text" style="font-size: 11px; color: var(--color-text-muted);">Tất cả hình ảnh chèn vào bài phải có thẻ ALT.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-img-alt-kw-icon">🔴</span>
                <span id="rule-img-alt-kw-text" style="font-size: 11px; color: var(--color-text-muted);">Có chứa từ khóa chính trong thẻ ALT của ảnh.</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-link-presence-icon">🔴</span>
                <span id="rule-link-presence-text" style="font-size: 11px; color: var(--color-text-muted);">Có liên kết chèn vào bài (Internal/External link).</span>
              </div>
              <div style="display: flex; align-items: flex-start; gap: 8px;">
                <span id="rule-link-anchor-icon">🔴</span>
                <span id="rule-link-anchor-text" style="font-size: 11px; color: var(--color-text-muted);">Chất lượng Anchor text (Tránh từ khóa chung chung).</span>
              </div>
            </div>
          </div>

          <!-- SUGGESTED KEYWORDS -->
          <div style="display: flex; flex-direction: column; gap: 6px; border: 1px dashed rgba(52, 211, 153, 0.15); padding: 10px; border-radius: 8px; background: var(--color-primary-glow);">
            <span style="font-weight: bold; color: var(--color-primary); font-size: 11.5px; text-transform: uppercase;">💡 Gợi ý từ khóa khuyên dùng:</span>
            <div id="seo-smart-tags" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px;">
              <!-- Tags will load dynamically using JS based on Category selector -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>





