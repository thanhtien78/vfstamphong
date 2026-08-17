      <?php
        // Fetch existing counselors list
        $counselors = $db->query("SELECT * FROM counselors ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
        
        // Handle Edit Counselor retrieval if edit_counselor_id is set
        $editing_counselor = null;
        if (isset($_GET['edit_counselor_id'])) {
            $edit_id = (int)$_GET['edit_counselor_id'];
            $stmt_edit = $db->prepare("SELECT * FROM counselors WHERE id = ?");
            $stmt_edit->execute([$edit_id]);
            $editing_counselor = $stmt_edit->fetch(PDO::FETCH_ASSOC);
        }
      ?>

      <div class="layout-split layout-split--wide-left">
        <!-- Left Column: Active Counselors List -->
        <div>
          <div class="card">
            <div class="card__title" style="display: flex; align-items: center; gap: 8px; color: var(--color-primary); font-size: 14px; font-weight: 700;">
              <span>👥 DANH SÁCH ĐỘI NGŨ NHÂN VIÊN TƯ VẤN & HỖ TRỢ VIP</span>
            </div>
            <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom: 20px;">
              💡 <strong>Lưu ý hiển thị:</strong> Chỉ những nhân viên có trạng thái <strong style="color: #2ec4b6;">ONLINE</strong> mới được hiển thị trên trang chủ và các trang chi tiết sản phẩm xe để khách hàng bấm gọi trực tiếp hoặc chat Zalo.
            </p>

            <table class="cms-table">
              <thead>
                <tr>
                  <th style="width: 70px;">Avatar</th>
                  <th>Tên nhân viên</th>
                  <th>Số điện thoại</th>
                  <th>Link Zalo</th>
                  <th>Địa bàn pSEO</th>
                  <th style="width: 100px;">Trạng thái</th>
                  <th style="width: 130px; text-align: center;">Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($counselors)): ?>
                  <tr>
                    <td colspan="7" style="text-align: center; color: var(--color-text-muted); padding: 30px;">
                      📭 Chưa có nhân viên tư vấn nào trong hệ thống. Hãy thêm mới bên phải.
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($counselors as $c): ?>
                    <tr>
                      <td>
                        <div style="width: 48px; height: 48px; border-radius: 50%; overflow: hidden; border: 2px solid <?php echo $c['status'] === 'ONLINE' ? 'var(--color-primary)' : 'var(--color-border)'; ?>; background: #0d121c; display: flex; align-items: center; justify-content: center;">
                          <?php if ($c['avatar']): ?>
                            <img src="<?php echo htmlspecialchars($c['avatar']); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Avatar">
                          <?php else: ?>
                            <span style="font-size: 20px;">👤</span>
                          <?php endif; ?>
                        </div>
                      </td>
                      <td style="font-weight: 600; color: #fff;">
                        <?php echo htmlspecialchars($c['fullname']); ?>
                      </td>
                      <td style="font-family: monospace; font-size: 13px;">
                        <a href="tel:<?php echo htmlspecialchars($c['phone']); ?>" style="color: var(--color-primary); text-decoration: none;">
                          📞 <?php echo htmlspecialchars($c['phone']); ?>
                        </a>
                      </td>
                      <td>
                        <a href="<?php echo htmlspecialchars($c['zalo']); ?>" target="_blank" style="color: #0084ff; text-decoration: none; font-size: 12px; display: inline-flex; align-items: center; gap: 4px;" rel="noopener">
                          💬 Chat Zalo <span style="font-size: 10px;">↗</span>
                        </a>
                      </td>
                      <td style="font-size: 11px; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?php echo htmlspecialchars($c['assigned_areas'] ?? ''); ?>">
                        <?php echo !empty($c['assigned_areas']) ? htmlspecialchars($c['assigned_areas']) : '<span style="color:var(--color-text-muted); font-style:italic;">Toàn quốc</span>'; ?>
                      </td>
                      <td>
                        <?php if ($c['status'] === 'ONLINE'): ?>
                          <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(46, 196, 182, 0.15); color: #2ec4b6; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; border: 1px solid rgba(46, 196, 182, 0.3);">
                            <span style="width: 6px; height: 6px; background: #2ec4b6; border-radius: 50%; display: inline-block; box-shadow: 0 0 8px #2ec4b6; animation: blink 1.5s infinite;"></span>
                            ONLINE
                          </span>
                        <?php else: ?>
                          <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.05); color: var(--color-text-muted); padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; border: 1px solid var(--color-border);">
                            OFFLINE
                          </span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <div style="display: flex; gap: 8px; justify-content: center;">
                          <a href="admin.php?p=counselors&edit_counselor_id=<?php echo $c['id']; ?>" class="btn btn--secondary" style="padding: 6px 12px; font-size: 12px; height: auto;">
                            ✏️ Sửa
                          </a>
                          <form method="POST" action="admin.php?p=counselors" style="display: inline;" onsubmit="return confirm('Bạn chắc chắn muốn xóa nhân viên <?php echo htmlspecialchars($c['fullname']); ?> khỏi hệ thống?');">
                            <input type="hidden" name="action" value="delete_counselor">
                            <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                            <button type="submit" class="btn btn--danger" style="padding: 6px 12px; font-size: 12px; height: auto; background: #d90429;">
                              🗑️ Xóa
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Right Column: Add/Edit Counselor Form -->
        <div>
          <div class="card">
            <?php if ($editing_counselor): ?>
              <div class="card__title" style="color: var(--color-primary); font-size: 14px; font-weight: 700; display: flex; justify-content: space-between; align-items: center;">
                <span>✏️ CẬP NHẬT TƯ VẤN VIÊN</span>
                <a href="admin.php?p=counselors" style="font-size: 12px; color: var(--color-text-muted); text-decoration: none; font-weight: normal; background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px;">Huỷ sửa ✕</a>
              </div>
            <?php else: ?>
              <div class="card__title" style="color: var(--color-primary); font-size: 14px; font-weight: 700;">
                <span>➕ THÊM TƯ VẤN VIÊN MỚI</span>
              </div>
            <?php endif; ?>

            <form method="POST" action="admin.php?p=counselors" enctype="multipart/form-data" style="margin-top: 15px;">
              <input type="hidden" name="action" value="<?php echo $editing_counselor ? 'edit_counselor' : 'create_counselor'; ?>">
              <?php if ($editing_counselor): ?>
                <input type="hidden" name="id" value="<?php echo $editing_counselor['id']; ?>">
              <?php endif; ?>

              <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="counselor_fullname" style="font-weight: 600;">Họ và tên nhân viên <span style="color: #ff4d4f;">*</span></label>
                <input type="text" class="form-input" id="counselor_fullname" name="fullname" placeholder="Ví dụ: Nguyễn Thanh Hương" required value="<?php echo $editing_counselor ? htmlspecialchars($editing_counselor['fullname']) : ''; ?>">
              </div>

              <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="counselor_phone" style="font-weight: 600;">Số điện thoại liên hệ <span style="color: #ff4d4f;">*</span></label>
                <input type="text" class="form-input" id="counselor_phone" name="phone" placeholder="Ví dụ: 0817777855" required value="<?php echo $editing_counselor ? htmlspecialchars($editing_counselor['phone']) : ''; ?>">
              </div>

              <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="counselor_zalo" style="font-weight: 600;">Đường dẫn Chat Zalo <span style="color: #ff4d4f;">*</span></label>
                <input type="url" class="form-input" id="counselor_zalo" name="zalo" placeholder="Ví dụ: https://zalo.me/0817777855" required value="<?php echo $editing_counselor ? htmlspecialchars($editing_counselor['zalo']) : ''; ?>">
                <span style="font-size: 11px; color: var(--color-text-muted); margin-top: 4px; display: block;">💡 Nhập đầy đủ giao thức: <code>https://zalo.me/sodt_cua_ban</code></span>
              </div>

              <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="counselor_avatar" style="font-weight: 600;">Ảnh đại diện (Đường dẫn URL hoặc Tải lên ảnh mới)</label>
                <div style="display: flex; gap: 8px; align-items: center;">
                  <input type="text" class="form-input" id="counselor_avatar" name="avatar" data-has-picker="true" placeholder="Nhập link ảnh hoặc chọn từ thư viện" value="<?php echo $editing_counselor ? htmlspecialchars($editing_counselor['avatar']) : ''; ?>" style="flex: 1;">
                  <button type="button" class="btn-select-media btn-gold" id="btn-select-counselor-avatar" style="margin-top: 0; padding: 10px 14px; font-size: 12px; font-weight: 700; white-space: nowrap; height: auto; line-height: 1.2; box-shadow: none;">📂 Chọn từ thư viện</button>
                </div>
                <input type="file" class="form-input" id="counselor_avatar_file" name="avatar_file" accept="image/*" style="margin-top:8px;">
                <span style="font-size: 11px; color: var(--color-text-muted); margin-top: 4px; display: block;">💡 Nên sử dụng ảnh chụp chân dung tỉ lệ vuông 1:1 rõ nét.</span>
              </div>

              <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="counselor_assigned_areas" style="font-weight: 600;">Địa bàn phụ trách (pSEO Slugs)</label>
                <input type="text" class="form-input" id="counselor_assigned_areas" name="assigned_areas" placeholder="Ví dụ: quan-1, binh-duong, huyen-nha-be" value="<?php echo $editing_counselor ? htmlspecialchars($editing_counselor['assigned_areas'] ?? '') : ''; ?>">
                <span style="font-size: 11px; color: var(--color-text-muted); margin-top: 4px; display: block;">💡 Nhập danh sách các slug địa phương cách nhau bởi dấu phẩy để hệ thống tự phân phối tư vấn viên trên các trang pSEO tương ứng.</span>
              </div>

              <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" for="counselor_status" style="font-weight: 600;">Trạng thái hoạt động <span style="color: #ff4d4f;">*</span></label>
                <select class="form-input" id="counselor_status" name="status" required>
                  <option value="ONLINE" <?php echo ($editing_counselor && $editing_counselor['status'] === 'ONLINE') ? 'selected' : ''; ?>>🟢 ONLINE (Hiển thị ra ngoài)</option>
                  <option value="OFFLINE" <?php echo ($editing_counselor && $editing_counselor['status'] === 'OFFLINE') ? 'selected' : ''; ?>>⚪ OFFLINE (Tạm ẩn khỏi client)</option>
                </select>
              </div>

              <button type="submit" class="btn" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700;">
                <?php echo $editing_counselor ? '💾 CẬP NHẬT THÔNG TIN' : '➕ THÊM TƯ VẤN VIÊN'; ?>
              </button>
            </form>
          </div>
        </div>
      </div>

      <style>
        @keyframes blink {
          0% { opacity: 0.4; }
          50% { opacity: 1; }
          100% { opacity: 0.4; }
        }
      </style>

      <script>
        const initCounselorPicker = () => {
          const btn = document.getElementById("btn-select-counselor-avatar");
          if (btn) {
            btn.addEventListener("click", () => {
              const input = document.getElementById("counselor_avatar");
              if (input && typeof window.openMediaLibrary === "function") {
                window.openMediaLibrary(input);
              }
            });
          }
        };

        if (document.readyState === "loading") {
          document.addEventListener("DOMContentLoaded", initCounselorPicker);
        } else {
          initCounselorPicker();
        }
      </script>





