<?php
$basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
?>
      <style>
        .media-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
          gap: 24px;
          margin-top: 24px;
        }
        .media-card {
          background: var(--color-bg-card);
          border: 1px solid var(--color-border);
          border-radius: 12px;
          overflow: hidden;
          display: flex;
          flex-direction: column;
          transition: var(--transition-normal);
          position: relative;
        }
        .media-card:hover {
          border-color: var(--color-primary);
          transform: translateY(-4px);
          box-shadow: 0 10px 25px rgba(56, 189, 248, 0.08);
        }
        .media-preview {
          width: 100%;
          height: 160px;
          overflow: hidden;
          background: #0d121c;
          display: flex;
          align-items: center;
          justify-content: center;
          position: relative;
          border-bottom: 1px solid var(--color-border);
        }
        .media-img {
          width: 100%;
          height: 100%;
          object-fit: cover;
          transition: transform 0.5s ease;
        }
        .media-card:hover .media-img {
          transform: scale(1.05);
        }
        .media-info {
          padding: 16px;
          display: flex;
          flex-direction: column;
          gap: 10px;
          flex-grow: 1;
        }
        .media-title {
          font-size: 12px;
          font-weight: 700;
          color: #fff;
          word-break: break-all;
          line-height: 1.4;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
          height: 34px;
        }
        .media-meta {
          display: flex;
          justify-content: space-between;
          font-size: 10px;
          color: var(--color-text-muted);
          font-weight: bold;
        }
        .media-badge {
          background: var(--color-primary-glow);
          border: 1px solid var(--color-primary);
          color: var(--color-primary);
          padding: 2px 6px;
          border-radius: 4px;
          text-transform: uppercase;
        }
        .media-copy-group {
          position: relative;
          display: flex;
          margin-top: 5px;
        }
        .media-copy-input {
          background: rgba(10, 14, 22, 0.8) !important;
          border: 1px solid var(--color-border) !important;
          color: var(--color-text-muted) !important;
          font-size: 11px !important;
          padding: 6px 36px 6px 8px !important;
          border-radius: 4px !important;
          width: 100%;
          text-align: left;
          font-family: monospace;
          text-overflow: ellipsis;
        }
        .btn-copy-icon {
          position: absolute;
          right: 5px;
          top: 50%;
          transform: translateY(-50%);
          background: transparent;
          border: none;
          color: var(--color-primary);
          cursor: pointer;
          padding: 4px;
          display: flex;
          align-items: center;
          justify-content: center;
          transition: all 0.2s ease;
        }
        .btn-copy-icon:hover {
          color: #fff;
          transform: translateY(-50%) scale(1.1);
        }
        .media-actions {
          display: flex;
          gap: 8px;
          margin-top: auto;
          padding: 12px 16px;
          border-top: 1px solid var(--color-border);
          background: rgba(10, 14, 22, 0.3);
        }
        .btn-delete-media {
          width: 100%;
          padding: 8px 12px !important;
          font-size: 10.5px !important;
          background: rgba(229, 115, 115, 0.1) !important;
          border: 1px solid #e57373 !important;
          color: #e57373 !important;
          box-shadow: none !important;
          text-transform: uppercase;
          font-weight: 700;
          border-radius: 6px;
          cursor: pointer;
          transition: all 0.3s ease;
        }
        .btn-delete-media:hover {
          background: #e57373 !important;
          color: #000 !important;
          box-shadow: 0 0 10px rgba(229, 115, 115, 0.4) !important;
        }
        .toast-copy {
          position: fixed;
          bottom: 30px;
          right: 30px;
          background: rgba(16, 26, 44, 0.95);
          border: 1px solid var(--color-primary);
          color: #fff;
          padding: 12px 24px;
          border-radius: 8px;
          box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 15px var(--color-primary-glow);
          z-index: 1000;
          font-weight: 700;
          font-size: 12px;
          display: flex;
          align-items: center;
          gap: 8px;
          opacity: 0;
          transform: translateY(20px);
          transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
          pointer-events: none;
        }
        .toast-copy.show {
          opacity: 1;
          transform: translateY(0);
        }
      </style>

      <div class="row">
        <div class="col-12">
          
          <!-- Direct File Upload Card -->
          <div class="card">
            <div class="card__title">Tải lên hình ảnh trực tiếp</div>
            <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.6; margin-bottom: 20px;">
              Chọn một tệp ảnh từ thiết bị của bạn để chuẩn bị trước các tài nguyên hình ảnh. Sau khi tải lên thành công, các liên kết ảnh sẽ được lưu trữ trong Thư viện dưới đây để sử dụng cho Kho xe hoặc Bài viết CMS.
            </p>
            
            <form method="POST" action="admin.php?p=media" enctype="multipart/form-data" style="display:flex; flex-wrap:wrap; gap:16px; align-items:flex-end;">
              <input type="hidden" name="action" value="upload_media">
              
              <div class="form-group" style="flex-grow: 1; margin: 0; min-width: 250px;">
                <label class="form-label" for="media_file">Chọn hình ảnh tải lên máy chủ</label>
                <input class="form-input" type="file" name="media_file" id="media_file" accept="image/*" required style="padding: 9px 12px;">
              </div>
              
              <button class="btn-gold" type="submit" style="padding: 11px 24px;">
                <span>⚡ Bắt đầu tải lên</span>
              </button>
            </form>
          </div>

          <!-- Media Assets Library Grid Card -->
          <div class="card" style="margin-top: 30px;">
            <div class="card__title">Thư viện ảnh đã tải lên</div>
            <p style="font-size: 12.5px; color: var(--color-text-muted); line-height: 1.6;">
              Danh sách toàn bộ các hình ảnh đang lưu trữ thực tế trong thư mục <code>assets/uploads/</code> trên đĩa cứng máy chủ. Bạn có thể sao chép nhanh liên kết hoặc dọn dẹp các tệp tin không dùng để tiết kiệm tài nguyên.
            </p>

            <?php
              $uploadsDir = dirname(__DIR__, 2) . '/assets/uploads';
              $mediaFiles = [];
              if (is_dir($uploadsDir)) {
                  $files = glob($uploadsDir . '/*');
                  if ($files) {
                      foreach ($files as $file) {
                          if (is_file($file)) {
                              $basename = basename($file);
                              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                              $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                              if (in_array($ext, $allowed)) {
                                  $mediaFiles[] = [
                                      'path' => 'assets/uploads/' . $basename,
                                      'name' => $basename,
                                      'ext' => $ext,
                                      'size' => filesize($file),
                                      'time' => filemtime($file)
                                  ];
                              }
                          }
                      }
                  }
              }

              // Sort files by newest uploaded first
              usort($mediaFiles, function($a, $b) {
                  return $b['time'] <=> $a['time'];
              });
            ?>

            <?php if (empty($mediaFiles)): ?>
              <div style="text-align: center; padding: 60px 0; color: var(--color-text-muted);">
                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:15px; opacity:0.5; color: var(--color-primary);">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                  <circle cx="8.5" cy="8.5" r="1.5"/>
                  <polyline points="21 15 16 10 5 21"/>
                </svg>
                <p>Thư viện Media hiện tại chưa có hình ảnh nào được tải lên máy chủ.</p>
              </div>
            <?php else: ?>
              <!-- Selection & Bulk Actions Toolbar -->
              <div class="media-toolbar" style="display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-top: 15px; padding: 12px 20px; background: rgba(255,255,255,0.015); border: 1px solid var(--color-border); border-radius: 8px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 10px;">
                  <input type="checkbox" id="select-all-media" style="width: 17px; height: 17px; cursor: pointer; accent-color: var(--color-primary);" onchange="toggleSelectAllMedia(this)">
                  <label for="select-all-media" style="font-size: 13px; font-weight: 600; cursor: pointer; color: var(--color-text-muted); user-select: none;">Chọn tất cả (<span id="total-media-count"><?php echo count($mediaFiles); ?></span> ảnh)</label>
                </div>
                <div>
                  <button type="button" class="btn-delete-selected" id="btn-delete-selected-media" disabled onclick="deleteSelectedMedia()" style="padding: 8px 16px; font-size: 11px; background: rgba(229,115,115,0.05); border: 1px solid rgba(229,115,115,0.3); color: #e57373; border-radius: 6px; font-weight: 700; text-transform: uppercase; cursor: not-allowed; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 6px; box-shadow: none; outline: none; font-family: inherit;">
                    <i class="fas fa-trash-alt"></i>
                    <span>Xóa đã chọn (<span id="selected-media-count">0</span>)</span>
                  </button>
                </div>
              </div>

              <div class="media-grid">
                <?php foreach ($mediaFiles as $file): ?>
                  <?php
                    // Format file size nicely
                    $sizeBytes = $file['size'];
                    if ($sizeBytes >= 1024 * 1024) {
                        $sizeFormatted = number_format($sizeBytes / (1024 * 1024), 2) . ' MB';
                    } else {
                        $sizeFormatted = number_format($sizeBytes / 1024, 1) . ' KB';
                    }
                    $dateFormatted = date('d/m/Y H:i', $file['time']);
                    $fileHash = md5($file['name']);
                  ?>
                  <article class="media-card" id="card-<?php echo $fileHash; ?>">
                    <!-- Bulk selection checkbox overlay -->
                    <div class="media-select-overlay" style="position: absolute; top: 10px; left: 10px; z-index: 20; background: rgba(10, 14, 22, 0.8); border: 1px solid var(--color-border); border-radius: 4px; padding: 4px; display: flex; align-items: center; justify-content: center; width: 24px; height: 24px;">
                      <input type="checkbox" class="media-checkbox" value="<?php echo htmlspecialchars($file['path']); ?>" onchange="updateSelectedCount()" style="width: 16px; height: 16px; cursor: pointer; accent-color: var(--color-primary); margin: 0;">
                    </div>

                    <div class="media-preview">
                      <img src="<?php echo $basePath; ?>/<?php echo htmlspecialchars($file['path']); ?>" alt="<?php echo htmlspecialchars($file['name']); ?>" class="media-img" loading="lazy">
                    </div>
                    
                    <div class="media-info">
                      <div class="media-title" title="<?php echo htmlspecialchars($file['name']); ?>">
                        <?php echo htmlspecialchars($file['name']); ?>
                      </div>
                      
                      <div class="media-meta">
                        <span class="media-badge"><?php echo htmlspecialchars($file['ext']); ?></span>
                        <span><?php echo $sizeFormatted; ?></span>
                      </div>
                      
                      <div class="media-meta" style="font-size: 9.5px; font-weight:normal; border-top: 1px solid rgba(255,255,255,0.03); padding-top:6px;">
                        <span>Tải lên:</span>
                        <span><?php echo $dateFormatted; ?></span>
                      </div>

                      <div class="media-copy-group">
                        <input type="text" class="media-copy-input" readonly value="<?php echo htmlspecialchars($file['path']); ?>" id="input-path-<?php echo $fileHash; ?>">
                        <button class="btn-copy-icon" onclick="copyMediaLink('<?php echo htmlspecialchars($file['path']); ?>')" title="Sao chép liên kết ảnh">
                          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                          </svg>
                        </button>
                      </div>
                    </div>

                    <div class="media-actions">
                      <form method="POST" action="admin.php?p=media" style="width:100%; margin:0;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa hình ảnh này vĩnh viễn khỏi máy chủ? Thao tác này KHÔNG THỂ khôi phục và sẽ gây lỗi hiển thị nếu ảnh đang được dùng!')">
                        <input type="hidden" name="action" value="delete_media">
                        <input type="hidden" name="file_path" value="<?php echo htmlspecialchars($file['path']); ?>">
                        <button type="submit" class="btn-delete-media">Xóa vĩnh viễn</button>
                      </form>
                    </div>
                  </article>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

          </div>

        </div>
      </div>

      <!-- Hidden form for bulk media deletion -->
      <form id="bulk-delete-media-form" method="POST" action="admin.php?p=media" style="display: none;">
        <input type="hidden" name="action" value="delete_multiple_media">
        <input type="hidden" name="file_paths" id="bulk-delete-paths-input">
      </form>

      <!-- Toast Notification for Link Copying -->
      <div class="toast-copy" id="copy-toast">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#81c784" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span>Đã sao chép liên kết tệp tin thành công!</span>
      </div>

      <script>
        function copyMediaLink(path) {
          navigator.clipboard.writeText(path).then(() => {
            const toast = document.getElementById('copy-toast');
            toast.classList.add('show');
            setTimeout(() => {
              toast.classList.remove('show');
            }, 2500);
          }).catch(err => {
            alert('Không thể sao chép liên kết: ' + err);
          });
        }

        // Update total checked media files count and toggle delete button status
        function updateSelectedCount() {
          const checkboxes = document.querySelectorAll('.media-checkbox');
          const checkedCheckboxes = document.querySelectorAll('.media-checkbox:checked');
          const deleteBtn = document.getElementById('btn-delete-selected-media');
          const countSpan = document.getElementById('selected-media-count');
          const selectAllCheckbox = document.getElementById('select-all-media');
          
          if (!deleteBtn || !countSpan) return;
          
          const count = checkedCheckboxes.length;
          countSpan.textContent = count;
          
          // Toggle styling and disabled attribute
          if (count > 0) {
            deleteBtn.removeAttribute('disabled');
            deleteBtn.style.cursor = 'pointer';
            deleteBtn.style.background = 'rgba(229,115,115,0.2)';
            deleteBtn.style.borderColor = '#e57373';
            deleteBtn.style.color = '#e57373';
            
            // Subtle pulse hover effect enabled
            deleteBtn.onmouseover = () => {
              deleteBtn.style.background = '#e57373';
              deleteBtn.style.color = '#000';
              deleteBtn.style.boxShadow = '0 0 12px rgba(229, 115, 115, 0.4)';
            };
            deleteBtn.onmouseout = () => {
              deleteBtn.style.background = 'rgba(229,115,115,0.2)';
              deleteBtn.style.color = '#e57373';
              deleteBtn.style.boxShadow = 'none';
            };
          } else {
            deleteBtn.setAttribute('disabled', 'true');
            deleteBtn.style.cursor = 'not-allowed';
            deleteBtn.style.background = 'rgba(229,115,115,0.05)';
            deleteBtn.style.borderColor = 'rgba(229,115,115,0.3)';
            deleteBtn.style.color = '#e57373';
            deleteBtn.style.boxShadow = 'none';
            deleteBtn.onmouseover = null;
            deleteBtn.onmouseout = null;
          }
          
          // Sync select all master checkbox state
          if (selectAllCheckbox) {
            selectAllCheckbox.checked = (count === checkboxes.length && checkboxes.length > 0);
          }
        }

        // Toggle Select All checkbox action
        function toggleSelectAllMedia(masterCheckbox) {
          const checkboxes = document.querySelectorAll('.media-checkbox');
          checkboxes.forEach(cb => {
            cb.checked = masterCheckbox.checked;
          });
          updateSelectedCount();
        }

        // Submit bulk delete form
        function deleteSelectedMedia() {
          const checkedCheckboxes = document.querySelectorAll('.media-checkbox:checked');
          if (checkedCheckboxes.length === 0) return;
          
          const paths = [];
          checkedCheckboxes.forEach(cb => {
            paths.push(cb.value);
          });
          
          const confirmMsg = `Bạn có chắc chắn muốn xóa vĩnh viễn ${paths.length} hình ảnh đã chọn khỏi máy chủ?\nThao tác này sẽ giải phóng dung lượng nhưng KHÔNG THỂ hoàn tác và có thể gây lỗi hiển thị nếu có ảnh đang được sử dụng!`;
          
          if (confirm(confirmMsg)) {
            const pathsInput = document.getElementById('bulk-delete-paths-input');
            const deleteForm = document.getElementById('bulk-delete-media-form');
            if (pathsInput && deleteForm) {
              pathsInput.value = JSON.stringify(paths);
              deleteForm.submit();
            }
          }
        }
      </script>





