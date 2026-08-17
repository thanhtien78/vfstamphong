<?php
/**
 * VinFast Central pSEO PRO Administrative View
 * Organized into beautiful, highly intuitive premium tabbed sections
 * matching the precise multi-campaign workflow of SEO Địa Danh PRO.
 */
require_once 'backend/includes/class-pseo-helper.php';
$basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');

// Dedicated Campaign Editor Routing Setup
$editorAction = isset($_GET['editor']) ? trim($_GET['editor']) : '';
$editorId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editorType = isset($_GET['type']) ? trim($_GET['type']) : 'location';

$campaign = null;
$editorTitle = '';
$activeImages = [];
$actionVal = '';

if ($editorAction === 'edit' && $editorId > 0) {
    $stmtCamp = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
    $stmtCamp->execute([$editorId]);
    $campaign = $stmtCamp->fetch(PDO::FETCH_ASSOC);
    if ($campaign) {
        $editorTitle = 'Chỉnh sửa chiến dịch: ' . htmlspecialchars($campaign['keyword']);
        $actionVal = 'update_campaign';
        if (!empty($campaign['image_ids'])) {
            $activeImages = array_filter(array_map('trim', explode(',', $campaign['image_ids'])));
        }
    }
} elseif ($editorAction === 'add') {
    $campaign = [
        'id' => '',
        'keyword' => '',
        'slug' => '',
        'type' => $editorType,
        'phone_number' => '',
        'website_link' => '',
        'title_templates' => '',
        'content_template' => '',
        'image_ids' => '',
        'status' => 'published'
    ];
    if ($editorType === 'location') {
        $campaign['title_templates'] = "{KEYWORD} tại {WARD_FULL_NAME}, {PROVINCE_NAME}\n{KEYWORD} ở {WARD_FULL_NAME}, {PROVINCE_NAME}";
        $campaign['content_template'] = "{Chào mừng quý khách đến với|Khám phá ngay} dịch vụ {KEYWORD} tại khu vực {WARD_FULL_NAME}, {PROVINCE_NAME}. Mọi thông tin chi tiết vui lòng liên hệ số điện thoại {PHONE_NUMBER} hoặc truy cập website liên kết {WEBSITE_LINK} để được chuyên viên cố vấn phản hồi chu đáo nhất.";
    } elseif ($editorType === 'diadanhcu') {
        $campaign['title_templates'] = "{KEYWORD} tại {WARD_NAME}, {DISTRICT_NAME}, {PROVINCE_NAME}\n{KEYWORD} ở {WARD_NAME}, {DISTRICT_NAME}";
        $campaign['content_template'] = "{Chào mừng quý khách đến với|Khám phá ngay} dịch vụ {KEYWORD} tại {WARD_NAME}, thuộc khu vực {DISTRICT_NAME}, {PROVINCE_NAME}. Quý khách hàng vui lòng gọi ngay hotline {PHONE_NUMBER} hoặc truy cập {WEBSITE_LINK} để nhận bảng giá ưu đãi mới nhất.";
    } else {
        $campaign['title_templates'] = "{KEYWORD} gần {PROJECT_NAME}\n{KEYWORD} tại khu vực {PROJECT_NAME} | VIP Service";
        $campaign['content_template'] = "Đặc quyền VIP hỗ trợ cho cư dân đang sinh sống tại dự án chung cư cao cấp {PROJECT_NAME}, phát triển bởi chủ đầu tư {CHU_DAU_TU} tại địa chỉ {DIA_CHI}. Chương trình ưu đãi xe điện EV cực hot. Liên hệ hotline cố vấn {PHONE_NUMBER} hoặc {WEBSITE_LINK} ngay hôm nay!";
    }
    $editorTitle = 'Tạo chiến dịch pSEO mới';
    $actionVal = 'add_campaign';
}

// If POST request fails (e.g. unique constraints violation), retain form values so user doesn't lose progress!
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($campaign)) {
    $campaign['keyword'] = $_POST['keyword'] ?? $campaign['keyword'];
    $campaign['slug'] = $_POST['slug'] ?? $campaign['slug'];
    $campaign['type'] = $_POST['type'] ?? $campaign['type'];
    $campaign['phone_number'] = $_POST['phone_number'] ?? $campaign['phone_number'];
    $campaign['website_link'] = $_POST['website_link'] ?? $campaign['website_link'];
    $campaign['title_templates'] = $_POST['title_templates'] ?? $campaign['title_templates'];
    $campaign['content_template'] = $_POST['content_template'] ?? $campaign['content_template'];
    $campaign['status'] = $_POST['status'] ?? $campaign['status'];
    
    // Process image ids list
    $postedImages = $_POST['image_ids'] ?? [];
    $campaign['image_ids'] = is_array($postedImages) ? implode(',', $postedImages) : trim($postedImages);
    $activeImages = is_array($postedImages) ? $postedImages : array_filter(array_map('trim', explode(',', $postedImages)));
}

// Warm up index database
PSEO_Helper::init();

global $db;
// Query Stats for index database
$totalCount = $db->query("SELECT COUNT(*) FROM pseo_index")->fetchColumn();
$locCount = $db->query("SELECT COUNT(*) FROM pseo_index WHERE type = 'location'")->fetchColumn();
$oldLocCount = $db->query("SELECT COUNT(*) FROM pseo_index WHERE type = 'diadanhcu'")->fetchColumn();
$projCount = $db->query("SELECT COUNT(*) FROM pseo_index WHERE type = 'chungcu'")->fetchColumn();

// Query all campaigns from database
$stmtAll = $db->query("SELECT * FROM pseo_campaigns ORDER BY id ASC");
$allCampaigns = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

$campaignsNew = [];
$campaignsOld = [];
$campaignsProject = [];

foreach ($allCampaigns as $c) {
    if ($c['type'] === 'location') {
        $campaignsNew[] = $c;
    } elseif ($c['type'] === 'diadanhcu') {
        $campaignsOld[] = $c;
    } elseif ($c['type'] === 'chungcu') {
        $campaignsProject[] = $c;
    }
}

// Fetch global settings
$settingsQuery = $db->query("SELECT * FROM settings WHERE `key` LIKE 'pseo_%'");
$settings = [];
while ($row = $settingsQuery->fetch(PDO::FETCH_ASSOC)) {
    $settings[$row['key']] = $row['value'];
}

// General Base Info Settings
$pseo_phone = $settings['pseo_phone'] ?? '0975510794';
$pseo_website = $settings['pseo_website'] ?? 'https://example.com';
$pseoStatus = $settings['pseo_status'] ?? 'live';

// Scan uploaded media directory for checkboxes selection in popup modal
$uploadsDir = dirname(__DIR__, 2) . '/assets/uploads';
$allUploadedImages = [];
if (is_dir($uploadsDir)) {
    $files = glob($uploadsDir . '/*');
    if ($files) {
        foreach ($files as $file) {
            if (is_file($file)) {
                $basename = basename($file);
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $allUploadedImages[] = 'assets/uploads/' . $basename;
                }
            }
        }
    }
}

// ----------------------------------------------------
// DIRECTORY PAGINATION & FILTER LOGIC (Tab 6 Explorer)
// ----------------------------------------------------
$limit = 15;
$pageNo = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
if ($pageNo < 1) $pageNo = 1;
$offset = ($pageNo - 1) * $limit;

$filterType = isset($_GET['type_filter']) ? trim($_GET['type_filter']) : '';
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
$filterCampaign = isset($_GET['campaign_filter']) ? (int)$_GET['campaign_filter'] : 0;

$selectedCampaign = null;
if ($filterCampaign > 0) {
    $stmtC = $db->prepare("SELECT * FROM pseo_campaigns WHERE id = ?");
    $stmtC->execute([$filterCampaign]);
    $selectedCampaign = $stmtC->fetch(PDO::FETCH_ASSOC);
    if ($selectedCampaign) {
        $filterType = $selectedCampaign['type'];
    }
}

$where = [];
$params = [];
if ($filterType) {
    $where[] = "type = :type";
    $params[':type'] = $filterType;
}
if ($searchQuery) {
    $where[] = "(display_name LIKE :search OR slug LIKE :search)";
    $params[':search'] = '%' . $searchQuery . '%';
}

$whereSql = '';
if (!empty($where)) {
    $whereSql = "WHERE " . implode(" AND ", $where);
}

// Get total count for pagination
$totalRowsStmt = $db->prepare("SELECT COUNT(*) FROM pseo_index $whereSql");
$totalRowsStmt->execute($params);
$totalFilteredRows = $totalRowsStmt->fetchColumn();
$totalPages = ceil($totalFilteredRows / $limit);
if ($totalPages < 1) $totalPages = 1;
if ($pageNo > $totalPages) $pageNo = $totalPages;
$offset = ($pageNo - 1) * $limit;

// Fetch paginated rows
$stmtRows = $db->prepare("SELECT * FROM pseo_index $whereSql ORDER BY display_name ASC LIMIT :limit OFFSET :offset");
$stmtRows->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmtRows->bindValue(':offset', $offset, PDO::PARAM_INT);
foreach ($params as $k => $v) {
    $stmtRows->bindValue($k, $v);
}
$stmtRows->execute();
$rows = $stmtRows->fetchAll();

// Active type filters buttons helper
function getTypeFilterUrl($type) {
    $q = isset($_GET['q']) ? $_GET['q'] : '';
    return "admin.php?p=pseo&type_filter=" . urlencode($type) . "&q=" . urlencode($q) . "#tab-explorer";
}
?>

<style>
  /* Premium hover effects for pSEO media library picker */
  .media-picker-item {
    position: relative;
    display: block;
    width: 100%;
    height: 0;
    padding-top: 100%;
    border-radius: 6px;
    overflow: hidden;
    border: 2px solid var(--color-border) !important;
    cursor: pointer;
    background: #05070a;
    transition: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
  }
  .media-picker-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
  }
  .media-picker-item:hover {
    border-color: var(--color-primary) !important;
    box-shadow: 0 4px 15px rgba(25, 96, 215, 0.15);
  }
  .media-picker-item:hover img {
    transform: scale(1.08);
  }
  .media-picker-item::before {
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
  .media-picker-item:hover::before {
    opacity: 1;
    transform: translateY(0);
  }
  .media-picker-item.selected-active {
    border-color: var(--color-primary) !important;
    box-shadow: 0 0 10px rgba(25, 96, 215, 0.3);
  }

  /* Premium Dynamic Tab Styling */
  .pseo-tab-nav {
    display: flex;
    gap: 8px;
    margin-bottom: 25px;
    border-bottom: 1px solid var(--color-border);
    padding-bottom: 15px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  
  .pseo-tab-btn {
    background: rgba(255, 255, 255, 0.02);
    border: 1px solid var(--color-border);
    color: var(--color-text-muted);
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700 !important;
    cursor: pointer;
    transition: all 0.25s ease;
    white-space: nowrap;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  
  .pseo-tab-btn:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
    border-color: var(--color-border-active);
  }
  
  .pseo-tab-btn.active {
    background: var(--color-primary) !important;
    color: #000 !important;
    border-color: var(--color-primary) !important;
    box-shadow: 0 0 12px rgba(25, 96, 215, 0.35);
  }
  
  .pseo-tab-panel {
    display: none;
    animation: fadeInTab 0.35s ease;
  }
  
  .pseo-tab-panel.active {
    display: block;
  }
  
  @keyframes fadeInTab {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  /* Quick Insert Badge Styling */
  .badge-placeholder {
    display: inline-block;
    background: rgba(25, 96, 215,0.08);
    border: 1px solid rgba(25, 96, 215,0.2);
    color: var(--color-primary);
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-family: monospace;
    cursor: pointer;
    margin-right: 6px;
    margin-bottom: 6px;
    transition: all 0.2s;
  }
  .badge-placeholder:hover {
    background: var(--color-primary);
    color: #000;
    box-shadow: 0 0 8px rgba(25, 96, 215,0.3);
  }

  /* Luxury Modal Window Styling */
  .pseo-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10000;
    background: rgba(10, 14, 22, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    animation: fadeInModal 0.25s ease-out;
  }
  
  .pseo-modal-content {
    background: var(--color-surface-dark);
    border: 1px solid var(--color-border);
    border-top: 3px solid var(--color-primary);
    border-radius: 16px;
    width: 100%;
    max-width: 900px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 30px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    position: relative;
    animation: scaleInModal 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  }

  .pseo-modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--color-border);
    color: var(--color-text-muted);
    font-size: 18px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }
  .pseo-modal-close:hover {
    background: #ff5252;
    color: #fff;
    border-color: #ff5252;
  }

  @keyframes fadeInModal {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes scaleInModal {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }

  /* Campaign Editor Page Custom Styling */
  .pseo-editor-card {
    background: var(--color-bg-card);
    border: 1px solid var(--color-border);
    border-top: 3px solid var(--color-primary);
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
    position: relative;
    transition: transform 0.3s ease;
  }
  .pseo-editor-card:hover {
    transform: translateY(-2px);
  }
  .pseo-editor-section-title {
    color: var(--color-primary);
    font-size: 13.5px;
    font-weight: 700;
    text-transform: uppercase;
    border-left: 3px solid var(--color-primary);
    padding-left: 10px;
    margin-bottom: 20px;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .pseo-editor-grid {
    display: grid;
    grid-template-columns: 2.2fr 1fr;
    gap: 25px;
    margin-top: 20px;
  }
  @media (max-width: 1024px) {
    .pseo-editor-grid {
      grid-template-columns: 1fr;
    }
  }
  .editor-form-group {
    margin-bottom: 20px;
  }
  .editor-form-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .editor-form-control {
    width: 100%;
    background: rgba(0, 0, 0, 0.4) !important;
    border: 1px solid var(--color-border);
    border-radius: 6px;
    padding: 10px 14px;
    color: #fff;
    font-size: 13px;
    outline: none;
    transition: all 0.25s ease;
  }
  .editor-form-control:focus {
    border-color: var(--color-primary);
    box-shadow: 0 0 8px rgba(25, 96, 215, 0.2);
  }
  .editor-form-control[readonly] {
    opacity: 0.6;
    background: rgba(0, 0, 0, 0.6) !important;
    cursor: not-allowed;
  }
  .editor-hint {
    font-size: 11px;
    color: var(--color-text-muted);
    margin-top: 5px;
    display: block;
  }
  /* SEO Assistant List styling */
  .seo-assistant-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .seo-assistant-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 12.5px;
    line-height: 1.5;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    color: var(--color-text-muted);
    transition: all 0.2s;
  }
  .seo-assistant-item.passed {
    color: #fff;
  }
  .seo-assistant-item .seo-icon {
    font-size: 14px;
    line-height: 1;
    margin-top: 2px;
  }
  .seo-assistant-item.passed .seo-icon {
    color: #4caf50;
  }
  /* Checked image list styling */
  .campaign-image-item {
    position: relative;
    display: block;
    width: 100%;
    aspect-ratio: 1;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid var(--color-border);
    cursor: pointer;
    transition: all 0.2s;
  }
  .campaign-image-item:hover {
    border-color: #ef5350 !important;
  }
  .campaign-image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .remove-image-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(239, 83, 80, 0.95);
    color: #fff;
    font-size: 10px;
    text-align: center;
    padding: 4px 0;
    opacity: 0;
    transition: opacity 0.2s;
    font-weight: 700;
  }
  .campaign-image-item:hover .remove-image-overlay {
    opacity: 1;
  }
</style>

<?php if (isset($_GET['editor'])): ?>
  <!-- DEDICATED FULL-PAGE LUXURY CAMPAIGN EDITOR -->
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; border-bottom:1px solid var(--color-border); padding-bottom:15px; flex-wrap:wrap; gap:15px;">
    <div>
      <a href="admin.php?p=pseo" class="btn-gold" style="padding:8px 16px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; background:#222; border-color:#444; color:#fff;">
        <i class="fas fa-arrow-left"></i> Quay lại danh sách
      </a>
    </div>
    <h2 style="margin:0; font-size:16px; text-transform:uppercase; color:var(--color-primary); font-weight:700;"><?php echo $editorTitle; ?></h2>
    <div>
      <a href="admin.php?p=pseo#tab-rebuilder" class="btn-gold" style="padding:8px 16px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
        <i class="fas fa-sync"></i> Quản lý Import CSDL
      </a>
    </div>
  </div>

  <?php if ($successMessage): ?>
    <div style="background: rgba(76, 175, 80, 0.1); border: 1px solid rgba(76, 175, 80, 0.3); border-radius: 12px; padding: 20px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; animation: fadeInTab 0.35s ease;">
      <div>
        <h4 style="margin: 0; color: #4caf50; font-size: 14px; text-transform: uppercase; font-weight: 700; display: flex; align-items: center; gap: 8px;">
          <i class="fas fa-check-circle"></i> Cập nhật cấu hình thành công!
        </h4>
        <p style="margin: 5px 0 0 0; font-size: 12.5px; color: var(--color-text-muted);">
          Chiến dịch <strong><?php echo htmlspecialchars($campaign['keyword']); ?></strong> đã được lưu trữ an toàn trong CSDL.
        </p>
      </div>
      <div style="display: flex; gap: 10px;">
        <a href="admin.php?p=pseo" class="btn-gold" style="padding: 8px 16px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; background: #222; border-color: #444; color: #fff;">
          <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
        <a href="admin.php?p=pseo#tab-rebuilder" class="btn-gold" style="padding: 8px 16px; font-size: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
          <i class="fas fa-sync"></i> Chạy Import CSDL ngay
        </a>
      </div>
    </div>
  <?php endif; ?>

  <form method="POST" id="pseo-campaign-form">
    <div class="pseo-editor-grid" style="animation: fadeInTab 0.35s ease;">
      <!-- LEFT COLUMN: SETTINGS FORM -->
      <div class="pseo-editor-left">
        <input type="hidden" name="action" id="modal-action" value="<?php echo $actionVal; ?>">
        <input type="hidden" name="id" id="modal-id" value="<?php echo htmlspecialchars($campaign['id']); ?>">
        
        <!-- BƯỚC 1: THÔNG TIN LIÊN HỆ -->
        <div class="pseo-editor-card">
          <h3 class="pseo-editor-section-title">
            <i class="fas fa-info-circle"></i> Bước 1: Cài đặt thông tin chiến dịch
          </h3>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <div class="editor-form-group">
              <label>Từ khóa chính <span style="color:var(--color-primary);">*</span></label>
              <input type="text" name="keyword" id="modal-keyword" required value="<?php echo htmlspecialchars($campaign['keyword']); ?>" class="editor-form-control" placeholder="Ví dụ: Thiết kế website" oninput="autoGenerateSlug(this.value); updateSeoChecks();">
              <span class="editor-hint">Từ khóa hiển thị chính trong bài viết (vd: Mua xe VinFast EV).</span>
            </div>
            
            <div class="editor-form-group">
              <label>Đường dẫn tĩnh Slug <span style="color:var(--color-primary);">*</span></label>
              <input type="text" name="slug" id="modal-slug" required value="<?php echo htmlspecialchars($campaign['slug']); ?>" <?php echo in_array($campaign['slug'], ['gia-xe-VinFast', 'dai-ly-VinFast']) ? 'readonly' : ''; ?> class="editor-form-control" placeholder="Ví dụ: thiet-ke-website" oninput="checkSlugUniqueness(); updateSeoChecks();">
              <div id="slug-validation-msg" style="color: #ff5252; font-size: 11px; margin-top: 5px; font-weight: 600; display: none;"></div>
              <span class="editor-hint" id="slug-editor-hint">Đường dẫn không dấu phân biệt chiến dịch. Không đổi nếu là mặc định hệ thống.</span>
            </div>

            <div class="editor-form-group">
              <label>Phân loại địa bàn mục tiêu <span style="color:var(--color-primary);">*</span></label>
              <select name="type" id="modal-type" class="editor-form-control" onchange="updateModalPlaceholders(this.value); updateSeoChecks();">
                <option value="location" <?php echo $campaign['type'] === 'location' ? 'selected' : ''; ?>>🗺️ Địa danh mới (14,000+ Phường Xã)</option>
                <option value="diadanhcu" <?php echo $campaign['type'] === 'diadanhcu' ? 'selected' : ''; ?>>🏛️ Địa danh cũ trước 2025</option>
                <option value="chungcu" <?php echo $campaign['type'] === 'chungcu' ? 'selected' : ''; ?>>🏢 Cư dân & Dự án Chung cư VIP</option>
              </select>
              <span class="editor-hint">Phạm vi cào của chiến dịch địa phương.</span>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-top: 10px;">
            <div class="editor-form-group">
              <label>Số điện thoại riêng biệt (Không bắt buộc)</label>
              <input type="text" name="phone_number" id="modal-phone" value="<?php echo htmlspecialchars($campaign['phone_number']); ?>" class="editor-form-control" placeholder="Mặc định: <?php echo htmlspecialchars($pseo_phone); ?> (Để trống sẽ tự dùng số này)" oninput="updateSeoChecks();">
              <span class="editor-hint">Nếu anh muốn dùng SĐT khác cho riêng chiến dịch này thì nhập vào. Nếu không, hãy **để trống** để dùng cấu hình chung.</span>
            </div>

            <div class="editor-form-group">
              <label>Website liên kết riêng biệt (Không bắt buộc)</label>
              <input type="url" name="website_link" id="modal-website" value="<?php echo htmlspecialchars($campaign['website_link']); ?>" class="editor-form-control" placeholder="Mặc định: <?php echo htmlspecialchars($pseo_website); ?> (Để trống sẽ tự dùng link này)" oninput="updateSeoChecks();">
              <span class="editor-hint">Nếu anh muốn dùng link khác cho riêng chiến dịch này thì nhập vào. Nếu không, hãy **để trống** để dùng cấu hình chung.</span>
            </div>

            <div class="editor-form-group">
              <label>Trạng thái hoạt động</label>
              <select name="status" class="editor-form-control">
                <option value="published" <?php echo $campaign['status'] === 'published' ? 'selected' : ''; ?>>🟢 Hoạt động (Xuất bản)</option>
                <option value="draft" <?php echo $campaign['status'] === 'draft' ? 'selected' : ''; ?>>🟡 Nháp / Tạm ngưng hoạt động</option>
              </select>
              <span class="editor-hint">Trạng thái cho phép Bot hoặc khách hàng thu nạp.</span>
            </div>
          </div>
        </div>

        <!-- BƯỚC 2: CẤU HÌNH TIÊU ĐỀ & NỘI DUNG -->
        <div class="pseo-editor-card">
          <h3 class="pseo-editor-section-title">
            <i class="fas fa-edit"></i> Bước 2: Cấu hình mẫu tiêu đề & nội dung Spintax bài viết
          </h3>

          <div class="editor-form-group">
            <label>Danh sách mẫu tiêu đề bài viết (Mỗi dòng là một tiêu đề ngẫu nhiên) <span style="color:var(--color-primary);">*</span></label>
            
            <!-- Dynamic insert toolbar for title templates -->
            <div style="background: rgba(0, 0, 0, 0.3); border: 1px solid var(--color-border); padding: 10px 15px; border-radius: 8px 8px 0 0; border-bottom: none; display: flex; flex-direction: column; gap: 6px;">
              <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--color-primary); letter-spacing: 0.5px;">
                📋 Click để chèn nhanh tag vào Tiêu đề:
              </span>
              <div id="modal-title-placeholders-list" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px;">
                <!-- Dynamically populated via JS -->
              </div>
            </div>

            <textarea name="title_templates" id="modal-title-templates" rows="4" required class="editor-form-control" style="font-family: monospace; line-height: 1.6; border-radius: 0 0 8px 8px; font-size: 13px;" placeholder="Ví dụ:&#10;{KEYWORD} tại {WARD_FULL_NAME}, {PROVINCE_NAME}&#10;{KEYWORD} giá tốt ở {WARD_FULL_NAME}" oninput="updateSeoChecks();"><?php echo htmlspecialchars($campaign['title_templates']); ?></textarea>
            <span class="editor-hint">Mỗi địa danh cụ thể khi biên dịch bài viết sẽ tự động lấy ngẫu nhiên 1 trong các mẫu tiêu đề này để đảm bảo tính độc nhất.</span>
          </div>

          <div class="editor-form-group" style="margin-top: 25px;">
            <label>Nội dung bài viết mẫu (Hỗ trợ cấu trúc Spintax xáo trộn <code>{A|B|C}</code>)</label>
            
            <!-- Dynamic insert toolbar -->
            <div style="background: rgba(0, 0, 0, 0.3); border: 1px solid var(--color-border); padding: 12px 15px; border-radius: 8px 8px 0 0; border-bottom: none; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
              <div style="display: flex; flex-direction: column; gap: 6px;">
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--color-primary); letter-spacing: 0.5px;">
                  📋 Click để chèn nhanh tag Placeholder:
                </span>
              </div>
              <button type="button" class="btn-gold" style="padding: 5px 12px; font-size: 10.5px; min-height: auto; font-weight: 700; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px; background: var(--color-primary); color: #000; border-color: var(--color-primary);" onclick="openSpintaxHelperModal()">
                <i class="fas fa-magic" style="font-size: 10px;"></i> Trình tạo Spintax nhanh
              </button>
              <div id="modal-placeholders-list" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 4px;">
                <!-- Dynamically populated via JS -->
              </div>
            </div>

            <textarea name="content_template" id="modal-content-template" rows="12" class="editor-form-control" style="font-family: monospace; line-height: 1.7; border-radius: 0 0 8px 8px; font-size: 13px;" placeholder="Ví dụ:&#10;{Chào mừng quý khách đến với|Khám phá ngay} dịch vụ {KEYWORD} tại {WARD_FULL_NAME}. Liên hệ ngay {PHONE_NUMBER} để được ưu đãi tốt nhất..." oninput="updateSeoChecks();"><?php echo htmlspecialchars($campaign['content_template']); ?></textarea>
            <span class="editor-hint">Mẹo: Cấu trúc Spintax <code>{từ đồng nghĩa 1|từ đồng nghĩa 2}</code> giúp bài viết xáo trộn ngẫu nhiên không trùng lặp, tối ưu hóa điểm chất lượng SEO tốt nhất!</span>
        </div>
      </div>
    </div>

    <!-- RIGHT COLUMN: MEDIA POOL & SEO ASSISTANT -->
    <div class="pseo-editor-right">
      
      <!-- SEO ASSISTANT CHAT -->
      <div class="pseo-editor-card">
        <h3 class="pseo-editor-section-title" style="border-left-color: #4caf50; color: #4caf50;">
          <i class="fas fa-robot"></i> Trợ lý tối ưu SEO Live
        </h3>
        
        <!-- SVG SEO Score Circle -->
        <div style="display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.02); border: 1px solid var(--color-border); padding: 15px; border-radius: 10px; margin-bottom: 20px;">
          <div style="position: relative; width: 60px; height: 60px; flex-shrink: 0;">
            <svg width="60" height="60" viewBox="0 0 36 36" style="transform: rotate(-90deg); width: 100%; height: 100%;">
              <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="3.5" />
              <path id="seo-score-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#ef5350" stroke-width="3.5" stroke-dasharray="0, 100" stroke-linecap="round" style="transition: stroke-dasharray 0.35s ease, stroke 0.35s ease;" />
            </svg>
            <div id="seo-score-number" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; font-size: 13.5px; font-weight: 800; color: #ef5350;">0%</div>
          </div>
          <div>
            <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: #fff;" id="seo-score-label">Tối ưu SEO: Yếu</h4>
            <p style="margin: 3px 0 0 0; font-size: 11px; color: var(--color-text-muted);" id="seo-score-desc">Anh hãy hoàn thiện các chỉ số bên dưới nhé.</p>
          </div>
        </div>

        <p style="font-size: 12px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px; margin-top:0;">
          Hệ thống tự động phân tích và khuyến nghị tối ưu chiến dịch bài viết của anh trong thời gian thực:
        </p>

        <ul class="seo-assistant-list">
          <li class="seo-assistant-item" id="check-keyword">
            <span class="seo-icon">❌</span>
            <span>Đã nhập Từ khóa chính chiến dịch</span>
          </li>
          <li class="seo-assistant-item" id="check-keyword-title">
            <span class="seo-icon">❌</span>
            <span>Mẫu tiêu đề phải chứa tag <code>{KEYWORD}</code></span>
          </li>
          <li class="seo-assistant-item" id="check-placeholders-title">
            <span class="seo-icon">❌</span>
            <span>Mẫu tiêu đề chứa Địa danh đích <code>{WARD_FULL_NAME}</code> / <code>{PROJECT_NAME}</code></span>
          </li>
          <li class="seo-assistant-item" id="check-contact-content">
            <span class="seo-icon">❌</span>
            <span>Nội dung chứa tag Liên hệ <code>{PHONE_NUMBER}</code> và <code>{WEBSITE_LINK}</code></span>
          </li>
          <li class="seo-assistant-item" id="check-spintax-complexity">
            <span class="seo-icon">❌</span>
            <span>Sử dụng ít nhất 2 nhóm Spintax xáo trộn <code>{A|B}</code> để chống trùng lặp</span>
          </li>
          <li class="seo-assistant-item" id="check-images-count">
            <span class="seo-icon">❌</span>
            <span>Đã chọn ít nhất 1 hình ảnh đại diện chiến dịch</span>
          </li>
        </ul>
      </div>

      <!-- VISUAL IMAGE GALLERY CARD -->
      <div class="pseo-editor-card">
        <h3 class="pseo-editor-section-title">
          <i class="fas fa-images"></i> Ảnh đại diện bài viết
        </h3>
        <p style="font-size: 12px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px; margin-top:0;">
          Chưa chọn ảnh nào có nghĩa là bài viết sẽ không có ảnh đại diện. Hệ thống sẽ bốc ngẫu nhiên 1 ảnh trong bể ảnh được tích chọn bên dưới để đặt làm ảnh đại diện thực tế.
        </p>

        <div style="display: flex; gap: 8px; margin-bottom: 15px;">
          <input type="file" id="modal-upload-images" multiple accept="image/*" style="display: none;" onchange="handleModalImageUpload(this.files); updateSeoChecks();">
          <button type="button" class="btn-gold" style="flex: 1; padding: 10px; font-size: 12px; min-height: auto; display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #222; border-color: #444;" onclick="document.getElementById('modal-upload-images').click()">
            <i class="fas fa-upload"></i> Tải ảnh từ máy
          </button>
          <button type="button" class="btn-gold" style="flex: 1; padding: 10px; font-size: 12px; min-height: auto; display: inline-flex; align-items: center; justify-content: center; gap: 6px; background: #222; border-color: #444;" onclick="openMediaPickerModal()">
            <i class="fas fa-images"></i> Từ thư viện
          </button>
        </div>

        <div id="modal-upload-status" style="display:none; margin-bottom:12px; font-size:11.5px; color:var(--color-primary); align-items:center; gap:6px;">
          <i class="fas fa-spinner fa-spin"></i> Đang tải lên máy chủ...
        </div>

        <div id="modal-image-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 10px; max-height: 250px; overflow-y: auto; border: 1px solid var(--color-border); padding: 12px; border-radius: 8px; background: rgba(0,0,0,0.3);">
          <?php if (!empty($activeImages)): ?>
            <?php foreach ($activeImages as $imgPath): ?>
              <label class="campaign-image-item">
                <input type="checkbox" name="image_ids[]" value="<?php echo htmlspecialchars($imgPath); ?>" class="modal-image-checkbox" checked style="position: absolute; top: 4px; right: 4px; z-index: 10; accent-color: var(--color-primary); width:14px; height:14px;" onchange="updateSeoChecks();">
                <img src="<?php echo $basePath; ?>/<?php echo htmlspecialchars($imgPath); ?>" style="width:100%; height:100%; object-fit: cover;">
                <span class="remove-image-overlay" onclick="event.preventDefault(); this.closest('label').remove(); updateSeoChecks();">Gỡ bỏ</span>
              </label>
            <?php endforeach; ?>
          <?php else: ?>
            <p id="modal-image-grid-placeholder" style="grid-column: 1/-1; color: var(--color-text-muted); font-size:11.5px; text-align:center; margin:15px 0; line-height:1.5;">
              Chưa có ảnh đại diện nào được chọn cho chiến dịch này.<br>Anh hãy click nút <strong>"Tải ảnh từ máy"</strong> hoặc <strong>"Từ thư viện"</strong> để thêm ảnh nhé!
            </p>
          <?php endif; ?>
        </div>
      </div>

      <!-- VISUAL LIVE PREVIEW CARD -->
      <div class="pseo-editor-card" style="border-top-color: var(--color-primary);">
        <h3 class="pseo-editor-section-title">
          <i class="fas fa-eye"></i> Bản xem trước bài viết Live
        </h3>
        <p style="font-size: 12px; color: var(--color-text-muted); line-height: 1.5; margin-bottom: 15px; margin-top:0;">
          Giả lập hiển thị bài viết thực tế tại một địa bàn ngẫu nhiên khi người dùng truy cập.
        </p>

        <!-- Google Snippet Simulation -->
        <div style="background: #1e1e1e; border: 1px solid #333; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
          <span style="font-size: 10px; color: #888; display: block; margin-bottom: 4px;">Xem trước kết quả tìm kiếm Google:</span>
          <div id="preview-google-url" style="font-size: 11px; color: #8ab4f8; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;">https://VinFast-vietnam.vn/gia-xe-VinFast...</div>
          <div id="preview-google-title" style="font-size: 14px; color: #1960d7; font-weight: 500; margin-bottom: 4px; line-height: 1.3; cursor: pointer; text-decoration: underline;">Tiêu đề bài viết...</div>
          <div id="preview-google-desc" style="font-size: 11.5px; color: #aaa; line-height: 1.4;">Đoạn văn ngắn tóm tắt bài viết hiển thị trên Google...</div>
        </div>

        <!-- Mobile Article simulation -->
        <div style="background: rgba(0,0,0,0.5); border: 1px solid var(--color-border); border-radius: 8px; padding: 15px; max-height: 300px; overflow-y: auto;">
          <div id="preview-article-image-container" style="width: 100%; aspect-ratio: 1.8; border-radius: 6px; overflow: hidden; margin-bottom: 12px; display: none; background: #000;">
            <img id="preview-article-image" src="" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
          <h4 id="preview-article-title" style="font-size: 14px; color: #fff; margin: 0 0 10px 0; font-weight: 700; line-height: 1.4;">Tiêu đề...</h4>
          <div id="preview-article-content" style="font-size: 12px; color: #ccc; line-height: 1.6; word-break: break-word;">Nội dung bài viết...</div>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 15px;">
          <button type="button" class="btn-gold" style="flex: 1; padding: 10px; font-size: 11px; background: #222; border-color: #444; color: #fff; min-height: auto; display: flex; align-items: center; justify-content: center; gap: 6px;" onclick="refreshLivePreview()">
            <i class="fas fa-redo"></i> Đổi địa bàn ngẫu nhiên
          </button>
          
          <button type="button" id="btn-live-sandbox-preview" class="btn-gold" style="flex: 1; padding: 10px; font-size: 11px; min-height: auto; display: flex; align-items: center; justify-content: center; gap: 6px; font-weight: 700; background: rgba(76, 175, 80, 0.15); border-color: #4caf50; color: #4caf50;" onclick="openLiveSandboxPreview()">
            <i class="fas fa-external-link-alt"></i> Xem thử Trang thực tế 🌐
          </button>
        </div>
      </div>

      <!-- MASTER SAVE ACTION BUTTONS -->
      <div style="position: sticky; bottom: 20px; z-index: 50; display: flex; flex-direction: column; gap: 10px;">
        <button type="button" class="btn-gold" style="width: 100%; padding: 14px; font-size: 13.5px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 10px 20px rgba(0,0,0,0.4);" onclick="submitCampaignForm()">
          <i class="fas fa-save" style="font-size: 14px;"></i> LƯU THAY ĐỔI CẤU HÌNH
        </button>
        
        <a href="admin.php?p=pseo" class="btn-gold" style="width: 100%; padding: 12px; font-size: 12.5px; text-decoration: none; text-align: center; background: #1a1e26; border-color: #333; color: #aaa; display: flex; align-items: center; justify-content: center; gap: 6px;">
          Hủy bỏ & Quay lại
        </a>
      </div>

    </div>
  </div>
</form>

  <!-- POPUP MEDIA PICKER MODAL (Thư viện ảnh có sẵn) -->
  <div class="pseo-modal" id="media-picker-modal" style="z-index: 25000;">
    <div class="pseo-modal-content" style="max-width: 1600px; width: 97vw; max-height: 95vh; height: 95vh; display: flex; flex-direction: column; overflow: hidden; padding: 25px;">
      <button type="button" class="pseo-modal-close" onclick="closeMediaPickerModal()">×</button>
      <h3 style="margin-top: 0; font-size: 15px; text-transform: uppercase; color:#fff; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px;">📂 Chọn ảnh từ Thư viện có sẵn</h3>
      
      <div style="display: flex; flex-direction: row; gap: 20px; flex-grow: 1; min-height: 0; width: 100%; margin-bottom: 20px;">
        <!-- Left Grid Area -->
        <div style="flex: 1; display: flex; flex-direction: column; min-width: 0; height: 100%;">
          <input type="text" id="media-picker-search" placeholder="🔍 Nhập tên tệp ảnh để tìm kiếm nhanh..." class="form-input" style="width:100%; margin-bottom:15px; background:rgba(0,0,0,0.4);" oninput="filterMediaPicker(this.value)">
          
          <div id="media-picker-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; flex-grow: 1; overflow-y: auto; border: 1px solid var(--color-border); padding: 15px; border-radius: 8px; background: rgba(0,0,0,0.3); min-height: 350px;">
            <!-- Dynamic populated images -->
            <p style="grid-column: 1/-1; color: var(--color-text-muted); font-size:12px; text-align:center; margin:15px 0;">Đang nạp thư viện hình ảnh...</p>
          </div>
        </div>
        
        <!-- Right Sidebar Area -->
        <div id="media-picker-sidebar" style="width: 320px; display: flex; flex-direction: column; gap: 15px; border-left: 1px solid var(--color-border); padding-left: 20px; background: rgba(10,14,22,0.15); padding: 15px; border-radius: 8px; overflow-y: auto; box-sizing: border-box;">
          <div style="font-size: 11px; font-weight: bold; color: var(--color-primary); text-transform: uppercase; border-bottom: 1px solid var(--color-border); padding-bottom: 6px; letter-spacing: 0.5px;">Chi tiết hình ảnh</div>
          
          <div id="media-picker-sidebar-preview" style="width: 100%; height: 160px; border-radius: 6px; overflow: hidden; border: 1px solid var(--color-border); background: #000; display: flex; align-items: center; justify-content: center;">
            <span style="color: var(--color-text-muted); font-size: 11px;">Chưa chọn ảnh nào</span>
          </div>
          
          <div id="media-picker-sidebar-info" style="font-size: 11.5px; display: flex; flex-direction: column; gap: 8px; color: var(--color-text-muted); line-height: 1.4;">
            <span style="color: var(--color-text-muted); font-size: 11px; text-align: center; display: block; margin-top: 10px;">Chọn một hình ảnh bên trái để xem chi tiết.</span>
          </div>
        </div>
      </div>
      
      <div style="border-top:1px solid var(--color-border); padding-top:20px; display:flex; justify-content:flex-end; gap:10px;">
        <button type="button" class="btn-gold" style="background:#222; border-color:#444; color:#fff; padding:10px 20px; font-size:12px;" onclick="closeMediaPickerModal()">Hủy bỏ</button>
        <button type="button" class="btn-gold" style="padding:10px 24px; font-size:12px; font-weight:700;" onclick="confirmMediaPickerSelection()">
          <i class="fas fa-check" style="margin-right:6px;"></i> Xác nhận chọn ảnh (<span id="media-picker-selected-count">0</span>)
        </button>
      </div>
    </div>
  </div>

  <!-- POPUP SPINTAX HELPER MODAL -->
  <div class="pseo-modal" id="spintax-helper-modal" style="z-index: 26000;">
    <div class="pseo-modal-content" style="max-width: 500px;">
      <button type="button" class="pseo-modal-close" onclick="closeSpintaxHelperModal()">×</button>
      <h3 style="margin-top: 0; font-size: 15px; text-transform: uppercase; color:#fff; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px;">🪄 Trình tạo Spintax nhanh</h3>
      
      <p style="font-size:12px; color:var(--color-text-muted); line-height:1.5; margin-bottom:15px;">
        Nhập các từ hoặc cụm từ đồng nghĩa ngăn cách bởi dấu phẩy. Hệ thống sẽ tự động ghép thành mẫu Spintax chuẩn và chèn vào văn bản của anh.
      </p>

      <div class="form-group" style="margin-bottom:15px;">
        <label class="form-label" style="font-weight:600; font-size:12.5px; color:var(--color-primary);">Các cụm từ đồng nghĩa:</label>
        <textarea id="spintax-synonyms" rows="3" class="form-control" style="width:100%; font-size:12.5px; background:rgba(0,0,0,0.4); border-color:var(--color-border);" placeholder="Ví dụ: giá xe tốt nhất, bảng giá mới nhất, báo giá ưu đãi cực hot"></textarea>
      </div>

      <div style="background: rgba(25, 96, 215, 0.05); border: 1px dashed var(--color-primary); padding: 12px; border-radius: 6px; margin-bottom:20px; font-size:12px; line-height:1.5;">
        <strong style="color:#fff;">Kết quả mẫu Spintax sinh ra:</strong>
        <code id="spintax-result-preview" style="display:block; margin-top:5px; word-break:break-all; color:var(--color-primary); font-family:monospace; font-size:12px;">{...}</code>
      </div>
      
      <div style="border-top:1px solid var(--color-border); padding-top:20px; display:flex; justify-content:flex-end; gap:10px;">
        <button type="button" class="btn-gold" style="background:#222; border-color:#444; color:#fff; padding:8px 16px; font-size:12px;" onclick="closeSpintaxHelperModal()">Đóng</button>
        <button type="button" class="btn-gold" style="padding:8px 20px; font-size:12px; font-weight:700;" onclick="insertSpintaxResult()">
          <i class="fas fa-check" style="margin-right:6px;"></i> Chèn Spintax
        </button>
      </div>
    </div>
  </div>

<?php else: ?>
<!-- STATUS OPERATIONAL BLOCK -->
<div class="card" style="border-radius:12px; padding:20px; margin-bottom:25px; border-color: <?php echo $pseoStatus === 'live' ? 'rgba(76, 175, 80, 0.25)' : 'rgba(255, 193, 7, 0.25)'; ?>; background: <?php echo $pseoStatus === 'live' ? 'rgba(76, 175, 80, 0.015)' : 'rgba(255, 193, 7, 0.015)'; ?>;">
  <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
    <div>
      <h3 style="margin:0; font-size:14px; text-transform:uppercase; display:flex; align-items:center; gap:8px; color: <?php echo $pseoStatus === 'live' ? '#4caf50' : '#ffc107'; ?>;">
        <span class="pulse-dot" style="background-color: <?php echo $pseoStatus === 'live' ? '#4caf50' : '#ffc107'; ?>;"></span>
        <?php echo $pseoStatus === 'live' ? 'Hệ thống pSEO PRO đang LIVE (Công khai)' : 'Hệ thống pSEO PRO đang BẢO TRÌ TẠM ẨN (DRAFT)'; ?>
      </h3>
      <p style="font-size:12px; color:var(--color-text-muted); margin-top:4px;">
        <?php echo $pseoStatus === 'live' 
          ? 'Cho phép khách hàng và Google Bot truy cập 20,000+ trang đích địa phương.' 
          : 'Tự động khóa toàn bộ các trang đích vệ tinh để sửa chữa, tránh tối đa lập chỉ mục nội dung hỏng.'; ?>
      </p>
    </div>
    
    <form method="POST" style="margin:0; display:flex; align-items:center; gap:8px;">
      <input type="hidden" name="action" value="save_global_status">
      <label class="form-label" style="margin:0; font-size:10px; font-weight:700;">CHẾ ĐỘ VẬN HÀNH:</label>
      <select name="pseo_status" class="form-control" style="padding:6px 12px; font-size:11.5px; font-weight:700; width:170px; background:rgba(0,0,0,0.4); border-color:var(--color-border);" onchange="this.form.submit()">
        <option value="live" <?php echo $pseoStatus === 'live' ? 'selected' : ''; ?>>🟢 LIVE (Công khai)</option>
        <option value="draft" <?php echo $pseoStatus === 'draft' ? 'selected' : ''; ?>>🟡 DRAFT (Bảo trì/Tạm ẩn)</option>
      </select>
    </form>
  </div>
</div>

<!-- PREMIUM TAB NAVIGATION HEADER -->
<div class="pseo-tab-nav">
  <button type="button" class="pseo-tab-btn active" data-target="tab-general">
    <i class="fas fa-sliders-h"></i> ⚙️ Cài đặt chung
  </button>
  <button type="button" class="pseo-tab-btn" data-target="tab-new-location">
    <i class="fas fa-map-marker-alt"></i> 🗺️ SEO Địa Danh (Mới)
  </button>
  <button type="button" class="pseo-tab-btn" data-target="tab-old-location">
    <i class="fas fa-history"></i> 🏛️ SEO Địa Danh Cũ
  </button>
  <button type="button" class="pseo-tab-btn" data-target="tab-apartments">
    <i class="fas fa-building"></i> 🏢 SEO Chung Cư
  </button>
  <button type="button" class="pseo-tab-btn" data-target="tab-import-mgr">
    <i class="fas fa-tasks"></i> 📋 Quản lý Import
  </button>
  <button type="button" class="pseo-tab-btn" data-target="tab-rebuilder">
    <i class="fas fa-sync"></i> 🔄 Quản lý Import CSDL
  </button>
  <button type="button" class="pseo-tab-btn" id="btn-tab-explorer" data-target="tab-explorer">
    <i class="fas fa-search-location"></i> 📂 Trình duyệt Bài viết
  </button>
</div>

<!-- ==========================================
     TAB 1: GENERAL SETTINGS (⚙️ Cài đặt chung)
     ========================================== -->
<div class="pseo-tab-panel active" id="tab-general">
  <div class="card" style="border-radius:12px; padding:25px;">
    <h3 class="card__title" style="margin-top:0; border-bottom:1px solid var(--color-border); padding-bottom:15px; font-size:15px; text-transform:uppercase; margin-bottom:20px;">
      ⚙️ Cài đặt chung & Thông tin liên hệ mặc định
    </h3>
    
    <p style="font-size:13px; color:var(--color-text-muted); line-height:1.6; margin-bottom:25px;">
      Cấu hình các thông tin cơ bản mặc định để chèn tự động vào bài viết vệ tinh. Sử dụng placeholder <code>{PHONE_NUMBER}</code> và <code>{WEBSITE_LINK}</code> để hệ thống tự thay thế. Bạn có thể ghi đè riêng các giá trị này bên trong từng chiến dịch cụ thể.
    </p>

    <form method="POST">
      <input type="hidden" name="action" value="save_general_settings">
      
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:25px; margin-bottom:25px;">
        <div class="form-group">
          <label class="form-label" style="font-weight:600;">Số điện thoại liên hệ mặc định (Phone) *</label>
          <input type="text" name="pseo_phone" required value="<?php echo htmlspecialchars($pseo_phone); ?>" class="form-control" style="width:100%;" placeholder="Ví dụ: 0975510794">
          <span style="font-size:11px; color:var(--color-text-muted);">Thay thế cho tag <code>{PHONE_NUMBER}</code>.</span>
        </div>
        
        <div class="form-group">
          <label class="form-label" style="font-weight:600;">Đường dẫn Website liên kết mặc định *</label>
          <input type="url" name="pseo_website" required value="<?php echo htmlspecialchars($pseo_website); ?>" class="form-control" style="width:100%;" placeholder="Ví dụ: https://VinFast-vietnam.vn">
          <span style="font-size:11px; color:var(--color-text-muted);">Thay thế cho tag <code>{WEBSITE_LINK}</code>.</span>
        </div>
      </div>
      
      <div style="display:flex; justify-content:flex-end;">
        <button type="submit" class="btn-gold" style="padding:12px 25px; font-weight:700;">
          <i class="fas fa-save" style="margin-right:6px;"></i> LƯU CẤU HÌNH LIÊN HỆ
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ==========================================
     TAB 2: NEW LOCATIONS (🗺️ SEO Địa Danh Mới)
     ========================================== -->
<div class="pseo-tab-panel" id="tab-new-location">
  <div class="card" style="border-radius:12px; padding:25px;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
      <div>
        <h3 class="card__title" style="margin:0; font-size:15px; text-transform:uppercase;">🗺️ Quản lý Chiến dịch SEO Địa Danh (Mới)</h3>
        <p style="font-size:12px; color:var(--color-text-muted); margin-top:4px;">Tự động tạo các bài viết vệ tinh theo tên đầy đủ của 14,000+ Phường/Xã/Tỉnh thành cấu trúc mới.</p>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="button" onclick="openBulkImportModal()" class="btn-gold" style="padding:8px 16px; font-size:12px; display:inline-flex; align-items:center; gap:6px; cursor:pointer; background:#10b981; border-color:#10b981; color:#fff;">
          <i class="fas fa-file-import"></i> Nhập hàng loạt từ khóa
        </button>
        <a href="admin.php?p=pseo&editor=add&type=location" class="btn-gold" style="padding:8px 16px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
          <i class="fas fa-plus"></i> Tạo chiến dịch Địa Danh Mới
        </a>
      </div>
    </div>

    <!-- Campaigns list table -->
    <?php renderCampaignsTable($campaignsNew); ?>
  </div>
</div>

<!-- ==========================================
     TAB 3: OLD LOCATIONS (🏛️ SEO Địa Danh Cũ)
     ========================================== -->
<div class="pseo-tab-panel" id="tab-old-location">
  <div class="card" style="border-radius:12px; padding:25px;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
      <div>
        <h3 class="card__title" style="margin:0; font-size:15px; text-transform:uppercase;">🏛️ Quản lý Chiến dịch SEO Địa Danh Cũ</h3>
        <p style="font-size:12px; color:var(--color-text-muted); margin-top:4px;">SEO đón đầu nhóm khách hàng vẫn có thói quen tìm kiếm theo cấu trúc hành chính cũ trước năm 2025.</p>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="button" onclick="openBulkImportModal()" class="btn-gold" style="padding:8px 16px; font-size:12px; display:inline-flex; align-items:center; gap:6px; cursor:pointer; background:#10b981; border-color:#10b981; color:#fff;">
          <i class="fas fa-file-import"></i> Nhập hàng loạt từ khóa
        </button>
        <a href="admin.php?p=pseo&editor=add&type=diadanhcu" class="btn-gold" style="padding:8px 16px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
          <i class="fas fa-plus"></i> Tạo chiến dịch Địa Danh Cũ
        </a>
      </div>
    </div>

    <!-- Campaigns list table -->
    <?php renderCampaignsTable($campaignsOld); ?>
  </div>
</div>

<!-- ==========================================
     TAB 4: APARTMENTS (🏢 SEO Chung Cư)
     ========================================== -->
<div class="pseo-tab-panel" id="tab-apartments">
  <div class="card" style="border-radius:12px; padding:25px;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
      <div>
        <h3 class="card__title" style="margin:0; font-size:15px; text-transform:uppercase;">🏢 Quản lý Chiến dịch SEO Dự án Chung Cư</h3>
        <p style="font-size:12px; color:var(--color-text-muted); margin-top:4px;">Tạo chiến dịch tiếp cận trực tiếp 5,877+ cụm chung cư cao cấp, dự án đô thị nổi tiếng toàn quốc.</p>
      </div>
      <div style="display:flex; gap:10px;">
        <button type="button" onclick="openBulkImportModal()" class="btn-gold" style="padding:8px 16px; font-size:12px; display:inline-flex; align-items:center; gap:6px; cursor:pointer; background:#10b981; border-color:#10b981; color:#fff;">
          <i class="fas fa-file-import"></i> Nhập hàng loạt từ khóa
        </button>
        <a href="admin.php?p=pseo&editor=add&type=chungcu" class="btn-gold" style="padding:8px 16px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
          <i class="fas fa-plus"></i> Tạo chiến dịch Chung Cư
        </a>
      </div>
    </div>

    <!-- Campaigns list table -->
    <?php renderCampaignsTable($campaignsProject); ?>
  </div>
</div>

<!-- ==========================================
     TAB 5: IMPORT TASK MANAGER (📋 Quản lý Import)
     ========================================== -->
<div class="pseo-tab-panel" id="tab-import-mgr">
  <div class="card" style="border-radius:12px; padding:25px; margin-bottom: 30px;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
      <div>
        <h3 class="card__title" style="margin:0; font-size:15px; text-transform:uppercase;">📋 Quản lý & Theo Dõi Tiến Trình Import Chiến Dịch pSEO</h3>
        <p style="font-size:12px; color:var(--color-text-muted); margin-top:4px;">Theo dõi trạng thái và quản lý các tác vụ import nội dung SEO địa danh.</p>
      </div>
    </div>

    <!-- FILTER & BULK ACTIONS -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px; background:rgba(0,0,0,0.12); padding:15px; border-radius:8px; border:1px solid var(--color-border);">
      <!-- Status Filters (Client-side) -->
      <div style="display:flex; gap:8px; flex-wrap:wrap;" id="import-status-filters">
        <button type="button" class="btn-filter-status active" data-filter="all" style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid var(--color-border); background:var(--color-primary); color:#000; cursor:pointer;">Tất cả</button>
        <button type="button" class="btn-filter-status" data-filter="not_started" style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid var(--color-border); background:rgba(255,255,255,0.03); color:var(--color-text-muted); cursor:pointer;">Chưa chạy</button>
        <button type="button" class="btn-filter-status" data-filter="running" style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid var(--color-border); background:rgba(255,255,255,0.03); color:var(--color-text-muted); cursor:pointer;">Đang chạy</button>
        <button type="button" class="btn-filter-status" data-filter="paused" style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid var(--color-border); background:rgba(255,255,255,0.03); color:var(--color-text-muted); cursor:pointer;">Tạm dừng</button>
        <button type="button" class="btn-filter-status" data-filter="completed" style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; border:1px solid var(--color-border); background:rgba(255,255,255,0.03); color:var(--color-text-muted); cursor:pointer;">Hoàn thành</button>
      </div>

      <!-- Bulk action -->
      <div style="display:flex; gap:8px; align-items:center;">
        <select id="import-bulk-action" class="form-control" style="font-size:12px; padding:6px 12px; background:rgba(0,0,0,0.5); color:#fff; border:1px solid var(--color-border); border-radius:4px; max-width:200px;">
          <option value="">Hành động hàng loạt</option>
          <option value="reset">Đặt lại trạng thái</option>
        </select>
        <button type="button" id="btn-import-bulk-apply" class="btn-gold" style="padding:6px 14px; font-size:12px;">Áp dụng</button>
      </div>
    </div>

    <!-- TABLE LIST -->
    <div style="overflow-x:auto; width:100%; border:1px solid var(--color-border); border-radius:8px;">
      <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px;" id="table-import-tasks">
        <thead>
          <tr style="background:rgba(255, 255, 255, 0.015); border-bottom:1px solid var(--color-border);">
            <th style="padding:12px 18px; width:40px; text-align:center;"><input type="checkbox" id="import-select-all"></th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:60px;">ID</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; min-width:220px;">Từ khóa</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:130px;">Trạng thái</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:90px; text-align:center;">Đã tạo</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:90px; text-align:center;">Dự kiến</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:180px;">Tiến trình (%)</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:140px;">Bắt đầu</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600; width:140px;">Kết thúc</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($allCampaigns) > 0): ?>
            <?php foreach ($allCampaigns as $c): 
              $expected = (int)$c['import_expected'];
              $created = (int)$c['import_created'];
              $percent = $expected > 0 ? round(($created / $expected) * 100, 2) : 0;
              $status = $c['import_status'] ?: 'not_started';
              $isCore = in_array($c['slug'], ['gia-xe-VinFast', 'dai-ly-VinFast']);
            ?>
              <tr class="import-task-row" data-id="<?php echo $c['id']; ?>" data-status="<?php echo $status; ?>" style="border-bottom:1px solid rgba(255,255,255,0.02); height:75px;" onmouseover="this.style.background='rgba(255,255,255,0.005)';" onmouseout="this.style.background='transparent';">
                <td style="padding:12px 18px; text-align:center;"><input type="checkbox" class="import-row-checkbox" value="<?php echo $c['id']; ?>"></td>
                <td style="padding:12px 18px; color:var(--color-text-muted);"><?php echo $c['id']; ?></td>
                <td style="padding:12px 18px;">
                  <strong style="color:#fff; font-size:14px;"><?php echo htmlspecialchars($c['keyword']); ?></strong>
                  <div class="row-actions" style="margin-top:6px; font-size:11.5px; display:flex; gap:10px;">
                    <!-- Contextual action triggers -->
                    <a href="javascript:void(0);" class="act-import-start" data-id="<?php echo $c['id']; ?>" style="color:var(--color-primary); text-decoration:none; font-weight:700; display:<?php echo ($status === 'not_started') ? 'inline' : 'none'; ?>;"><i class="fas fa-play" style="font-size:9px; margin-right:2px;"></i> Bắt đầu</a>
                    <a href="javascript:void(0);" class="act-import-resume" data-id="<?php echo $c['id']; ?>" style="color:var(--color-primary); text-decoration:none; font-weight:700; display:<?php echo ($status === 'paused') ? 'inline' : 'none'; ?>;"><i class="fas fa-play" style="font-size:9px; margin-right:2px;"></i> Tiếp tục</a>
                    <a href="javascript:void(0);" class="act-import-pause" data-id="<?php echo $c['id']; ?>" style="color:#ff8a80; text-decoration:none; font-weight:700; display:<?php echo ($status === 'running') ? 'inline' : 'none'; ?>;"><i class="fas fa-pause" style="font-size:9px; margin-right:2px;"></i> Tạm dừng</a>
                    
                    <a href="javascript:void(0);" class="act-import-reset" data-id="<?php echo $c['id']; ?>" style="color:var(--color-text-muted); text-decoration:none; display:<?php echo ($status !== 'not_started') ? 'inline' : 'none'; ?>;"><i class="fas fa-undo" style="font-size:9px; margin-right:2px;"></i> Đặt lại</a>
                    <span style="color:rgba(255,255,255,0.1); display:<?php echo ($status !== 'not_started') ? 'inline' : 'none'; ?>;">|</span>
                    
                    <a href="javascript:void(0);" class="act-import-log" data-id="<?php echo $c['id']; ?>" style="color:var(--color-text-muted); text-decoration:none;"><i class="fas fa-file-alt" style="font-size:9px; margin-right:2px;"></i> Xem Log</a>
                    <span>|</span>
                    
                    <a href="admin.php?p=pseo&campaign_filter=<?php echo $c['id']; ?>#tab-explorer" style="color:var(--color-primary); text-decoration:none; font-weight:600;"><i class="fas fa-external-link-alt" style="font-size:9px; margin-right:2px;"></i> Xem bài viết</a>
                    
                    <?php if (!$isCore): ?>
                      <span>|</span>
                      <a href="javascript:void(0);" class="act-import-delete" data-id="<?php echo $c['id']; ?>" style="color:#ef5350; text-decoration:none;"><i class="fas fa-trash-alt" style="font-size:9px; margin-right:2px;"></i> Xóa</a>
                    <?php endif; ?>
                  </div>
                </td>
                <td style="padding:12px 18px;">
                  <span class="badge-status-wrap">
                    <?php if ($status === 'running'): ?>
                      <span style="background:rgba(255,193,7,0.1); color:#ffc107; border:1px solid rgba(255,193,7,0.25); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;"><span class="pulse-dot" style="background-color:#ffc107;"></span>Đang chạy</span>
                    <?php elseif ($status === 'paused'): ?>
                      <span style="background:rgba(0,150,255,0.1); color:#33b3ff; border:1px solid rgba(0,150,255,0.25); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;">Tạm dừng</span>
                    <?php elseif ($status === 'completed'): ?>
                      <span style="background:rgba(76,175,80,0.1); color:#4caf50; border:1px solid rgba(76,175,80,0.25); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;"><i class="fas fa-check-circle" style="font-size:10px;"></i>Hoàn thành</span>
                    <?php else: ?>
                      <span style="background:rgba(255,255,255,0.05); color:var(--color-text-muted); border:1px solid rgba(255,255,255,0.1); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;">Chưa chạy</span>
                    <?php endif; ?>
                  </span>
                </td>
                <td style="padding:12px 18px; text-align:center; font-weight:bold; color:#fff;" class="col-created"><?php echo number_format($created); ?></td>
                <td style="padding:12px 18px; text-align:center; color:var(--color-text-muted);" class="col-expected"><?php echo number_format($expected); ?></td>
                <td style="padding:12px 18px;">
                  <div style="display:flex; align-items:center; gap:8px;">
                    <div style="flex-grow:1; height:6px; background:rgba(255,255,255,0.05); border-radius:3px; overflow:hidden;">
                      <div class="progress-bar-fill" style="width:<?php echo $percent; ?>%; height:100%; background:linear-gradient(90deg, var(--color-primary) 0%, #ffc107 100%); border-radius:3px; transition: width 0.2s ease;"></div>
                    </div>
                    <span class="progress-percent-txt" style="font-size:11px; font-weight:bold; color:#fff; width:45px; text-align:right;"><?php echo $percent; ?>%</span>
                  </div>
                </td>
                <td style="padding:12px 18px; font-size:11.5px; color:var(--color-text-muted);" class="col-start"><?php echo $c['import_start_time'] ? date('Y-m-d H:i:s', strtotime($c['import_start_time'])) : '--'; ?></td>
                <td style="padding:12px 18px; font-size:11.5px; color:var(--color-text-muted);" class="col-end"><?php echo $c['import_end_time'] ? date('Y-m-d H:i:s', strtotime($c['import_end_time'])) : '--'; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" style="padding:25px; text-align:center; color:var(--color-text-muted);">Không tìm thấy chiến dịch nào để import. Hãy tạo chiến dịch mới trước!</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ==========================================
     MODAL: BULK IMPORT CAMPAIGNS
     ========================================== -->
<div id="bulk-import-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:99999; justify-content:center; align-items:center;">
  <div style="background:#111622; border:1px solid var(--color-border); border-radius:12px; max-width:600px; width:90%; padding:25px; box-shadow:0 10px 30px rgba(0,0,0,0.5); display:flex; flex-direction:column; max-height:85%;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:15px;">
      <h3 style="margin:0; font-size:16px; color:#fff; text-transform:uppercase;"><i class="fas fa-file-import" style="color:var(--color-primary); margin-right:8px;"></i> Nhập Hàng Loạt Từ Khóa Chiến Dịch pSEO</h3>
      <button type="button" onclick="closeBulkImportModal()" style="background:transparent; border:none; color:var(--color-text-muted); font-size:20px; cursor:pointer;" onmouseover="this.style.color='#fff';" onmouseout="this.style.color='var(--color-text-muted)';">&times;</button>
    </div>
    
    <form action="admin.php?p=pseo&action=bulk_import_campaigns" method="POST" id="bulk-import-form">
      <p style="font-size:12.5px; color:var(--color-text-muted); margin:0 0 15px; line-height:1.5;">
        Nhập mỗi dòng một từ khóa chính. Bạn cũng có thể định dạng nâng cao bằng cách ngăn cách bởi ký tự đứng <code>|</code>:<br>
        <code>Từ khóa | Đường dẫn tĩnh (slug) | Mẫu tiêu đề riêng (tùy chọn)</code>
      </p>
      
      <div style="display:flex; flex-direction:column; gap:5px; margin-bottom:20px;">
        <label style="font-size:11px; color:var(--color-primary); font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Danh sách từ khóa (Mỗi từ khóa 1 dòng):</label>
        <textarea name="bulk_text" required placeholder="Ví dụ:
Giá xe lăn bánh Vinfast VF3
Đại lý xe Vinfast | dai-ly-vinfast-chinh-hang
Khuyến mãi xe Vinfast | khuyen-mai-xe-vinfast | Mua xe Vinfast giá ưu đãi tại {LOCATION}" style="width:100%; height:200px; background:#0a0e15; border:1px solid rgba(255,255,255,0.08); border-radius:6px; padding:15px; color:#fff; font-family:Courier, monospace; font-size:12px; line-height:1.6; outline:none; resize:vertical;"></textarea>
      </div>
      
      <div style="display:flex; justify-content:flex-end; gap:10px; border-top:1px solid var(--color-border); padding-top:15px;">
        <button type="button" onclick="closeBulkImportModal()" class="btn-gold" style="background:#222; border-color:#444; color:#fff; padding:8px 16px; font-size:12px;">Hủy bỏ</button>
        <button type="submit" class="btn-gold" style="padding:8px 16px; font-size:12px; background:#10b981; border-color:#10b981; color:#fff;"><i class="fas fa-check" style="margin-right:6px;"></i> Nhập Hàng Loạt</button>
      </div>
    </form>
  </div>
</div>

<!-- ==========================================
     MODAL: VIEW IMPORT LOGS
     ========================================== -->
<div id="import-log-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:99999; justify-content:center; align-items:center;">
  <div style="background:#111622; border:1px solid var(--color-border); border-radius:12px; max-width:800px; width:90%; padding:25px; box-shadow:0 10px 30px rgba(0,0,0,0.5); display:flex; flex-direction:column; max-height:85%;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:15px;">
      <h3 style="margin:0; font-size:16px; color:#fff; text-transform:uppercase;"><i class="fas fa-file-alt" style="color:var(--color-primary); margin-right:8px;"></i> Nhật ký Import: <span id="log-modal-campaign-title" style="color:var(--color-primary);">...</span></h3>
      <button type="button" id="btn-close-log-modal" style="background:transparent; border:none; color:var(--color-text-muted); font-size:20px; cursor:pointer;" onmouseover="this.style.color='#fff';" onmouseout="this.style.color='var(--color-text-muted)';">&times;</button>
    </div>
    <div id="log-modal-content" style="background:#0a0e15; border:1px solid rgba(255,255,255,0.03); border-radius:6px; padding:15px; color:#a2b4cd; font-family:Courier, monospace; font-size:12px; line-height:1.6; overflow-y:auto; flex-grow:grow; min-height:300px; max-height:450px; white-space:pre-wrap; scroll-behavior: smooth;">
      Đang tải...
    </div>
    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px; border-top:1px solid var(--color-border); padding-top:15px;">
      <button type="button" id="btn-refresh-modal-log" class="btn-gold" style="background:#222; border-color:#444; color:#fff; padding:8px 16px; font-size:12px;"><i class="fas fa-sync-alt" style="margin-right:6px;"></i> Làm mới</button>
      <button type="button" id="btn-close-log-modal-footer" class="btn-gold" style="padding:8px 16px; font-size:12px;">Đóng</button>
    </div>
  </div>
</div>

<!-- ==========================================
     TAB 6: INDEX REBUILDER (🔄 Quản lý Import CSDL)
     ========================================== -->
<div class="pseo-tab-panel" id="tab-rebuilder">
  <div class="card inline-action-card" style="margin-bottom: 30px; border-radius: 12px; padding: 25px;">
    <h3 class="card__title" style="margin-top:0; font-size:16px; text-transform:uppercase;">🔄 Quản Lý Tiến Trình Import & Tái Thiết CSDL Địa Bàn</h3>
    <p style="font-size:13px; color:var(--color-text-muted); line-height:1.6; margin-bottom:20px;">
      Nhấn nút bắt đầu import để biên dịch chéo toàn bộ dữ liệu địa bàn thô từ các tệp JSON và áp dụng vào cấu trúc chỉ mục động vệ tinh. Tiến trình sử dụng công nghệ an toàn không gây gián đoạn trang web công cộng.
    </p>
    
    <div style="display:flex; flex-wrap:wrap; gap:15px; align-items:center; margin-bottom:25px;">
      <button type="button" id="btn-rebuild-start" class="btn-gold" style="padding:10px 20px; font-size:12px;">
        <i class="fas fa-sync" style="margin-right:6px;"></i> Bắt đầu Import Dữ Liệu
      </button>
      
      <form method="POST" style="margin:0;">
        <input type="hidden" name="action" value="clear_cache">
        <button type="submit" class="btn-gold" style="background:#222; border-color:#444; color:#fff; padding:10px 20px; font-size:12px;">
          <i class="fas fa-trash-alt" style="margin-right:6px;"></i> Xóa Bộ nhớ đệm Static Cache
        </button>
      </form>
    </div>

    <!-- Progress UI Panel -->
    <div id="ajax-progress-container" style="display:none; padding:20px; border-radius:8px; background:rgba(0,0,0,0.4); border:1px solid var(--color-border); margin-bottom:25px;">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <span style="font-size:13px; font-weight:700; color:var(--color-primary);" id="progress-status-text">Chuẩn bị...</span>
        <span style="font-size:12.5px; font-weight:bold; color:#fff;" id="progress-percentage-text">0%</span>
      </div>
      
      <div style="width:100%; height:12px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden; margin-bottom:15px;">
        <div id="progress-bar-fill" style="width:0%; height:100%; background:linear-gradient(90deg, var(--color-primary) 0%, #ffc107 100%); border-radius:10px; transition: width 0.2s ease;"></div>
      </div>

      <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px; color:var(--color-text-muted); margin-bottom:15px; flex-wrap:wrap; gap:10px;">
        <span id="progress-counter-text">Đang nạp dữ liệu...</span>
        <span id="progress-speed-text">Tốc độ: -- mục/giây</span>
      </div>

      <div style="display:flex; gap:10px;">
        <button type="button" id="btn-rebuild-pause" class="btn-gold" style="background:#222; border-color:#444; color:#fff; padding:6px 14px; font-size:11.5px; min-height:auto; display:inline-flex; align-items:center; gap:6px;">
          <i class="fas fa-pause"></i> Tạm dừng Import
        </button>
        <button type="button" id="btn-rebuild-resume" class="btn-gold" style="padding:6px 14px; font-size:11.5px; min-height:auto; display:none; align-items:center; gap:6px;">
          <i class="fas fa-play"></i> Tiếp tục Import
        </button>
        <button type="button" id="btn-rebuild-cancel" class="btn-gold" style="background:rgba(239, 83, 80, 0.1); border-color:#ef5350; color:#ff8a80; padding:6px 14px; font-size:11.5px; min-height:auto; display:inline-flex; align-items:center; gap:6px;">
          <i class="fas fa-stop-circle"></i> Hủy (Khôi phục CSDL cũ)
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ==========================================
     TAB 6: DIRECTORY EXPLORER (📂 Trình duyệt Bài viết)
     ========================================== -->
<div class="pseo-tab-panel" id="tab-explorer">
  <div class="card" style="border-radius:12px; padding:25px;">
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid var(--color-border); padding-bottom:15px; margin-bottom:20px; flex-wrap:wrap; gap:15px;">
      <h3 class="card__title" style="margin:0; font-size:15px; text-transform:uppercase;">📂 Trình duyệt & Kiểm soát Bài viết vệ tinh địa phương</h3>
      <span style="font-size:11.5px; background:rgba(76, 175, 80, 0.1); color:#4caf50; border:1px solid rgba(76, 175, 80, 0.25); padding:4px 10px; border-radius:20px; font-weight:700;">
        Tổng số địa bàn: <?php echo number_format($totalFilteredRows); ?> mục
      </span>
    </div>

    <?php if ($selectedCampaign): ?>
      <?php if ($selectedCampaign['import_created'] == 0): ?>
        <div style="background:rgba(239, 83, 80, 0.1); border:1px solid #ef5350; border-radius:8px; padding:15px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; border-left:4px solid #ef5350;">
          <span style="font-size:13px; color:#fff;">
             <i class="fas fa-exclamation-circle" style="color:#ef5350; margin-right:6px;"></i> Chiến dịch <strong style="color:#ef5350;"><?php echo htmlspecialchars($selectedCampaign['keyword']); ?></strong> chưa được chạy import nên chưa kích hoạt bài viết nào. Vui lòng sang tab <a href="admin.php?p=pseo#tab-import-mgr" style="color:var(--color-primary); text-decoration:underline; font-weight:700;">Quản lý Import</a> để bắt đầu tác vụ!
          </span>
          <a href="admin.php?p=pseo#tab-explorer" style="font-size:12px; color:#ff8a80; text-decoration:none; font-weight:700; display:inline-flex; align-items:center; gap:5px;"><i class="fas fa-times-circle"></i> Xóa bộ lọc</a>
        </div>
      <?php else: ?>
        <div style="background:rgba(25, 96, 215,0.1); border:1px solid var(--color-primary); border-radius:8px; padding:15px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; border-left:4px solid var(--color-primary);">
          <span style="font-size:13px; color:#fff;">
             <i class="fas fa-filter" style="color:var(--color-primary); margin-right:6px;"></i> Đang lọc bài viết cho chiến dịch: <strong style="color:var(--color-primary);"><?php echo htmlspecialchars($selectedCampaign['keyword']); ?></strong> (Loại: <?php echo $selectedCampaign['type'] === 'location' ? 'Địa danh mới' : ($selectedCampaign['type'] === 'diadanhcu' ? 'Địa danh cũ' : 'Chung cư'); ?>) - Tiến trình: <strong style="color:var(--color-primary);"><?php echo number_format($selectedCampaign['import_created']); ?> / <?php echo number_format($selectedCampaign['import_expected']); ?></strong> bài viết
          </span>
          <a href="admin.php?p=pseo#tab-explorer" style="font-size:12px; color:var(--color-primary); text-decoration:none; font-weight:700; display:inline-flex; align-items:center; gap:5px;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';"><i class="fas fa-times-circle"></i> Xóa bộ lọc</a>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- FILTER TABS & SEARCH BAR -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:15px; background:rgba(0,0,0,0.12); padding:15px; border-radius:8px; border:1px solid var(--color-border);">
      <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <a href="<?php echo getTypeFilterUrl(''); ?>" style="text-decoration:none; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; <?php echo $filterType === '' ? 'background:var(--color-primary); color:#000;' : 'background:rgba(255,255,255,0.03); color:var(--color-text-muted); border:1px solid var(--color-border);'; ?>">Tất cả</a>
        <a href="<?php echo getTypeFilterUrl('location'); ?>" style="text-decoration:none; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; <?php echo $filterType === 'location' ? 'background:var(--color-primary); color:#000;' : 'background:rgba(255,255,255,0.03); color:var(--color-text-muted); border:1px solid var(--color-border);'; ?>">Địa danh mới</a>
        <a href="<?php echo getTypeFilterUrl('diadanhcu'); ?>" style="text-decoration:none; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; <?php echo $filterType === 'diadanhcu' ? 'background:var(--color-primary); color:#000;' : 'background:rgba(255,255,255,0.03); color:var(--color-text-muted); border:1px solid var(--color-border);'; ?>">Địa danh cũ</a>
        <a href="<?php echo getTypeFilterUrl('chungcu'); ?>" style="text-decoration:none; padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; <?php echo $filterType === 'chungcu' ? 'background:var(--color-primary); color:#000;' : 'background:rgba(255,255,255,0.03); color:var(--color-text-muted); border:1px solid var(--color-border);'; ?>">Chung cư</a>
      </div>

      <form method="GET" action="admin.php#tab-explorer" style="margin:0; display:flex; gap:8px;">
        <input type="hidden" name="p" value="pseo">
        <input type="hidden" name="type_filter" value="<?php echo htmlspecialchars($filterType); ?>">
        <input type="hidden" name="campaign_filter" value="<?php echo $filterCampaign; ?>">
        <input type="text" name="q" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Tìm kiếm địa bàn/slug..." class="form-control" style="font-size:12px; padding:6px 12px; width:220px; background:rgba(0,0,0,0.5);">
        <button type="submit" class="btn-gold" style="padding:6px 14px; font-size:12px;">Lọc</button>
      </form>
    </div>

    <!-- TABLE LIST -->
    <div style="overflow-x:auto; width:100%; border:1px solid var(--color-border); border-radius:8px;">
      <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px;">
        <thead>
          <tr style="background:rgba(255, 255, 255, 0.015); border-bottom:1px solid var(--color-border);">
            <th style="padding:12px 18px; color:#fff; font-weight:600;">Địa bàn / Dự án</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600;">Phân loại</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600;">Đường dẫn xem trước</th>
            <th style="padding:12px 18px; color:#fff; font-weight:600;">Tiến trình</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($rows) > 0): ?>
            <?php foreach ($rows as $row): 
              $slug = $row['slug'];
              $type = $row['type'];
              $rel = 'tai';
              if ($type === 'chungcu' && strpos($slug, 'chung-cu-') !== 0) {
                  $rel = 'gan';
              }
            ?>
              <tr style="border-bottom:1px solid rgba(255,255,255,0.02); height:50px;" onmouseover="this.style.background='rgba(255,255,255,0.005)';" onmouseout="this.style.background='transparent';">
                <td style="padding:12px 18px; font-weight:600; color:#fff;"><?php echo htmlspecialchars($row['display_name']); ?></td>
                <td style="padding:12px 18px;">
                  <?php if ($type === 'location'): ?>
                    <span style="font-size:10px; background:rgba(0,150,255,0.1); color:#33b3ff; border:1px solid rgba(0,150,255,0.25); padding:2px 8px; border-radius:12px; font-weight:700; text-transform:uppercase;">Địa danh mới</span>
                  <?php elseif ($type === 'diadanhcu'): ?>
                    <span style="font-size:10px; background:rgba(255,193,7,0.1); color:#ffc107; border:1px solid rgba(255,193,7,0.25); padding:2px 8px; border-radius:12px; font-weight:700; text-transform:uppercase;">Địa danh cũ</span>
                  <?php else: ?>
                    <span style="font-size:10px; background:rgba(25, 96, 215,0.1); color:var(--color-primary); border:1px solid rgba(25, 96, 215,0.25); padding:2px 8px; border-radius:12px; font-weight:700; text-transform:uppercase;">Chung cư VIP</span>
                  <?php endif; ?>
                </td>
                <td style="padding:12px 18px;">
                  <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <?php 
                    $previewCount = 0;
                    $campaignsActiveForType = array_filter($allCampaigns, function($c) use ($type, $selectedCampaign) {
                        if ($selectedCampaign) {
                            return $c['id'] == $selectedCampaign['id'];
                        }
                        return $c['type'] === $type && $c['status'] === 'published' && $c['import_created'] > 0;
                    });
                    $activeCount = count($campaignsActiveForType);
                    foreach ($campaignsActiveForType as $kw) {
                        if ($previewCount >= 3) {
                            echo '<span style="font-size:11px; color:var(--color-text-muted); align-self:center;">+ ' . ($activeCount - 3) . ' từ khóa</span>';
                            break;
                        }
                        $cleanBasePath = !empty($basePath) ? '/' . trim($basePath, '/') : '';
                        $link = $cleanBasePath . '/' . $kw['slug'] . '-' . $rel . '-' . $slug . '.html';
                        ?>
                        <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" style="color:var(--color-primary); text-decoration:none; font-size:11.5px; display:inline-flex; align-items:center; gap:4px; background:rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.05); padding:3px 8px; border-radius:4px;" onmouseover="this.style.borderColor='var(--color-primary)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.05)';">
                          <i class="fas fa-external-link-alt" style="font-size:9px;"></i> <?php echo htmlspecialchars($kw['keyword']); ?>
                        </a>
                        <?php
                        $previewCount++;
                    }
                    if ($previewCount === 0) {
                        echo '<span style="font-size:11px; color:var(--color-text-muted);">Không có chiến dịch hoạt động cho loại địa bàn này.</span>';
                    }
                    ?>
                  </div>
                </td>
                <td style="padding:12px 18px;">
                  <span style="font-size:11px; color:#4caf50; display:inline-flex; align-items:center; gap:5px; font-weight:600;">
                    <span class="pulse-dot" style="background-color:#4caf50;"></span> Đã lập chỉ mục
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" style="padding:25px; text-align:center; color:var(--color-text-muted);">Không tìm thấy bài viết vệ tinh nào khớp với bộ lọc.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION NAVIGATION -->
    <?php if ($totalPages > 1): 
      $campaignParam = $filterCampaign > 0 ? '&campaign_filter=' . $filterCampaign : '';
    ?>
      <div style="display:flex; justify-content:space-between; align-items:center; margin-top:25px; flex-wrap:wrap; gap:15px; padding-top:15px; border-top:1px solid var(--color-border);">
        <span style="font-size:12.5px; color:var(--color-text-muted);">
          Trang <strong><?php echo $pageNo; ?></strong> / <?php echo $totalPages; ?> (Đang hiển thị <?php echo count($rows); ?> / <?php echo number_format($totalFilteredRows); ?> địa bàn)
        </span>
        <div style="display:flex; gap:6px;">
          <?php if ($pageNo > 1): ?>
            <a href="admin.php?p=pseo&type_filter=<?php echo urlencode($filterType); ?>&q=<?php echo urlencode($searchQuery); ?><?php echo $campaignParam; ?>&page_no=1#tab-explorer" class="btn-gold" style="padding:6px 12px; font-size:11px; background:#222; border-color:#444; color:#fff; text-decoration:none;">« Đầu</a>
            <a href="admin.php?p=pseo&type_filter=<?php echo urlencode($filterType); ?>&q=<?php echo urlencode($searchQuery); ?><?php echo $campaignParam; ?>&page_no=<?php echo $pageNo - 1; ?>#tab-explorer" class="btn-gold" style="padding:6px 12px; font-size:11px; background:#222; border-color:#444; color:#fff; text-decoration:none;">‹ Trước</a>
          <?php endif; ?>

          <span style="padding:6px 14px; background:rgba(25, 96, 215,0.1); border:1px solid rgba(25, 96, 215,0.3); border-radius:4px; font-size:11.5px; font-weight:700; color:var(--color-primary);">
            <?php echo $pageNo; ?>
          </span>

          <?php if ($pageNo < $totalPages): ?>
            <a href="admin.php?p=pseo&type_filter=<?php echo urlencode($filterType); ?>&q=<?php echo urlencode($searchQuery); ?><?php echo $campaignParam; ?>&page_no=<?php echo $pageNo + 1; ?>#tab-explorer" class="btn-gold" style="padding:6px 12px; font-size:11px; background:#222; border-color:#444; color:#fff; text-decoration:none;">Tiếp ›</a>
            <a href="admin.php?p=pseo&type_filter=<?php echo urlencode($filterType); ?>&q=<?php echo urlencode($searchQuery); ?><?php echo $campaignParam; ?>&page_no=<?php echo $totalPages; ?>#tab-explorer" class="btn-gold" style="padding:6px 12px; font-size:11px; background:#222; border-color:#444; color:#fff; text-decoration:none;">Cuối »</a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php endif; ?>

<?php
/**
 * Dynamic Campaigns Table Helper function
 */
function renderCampaignsTable($campaigns) {
    global $pseo_phone, $pseo_website;
    if (empty($campaigns)):
    ?>
      <div style="text-align: center; padding: 40px 0; border: 1px dashed var(--color-border); border-radius:8px; color: var(--color-text-muted); font-size:13px;">
        Không tìm thấy chiến dịch nào hoạt động. Hãy nhấp nút phía trên để tạo chiến dịch mới!
      </div>
    <?php
    else:
    ?>
      <div style="overflow-x:auto; width:100%; border:1px solid var(--color-border); border-radius:8px;">
        <table style="width:100%; border-collapse:collapse; text-align:left; font-size:13px;">
          <thead>
            <tr style="background:rgba(255, 255, 255, 0.015); border-bottom:1px solid var(--color-border);">
              <th style="padding:12px 18px; color:#fff; font-weight:600;">Từ khóa chính</th>
              <th style="padding:12px 18px; color:#fff; font-weight:600;">Đường dẫn Slug</th>
              <th style="padding:12px 18px; color:#fff; font-weight:600;">Liên hệ chèn</th>
              <th style="padding:12px 18px; color:#fff; font-weight:600;">Số mẫu Tiêu đề</th>
              <th style="padding:12px 18px; color:#fff; font-weight:600;">Ảnh bể chọn</th>
              <th style="padding:12px 18px; color:#fff; font-weight:600;">Trạng thái</th>
              <th style="padding:12px 18px; color:#fff; font-weight:600; text-align:right;">Thao tác</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($campaigns as $c): 
              $isCore = in_array($c['slug'], ['gia-xe-VinFast', 'dai-ly-VinFast']);
              $titleCount = count(array_filter(array_map('trim', explode("\n", $c['title_templates']))));
              $imageCount = !empty($c['image_ids']) ? count(explode(',', $c['image_ids'])) : 0;
              $cPhone = !empty($c['phone_number']) ? $c['phone_number'] : $pseo_phone . ' <span style="font-size:10px; color:var(--color-text-muted);">(mặc định)</span>';
              $cWeb = !empty($c['website_link']) ? $c['website_link'] : $pseo_website . ' <span style="font-size:10px; color:var(--color-text-muted);">(mặc định)</span>';
            ?>
              <tr style="border-bottom:1px solid rgba(255,255,255,0.02); height:55px;" onmouseover="this.style.background='rgba(255,255,255,0.005)';" onmouseout="this.style.background='transparent';">
                <td style="padding:12px 18px; font-weight:600; color:#fff;"><?php echo htmlspecialchars($c['keyword']); ?></td>
                <td style="padding:12px 18px; font-family:monospace; font-size:12px; color:var(--color-primary);"><?php echo htmlspecialchars($c['slug']); ?></td>
                <td style="padding:12px 18px; line-height:1.4;">
                  📱 <?php echo $cPhone; ?><br>
                  🌐 <?php echo $cWeb; ?>
                </td>
                <td style="padding:12px 18px; font-weight:700; color:#fff;"><?php echo $titleCount; ?> tiêu đề</td>
                <td style="padding:12px 18px;">
                  <span style="font-size:11px; background:rgba(25, 96, 215,0.1); color:var(--color-primary); padding:2px 8px; border-radius:12px; border:1px solid rgba(25, 96, 215,0.25);">
                    🖼️ <?php echo $imageCount; ?> ảnh
                  </span>
                </td>
                <td style="padding:12px 18px;">
                  <?php if ($c['status'] === 'published'): ?>
                    <span style="font-size:10px; background:rgba(76,175,80,0.1); color:#4caf50; border:1px solid rgba(76,175,80,0.25); padding:2px 8px; border-radius:12px; font-weight:700; text-transform:uppercase;">Hoạt động</span>
                  <?php else: ?>
                    <span style="font-size:10px; background:rgba(255,193,7,0.1); color:#ffc107; border:1px solid rgba(255,193,7,0.25); padding:2px 8px; border-radius:12px; font-weight:700; text-transform:uppercase;">Tạm ẩn/Nháp</span>
                  <?php endif; ?>
                </td>
                <td style="padding:12px 18px; text-align:right;">
                  <a href="admin.php?p=pseo&editor=edit&id=<?php echo $c['id']; ?>" class="btn-gold" style="padding:5px 10px; font-size:11px; min-height:auto; display:inline-flex; align-items:center; gap:4px; text-decoration:none;">
                    <i class="fas fa-edit" style="font-size:9px;"></i> Cấu hình
                  </a>
                  
                  <?php if (!$isCore): ?>
                    <form method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Anh có chắc muốn loại bỏ chiến dịch này? Tất cả các bài viết tương ứng sẽ ngay lập tức ngừng hoạt động.')">
                      <input type="hidden" name="action" value="delete_campaign">
                      <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                      <button type="submit" class="btn-gold" style="background:rgba(239,83,80,0.1); border-color:#ef5350; color:#ff8a80; padding:5px 10px; font-size:11px; min-height:auto; margin-left:4px; display:inline-flex; align-items:center; gap:4px;">
                        <i class="fas fa-trash-alt" style="font-size:9px;"></i> Xóa
                      </button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php
    endif;
}
?>

<!-- HIGH PERFORMANCE INTERACTIVE TAB DRIVER & POPUP CONTROLLERS -->
<script>
// Global campaigns JSON parsed for instant modal populations
const campaignsData = <?php echo json_encode($allCampaigns, JSON_UNESCAPED_UNICODE); ?>;

// --- Live SEO Assistant Analysis Checks ---
function updateSeoChecks() {
    const keywordInput = document.getElementById('modal-keyword');
    const titleInput = document.getElementById('modal-title-templates');
    const contentInput = document.getElementById('modal-content-template');
    const typeInput = document.getElementById('modal-type');
    const phoneInput = document.getElementById('modal-phone');
    const websiteInput = document.getElementById('modal-website');
    const imageCheckboxes = document.querySelectorAll('.modal-image-checkbox');

    if (!keywordInput || !titleInput || !contentInput || !typeInput) return;

    const keyword = keywordInput.value.trim().toLowerCase();
    const title = titleInput.value.trim();
    const content = contentInput.value.trim();
    const type = typeInput.value;
    const phone = phoneInput ? phoneInput.value.trim() : '';
    const website = websiteInput ? websiteInput.value.trim() : '';
    
    // Check elements
    function markCheck(elementId, passed) {
        const li = document.getElementById(elementId);
        if (!li) return;
        const icon = li.querySelector('.seo-icon');
        if (passed) {
            li.classList.add('passed');
            icon.innerHTML = '✅';
        } else {
            li.classList.remove('passed');
            icon.innerHTML = '❌';
        }
    }

    // 1. Keyword check
    markCheck('check-keyword', keyword !== '');

    // 2. Target placeholders check
    let targetPlaceholdersPassed = false;
    if (type === 'location') {
        targetPlaceholdersPassed = title.includes('{WARD_FULL_NAME}') || title.includes('{PROVINCE_NAME}');
    } else if (type === 'diadanhcu') {
        targetPlaceholdersPassed = title.includes('{WARD_NAME}') || title.includes('{DISTRICT_NAME}') || title.includes('{PROVINCE_NAME}');
    } else if (type === 'chungcu') {
        targetPlaceholdersPassed = title.includes('{PROJECT_NAME}');
    }
    markCheck('check-placeholders-title', targetPlaceholdersPassed);

    // 3. Keyword in title check
    markCheck('check-keyword-title', keyword !== '' && title.toLowerCase().includes('{keyword}'));

    // 4. Contact placeholders check
    markCheck('check-contact-content', content.includes('{PHONE_NUMBER}') && content.includes('{WEBSITE_LINK}'));

    // 5. Spintax complexity check
    const spintaxCount = (content.match(/\{[^{}]+\|[^{}]+\}/g) || []).length;
    markCheck('check-spintax-complexity', spintaxCount >= 2);

    // 6. Selected images check
    markCheck('check-images-count', imageCheckboxes.length >= 1);
    
    // Update image grid placeholder if empty
    const grid = document.getElementById('modal-image-grid');
    if (grid) {
        const checkboxes = grid.querySelectorAll('.modal-image-checkbox');
        if (checkboxes.length === 0) {
            if (!document.getElementById('modal-image-grid-placeholder')) {
                grid.innerHTML = `
                    <p id="modal-image-grid-placeholder" style="grid-column: 1/-1; color: var(--color-text-muted); font-size:11.5px; text-align:center; margin:15px 0; line-height:1.5;">
                      Chưa có ảnh đại diện nào được chọn cho chiến dịch này.<br>Anh hãy click nút <strong>"Tải ảnh từ máy"</strong> hoặc <strong>"Từ thư viện"</strong> để thêm ảnh nhé!
                    </p>
                `;
            }
        } else {
            const placeholder = document.getElementById('modal-image-grid-placeholder');
            if (placeholder) placeholder.remove();
        }
    }
    
    // Calculate and update SEO score (0-100%)
    let totalChecks = 6;
    let passedChecks = 0;
    if (keyword !== '') passedChecks++;
    if (targetPlaceholdersPassed) passedChecks++;
    if (keyword !== '' && title.toLowerCase().includes('{keyword}')) passedChecks++;
    if (content.includes('{PHONE_NUMBER}') && content.includes('{WEBSITE_LINK}')) passedChecks++;
    if (spintaxCount >= 2) passedChecks++;
    if (imageCheckboxes.length >= 1) passedChecks++;

    const score = Math.round((passedChecks / totalChecks) * 100);

    const circle = document.getElementById('seo-score-circle');
    const numEl = document.getElementById('seo-score-number');
    const labelEl = document.getElementById('seo-score-label');
    const descEl = document.getElementById('seo-score-desc');

    if (circle && numEl && labelEl && descEl) {
        circle.setAttribute('stroke-dasharray', `${score}, 100`);
        numEl.innerText = `${score}%`;

        let strokeColor = '#ef5350'; // Red
        let labelText = 'Tối ưu SEO: Yếu';
        let descText = 'Nội dung sơ sài, hãy chèn thêm các tag và Spintax xáo trộn.';

        if (score >= 80) {
            strokeColor = '#4caf50'; // Green
            labelText = 'Tối ưu SEO: Xuất Sắc';
            descText = 'Bài viết đã tối ưu chuẩn SEO địa danh hoàn hảo!';
        } else if (score >= 50) {
            strokeColor = 'var(--color-primary)'; // Yellow
            labelText = 'Tối ưu SEO: Khá Tốt';
            descText = 'Cấu hình tương đối tốt, tối ưu thêm để đạt điểm tuyệt đối.';
        }

        circle.setAttribute('stroke', strokeColor);
        numEl.style.color = strokeColor;
        labelEl.style.color = strokeColor;
        labelEl.innerText = labelText;
        descEl.innerText = descText;
    }
    
    // Auto-update Visual Live Preview simulation
    renderLivePreview();
}

// --- Visual Live Preview Simulation Engine ---
const mockLocations = [
    {
        type: 'location',
        ward_full_name: 'Phường Phúc Xá',
        ward_name: 'Phúc Xá',
        district_name: 'Quận Ba Đình',
        province_name: 'Thành phố Hà Nội',
        slug: 'phuong-phuc-xa-quan-ba-dinh-thanh-pho-ha-noi'
    },
    {
        type: 'location',
        ward_full_name: 'Phường Bến Nghé',
        ward_name: 'Bến Nghé',
        district_name: 'Quận 1',
        province_name: 'Thành phố Hồ Chí Minh',
        slug: 'phuong-ben-nghe-quan-1-thanh-pho-ho-chi-minh'
    },
    {
        type: 'location',
        ward_full_name: 'Xã Phú Hữu',
        ward_name: 'Phú Hữu',
        district_name: 'Nhơn Trạch',
        province_name: 'Tỉnh Đồng Nai',
        slug: 'xa-phu-huu-huyen-nhon-trach-tinh-dong-nai'
    },
    {
        type: 'diadanhcu',
        ward_name: 'Phường Phú Hữu',
        district_name: 'Quận 9',
        province_name: 'Thành phố Hồ Chí Minh',
        slug: 'phuong-phu-huu-quan-9-thanh-pho-ho-chi-minh'
    },
    {
        type: 'diadanhcu',
        ward_name: 'Xã Bình Hưng',
        district_name: 'Huyện Bình Chánh',
        province_name: 'Thành phố Hồ Chí Minh',
        slug: 'xa-binh-hung-huyen-binh-chanh-thanh-pho-ho-chi-minh'
    },
    {
        type: 'chungcu',
        project_name: 'Vinhomes Central Park',
        chu_dau_tu: 'Tập đoàn Vingroup',
        dia_chi: '720A Điện Biên Phủ, Phường 22, Quận Bình Thạnh, TP. Hồ Chí Minh',
        slug: 'vinhomes-central-park'
    },
    {
        type: 'chungcu',
        project_name: 'Masteri Thảo Điền',
        chu_dau_tu: 'Thảo Điền Investment',
        dia_chi: '159 Xa lộ Hà Nội, Phường Thảo Điền, Quận 2, TP. Hồ Chí Minh',
        slug: 'masteri-thao-dien'
    }
];

let currentMockIndex = 0;

function refreshLivePreview() {
    currentMockIndex = Math.floor(Math.random() * mockLocations.length);
    renderLivePreview();
}

// --- Live Sandbox Preview (Xem thử Trang thực tế) ---
function openLiveSandboxPreview() {
    const slugInput = document.getElementById('modal-slug');
    if (!slugInput) return;
    const campaignSlug = slugInput.value.trim().toLowerCase();
    if (!campaignSlug) {
        alert('Anh vui lòng nhập Tên đường dẫn tĩnh (Slug) của chiến dịch trước nhé!');
        return;
    }

    const isConfirmed = confirm("Tính năng Xem thử Trang thực tế yêu cầu chiến dịch này đã được LƯU CẤU HÌNH vào CSDL.\n\nNếu anh vừa sửa đổi thông tin hoặc đổi Slug, hãy bấm 'Hủy' để lưu cấu hình trước, sau đó mới xem thử nhé. Anh có muốn tiếp tục mở trang xem thử không?");
    if (!isConfirmed) return;

    const mock = mockLocations[currentMockIndex];
    const locationSlug = mock.slug || 'phuong-ben-nghe-quan-1-thanh-pho-ho-chi-minh';
    const relation = mock.type === 'chungcu' ? 'gan' : 'tai';
    
    // Construct direct URL using query parameter to bypass Apache mod_rewrite / subdirectory limitations
    const url = 'local-seo.php?slug=' + campaignSlug + '-' + relation + '-' + locationSlug;
    
    // Open in a new tab
    window.open(url, '_blank');
}

// --- Spintax Generator Helper Popup logic ---
function openSpintaxHelperModal() {
    document.getElementById('spintax-helper-modal').style.display = 'flex';
    const textarea = document.getElementById('spintax-synonyms');
    textarea.value = '';
    document.getElementById('spintax-result-preview').innerText = '{}';
    
    textarea.oninput = () => {
        const val = textarea.value.trim();
        if (val === '') {
            document.getElementById('spintax-result-preview').innerText = '{}';
            return;
        }
        const parts = val.split(',').map(s => s.trim()).filter(s => s !== '');
        document.getElementById('spintax-result-preview').innerText = '{' + parts.join('|') + '}';
    };
    
    setTimeout(() => textarea.focus(), 150);
}

function closeSpintaxHelperModal() {
    document.getElementById('spintax-helper-modal').style.display = 'none';
}

function insertSpintaxResult() {
    const textVal = document.getElementById('spintax-synonyms').value.trim();
    if (!textVal) {
        alert('Anh vui lòng nhập ít nhất 1 cụm từ đồng nghĩa nhé!');
        return;
    }
    const parts = textVal.split(',').map(s => s.trim()).filter(s => s !== '');
    if (parts.length < 2) {
        alert('Anh hãy nhập ít nhất 2 cụm từ đồng nghĩa ngăn cách bởi dấu phẩy để tạo cấu trúc Spintax xáo trộn nhé!');
        return;
    }
    const spintax = '{' + parts.join('|') + '}';
    
    if (typeof tinymce !== "undefined" && tinymce.get('modal-content-template')) {
        tinymce.get('modal-content-template').insertContent(spintax);
        tinymce.get('modal-content-template').save();
    } else {
        const textarea = document.getElementById('modal-content-template');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const val = textarea.value;
        textarea.value = val.substring(0, start) + spintax + val.substring(end);
        textarea.focus();
        textarea.selectionStart = textarea.selectionEnd = start + spintax.length;
    }
    
    closeSpintaxHelperModal();
    updateSeoChecks();
}

function renderLivePreview() {
    const keywordInput = document.getElementById('modal-keyword');
    const titleInput = document.getElementById('modal-title-templates');
    const contentInput = document.getElementById('modal-content-template');
    const typeInput = document.getElementById('modal-type');
    const phoneInput = document.getElementById('modal-phone');
    const websiteInput = document.getElementById('modal-website');
    
    const googleTitle = document.getElementById('preview-google-title');
    const googleDesc = document.getElementById('preview-google-desc');
    const googleUrl = document.getElementById('preview-google-url');
    const articleTitle = document.getElementById('preview-article-title');
    const articleContent = document.getElementById('preview-article-content');
    const articleImg = document.getElementById('preview-article-image');
    const imgContainer = document.getElementById('preview-article-image-container');

    if (!keywordInput || !titleInput || !contentInput || !typeInput) return;

    const keyword = keywordInput.value.trim() || '[Từ khóa chính]';
    const type = typeInput.value;
    
    const phone = (phoneInput && phoneInput.value.trim()) ? phoneInput.value.trim() : '<?php echo htmlspecialchars($pseo_phone); ?>';
    const website = (websiteInput && websiteInput.value.trim()) ? websiteInput.value.trim() : '<?php echo htmlspecialchars($pseo_website); ?>';

    const titleLines = titleInput.value.split('\n').map(l => l.trim()).filter(l => l !== '');
    let titleTemplate = titleLines.length > 0 ? titleLines[0] : '{KEYWORD} tại {WARD_FULL_NAME}';
    
    let contentTemplate = "";
    if (typeof tinymce !== "undefined" && tinymce.get('modal-content-template')) {
        contentTemplate = tinymce.get('modal-content-template').getContent();
    } else {
        contentTemplate = contentInput.value;
    }
    
    const possibleMocks = mockLocations.filter(m => m.type === type);
    const mock = possibleMocks.length > 0 
        ? possibleMocks[currentMockIndex % possibleMocks.length] 
        : mockLocations[0];

    function replacePlaceholders(str) {
        if (!str) return '';
        str = str.replace(/{KEYWORD}/gi, keyword);
        str = str.replace(/{PHONE_NUMBER}/gi, phone);
        str = str.replace(/{WEBSITE_LINK}/gi, `<a href="${website}" target="_blank" style="color:var(--color-primary); font-weight:700;">${website}</a>`);
        
        str = str.replace(/{WARD_FULL_NAME}/gi, mock.ward_full_name || '');
        str = str.replace(/{WARD_NAME}/gi, mock.ward_name || '');
        str = str.replace(/{DISTRICT_NAME}/gi, mock.district_name || '');
        str = str.replace(/{PROVINCE_NAME}/gi, mock.province_name || '');
        str = str.replace(/{PROJECT_NAME}/gi, mock.project_name || '');
        str = str.replace(/{CHU_DAU_TU}/gi, mock.chu_dau_tu || '');
        str = str.replace(/{DIA_CHI}/gi, mock.dia_chi || '');
        return str;
    }

    function parseSpintax(str) {
        if (!str) return '';
        const regex = /\{([^{}]+)\}/;
        let match;
        let iterations = 0;
        while ((match = regex.exec(str)) && iterations < 100) {
            const parts = match[1].split('|');
            const choice = parts[Math.floor(Math.random() * parts.length)];
            str = str.replace(match[0], choice);
            iterations++;
        }
        return str;
    }

    const resolvedTitle = parseSpintax(replacePlaceholders(titleTemplate));
    const resolvedContent = parseSpintax(replacePlaceholders(contentTemplate));

    if (googleTitle) googleTitle.innerText = resolvedTitle;
    if (articleTitle) articleTitle.innerText = resolvedTitle;
    if (articleContent) {
        if (resolvedContent.trim() === '') {
            articleContent.innerHTML = '<span style="color:var(--color-text-muted);">[Chưa soạn nội dung bài viết]</span>';
        } else {
            articleContent.innerHTML = resolvedContent;
        }
    }
    
    if (googleDesc) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = resolvedContent;
        const plainText = tempDiv.textContent || tempDiv.innerText || "";
        googleDesc.innerText = plainText.substring(0, 160) + (plainText.length > 160 ? '...' : '');
    }

    if (googleUrl) {
        const slugifiedKw = slugifyText(keyword);
        const relationStr = (type === 'chungcu') ? 'gan' : 'tai';
        const nodeSlug = mock.project_name ? slugifyText(mock.project_name) : slugifyText(mock.ward_full_name || mock.ward_name);
        googleUrl.innerText = `https://VinFast-vietnam.vn/${slugifiedKw}-${relationStr}-${nodeSlug}.html`;
    }

    const checkedImages = document.querySelectorAll('.modal-image-checkbox:checked');
    if (checkedImages.length > 0) {
        const firstImgUrl = checkedImages[0].value;
        if (articleImg) {
            articleImg.src = firstImgUrl;
            if (imgContainer) imgContainer.style.display = 'block';
        }
    } else {
        if (imgContainer) imgContainer.style.display = 'none';
    }
}

function checkSlugUniqueness() {
    const slugInput = document.getElementById('modal-slug');
    const msgEl = document.getElementById('slug-validation-msg');
    const hintEl = document.getElementById('slug-editor-hint');
    const currentIdEl = document.getElementById('modal-id');
    const currentId = currentIdEl ? currentIdEl.value : '';
    
    if (!slugInput || !msgEl) return;
    
    const val = slugInput.value.trim().toLowerCase();
    
    if (val === '') {
        msgEl.style.display = 'none';
        if (hintEl) hintEl.style.display = 'block';
        return;
    }
    
    // Check duplicate in campaignsData array parsed globally
    const isDuplicate = campaignsData.some(c => c.slug.toLowerCase() === val && c.id != currentId);
    
    if (isDuplicate) {
        msgEl.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Đường dẫn tĩnh (Slug) này đã bị trùng lặp với chiến dịch khác!';
        msgEl.style.display = 'block';
        if (hintEl) hintEl.style.display = 'none';
        slugInput.style.borderColor = '#ff5252';
    } else {
        msgEl.style.display = 'none';
        if (hintEl) hintEl.style.display = 'block';
        slugInput.style.borderColor = '';
    }
}

function submitCampaignForm() {
    const form = document.getElementById('pseo-campaign-form');
    const slugInput = document.getElementById('modal-slug');
    const currentIdEl = document.getElementById('modal-id');
    const currentId = currentIdEl ? currentIdEl.value : '';
    
    if (!form) return;
    if (!form.reportValidity()) return;
    
    if (slugInput) {
        const val = slugInput.value.trim().toLowerCase();
        const isDuplicate = campaignsData.some(c => c.slug.toLowerCase() === val && c.id != currentId);
        if (isDuplicate) {
            alert('Đường dẫn tĩnh (Slug) đã bị trùng lặp với một chiến dịch khác! Anh hãy đổi tên Slug khác trước khi Lưu cấu hình nhé.');
            slugInput.focus();
            return;
        }
    }
    
    form.submit();
}

// --- Auto-generate URL slug from Keyword ---
function autoGenerateSlug(keyword) {
    const slugInput = document.getElementById('modal-slug');
    const actionEl = document.getElementById('modal-action');
    if (slugInput && actionEl && actionEl.value === 'add_campaign') {
        slugInput.value = slugifyText(keyword);
        checkSlugUniqueness(); // Instantly validate the auto-generated slug!
    }
}

function slugifyText(str) {
    str = str.toLowerCase();
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
    str = str.replace(/[^a-z0-9\s-]/g, '');
    str = str.replace(/[\s-]+/g, '-');
    return str.trim().replace(/^-+|-+$/g, '');
}

// --- Asynchronous Campaign Images Multi-Uploader (Sequential) ---
async function handleModalImageUpload(files) {
    if (!files || files.length === 0) return;

    const statusEl = document.getElementById('modal-upload-status');
    statusEl.style.display = 'inline-flex';

    const totalFiles = files.length;
    let uploadedCount = 0;
    const allErrors = [];

    const grid = document.getElementById('modal-image-grid');

    for (let i = 0; i < totalFiles; i++) {
        const file = files[i];
        statusEl.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Đang tải lên ảnh ${i + 1}/${totalFiles} (${file.name})...`;

        const formData = new FormData();
        formData.append('action', 'upload_campaign_images');
        formData.append('campaign_images[]', file);

        try {
            const res = await fetch('<?php echo $basePath; ?>/admin/admin.php?p=pseo', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if (data.status === 'success' && data.uploaded && data.uploaded.length > 0) {
                uploadedCount++;
                data.uploaded.forEach(imgPath => {
                    // Remove empty placeholder message if it exists
                    const placeholderMsg = grid.querySelector('#modal-image-grid-placeholder') || grid.querySelector('p');
                    if (placeholderMsg) {
                        placeholderMsg.remove();
                    }

                    const label = document.createElement('label');
                    label.className = 'campaign-image-item';
                    label.innerHTML = `
                        <input type="checkbox" name="image_ids[]" value="${imgPath}" class="modal-image-checkbox" checked style="position: absolute; top: 4px; right: 4px; z-index: 10; accent-color: var(--color-primary); width:14px; height:14px;" onchange="updateSeoChecks();">
                        <img src="<?php echo $basePath; ?>/${imgPath}" style="width:100%; height:100%; object-fit: cover;">
                        <span class="remove-image-overlay" onclick="event.preventDefault(); this.closest('label').remove(); updateSeoChecks();">Gỡ bỏ</span>
                    `;
                    grid.insertBefore(label, grid.firstChild);
                });
            }
            if (data.errors && data.errors.length > 0) {
                allErrors.push(...data.errors);
            } else if (data.status !== 'success') {
                allErrors.push(`${file.name}: ${data.message || 'Lỗi không xác định.'}`);
            }
        } catch (err) {
            allErrors.push(`${file.name}: Lỗi kết nối (${err.message}).`);
        }
    }

    statusEl.style.display = 'none';
    grid.scrollTop = 0;
    
    if (typeof updateSeoChecks === 'function') {
        updateSeoChecks();
    }

    if (allErrors.length > 0) {
        alert(`Hoàn thành tải lên. Thành công: ${uploadedCount}/${totalFiles} ảnh.\n\nMột số ảnh gặp lỗi:\n` + allErrors.join("\n"));
    }
}

// --- Popup Modal Controllers ---
function openAddCampaignModal(type = 'location') {
    document.getElementById('modal-title').innerText = 'Tạo Chiến Dịch pSEO Vệ Tinh Mới';
    document.getElementById('modal-action').value = 'add_campaign';
    document.getElementById('modal-id').value = '';
    document.getElementById('modal-keyword').value = '';
    
    const slugInput = document.getElementById('modal-slug');
    slugInput.value = '';
    slugInput.readOnly = false;
    slugInput.style.opacity = '1';
    slugInput.style.background = 'transparent';

    document.getElementById('modal-type').value = type;
    document.getElementById('modal-phone').value = '';
    document.getElementById('modal-website').value = '';
    
    // Default dynamic templates based on selected geographical level
    let defaultTitle = '';
    let defaultContent = '';
    if (type === 'location') {
        defaultTitle = "{KEYWORD} tại {WARD_FULL_NAME}, {PROVINCE_NAME}\n{KEYWORD} ở {WARD_FULL_NAME}, {PROVINCE_NAME}";
        defaultContent = "{Chào mừng quý khách đến với|Khám phá ngay} dịch vụ {KEYWORD} tại khu vực {WARD_FULL_NAME}, {PROVINCE_NAME}. Mọi thông tin chi tiết vui lòng liên hệ số điện thoại {PHONE_NUMBER} hoặc truy cập website liên kết {WEBSITE_LINK} để được chuyên viên cố vấn phản hồi chu đáo nhất.";
    } else if (type === 'diadanhcu') {
        defaultTitle = "{KEYWORD} tại {WARD_NAME}, {DISTRICT_NAME}, {PROVINCE_NAME}\n{KEYWORD} ở {WARD_NAME}, {DISTRICT_NAME}";
        defaultContent = "{Chào mừng quý khách đến với|Khám phá ngay} dịch vụ {KEYWORD} tại {WARD_NAME}, thuộc khu vực {DISTRICT_NAME}, {PROVINCE_NAME}. Quý khách hàng vui lòng gọi ngay hotline {PHONE_NUMBER} hoặc truy cập {WEBSITE_LINK} để nhận bảng giá ưu đãi mới nhất.";
    } else {
        defaultTitle = "{KEYWORD} gần {PROJECT_NAME}\n{KEYWORD} tại khu vực {PROJECT_NAME} | VIP Service";
        defaultContent = "Đặc quyền VIP hỗ trợ cho cư dân đang sinh sống tại dự án chung cư cao cấp {PROJECT_NAME}, phát triển bởi chủ đầu tư {CHU_DAU_TU} tại địa chỉ {DIA_CHI}. Chương trình ưu đãi xe điện EV cực hot. Liên hệ hotline cố vấn {PHONE_NUMBER} hoặc {WEBSITE_LINK} ngay hôm nay!";
    }
    
    document.getElementById('modal-title-templates').value = defaultTitle;
    document.getElementById('modal-content-template').value = defaultContent;
    document.getElementById('modal-status').value = 'published';

    // Clear image grid and show empty placeholder
    const grid = document.getElementById('modal-image-grid');
    grid.innerHTML = `
        <p id="modal-image-grid-placeholder" style="grid-column: 1/-1; color: var(--color-text-muted); font-size:11.5px; text-align:center; margin:15px 0; line-height:1.5;">
          Chưa có ảnh đại diện nào được chọn cho chiến dịch này.<br>Anh hãy click nút <strong>"Tải ảnh mới từ máy tính"</strong> phía trên để bắt đầu thêm ảnh nhé!
        </p>
    `;

    // Populate placeholder badged insert toolbar
    updateModalPlaceholders(type);

    document.getElementById('campaign-modal').style.display = 'flex';
}

function openEditCampaignModal(id) {
    const c = campaignsData.find(item => item.id == id);
    if (!c) return;

    document.getElementById('modal-title').innerText = 'Chỉnh Sửa Chiến Dịch: ' + c.keyword;
    document.getElementById('modal-action').value = 'update_campaign';
    document.getElementById('modal-id').value = c.id;
    document.getElementById('modal-keyword').value = c.keyword;
    
    const slugInput = document.getElementById('modal-slug');
    slugInput.value = c.slug;
    
    // Core default campaigns are read-only to prevent path breakages
    if (c.slug === 'gia-xe-VinFast' || c.slug === 'dai-ly-VinFast') {
        slugInput.readOnly = true;
        slugInput.style.opacity = '0.6';
        slugInput.style.background = 'rgba(0,0,0,0.3)';
    } else {
        slugInput.readOnly = false;
        slugInput.style.opacity = '1';
        slugInput.style.background = 'transparent';
    }

    document.getElementById('modal-type').value = c.type;
    document.getElementById('modal-phone').value = c.phone_number || '';
    document.getElementById('modal-website').value = c.website_link || '';
    document.getElementById('modal-title-templates').value = c.title_templates || '';
    document.getElementById('modal-content-template').value = c.content_template || '';
    document.getElementById('modal-status').value = c.status || 'published';

    // Build grid using ONLY saved images for this campaign to avoid clutter
    const grid = document.getElementById('modal-image-grid');
    grid.innerHTML = '';

    if (c.image_ids && c.image_ids.trim() !== '') {
        const activeImages = c.image_ids.split(',');
        activeImages.forEach(img => {
            const imgPath = img.trim();
            if (imgPath === '') return;

            const label = document.createElement('label');
            label.style.cssText = "position: relative; display: block; width: 100%; aspect-ratio: 1; border-radius: 6px; overflow: hidden; border: 1px solid var(--color-border); cursor: pointer; transition: all 0.2s;";
            
            label.innerHTML = `
                <input type="checkbox" name="image_ids[]" value="${imgPath}" class="modal-image-checkbox" checked style="position: absolute; top: 4px; right: 4px; z-index: 10; accent-color: var(--color-primary); width:14px; height:14px;">
                <img src="<?php echo $basePath; ?>/${imgPath}" style="width:100%; height:100%; object-fit: cover;">
            `;
            grid.appendChild(label);
        });
    } else {
        grid.innerHTML = `
            <p id="modal-image-grid-placeholder" style="grid-column: 1/-1; color: var(--color-text-muted); font-size:11.5px; text-align:center; margin:15px 0; line-height:1.5;">
              Chưa có ảnh đại diện nào được chọn cho chiến dịch này.<br>Anh hãy click nút <strong>"Tải ảnh mới từ máy tính"</strong> phía trên để bắt đầu thêm ảnh nhé!
            </p>
        `;
    }

    // Populate placeholders
    updateModalPlaceholders(c.type);

    document.getElementById('campaign-modal').style.display = 'flex';
}

function closeCampaignModal() {
    document.getElementById('campaign-modal').style.display = 'none';
}

function openBulkImportModal() {
    document.getElementById('bulk-import-modal').style.display = 'flex';
}

function closeBulkImportModal() {
    document.getElementById('bulk-import-modal').style.display = 'none';
}

// --- Global Media Picker Modal Logic ---
let mediaLibraryFiles = []; // Holds all library images cached locally

function openMediaPickerModal() {
    const picker = document.getElementById('media-picker-modal');
    const grid = document.getElementById('media-picker-grid');
    picker.style.display = 'flex';
    grid.innerHTML = '<p style="grid-column: 1/-1; color: var(--color-text-muted); font-size:12px; text-align:center; margin:15px 0;"><i class="fas fa-spinner fa-spin"></i> Đang nạp thư viện hình ảnh...</p>';
    document.getElementById('media-picker-search').value = '';
    document.getElementById('media-picker-selected-count').innerText = '0';

    fetch('<?php echo $basePath; ?>/admin/admin.php?get_media_library_files=1')
    .then(res => res.json())
    .then(files => {
        mediaLibraryFiles = files || [];
        renderMediaPickerGrid(mediaLibraryFiles);
    })
    .catch(err => {
        grid.innerHTML = '<p style="grid-column: 1/-1; color: #ff5252; font-size:12px; text-align:center; margin:15px 0;">Không thể tải thư viện: ' + err.message + '</p>';
    });
}

function closeMediaPickerModal() {
    document.getElementById('media-picker-modal').style.display = 'none';
}

function renderMediaPickerGrid(files) {
    const grid = document.getElementById('media-picker-grid');
    grid.innerHTML = '';

    if (files.length === 0) {
        grid.innerHTML = '<p style="grid-column: 1/-1; color: var(--color-text-muted); font-size:12px; text-align:center; margin:15px 0;">Không tìm thấy hình ảnh nào trong thư viện.</p>';
        return;
    }

    // Get currently selected image paths in the campaign editor modal
    const campaignCheckboxes = document.querySelectorAll('.modal-image-checkbox');
    const selectedPaths = Array.from(campaignCheckboxes).map(cb => cb.value);

    // Format bytes helper for sidebar
    const formatBytes = (bytes, decimals = 1) => {
      if (!bytes || bytes === 0) return '0 Bytes';
      const k = 1024;
      const dm = decimals < 0 ? 0 : decimals;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    };

    // Reset sidebar when grid re-renders
    const sidebarPreview = document.getElementById('media-picker-sidebar-preview');
    const sidebarInfo = document.getElementById('media-picker-sidebar-info');
    if (sidebarPreview) sidebarPreview.innerHTML = '<span style="color: var(--color-text-muted); font-size: 11px;">Chưa chọn ảnh nào</span>';
    if (sidebarInfo) sidebarInfo.innerHTML = '<span style="color: var(--color-text-muted); font-size: 11px; text-align: center; display: block; margin-top: 10px;">Chọn một hình ảnh bên trái để xem chi tiết.</span>';

    files.forEach(file => {
        const isAlreadyChecked = selectedPaths.includes(file.url);
        
        const label = document.createElement('label');
        label.className = 'media-picker-item';
        label.setAttribute('data-name', file.name);
        if (isAlreadyChecked) {
            label.classList.add('selected-active');
        }

        label.innerHTML = `
            <input type="checkbox" value="${file.url}" class="picker-image-checkbox" ${isAlreadyChecked ? 'checked' : ''} style="position: absolute; top: 8px; right: 8px; z-index: 10; accent-color: var(--color-primary); width:16px; height:16px; cursor:pointer;" onchange="updatePickerSelectedCount(this)">
            <img src="<?php echo $basePath; ?>/${file.url}" title="${file.name}" style="width:100%; height:100%; object-fit: cover;">
        `;

        // Click event to display details in sidebar
        label.addEventListener('click', (e) => {
            // If user clicked the checkbox itself, don't interfere
            if (e.target.tagName === 'INPUT') return;

            // Highlight current item
            document.querySelectorAll('.media-picker-item').forEach(el => {
              el.style.border = '2px solid var(--color-border)';
            });
            label.style.border = '2px solid var(--color-primary)';

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
        });

        grid.appendChild(label);
    });

    updatePickerSelectedCount();
}

function updatePickerSelectedCount(cb = null) {
    if (cb) {
        const label = cb.closest('label');
        if (cb.checked) {
            label.classList.add('selected-active');
        } else {
            label.classList.remove('selected-active');
        }
    }
    const checkedBoxes = document.querySelectorAll('.picker-image-checkbox:checked');
    document.getElementById('media-picker-selected-count').innerText = checkedBoxes.length;
}

function filterMediaPicker(query) {
    query = query.toLowerCase().trim();
    if (query === '') {
        renderMediaPickerGrid(mediaLibraryFiles);
        return;
    }
    const filtered = mediaLibraryFiles.filter(file => file.name.toLowerCase().includes(query));
    renderMediaPickerGrid(filtered);
}

function confirmMediaPickerSelection() {
    const checkedBoxes = document.querySelectorAll('.picker-image-checkbox:checked');
    const selectedPaths = Array.from(checkedBoxes).map(cb => cb.value);

    const grid = document.getElementById('modal-image-grid');
    
    // Clear and build the grid using selection
    grid.innerHTML = '';

    if (selectedPaths.length > 0) {
        selectedPaths.forEach(imgPath => {
            const label = document.createElement('label');
            label.className = 'campaign-image-item';
            label.innerHTML = `
                <input type="checkbox" name="image_ids[]" value="${imgPath}" class="modal-image-checkbox" checked style="position: absolute; top: 4px; right: 4px; z-index: 10; accent-color: var(--color-primary); width:14px; height:14px;" onchange="updateSeoChecks();">
                <img src="<?php echo $basePath; ?>/${imgPath}" style="width:100%; height:100%; object-fit: cover;">
                <span class="remove-image-overlay" onclick="event.preventDefault(); this.closest('label').remove(); updateSeoChecks();">Gỡ bỏ</span>
            `;
            grid.appendChild(label);
        });
    } else {
        grid.innerHTML = `
            <p id="modal-image-grid-placeholder" style="grid-column: 1/-1; color: var(--color-text-muted); font-size:11.5px; text-align:center; margin:15px 0; line-height:1.5;">
              Chưa có ảnh đại diện nào được chọn cho chiến dịch này.<br>Anh hãy click nút <strong>"Tải ảnh từ máy"</strong> hoặc <strong>"Từ thư viện"</strong> để thêm ảnh nhé!
            </p>
        `;
    }

    if (typeof updateSeoChecks === 'function') {
        updateSeoChecks();
    }

    closeMediaPickerModal();
}

function updateModalPlaceholders(type) {
    const containerContent = document.getElementById('modal-placeholders-list');
    const containerTitle = document.getElementById('modal-title-placeholders-list');
    
    if (containerContent) containerContent.innerHTML = '';
    if (containerTitle) containerTitle.innerHTML = '';

    let placeholders = [];
    if (type === 'location') {
        placeholders = [
            { tag: '{KEYWORD}', desc: 'Từ khóa chính bạn nhập' },
            { tag: '{WARD_FULL_NAME}', desc: 'Tên đầy đủ xã/phường (ví dụ: Phường Phúc Xá)' },
            { tag: '{PROVINCE_NAME}', desc: 'Tên tỉnh/thành phố' },
            { tag: '{PHONE_NUMBER}', desc: 'Số điện thoại liên hệ' },
            { tag: '{WEBSITE_LINK}', desc: 'Website liên kết' }
        ];
    } else if (type === 'diadanhcu') {
        placeholders = [
            { tag: '{KEYWORD}', desc: 'Từ khóa chính bạn nhập' },
            { tag: '{WARD_NAME}', desc: 'Tên phường/xã (ví dụ: Phường Phúc Xá)' },
            { tag: '{DISTRICT_NAME}', desc: 'Tên quận/huyện (ví dụ: Quận Ba Đình)' },
            { tag: '{PROVINCE_NAME}', desc: 'Tên tỉnh/thành phố' },
            { tag: '{PHONE_NUMBER}', desc: 'Số điện thoại liên hệ' },
            { tag: '{WEBSITE_LINK}', desc: 'Website liên kết' }
        ];
    } else {
        placeholders = [
            { tag: '{KEYWORD}', desc: 'Từ khóa chính' },
            { tag: '{PROJECT_NAME}', desc: 'Tên chung cư/dự án' },
            { tag: '{CHU_DAU_TU}', desc: 'Chủ đầu tư phát triển' },
            { tag: '{DIA_CHI}', desc: 'Địa chỉ dự án' },
            { tag: '{PHONE_NUMBER}', desc: 'Số điện thoại liên hệ' },
            { tag: '{WEBSITE_LINK}', desc: 'Website liên kết' }
        ];
    }

    placeholders.forEach(p => {
        // 1. Add to content template toolbar
        if (containerContent) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'badge-placeholder';
            btn.innerText = 'Chèn ' + p.tag;
            btn.title = p.desc;
            btn.onclick = () => {
                if (typeof tinymce !== "undefined" && tinymce.get('modal-content-template')) {
                    tinymce.get('modal-content-template').insertContent(p.tag);
                    tinymce.get('modal-content-template').save();
                } else {
                    const textarea = document.getElementById('modal-content-template');
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const val = textarea.value;
                    textarea.value = val.substring(0, start) + p.tag + val.substring(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + p.tag.length;
                }
                updateSeoChecks();
            };
            containerContent.appendChild(btn);
        }

        // 2. Add to title templates toolbar
        if (containerTitle) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'badge-placeholder';
            btn.innerText = 'Chèn ' + p.tag;
            btn.title = p.desc;
            btn.onclick = () => {
                const textarea = document.getElementById('modal-title-templates');
                if (textarea) {
                    const start = textarea.selectionStart;
                    const end = textarea.selectionEnd;
                    const val = textarea.value;
                    textarea.value = val.substring(0, start) + p.tag + val.substring(end);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = start + p.tag.length;
                }
                updateSeoChecks();
            };
            containerTitle.appendChild(btn);
        }
    });
}

// --- Tab selectors Restoration ---
document.addEventListener("DOMContentLoaded", () => {
  const tabBtns = document.querySelectorAll(".pseo-tab-btn");
  const tabPanels = document.querySelectorAll(".pseo-tab-panel");
  
  function switchTab(targetId) {
    const activeTab = document.querySelector(`.pseo-tab-btn[data-target="${targetId}"]`);
    const targetPanel = document.getElementById(targetId);
    if (activeTab && targetPanel) {
      tabBtns.forEach(t => t.classList.remove("active"));
      tabPanels.forEach(p => p.classList.remove("active"));
      activeTab.classList.add("active");
      targetPanel.classList.add("active");
    }
  }

  const hash = window.location.hash;
  if (hash) {
    switchTab(hash.substring(1));
  }

  window.addEventListener("hashchange", () => {
    const currentHash = window.location.hash;
    if (currentHash) {
      switchTab(currentHash.substring(1));
    }
  });

  tabBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      const target = btn.getAttribute("data-target");
      switchTab(target);
      history.pushState(null, null, '#' + target);
    });
  });

  // Close modal when clicking outside content box
  const modal = document.getElementById('campaign-modal');
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        closeCampaignModal();
      }
    });
  }

  const bulkModal = document.getElementById('bulk-import-modal');
  if (bulkModal) {
    bulkModal.addEventListener('click', (e) => {
      if (e.target === bulkModal) {
        closeBulkImportModal();
      }
    });
  }

  // --- Initialize TinyMCE for pSEO Content Template Editor ---
  if (typeof tinymce !== "undefined" && document.getElementById('modal-content-template')) {
    tinymce.init({
      selector: '#modal-content-template',
      height: 480,
      plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code fullscreen',
      skin: 'oxide-dark',
      content_css: 'dark',
      content_style: 'body { font-family:Montserrat,sans-serif; color:#fff; } a { color: #34d399 !important; text-decoration: underline !important; } a:hover { color: #fff !important; }',
      branding: false,
      promotion: false,
      images_upload_url: '<?php echo $basePath; ?>/admin/admin.php?upload_tinymce_image=1',
      automatic_uploads: true,
      setup: function (editor) {
          editor.on('change keyup input', function () {
              editor.save(); // Sync back to standard textarea for post submission
              updateSeoChecks(); // Update SEO Checklist
          });
      }
    });
  }

  // --- Dedicated Campaign Editor Live updates ---
  const inputsToBind = ['modal-keyword', 'modal-title-templates', 'modal-content-template', 'modal-phone', 'modal-website', 'modal-type'];
  inputsToBind.forEach(id => {
      const el = document.getElementById(id);
      if (el) {
          el.addEventListener('input', updateSeoChecks);
          el.addEventListener('change', updateSeoChecks);
      }
  });

  // Load placeholders & initial SEO analysis on load
  const typeEl = document.getElementById('modal-type');
  if (typeEl) {
      updateModalPlaceholders(typeEl.value);
      updateSeoChecks();
  }

  // --- AJAX Transactional Rebuild Manager ---
  const btnStart = document.getElementById("btn-rebuild-start");
  const btnPause = document.getElementById("btn-rebuild-pause");
  const btnResume = document.getElementById("btn-rebuild-resume");
  const btnCancel = document.getElementById("btn-rebuild-cancel");
  
  const progressContainer = document.getElementById("ajax-progress-container");
  const statusText = document.getElementById("progress-status-text");
  const percentageText = document.getElementById("progress-percentage-text");
  const fill = document.getElementById("progress-bar-fill");
  const counterText = document.getElementById("progress-counter-text");
  const speedText = document.getElementById("progress-speed-text");
  
  let totalItems = 0;
  let totalChunks = 0;
  let chunkSize = 400;
  let currentChunk = 0;
  let isPaused = false;
  let isCancelled = false;
  let startTime = 0;
  let itemsImported = 0;

  if (btnStart) {
    btnStart.addEventListener("click", () => {
      if (!confirm("Bắt đầu biên dịch chéo toàn bộ dữ liệu địa danh và dự án chung cư? Quá trình sẽ lập chỉ mục tĩnh an toàn và không gây gián đoạn hoạt động của trang web.")) return;
      
      isPaused = false;
      isCancelled = false;
      currentChunk = 0;
      itemsImported = 0;
      startTime = Date.now();
      
      progressContainer.style.display = "block";
      btnStart.style.display = "none";
      
      btnPause.style.display = "inline-flex";
      btnResume.style.display = "none";
      
      statusText.innerText = "Đang kết nối để khởi tạo cơ sở dữ liệu tạm thời (pseo_index_temp)...";
      percentageText.innerText = "0%";
      fill.style.width = "0%";
      counterText.innerText = "Đang xử lý...";
      speedText.innerText = "Tốc độ: Đang tính...";

      const data = new FormData();
      data.append("action", "rebuild_ajax_init");
      
      fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", {
        method: "POST",
        body: data
      })
      .then(res => res.json())
      .then(res => {
        if (res.status === 'success') {
          totalItems = res.total_items;
          chunkSize = res.chunk_size;
          totalChunks = res.total_chunks;
          statusText.innerText = "Khởi tạo thành công! Đang import " + totalItems.toLocaleString() + " địa danh và chung cư.";
          counterText.innerText = "Đã import: 0 / " + totalItems.toLocaleString() + " địa bàn";
          
          startTime = Date.now();
          processNextChunk();
        } else {
          alert("Lỗi khởi tạo: " + res.message);
          resetUI();
        }
      })
      .catch(err => {
        alert("Lỗi kết nối máy chủ: " + err.message);
        resetUI();
      });
    });
  }

  if (btnPause) {
    btnPause.addEventListener("click", () => {
      isPaused = true;
      btnPause.style.display = "none";
      btnResume.style.display = "inline-flex";
      statusText.innerText = "Đã tạm dừng tiến trình! Bạn có thể kiểm tra dữ liệu và bấm Tiếp tục bất kỳ lúc nào.";
    });
  }

  if (btnResume) {
    btnResume.addEventListener("click", () => {
      isPaused = false;
      btnPause.style.display = "inline-flex";
      btnResume.style.display = "none";
      statusText.innerText = "Đang tiếp tục nạp dữ liệu vệ tinh...";
      processNextChunk();
    });
  }

  if (btnCancel) {
    btnCancel.addEventListener("click", () => {
      isCancelled = true;
      statusText.innerText = "Đang dừng lập tức và khôi phục CSDL cũ...";
      
      const data = new FormData();
      data.append("action", "rebuild_ajax_cancel");
      
      fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", {
        method: "POST",
        body: data
      })
      .then(() => {
        alert("Đã dừng import! Cơ sở dữ liệu vệ tinh cũ được giữ nguyên vẹn 100%.");
        resetUI();
      })
      .catch(() => {
        resetUI();
      });
    });
  }

  function processNextChunk() {
    if (isPaused || isCancelled) return;

    statusText.innerText = "Đang import gói dữ liệu " + (currentChunk + 1) + " / " + totalChunks + "...";
    
    const data = new FormData();
    data.append("action", "rebuild_ajax_chunk");
    data.append("chunk_index", currentChunk);
    data.append("chunk_size", chunkSize);

    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", {
      method: "POST",
      body: data
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        itemsImported += res.imported;
        currentChunk++;

        const pct = Math.min(Math.round((itemsImported / totalItems) * 100), 100);
        percentageText.innerText = pct + "%";
        fill.style.width = pct + "%";
        counterText.innerText = "Đã import: " + itemsImported.toLocaleString() + " / " + totalItems.toLocaleString() + " địa bàn";
        
        const elapsedSeconds = (Date.now() - startTime) / 1000;
        const speed = elapsedSeconds > 0 ? Math.round(itemsImported / elapsedSeconds) : 0;
        speedText.innerText = "Tốc độ: " + speed.toLocaleString() + " mục/giây";

        if (currentChunk < totalChunks && !isCancelled) {
          processNextChunk();
        } else if (currentChunk >= totalChunks && !isCancelled) {
          finalizeRebuild();
        }
      } else {
        alert("Lỗi import chunk " + currentChunk + ": " + res.message);
        resetUI();
      }
    })
    .catch(err => {
      alert("Lỗi mạng khi import chunk " + currentChunk + ": " + err.message);
      resetUI();
    });
  }

  function finalizeRebuild() {
    statusText.innerText = "Biên dịch hoàn tất 100%! Đang áp dụng CSDL mới chớp nhoáng (zero-downtime)...";
    
    const data = new FormData();
    data.append("action", "rebuild_ajax_finalize");
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", {
      method: "POST",
      body: data
    })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        statusText.innerText = "Thành công! Tải lại trang sau 1.5s...";
        setTimeout(() => {
          window.location.href = "admin.php?p=pseo";
        }, 1500);
      } else {
        alert("Lỗi khi áp dụng CSDL mới: " + res.message);
        resetUI();
      }
    })
    .catch(err => {
      alert("Lỗi mạng khi áp dụng CSDL mới: " + err.message);
      resetUI();
    });
  }

  function resetUI() {
    progressContainer.style.display = "none";
    btnStart.style.display = "inline-flex";
  }

  // ====================================================
  // --- CLIENT-SIDE IMPORT TASK MANAGER ---
  // ====================================================
  
  // 1. Client-side status filtering
  const filterBtns = document.querySelectorAll(".btn-filter-status");
  filterBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      filterBtns.forEach(b => {
        b.classList.remove("active");
        b.style.background = "rgba(255,255,255,0.03)";
        b.style.color = "var(--color-text-muted)";
      });
      btn.classList.add("active");
      btn.style.background = "var(--color-primary)";
      btn.style.color = "#000";
      
      const filterValue = btn.getAttribute("data-filter");
      const rows = document.querySelectorAll(".import-task-row");
      
      rows.forEach(row => {
        if (filterValue === "all" || row.getAttribute("data-status") === filterValue) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  });

  // 2. Select All Checkboxes
  const selectAllChk = document.getElementById("import-select-all");
  if (selectAllChk) {
    selectAllChk.addEventListener("change", () => {
      const isChecked = selectAllChk.checked;
      const checkboxes = document.querySelectorAll(".import-row-checkbox");
      checkboxes.forEach(chk => {
        const row = chk.closest("tr");
        if (row && row.style.display !== "none") {
          chk.checked = isChecked;
        }
      });
    });
  }

  // 3. Bulk Actions Apply
  const btnBulkApply = document.getElementById("btn-import-bulk-apply");
  if (btnBulkApply) {
    btnBulkApply.addEventListener("click", () => {
      const action = document.getElementById("import-bulk-action").value;
      if (!action) {
        alert("Vui lòng chọn hành động!");
        return;
      }
      
      const checkedBoxes = document.querySelectorAll(".import-row-checkbox:checked");
      if (checkedBoxes.length === 0) {
        alert("Vui lòng chọn ít nhất một chiến dịch!");
        return;
      }
      
      if (action === "reset") {
        if (!confirm("Bạn có chắc chắn muốn đặt lại trạng thái của các chiến dịch đã chọn? Dữ liệu tiến trình cũ sẽ bị xóa.")) return;
        
        let processed = 0;
        const total = checkedBoxes.length;
        
        checkedBoxes.forEach(chk => {
          const id = chk.value;
          const data = new FormData();
          data.append("action", "import_campaign_reset");
          data.append("campaign_id", id);
          
          fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
          .then(res => res.json())
          .then(res => {
            processed++;
            if (processed === total) {
              alert("Đã đặt lại thành công " + total + " chiến dịch!");
              window.location.reload();
            }
          });
        });
      }
    });
  }

  // 4. Modal Log Viewer
  const logModal = document.getElementById("import-log-modal");
  const logContent = document.getElementById("log-modal-content");
  const logTitle = document.getElementById("log-modal-campaign-title");
  let activeLogCampaignId = 0;

  function showLogModal(campaignId) {
    activeLogCampaignId = campaignId;
    logContent.innerText = "Đang tải nhật ký...";
    logModal.style.display = "flex";
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo&action=import_campaign_get_log&campaign_id=" + campaignId)
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        logTitle.innerText = res.keyword;
        logContent.innerText = res.log;
        setTimeout(() => {
          logContent.scrollTop = logContent.scrollHeight;
        }, 50);
      } else {
        logContent.innerText = "Lỗi: " + res.message;
      }
    })
    .catch(err => {
      logContent.innerText = "Lỗi kết nối máy chủ: " + err.message;
    });
  }

  document.querySelectorAll(".act-import-log").forEach(link => {
    link.addEventListener("click", () => {
      const id = link.getAttribute("data-id");
      showLogModal(id);
    });
  });

  const btnCloseModal = document.getElementById("btn-close-log-modal");
  if (btnCloseModal) {
    btnCloseModal.addEventListener("click", () => logModal.style.display = "none");
  }
  const btnCloseModalFooter = document.getElementById("btn-close-log-modal-footer");
  if (btnCloseModalFooter) {
    btnCloseModalFooter.addEventListener("click", () => logModal.style.display = "none");
  }
  const btnRefreshLog = document.getElementById("btn-refresh-modal-log");
  if (btnRefreshLog) {
    btnRefreshLog.addEventListener("click", () => {
      if (activeLogCampaignId > 0) {
        showLogModal(activeLogCampaignId);
      }
    });
  }

  if (logModal) {
    logModal.addEventListener("click", (e) => {
      if (e.target === logModal) {
        logModal.style.display = "none";
      }
    });
  }

  // 5. Delete Campaign Link
  document.querySelectorAll(".act-import-delete").forEach(link => {
    link.addEventListener("click", () => {
      const id = link.getAttribute("data-id");
      if (confirm("Bạn có chắc chắn muốn xóa chiến dịch này vĩnh viễn?")) {
        const data = new FormData();
        data.append("action", "delete_campaign");
        data.append("id", id);
        
        fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
        .then(() => {
          window.location.reload();
        });
      }
    });
  });

  // 6. Loop-based Campaign Import
  let activeCampId = 0;
  let campTotalItems = 0;
  let campTotalChunks = 0;
  let campChunkSize = 200;
  let campCurrentChunk = 0;
  let campIsPaused = false;
  let campItemsImported = 0;
  let campRowEl = null;

  function setRowStatusUI(row, status) {
    row.setAttribute("data-status", status);
    const wrap = row.querySelector(".badge-status-wrap");
    const actions = row.querySelector(".row-actions");
    
    if (status === 'running') {
      wrap.innerHTML = `<span style="background:rgba(255,193,7,0.1); color:#ffc107; border:1px solid rgba(255,193,7,0.25); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;"><span class="pulse-dot" style="background-color:#ffc107;"></span>Đang chạy</span>`;
      actions.querySelector(".act-import-start").style.display = "none";
      actions.querySelector(".act-import-resume").style.display = "none";
      actions.querySelector(".act-import-pause").style.display = "inline";
      if (actions.querySelector(".act-import-reset")) actions.querySelector(".act-import-reset").style.display = "inline";
    } else if (status === 'paused') {
      wrap.innerHTML = `<span style="background:rgba(0,150,255,0.1); color:#33b3ff; border:1px solid rgba(0,150,255,0.25); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;">Tạm dừng</span>`;
      actions.querySelector(".act-import-start").style.display = "none";
      actions.querySelector(".act-import-resume").style.display = "inline";
      actions.querySelector(".act-import-pause").style.display = "none";
      if (actions.querySelector(".act-import-reset")) actions.querySelector(".act-import-reset").style.display = "inline";
    } else if (status === 'completed') {
      wrap.innerHTML = `<span style="background:rgba(76,175,80,0.1); color:#4caf50; border:1px solid rgba(76,175,80,0.25); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;"><i class="fas fa-check-circle" style="font-size:10px;"></i>Hoàn thành</span>`;
      actions.querySelector(".act-import-start").style.display = "none";
      actions.querySelector(".act-import-resume").style.display = "none";
      actions.querySelector(".act-import-pause").style.display = "none";
      if (actions.querySelector(".act-import-reset")) actions.querySelector(".act-import-reset").style.display = "inline";
    } else {
      wrap.innerHTML = `<span style="background:rgba(255,255,255,0.05); color:var(--color-text-muted); border:1px solid rgba(255,255,255,0.1); padding:4px 8px; border-radius:4px; font-weight:700; text-transform:uppercase; display:inline-flex; align-items:center; gap:5px;">Chưa chạy</span>`;
      actions.querySelector(".act-import-start").style.display = "inline";
      actions.querySelector(".act-import-resume").style.display = "none";
      actions.querySelector(".act-import-pause").style.display = "none";
      if (actions.querySelector(".act-import-reset")) actions.querySelector(".act-import-reset").style.display = "none";
    }
  }

  function startCampaignImport(id) {
    if (activeCampId > 0 && activeCampId !== id && !campIsPaused) {
      alert("Đang có một tiến trình import khác đang chạy. Vui lòng tạm dừng tiến trình kia trước!");
      return;
    }
    
    activeCampId = id;
    campIsPaused = false;
    campCurrentChunk = 0;
    campItemsImported = 0;
    campRowEl = document.querySelector(`.import-task-row[data-id="${id}"]`);
    
    setRowStatusUI(campRowEl, 'running');
    
    const data = new FormData();
    data.append("action", "import_campaign_init");
    data.append("campaign_id", id);
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        campTotalItems = res.total_items;
        campChunkSize = res.chunk_size;
        campTotalChunks = res.total_chunks;
        
        campRowEl.querySelector(".col-expected").innerText = campTotalItems.toLocaleString();
        campRowEl.querySelector(".col-created").innerText = "0";
        campRowEl.querySelector(".progress-bar-fill").style.width = "0%";
        campRowEl.querySelector(".progress-percent-txt").innerText = "0%";
        
        const nowStr = new Date().toISOString().slice(0, 19).replace('T', ' ');
        campRowEl.querySelector(".col-start").innerText = nowStr;
        campRowEl.querySelector(".col-end").innerText = "--";
        
        processCampaignChunk();
      } else {
        alert("Lỗi khởi tạo: " + res.message);
        setRowStatusUI(campRowEl, 'not_started');
        activeCampId = 0;
      }
    })
    .catch(err => {
      alert("Lỗi mạng: " + err.message);
      setRowStatusUI(campRowEl, 'not_started');
      activeCampId = 0;
    });
  }

  function processCampaignChunk() {
    if (campIsPaused || activeCampId === 0) return;
    
    const data = new FormData();
    data.append("action", "import_campaign_chunk");
    data.append("campaign_id", activeCampId);
    data.append("chunk_index", campCurrentChunk);
    data.append("chunk_size", campChunkSize);
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        campItemsImported += res.imported;
        campCurrentChunk++;
        
        const pct = Math.min(Math.round((campItemsImported / campTotalItems) * 100), 100);
        campRowEl.querySelector(".col-created").innerText = campItemsImported.toLocaleString();
        campRowEl.querySelector(".progress-bar-fill").style.width = pct + "%";
        campRowEl.querySelector(".progress-percent-txt").innerText = pct + "%";
        
        if (campCurrentChunk < campTotalChunks && res.imported > 0) {
          processCampaignChunk();
        } else {
          finalizeCampaignImport();
        }
      } else {
        alert("Lỗi import gói dữ liệu: " + res.message);
        setRowStatusUI(campRowEl, 'paused');
      }
    })
    .catch(err => {
      alert("Lỗi mạng khi import: " + err.message);
      setRowStatusUI(campRowEl, 'paused');
    });
  }

  function pauseCampaignImport(id) {
    if (activeCampId !== id) return;
    campIsPaused = true;
    
    const data = new FormData();
    data.append("action", "import_campaign_pause");
    data.append("campaign_id", id);
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
    .then(() => {
      setRowStatusUI(campRowEl, 'paused');
    });
  }

  function resumeCampaignImport(id) {
    activeCampId = id;
    campIsPaused = false;
    campRowEl = document.querySelector(`.import-task-row[data-id="${id}"]`);
    
    setRowStatusUI(campRowEl, 'running');
    
    const created = parseInt(campRowEl.querySelector(".col-created").innerText.replace(/,/g, '')) || 0;
    const expected = parseInt(campRowEl.querySelector(".col-expected").innerText.replace(/,/g, '')) || 1;
    
    campItemsImported = created;
    campTotalItems = expected;
    campChunkSize = 200;
    campTotalChunks = Math.ceil(expected / campChunkSize);
    campCurrentChunk = Math.floor(created / campChunkSize);
    
    const data = new FormData();
    data.append("action", "import_campaign_resume");
    data.append("campaign_id", id);
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        processCampaignChunk();
      } else {
        alert("Lỗi: " + res.message);
        setRowStatusUI(campRowEl, 'paused');
      }
    });
  }

  function resetCampaignImport(id) {
    if (!confirm("Bạn có chắc muốn đặt lại trạng thái import chiến dịch này? Tiến trình và thời gian chạy cũ sẽ bị xóa hết.")) return;
    
    if (activeCampId === id) {
      activeCampId = 0;
      campIsPaused = true;
    }
    
    const row = document.querySelector(`.import-task-row[data-id="${id}"]`);
    
    const data = new FormData();
    data.append("action", "import_campaign_reset");
    data.append("campaign_id", id);
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        setRowStatusUI(row, 'not_started');
        row.querySelector(".col-created").innerText = "0";
        row.querySelector(".col-expected").innerText = "0";
        row.querySelector(".progress-bar-fill").style.width = "0%";
        row.querySelector(".progress-percent-txt").innerText = "0%";
        row.querySelector(".col-start").innerText = "--";
        row.querySelector(".col-end").innerText = "--";
      }
    });
  }

  function finalizeCampaignImport() {
    const data = new FormData();
    data.append("action", "import_campaign_finalize");
    data.append("campaign_id", activeCampId);
    
    fetch("<?php echo $basePath; ?>/admin/admin.php?p=pseo", { method: "POST", body: data })
    .then(res => res.json())
    .then(res => {
      if (res.status === 'success') {
        setRowStatusUI(campRowEl, 'completed');
        const nowStr = new Date().toISOString().slice(0, 19).replace('T', ' ');
        campRowEl.querySelector(".col-end").innerText = nowStr;
        activeCampId = 0;
        alert("Đã hoàn thành import chiến dịch thành công!");
      }
    });
  }

  // Bind actions click triggers
  document.querySelectorAll(".act-import-start").forEach(btn => {
    btn.addEventListener("click", () => {
      const id = parseInt(btn.getAttribute("data-id"));
      startCampaignImport(id);
    });
  });

  document.querySelectorAll(".act-import-pause").forEach(btn => {
    btn.addEventListener("click", () => {
      const id = parseInt(btn.getAttribute("data-id"));
      pauseCampaignImport(id);
    });
  });

  document.querySelectorAll(".act-import-resume").forEach(btn => {
    btn.addEventListener("click", () => {
      const id = parseInt(btn.getAttribute("data-id"));
      resumeCampaignImport(id);
    });
  });

  document.querySelectorAll(".act-import-reset").forEach(btn => {
    btn.addEventListener("click", () => {
      const id = parseInt(btn.getAttribute("data-id"));
      resetCampaignImport(id);
    });
  });  // On page load: If there is an active/running import task, auto-resume it!
  document.querySelectorAll(".import-task-row[data-status='running']").forEach(row => {
    const id = parseInt(row.getAttribute("data-id"));
    setTimeout(() => {
      resumeCampaignImport(id);
    }, 500);
  });
});
</script>






