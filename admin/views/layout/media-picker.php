<?php
/**
 * Admin Panel Layout: WordPress-style Media Picker Modal
 * Renders the Media Library picker, CSS styles, and JS controllers.
 */
global $basePath;
?>
<!-- WORDPRESS-STYLE MEDIA MODAL FOR TINYMCE -->
<div class="wp-media-modal" id="wp-media-modal" style="display:none;">
  <div class="wp-media-modal-backdrop" id="wp-media-modal-backdrop"></div>
  <div class="wp-media-modal-dialog">
    <div class="wp-media-modal-header">
      <div class="wp-media-modal-title">Thư viện truyền thông (Media Library)</div>
      <button type="button" class="wp-media-modal-close" id="wp-media-modal-close">&times;</button>
    </div>
    
    <div class="wp-media-modal-tabs">
      <div class="wp-media-tab-btn active" data-tab="wp-tab-upload">Tải tập tin lên</div>
      <div class="wp-media-tab-btn" data-tab="wp-tab-library">Thư viện hình ảnh</div>
    </div>
    
    <div class="wp-media-modal-body">
      <!-- TAB 1: UPLOAD NEW FILE -->
      <div class="wp-media-tab-content active" id="wp-tab-upload">
        <div class="wp-upload-drag-zone" id="wp-upload-drag-zone">
          <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="var(--color-primary)" stroke-width="1.5" style="margin-bottom:15px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
          <div style="font-weight:700; font-size:15px; color:#fff; margin-bottom:8px;">Thả tệp tin hình ảnh vào đây</div>
          <div style="font-size:12px; color:var(--color-text-muted); margin-bottom:15px;">Hoặc</div>
          <button type="button" class="btn-gold" style="box-shadow:none; padding:8px 16px; min-height:auto;" onclick="document.getElementById('wp-media-upload-input').click()">Chọn tệp tin</button>
          <input type="file" id="wp-media-upload-input" accept="image/*" style="display:none;">
          <div style="font-size:11px; color:var(--color-text-muted); margin-top:15px;">Dung lượng tối đa: 15MB. Hỗ trợ: JPG, JPEG, PNG, GIF, WEBP.</div>
        </div>
        <div class="wp-upload-progress-container" id="wp-upload-progress-container" style="display:none; margin-top:20px; text-align:center; padding: 40px 0;">
          <div class="wp-spinner" style="display:inline-block; width:32px; height:32px; border:3px solid rgba(255,255,255,0.1); border-top-color:var(--color-primary); border-radius:50%; animation:wp-spin 0.8s linear infinite;"></div>
          <div style="font-size:13px; color:var(--color-text-muted); margin-top:15px; font-weight: 500;">Đang tải hình ảnh lên máy chủ...</div>
        </div>
      </div>
      
      <!-- TAB 2: CHOOSE FROM EXISTING FILES -->
      <div class="wp-media-tab-content" id="wp-tab-library">
        <div style="display: flex; flex-direction: row; gap: 20px; height: 100%; min-height: 0; width: 100%;">
          <!-- Grid Main Area -->
          <div class="wp-media-library-main" style="flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100%;">
            <div class="wp-media-library-search" style="margin-bottom:15px;">
              <input type="text" class="form-input" id="wp-media-search-input" placeholder="Tìm kiếm hình ảnh theo tên tệp..." style="font-size:12px; padding:8px 12px; height:auto; background: rgba(0,0,0,0.3);">
            </div>
            <div class="wp-media-grid" id="wp-media-grid">
              <!-- Populated dynamically via AJAX -->
            </div>
          </div>
          
          <!-- Details Sidebar Area -->
          <div class="wp-media-library-sidebar" id="wp-media-sidebar" style="width: 320px; display: flex; flex-direction: column; gap: 15px; border-left: 1px solid var(--color-border); padding-left: 20px; background: rgba(10,14,22,0.15); padding: 15px; border-radius: 8px; overflow-y: auto; box-sizing: border-box;">
            <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; letter-spacing: 0.5px;">Chi tiết hình ảnh</div>
            
            <div id="wp-media-sidebar-preview" style="width: 100%; height: 160px; border-radius: 6px; overflow: hidden; border: 1px solid var(--color-border); background: #000; display: flex; align-items: center; justify-content: center;">
              <span style="color: var(--color-text-muted); font-size: 11px;">Chưa chọn ảnh nào</span>
            </div>
            
            <div id="wp-media-sidebar-info" style="font-size: 11.5px; display: flex; flex-direction: column; gap: 8px; color: var(--color-text-muted); line-height: 1.4;">
              <span style="color: var(--color-text-muted); font-size: 11px; text-align: center; display: block; margin-top: 10px;">Chọn một hình ảnh từ lưới bên trái để xem chi tiết.</span>
            </div>

            <!-- IMAGE SEO ALT OPTIMIZER INPUT -->
            <div id="wp-media-alt-container" style="display: none; flex-direction: column; gap: 6px;">
              <label for="wp-media-alt-input" style="font-size:10px; font-weight:bold; color:var(--color-primary); text-transform:uppercase; letter-spacing:0.5px;">🔍 Thẻ ALT (Mô tả SEO):</label>
              <input type="text" id="wp-media-alt-input" placeholder="Mô tả nội dung hình ảnh chuẩn SEO (vd: xe VinFast EV)..." style="font-size: 12px; padding: 8px 10px; border-radius: 4px; border: 1px solid rgba(52, 211, 153, 0.3); background: rgba(0,0,0,0.2); color: #fff; width: 100%; outline: none; box-sizing: border-box;">
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="wp-media-modal-footer" style="display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap;">
      <div style="font-size:11.5px; color:var(--color-text-muted);" id="wp-selected-info">Chưa chọn hình ảnh nào</div>
      <button type="button" class="btn-gold" id="btn-wp-media-insert" disabled style="padding:8px 16px; font-size:12px; font-weight:700; min-height:auto; box-shadow:none;">Chèn vào bài viết</button>
    </div>
  </div>
</div>

<!-- STYLES FOR THE WORDPRESS-STYLE MEDIA PICKER -->
<style>
.wp-media-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 99999;
  display: flex;
  align-items: center;
  justify-content: center;
}
.wp-media-modal-backdrop {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(4, 6, 10, 0.85);
  backdrop-filter: blur(8px);
}
.wp-media-modal-dialog {
  position: relative;
  width: 98vw;
  max-width: 1600px;
  height: 94vh;
  max-height: 95vh;
  background: var(--color-bg-card);
  border: 1px solid var(--color-border);
  border-radius: 12px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 30px rgba(52, 211, 153, 0.05);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  animation: wp-modal-in 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
@keyframes wp-modal-in {
  from { opacity: 0; transform: scale(0.95) translateY(15px); }
  to { opacity: 1; transform: scale(1) translateY(0); }
}
.wp-media-modal-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--color-border);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(10, 14, 22, 0.4);
}
.wp-media-modal-title {
  font-family: 'Montserrat', sans-serif;
  font-weight: 700;
  font-size: 15px;
  color: #fff;
  letter-spacing: 0.5px;
}
.wp-media-modal-close {
  background: transparent;
  border: none;
  color: var(--color-text-muted);
  font-size: 24px;
  cursor: pointer;
  transition: color 0.2s;
  line-height: 1;
}
.wp-media-modal-close:hover {
  color: #fff;
}
.wp-media-modal-tabs {
  display: flex;
  background: rgba(10, 14, 22, 0.2);
  border-bottom: 1px solid var(--color-border);
}
.wp-media-tab-btn {
  padding: 12px 20px;
  font-size: 12.5px;
  font-weight: 600;
  color: var(--color-text-muted);
  cursor: pointer;
  border-bottom: 2px solid transparent;
  transition: all 0.2s ease;
}
.wp-media-tab-btn:hover {
  color: #fff;
}
.wp-media-tab-btn.active {
  color: var(--color-primary);
  border-bottom-color: var(--color-primary);
  background: rgba(255, 255, 255, 0.02);
}
.wp-media-modal-body {
  flex-grow: 1;
  padding: 20px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  min-height: 0;
}
.wp-media-tab-content {
  display: none;
  height: 100%;
}
.wp-media-tab-content.active {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  min-height: 0;
}
.wp-upload-drag-zone {
  flex-grow: 1;
  border: 2px dashed var(--color-border);
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px;
  background: rgba(255, 255, 255, 0.01);
  transition: all 0.3s ease;
}
.wp-upload-drag-zone.dragover {
  border-color: var(--color-primary);
  background: rgba(52, 211, 153, 0.05);
}
.wp-media-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 16px;
  flex-grow: 1;
  overflow-y: auto;
  padding: 6px;
}
.wp-media-item {
  position: relative;
  width: 100%;
  height: 0;
  padding-bottom: 100%; /* Perfect aspect ratio fallback */
  border: 2px solid var(--color-border);
  border-radius: 8px;
  overflow: hidden;
  cursor: pointer;
  background: #05070a;
  transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.wp-media-item img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: transform 0.3s ease;
}
.wp-media-item:hover {
  border-color: var(--color-primary);
  box-shadow: 0 4px 15px rgba(52, 211, 153, 0.15);
}
.wp-media-item:hover img {
  transform: scale(1.08); /* Premium micro-interaction zoom */
}
/* Smart file name overlay on hover */
.wp-media-item::before {
  content: attr(data-name);
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  background: linear-gradient(to top, rgba(0,0,0,0.85) 70%, transparent 100%);
  color: rgba(255, 255, 255, 0.85);
  font-size: 9.5px;
  padding: 8px 6px 4px 6px;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  z-index: 5;
  opacity: 0;
  transform: translateY(100%);
  transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
  pointer-events: none;
  font-weight: 500;
  text-align: center;
}
.wp-media-item:hover::before {
  opacity: 1;
  transform: translateY(0);
}
.wp-media-item.selected {
  border-color: var(--color-primary);
  box-shadow: 0 0 15px rgba(52, 211, 153, 0.35);
}
.wp-media-item.selected::after {
  content: '✓';
  position: absolute;
  top: 6px;
  right: 6px;
  background: var(--color-primary);
  color: #000;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 900;
  z-index: 10;
  box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}
.wp-media-modal-footer {
  padding: 16px 20px;
  border-top: 1px solid var(--color-border);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(10, 14, 22, 0.4);
}
@keyframes wp-spin {
  to { transform: rotate(360deg); }
}
</style>

<!-- JAVASCRIPT FOR THE WORDPRESS-STYLE MEDIA PICKER -->
<script>
  // Global scope variables for media picker target and invocation
  let activeTargetInput = null;
  
  window.openMediaLibrary = (targetInput) => {
    if (typeof targetInput === "string") {
      activeTargetInput = document.getElementById(targetInput);
    } else {
      activeTargetInput = targetInput;
    }
    const btnInsert = document.getElementById("btn-wp-media-insert");
    if (btnInsert) {
      btnInsert.textContent = activeTargetInput ? "Xác nhận chọn ảnh" : "Chèn vào bài viết";
    }
    const modal = document.getElementById("wp-media-modal");
    if (modal) {
      modal.style.display = "flex";
      document.body.style.overflow = "hidden";
      if (typeof window.loadMediaLibraryFiles === "function") {
        window.loadMediaLibraryFiles();
      }
    }
  };

  const initMediaLibrary = () => {
    const btnAddMedia = document.getElementById("btn-add-media-tinymce");
    const btnAddMediaPricelist = document.getElementById("btn-add-media-pricelist-editorial");
    const modal = document.getElementById("wp-media-modal");
    if (!modal) return;

    const modalBackdrop = document.getElementById("wp-media-modal-backdrop");
    const modalClose = document.getElementById("wp-media-modal-close");
    const tabBtns = modal.querySelectorAll(".wp-media-tab-btn");
    const tabContents = modal.querySelectorAll(".wp-media-tab-content");
    const dragZone = document.getElementById("wp-upload-drag-zone");
    const fileInput = document.getElementById("wp-media-upload-input");
    const progressContainer = document.getElementById("wp-upload-progress-container");
    const mediaGrid = document.getElementById("wp-media-grid");
    const searchInput = document.getElementById("wp-media-search-input");
    const selectedInfo = document.getElementById("wp-selected-info");
    const btnInsert = document.getElementById("btn-wp-media-insert");
    const altInputContainer = document.getElementById("wp-media-alt-container");
    const altInput = document.getElementById("wp-media-alt-input");

    let selectedImageUrl = null;
    let allLibraryFiles = [];

    // Format file sizes helper
    const formatBytes = (bytes, decimals = 1) => {
      if (!bytes || bytes === 0) return '0 Bytes';
      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    };

    // Open Modal Trigger
    const openModal = () => {
      modal.style.display = "flex";
      document.body.style.overflow = "hidden";
      window.loadMediaLibraryFiles();
    };

    if (btnAddMedia) {
      btnAddMedia.addEventListener("click", () => { 
        activeTargetInput = null; 
        if (btnInsert) btnInsert.textContent = "Chèn vào bài viết";
        openModal(); 
      });
    }
    if (btnAddMediaPricelist) {
      btnAddMediaPricelist.addEventListener("click", () => { 
        activeTargetInput = null; 
        if (btnInsert) btnInsert.textContent = "Chèn vào bài viết";
        openModal(); 
      });
    }

    const shouldHavePicker = (input) => {
      if (input.dataset.hasPicker === 'true') return false;
      if (input.type !== 'text' && input.type !== 'url') return false;
      if (input.nextElementSibling && input.nextElementSibling.classList.contains('btn-select-media')) {
        input.dataset.hasPicker = 'true';
        return false;
      }
      const name = (input.name || '').toLowerCase();
      const id = (input.id || '').toLowerCase();
      const placeholder = (input.placeholder || '').toLowerCase();
      if (name.includes('video') || id.includes('video') || name.includes('map') || id.includes('map') || name.includes('url_video')) return false;
      return (name.includes('image') || id.includes('image') || name.includes('banner') || id.includes('banner') || name.includes('logo') || id.includes('logo') || name.includes('avatar') || id.includes('avatar') || name.includes('photo') || id.includes('photo') || name.includes('file') || id.includes('file') || name.includes('slide') || id.includes('slide') || placeholder.includes('ảnh') || placeholder.includes('hình') || placeholder.includes('url ảnh') || placeholder.includes('đường dẫn ảnh'));
    };

    const injectPickerButtons = () => {
      const textInputs = document.querySelectorAll('input[type="text"], input[type="url"]');
      textInputs.forEach(input => {
        if (shouldHavePicker(input)) {
          input.dataset.hasPicker = 'true';
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'btn-select-media btn-gold';
          btn.style.marginTop = '6px';
          btn.style.padding = '5px 10px';
          btn.style.fontSize = '10.5px';
          btn.style.fontWeight = '700';
          btn.style.height = 'auto';
          btn.style.lineHeight = '1.2';
          btn.style.boxShadow = 'none';
          btn.style.display = 'inline-flex';
          btn.style.alignItems = 'center';
          btn.style.gap = '4px';
          btn.style.cursor = 'pointer';
          btn.innerHTML = '📂 Chọn từ thư viện';
          btn.addEventListener('click', () => { activeTargetInput = input; openModal(); });
          input.parentNode.insertBefore(btn, input.nextSibling);
        }
      });
    };

    // Initialize Observer for dynamic components (like new rows)
    injectPickerButtons();
    const observer = new MutationObserver(() => { injectPickerButtons(); });
    observer.observe(document.body, { childList: true, subtree: true });

    const closeModal = () => {
      modal.style.display = "none";
      document.body.style.overflow = "";
      resetUploadTab();
    };

    modalBackdrop.addEventListener("click", closeModal);
    modalClose.addEventListener("click", closeModal);

    const resetUploadTab = () => {
      progressContainer.style.display = "none";
      dragZone.style.display = "flex";
      fileInput.value = "";
    };

    tabBtns.forEach(btn => {
      btn.addEventListener("click", () => {
        tabBtns.forEach(b => b.classList.remove("active"));
        tabContents.forEach(c => c.classList.remove("active"));
        btn.classList.add("active");
        const targetTab = btn.getAttribute("data-tab");
        document.getElementById(targetTab).classList.add("active");
      });
    });

    // Set up file input change listener so click-to-upload actually works
    if (fileInput) {
      fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
          uploadFile(fileInput.files[0]);
        }
      });
    }

    // Set up drag events properly to prevent default browser behavior
    if (dragZone) {
      dragZone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dragZone.classList.add("dragover");
      });
      dragZone.addEventListener("dragleave", () => {
        dragZone.classList.remove("dragover");
      });
      dragZone.addEventListener("drop", (e) => {
        e.preventDefault();
        dragZone.classList.remove("dragover");
        const files = e.dataTransfer.files;
        if (files.length > 0) uploadFile(files[0]);
      });
    }

    function uploadFile(file) {
      dragZone.style.display = "none";
      progressContainer.style.display = "block";
      const formData = new FormData();
      formData.append("file", file);
      fetch("<?php echo $basePath; ?>/admin/admin.php?upload_tinymce_image=1", { method: "POST", body: formData })
      .then(res => res.json())
      .then(data => {
        if (data && data.location) {
          const fileName = data.location.split('/').pop();
          const suggestedAlt = fileName.substring(0, fileName.lastIndexOf('.')).replace(/[-_]+/g, ' ');
          if (activeTargetInput) {
            const val = activeTargetInput.value.trim();
            const isCommaSeparated = activeTargetInput.id.includes('exterior') || activeTargetInput.id.includes('interior') || activeTargetInput.id.includes('engine') || activeTargetInput.placeholder.includes('dấu phẩy') || activeTargetInput.placeholder.includes('comma');
            activeTargetInput.value = (isCommaSeparated && val) ? val + ',' + data.location : data.location;
            activeTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
            activeTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
            activeTargetInput = null;
          } else {
            insertImageIntoEditor(data.location, suggestedAlt);
          }
          closeModal();
        }
      })
      .catch(err => { alert("Lỗi tải tệp: " + err.message); resetUploadTab(); });
    }

    window.loadMediaLibraryFiles = () => {
      mediaGrid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 30px; color:var(--color-text-muted); font-size:12px;">Đang quét thư mục ảnh máy chủ...</div>';
      selectedImageUrl = null;
      btnInsert.disabled = true;
      selectedInfo.textContent = "Chưa chọn hình ảnh nào";
      const sidebarPreview = document.getElementById("wp-media-sidebar-preview");
      const sidebarInfo = document.getElementById("wp-media-sidebar-info");
      if (sidebarPreview) sidebarPreview.innerHTML = '<span style="color: var(--color-text-muted); font-size: 11px;">Chưa chọn ảnh nào</span>';
      if (sidebarInfo) sidebarInfo.innerHTML = '<span style="color: var(--color-text-muted); font-size: 11px; text-align: center; display: block; margin-top: 10px;">Chọn một hình ảnh từ lưới bên trái để xem chi tiết.</span>';
      if (altInputContainer) altInputContainer.style.display = "none";
      if (altInput) altInput.value = "";
      
      fetch("<?php echo $basePath; ?>/admin/admin.php?get_media_library_files=1")
      .then(res => res.json())
      .then(data => { 
        allLibraryFiles = data; 
        renderMediaGrid(data); 
      })
      .catch(err => {
        mediaGrid.innerHTML = '<div style="grid-column: 1/-1; text-align:center; padding: 20px; color:#e57373; font-size:12px;">Không thể tải danh sách tệp.</div>';
      });
    };

    function renderMediaGrid(files) {
      mediaGrid.innerHTML = files.length === 0 ? '<div style="grid-column: 1/-1; text-align:center; padding: 40px 20px; color:var(--color-text-muted); font-size:12px;">Thư mục assets/uploads/ đang rỗng.</div>' : "";
      files.forEach(file => {
        const item = document.createElement("div");
        item.className = "wp-media-item";
        item.setAttribute("data-url", file.url);
        item.setAttribute("data-name", file.name);
        item.innerHTML = `<img src="<?php echo $basePath; ?>/${file.url}" alt="${file.name}" style="width:100%; height:100%; object-fit: cover;">`;
        item.addEventListener("click", () => {
          modal.querySelectorAll(".wp-media-item").forEach(el => el.classList.remove("selected"));
          item.classList.add("selected");
          selectedImageUrl = file.url;
          selectedInfo.textContent = "Đã chọn: " + file.name;
          btnInsert.disabled = false;
          
          const sidebarPreview = document.getElementById("wp-media-sidebar-preview");
          const sidebarInfo = document.getElementById("wp-media-sidebar-info");
          if (sidebarPreview) sidebarPreview.innerHTML = `<img src="<?php echo $basePath; ?>/${file.url}" style="max-width:100%; max-height:100%; object-fit:contain; border-radius:4px;">`;
          if (sidebarInfo) {
            const sizeStr = file.size ? formatBytes(file.size) : 'Không rõ';
            const dateStr = file.time ? new Date(file.time * 1000).toLocaleString('vi-VN') : 'Không rõ';
            sidebarInfo.innerHTML = `
              <div style="margin-bottom:4px;"><strong>Tên tệp:</strong> <span style="color:#fff; word-break:break-all;">${file.name}</span></div>
              <div style="margin-bottom:4px;"><strong>Kích thước:</strong> <span style="color:#fff;">${sizeStr}</span></div>
              <div style="margin-bottom:4px;"><strong>Ngày tải:</strong> <span style="color:#fff;">${dateStr}</span></div>
              <div style="margin-bottom:4px;">
                <strong>Đường dẫn URL:</strong> 
                <input type="text" readonly value="${file.url}" style="font-size:10.5px; font-family:monospace; padding:6px; width:100%; background:rgba(0,0,0,0.3); border:1px solid var(--color-border); color:var(--color-primary); border-radius:4px; margin-top:3px; outline:none; box-sizing:border-box;" onclick="this.select()">
              </div>
            `;
          }
          if (altInputContainer) altInputContainer.style.display = "flex";
          if (altInput) altInput.value = file.name.substring(0, file.name.lastIndexOf('.')).replace(/[-_]+/g, ' ');
        });
        item.addEventListener("dblclick", () => {
          const val = activeTargetInput ? activeTargetInput.value.trim() : "";
          const isCommaSeparated = activeTargetInput && (activeTargetInput.id.includes('exterior') || activeTargetInput.id.includes('interior') || activeTargetInput.id.includes('engine') || activeTargetInput.placeholder.includes('dấu phẩy') || activeTargetInput.placeholder.includes('comma'));
          if (activeTargetInput) {
            activeTargetInput.value = (isCommaSeparated && val) ? val + ',' + file.url : file.url;
            activeTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
            activeTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
            activeTargetInput = null;
            closeModal();
          } else {
            insertImageIntoEditor(file.url, altInput ? altInput.value : "");
            closeModal();
          }
        });
        mediaGrid.appendChild(item);
      });
    }

    // Hook search filter input
    if (searchInput) {
      searchInput.addEventListener("input", () => {
        const query = searchInput.value.toLowerCase().trim();
        const filtered = allLibraryFiles.filter(f => f.name.toLowerCase().includes(query));
        renderMediaGrid(filtered);
      });
    }

    btnInsert.addEventListener("click", () => {
      if (selectedImageUrl) {
        if (activeTargetInput) {
          const val = activeTargetInput.value.trim();
          const isCommaSeparated = activeTargetInput.id.includes('exterior') || activeTargetInput.id.includes('interior') || activeTargetInput.id.includes('engine') || activeTargetInput.placeholder.includes('dấu phẩy') || activeTargetInput.placeholder.includes('comma');
          activeTargetInput.value = (isCommaSeparated && val) ? val + ',' + selectedImageUrl : selectedImageUrl;
          activeTargetInput.dispatchEvent(new Event('input', { bubbles: true }));
          activeTargetInput.dispatchEvent(new Event('change', { bubbles: true }));
          activeTargetInput = null;
        } else {
          insertImageIntoEditor(selectedImageUrl, altInput ? altInput.value : "");
        }
        closeModal();
      }
    });

    function insertImageIntoEditor(url, altText) {
      const cleanAlt = altText ? altText.replace(/"/g, '&quot;') : "Hình ảnh bài viết";
      if (typeof tinymce !== "undefined" && tinymce.activeEditor) {
        tinymce.activeEditor.insertContent(`<img src="${url}" alt="${cleanAlt}" style="max-width:100%; height:auto; margin:10px 0; border-radius:6px; display:block;" />`);
      } else {
        const textarea = document.activeElement && document.activeElement.tagName === "TEXTAREA" ? document.activeElement : document.getElementById("post_content");
        if (textarea) {
          const start = textarea.selectionStart;
          const end = textarea.selectionEnd;
          const text = textarea.value;
          const insert = `<img src="${url}" alt="${cleanAlt}" style="max-width:100%; height:auto; margin:10px 0; border-radius:6px; display:block;" />`;
          textarea.value = text.substring(0, start) + insert + text.substring(end);
        }
      }
      if (typeof window.updateSeoAnalysis === "function") window.updateSeoAnalysis();
    }
  };

  // Self-initializing triggers matching document loading status
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initMediaLibrary);
  } else {
    initMediaLibrary();
  }
</script>
