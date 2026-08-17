<?php
/**
 * Controller for route: local-seo
 */

/**
 * VinFast Programmatic Local SEO Engine (pSEO) - Unified & Upgraded PRO Edition
 * Dynamically generates 20,000+ high-ranking local landing pages on the fly
 * covering every commune/ward/district/province (including old geographical names before 2025)
 * and every premium condominium/apartment project in Vietnam with ZERO database bloat!
 * Integrates directly with CRM car prices so all local pages update prices in real-time.
 */

require_once 'includes/class-pseo-helper.php';


// Initialize session to detect logged-in administrators
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isAdmin = isset($_SESSION['user_id']);

// Fetch global operational status
$pseoStatus = 'live';
try {
    $stmtStatus = $db->query("SELECT value FROM settings WHERE `key` = 'pseo_status' LIMIT 1");
    $val = $stmtStatus->fetchColumn();
    if ($val) {
        $pseoStatus = $val;
    }
} catch (Exception $e) {}

// Google Indexation Shield: Immediately serve 503 if maintenance/draft mode is toggled (bypass for logged-in admins)
if ($pseoStatus === 'draft' && !$isAdmin) {
    header('HTTP/1.1 503 Service Unavailable');
    header('Retry-After: 3600');
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Hệ thống tạm ngưng hoạt động</title><style>body{background:#0a0e15;color:#fff;font-family:-apple-system,BlinkMacSystemFont,sans-serif;text-align:center;padding:100px 20px;}h1{color:#1960d7;font-size:28px;}p{color:#8a99ad;font-size:16px;max-width:600px;margin:20px auto;line-height:1.6;}</style></head><body><h1>Hệ thống vệ tinh pSEO đang bảo trì</h1><p>Hệ thống vệ tinh cào pSEO đang được tạm đóng để nâng cấp và tối ưu hóa nội dung nhằm mang lại thông tin chính xác nhất. Vui lòng quay lại sau.</p></body></html>';
    exit;
}



// Helper function to decode URL slugs back to human-readable names (legacy fallback)
function decodeLocalSlug($slug) {
    $slug = str_replace('-', ' ', $slug);
    
    // Auto-capitalize first letters for clean display
    $words = explode(' ', $slug);
    $capitalized = [];
    foreach ($words as $word) {
        if (in_array(strtolower($word), ['tp', 'hcm', 'hn', 'qn', 'dna'])) {
            $capitalized[] = strtoupper($word);
        } else {
            $capitalized[] = mb_convert_case($word, MB_CASE_TITLE, "UTF-8");
        }
    }
    $decoded = implode(' ', $capitalized);
    
    // Standard geographic prefix corrections
    $decoded = str_replace(['Quan ', 'quan '], 'Quận ', $decoded);
    $decoded = str_replace(['Phuong ', 'phuong '], 'Phường ', $decoded);
    $decoded = str_replace(['Xa ', 'xa '], 'Xã ', $decoded);
    $decoded = str_replace(['Huyen ', 'huyen '], 'Huyện ', $decoded);
    $decoded = str_replace(['Tinh ', 'tinh '], 'Tỉnh ', $decoded);
    $decoded = str_replace(['Tp ', 'tp '], 'TP. ', $decoded);
    
    return $decoded;
}

// 1. Capture dynamic URL parameters
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : 'gia-xe-VinFast-tai-quan-1-tp-hcm';

// 2. Identify pSEO Type & Campaign keywords
$customKeywords = PSEO_Helper::getCustomKeywords(!$isAdmin);
$matchedKeyword = null;
$locSlug = '';
$relation = 'tai';

// Scan registered keywords list to find the match
foreach ($customKeywords as $kwSlug => $kw) {
    if (preg_match('/^' . preg_quote($kwSlug, '/') . '-(tai|gan)-(.*)$/i', $slug, $matches)) {
        $matchedKeyword = $kw;
        $relation = $matches[1];
        $locSlug = $matches[2];
        break;
    }
}

// Security & SEO Shield: Return 404 for guests if no campaign matched or if not imported/published
if (!$matchedKeyword) {
    if (!$isAdmin) {
        header("HTTP/1.1 404 Not Found");
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Trang không tìm thấy - 404</title><style>body{background:#0a0e15;color:#fff;font-family:-apple-system,BlinkMacSystemFont,sans-serif;text-align:center;padding:100px 20px;}h1{color:#1960d7;font-size:48px;margin-bottom:10px;}p{color:#8a99ad;font-size:16px;max-width:600px;margin:20px auto;line-height:1.6;}a{color:#1960d7;text-decoration:none;border:1px solid #1960d7;padding:10px 20px;border-radius:4px;display:inline-block;margin-top:20px;transition:0.3s;}a:hover{background:#1960d7;color:#000;}</style></head><body><h1>404</h1><p>Bài viết thuộc chiến dịch này không tồn tại hoặc chưa được xuất bản chính thức.</p><a href="/vfstamphong/">Quay lại trang chủ</a></body></html>';
        exit;
    } else {
        // Logged-in admin preview fallback guessing
        if (preg_match('/^(.*)-(tai|gan)-(.*)$/i', $slug, $matches)) {
            $keywordSlug = $matches[1];
            $relation = $matches[2];
            $locSlug = $matches[3];
            
            $matchedKeyword = [
                'slug' => $keywordSlug,
                'label' => str_replace('-', ' ', $keywordSlug),
                'title' => '',
                'desc' => '',
                'content' => '',
                'import_created' => 0,
                'import_status' => 'not_started'
            ];
        } else {
            $locSlug = $slug;
            $matchedKeyword = [
                'slug' => 'gia-xe-VinFast',
                'label' => 'Bảng giá xe VinFast',
                'title' => '',
                'desc' => '',
                'content' => '',
                'import_created' => 0,
                'import_status' => 'not_started'
            ];
        }
    }
}

// Use high-performance PSEO_Helper for smart lookups
$match = PSEO_Helper::findLocationOrProject($locSlug);

// If location not in db index, return 404 for guests to prevent orphan/thin crawler indexation
if (!$match) {
    if (!$isAdmin) {
        header("HTTP/1.1 404 Not Found");
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Địa phương không tồn tại - 404</title><style>body{background:#0a0e15;color:#fff;font-family:-apple-system,BlinkMacSystemFont,sans-serif;text-align:center;padding:100px 20px;}h1{color:#1960d7;font-size:48px;margin-bottom:10px;}p{color:#8a99ad;font-size:16px;max-width:600px;margin:20px auto;line-height:1.6;}a{color:#1960d7;text-decoration:none;border:1px solid #1960d7;padding:10px 20px;border-radius:4px;display:inline-block;margin-top:20px;transition:0.3s;}a:hover{background:#1960d7;color:#000;}</style></head><body><h1>404</h1><p>Địa bàn, commune hoặc chung cư được chỉ định không được hỗ trợ trong hệ thống.</p><a href="/vfstamphong/">Quay lại trang chủ</a></body></html>';
        exit;
    } else {
        $locationName = decodeLocalSlug($locSlug);
        $isProject = false;
        $projectData = null;
        $locationType = 'location';
    }
} else {
    $locationName = $match['display_name'];
    $locationType = $match['type'];
    $isProject = ($locationType === 'chungcu');
    $projectData = $isProject ? $match['meta_data'] : null;
}

$isPriceSEO = (strpos($matchedKeyword['slug'], 'dai-ly') === false && strpos($matchedKeyword['slug'], 'showroom') === false);
$seoType = $matchedKeyword['label'];
$interestRate = 6.9; // Default interest rate for calculator widgets

if (empty($locationName)) {
    $locationName = "TP. Hồ Chí Minh";
}

try {
    // 3. Fetch real-time car catalog prices from database (including slug, power, acceleration, description)
    $stmtCars = $db->query("SELECT id, model_name, segment, price, engine, range_wltp, image, slug, power, acceleration, description FROM cars ORDER BY id ASC");
    $cars = $stmtCars->fetchAll();
} catch (Exception $e) {
    $cars = [];
}

$counselors = [];
try {
    // Try to find counselor specifically assigned to this location slug
    $locSlugClean = strtolower(trim($locSlug));
    $stmtC = $db->prepare("SELECT * FROM counselors WHERE status = 'ONLINE' AND (assigned_areas LIKE ? OR assigned_areas LIKE ? OR assigned_areas LIKE ? OR assigned_areas = ?)");
    $stmtC->execute(["%," . $locSlugClean . ",%", $locSlugClean . ",%", "%," . $locSlugClean, $locSlugClean]);
    $counselors = $stmtC->fetchAll();

    // Fallback: If no counselors assigned to this area, get default online counselors
    if (empty($counselors)) {
        $stmtC = $db->query("SELECT * FROM counselors WHERE status = 'ONLINE' LIMIT 2");
        $counselors = $stmtC->fetchAll();
    }
} catch (Exception $e) {
    try {
        $stmtC = $db->query("SELECT * FROM counselors WHERE status = 'ONLINE' LIMIT 2");
        $counselors = $stmtC->fetchAll();
    } catch (Exception $ex) {}
}

// 4. Fetch custom pSEO settings from settings table
$pseoSettings = [];
try {
    $stmtSettings = $db->query("SELECT * FROM settings WHERE `key` LIKE 'pseo_%'");
    while ($row = $stmtSettings->fetch()) {
        $pseoSettings[$row['key']] = $row['value'];
    }
} catch (Exception $e) {}

// Replaces phone number and website link placeholders dynamically
$pseo_phone_global = $pseoSettings['pseo_phone'] ?? '0975510794';
$pseo_website_global = $pseoSettings['pseo_website'] ?? 'https://example.com';

$phoneVal = !empty($matchedKeyword['phone_number']) ? $matchedKeyword['phone_number'] : $pseo_phone_global;
$websiteVal = !empty($matchedKeyword['website_link']) ? $matchedKeyword['website_link'] : $pseo_website_global;
$keywordVal = $matchedKeyword['keyword'] ?? $matchedKeyword['label'] ?? '';

// Define the calculator card HTML as a function to render it dynamically in both sidebar and main content
if (!function_exists('renderInstallmentCalculator')) {
    function renderInstallmentCalculator($locationName, $cars, $interestRate, $isMobileInstance = false) {
        $instanceClass = $isMobileInstance ? 'pseo-calculator-card-mobile' : 'pseo-calculator-card-sidebar';
        ob_start();
        ?>
        <div class="vip-local-card vip-local-card-calculator <?php echo $instanceClass; ?>" style="border-color: rgba(25, 96, 215,0.25); background: linear-gradient(135deg, rgba(25, 96, 215,0.03) 0%, rgba(10,14,21,0.98) 100%);">
          <h3 class="vip-local-title" style="font-size: 15px; display: flex; align-items: center; justify-content: center; gap: 8px; font-family: 'Montserrat', sans-serif !important;">
            <?php echo get_svg_icon('fa-calculator', 14, 14, 'vertical-align: middle; color: var(--color-primary);'); ?>
            Ước Tính Trả Góp Trực Tuyến
          </h3>
          <p class="vip-local-desc" style="font-size: 12px; margin-bottom: 15px; text-align: center;">
            Tính toán nhanh phương án tài chính hàng tháng dành riêng cho khách hàng tại <?php echo htmlspecialchars($locationName); ?>:
          </p>
          
          <div style="display: flex; flex-direction: column; gap: 12px; text-align: left;">
            <div style="display: flex; flex-direction: column; gap: 5px;">
              <label style="font-size: 10px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Dòng xe quan tâm</label>
              <select class="calc-car-select" style="background: rgba(0,0,0,0.4); border: 1px solid var(--color-border); border-radius: 6px; padding: 8px 12px; font-size: 12.5px; color: #fff; width: 100%; outline: none; cursor: pointer; transition: var(--transition-normal);" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
                <?php foreach ($cars as $car): ?>
                  <option value="<?php echo htmlspecialchars($car['price']); ?>" style="background: #0b0e14; color: #fff;">
                    <?php echo htmlspecialchars($car['model_name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 5px;">
              <label style="font-size: 10px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tỷ lệ vay từ ngân hàng</label>
              <select class="calc-ratio-select" style="background: rgba(0,0,0,0.4); border: 1px solid var(--color-border); border-radius: 6px; padding: 8px 12px; font-size: 12.5px; color: #fff; width: 100%; outline: none; cursor: pointer; transition: var(--transition-normal);" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
                <option value="80" selected style="background: #0b0e14; color: #fff;">Vay tối đa 80% giá trị xe</option>
                <option value="75" style="background: #0b0e14; color: #fff;">Vay 75% giá trị xe</option>
                <option value="70" style="background: #0b0e14; color: #fff;">Vay 70% giá trị xe</option>
                <option value="60" style="background: #0b0e14; color: #fff;">Vay 60% giá trị xe</option>
                <option value="50" style="background: #0b0e14; color: #fff;">Vay 50% giá trị xe</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 5px;">
              <label style="font-size: 10px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Thời hạn vay trả góp</label>
              <select class="calc-term-select" style="background: rgba(0,0,0,0.4); border: 1px solid var(--color-border); border-radius: 6px; padding: 8px 12px; font-size: 12.5px; color: #fff; width: 100%; outline: none; cursor: pointer; transition: var(--transition-normal);" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
                <option value="8" selected style="background: #0b0e14; color: #fff;">8 năm (96 tháng) - Lâu nhất</option>
                <option value="7" style="background: #0b0e14; color: #fff;">7 năm (84 tháng)</option>
                <option value="5" style="background: #0b0e14; color: #fff;">5 năm (60 tháng)</option>
                <option value="3" style="background: #0b0e14; color: #fff;">3 năm (36 tháng)</option>
              </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 5px;">
              <label style="font-size: 10px; color: var(--color-primary); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Lãi suất ưu đãi (%/năm)</label>
              <input type="number" class="calc-interest-input" value="<?php echo $interestRate; ?>" step="0.1" min="1" max="25" style="background: rgba(0,0,0,0.4); border: 1px solid var(--color-border); border-radius: 6px; padding: 8px 12px; font-size: 12.5px; color: #fff; width: 100%; outline: none; transition: var(--transition-normal);" onfocus="this.style.borderColor='var(--color-primary)';" onblur="this.style.borderColor='var(--color-border)';">
            </div>
          </div>

          <!-- Calculation outputs area -->
          <div style="background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.03); border-radius: 8px; padding: 15px; margin-top: 15px; text-align: left; display: flex; flex-direction: column; gap: 8px;">
            <div style="display: flex; justify-content: space-between; font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 6px;">
              <span style="color: var(--color-text-muted);">Giá xe niêm yết:</span>
              <span class="calc-res-listed" style="color: #fff; font-weight: 600;">0 VNĐ</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.03); padding-bottom: 6px;">
              <span style="color: var(--color-text-muted);">Hạn mức vay vốn:</span>
              <span class="calc-res-loan" style="color: #fff; font-weight: 600;">0 VNĐ</span>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 5px; gap: 2px;">
              <span style="color: var(--color-primary); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Gốc + Lãi tháng đầu (Ước tính)</span>
              <span class="calc-res-monthly" style="color: var(--color-primary); font-size: 18px; font-weight: 700; font-family: 'Montserrat', sans-serif !important;">0 VNĐ</span>
              <span style="color: rgba(255,255,255,0.3); font-size: 10px; font-style: italic; text-align: center; width: 100%;">*Áp dụng lãi suất ưu đãi <span class="calc-res-interest"><?php echo $interestRate; ?></span>%/năm</span>
            </div>
          </div>

          <a href="#pseo-sidebar-card" style="display: block; width: 100%; background: var(--color-primary); color: #000; padding: 10px 0; border-radius: 6px; font-size: 12px; font-weight: 700; text-transform: uppercase; text-decoration: none; margin-top: 15px; transition: var(--transition-normal); text-align: center;" onmouseover="this.style.boxShadow='0 0 15px rgba(25, 96, 215, 0.4)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
            Đăng ký nhận bảng tính chi tiết
          </a>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Fallbacks for Titles & Meta Descriptions
$defaultTitlePrice = "{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất Tại|Giá Lăn Bánh Xe Ô Tô VinFast Ưu Đãi Tại|Bảng Báo Giá Xe VinFast Mới Nhất Ở} {LOCATION} | Giao Xe Tận Nhà";
$defaultTitleDealer = "{Đại Lý Xe VinFast Chính Hãng Tại|Showroom Ủy Quyền VinFast 5 Sẵn Sàng Phục Vụ Tại|Đại Lý Ủy Quyền Đạt Chuẩn Showroom VinFast 3S Tại} {LOCATION} | VIP Service";
$defaultDescPrice = "Xem chi tiết bảng giá niêm yết và tính giá lăn bánh xe điện VinFast EV, VF 8, VF 9 mới nhất tại {LOCATION}. Chương trình khuyến mãi đặc quyền, trả góp 80% lãi suất ưu đãi.";
$defaultDescDealer = "Đại lý ủy quyền 5 sao của VinFast phục vụ khu vực {LOCATION}. Đăng ký lái thử xe tại nhà riêng, cứu hộ kỹ thuật khẩn cấp 24/7, phòng chờ VIP showroom tiện nghi.";

$titleTemplate = $matchedKeyword['title_templates'] ?? $matchedKeyword['title'] ?? '';
$descTemplate = $matchedKeyword['desc'] ?? '';
$contentTemplate = $matchedKeyword['content_template'] ?? $matchedKeyword['content'] ?? '';

// Fallback to settings or default strings if empty
if (empty($titleTemplate)) {
    if ($matchedKeyword['slug'] === 'gia-xe-VinFast') {
        $titleTemplate = !empty($pseoSettings['pseo_title_price']) ? $pseoSettings['pseo_title_price'] : $defaultTitlePrice;
    } elseif ($matchedKeyword['slug'] === 'dai-ly-VinFast') {
        $titleTemplate = !empty($pseoSettings['pseo_title_dealer']) ? $pseoSettings['pseo_title_dealer'] : $defaultTitleDealer;
    } else {
        $titleTemplate = $isPriceSEO 
            ? "{" . $keywordVal . " Mới Nhất Tại|Tính " . $keywordVal . " Ưu Đãi Tại} {LOCATION} | Giao Xe Tận Nhà"
            : "{" . $keywordVal . " Chính Hãng Tại|Địa Chỉ " . $keywordVal . " Ở} {LOCATION} | VIP Service";
    }
}

if (empty($descTemplate)) {
    if ($matchedKeyword['slug'] === 'gia-xe-VinFast') {
        $descTemplate = !empty($pseoSettings['pseo_desc_price']) ? $pseoSettings['pseo_desc_price'] : $defaultDescPrice;
    } elseif ($matchedKeyword['slug'] === 'dai-ly-VinFast') {
        $descTemplate = !empty($pseoSettings['pseo_desc_dealer']) ? $pseoSettings['pseo_desc_dealer'] : $defaultDescDealer;
    } else {
        $descTemplate = "Xem chi tiết và nhận tư vấn về " . mb_strtolower($keywordVal, 'UTF-8') . " tại {LOCATION}. Chương trình khuyến mãi đặc quyền cực kỳ ưu đãi.";
    }
}

// Special overrides for residential condominium/apartment projects if core campaigns are active
if ($isProject && $matchedKeyword['slug'] === 'gia-xe-VinFast') {
    $titleTemplate = "{Bảng Giá Xe VinFast Lăn Bánh Mới Nhất Gần|Giá Xe VinFast Ưu Đãi Cực Tốt Tại Khu Vực|Báo Giá Lăn Bánh Xe VinFast Chi Tiết Gần} {LOCATION} | Giao Xe Tận Nhà";
    $descTemplate = "Xem chi tiết bảng giá lăn bánh các mẫu xe điện VinFast EV, VF 8, VF 9 cực kỳ ưu đãi dành riêng cho cư dân sống tại {LOCATION}. Hỗ trợ mua trả góp lãi suất thấp.";
} elseif ($isProject && $matchedKeyword['slug'] === 'dai-ly-VinFast') {
    $titleTemplate = "{Đại Lý Ủy Quyền Xe VinFast Chính Hãng Gần|Showroom Trải Nghiệm Xe Điện VinFast Gần|Dịch Vụ Chăm Sóc Khách Hàng VinFast Gần} {LOCATION}";
    $descTemplate = "Showroom đại diện ủy quyền VinFast chính hãng hân hạnh phục vụ cư dân tại {LOCATION}. Đăng ký lái thử tại nhà riêng, cứu hộ kỹ thuật 24/7 và giao nhận xe bảo dưỡng tận nơi.";
}

// Support Multi-Line Titles (Choose one random title from multi-line text)
$titleLines = array_filter(array_map('trim', explode("\n", $titleTemplate)));
if (!empty($titleLines)) {
    $titleTemplate = $titleLines[array_rand($titleLines)];
}

// Support Multi-Line Descriptions
$descLines = array_filter(array_map('trim', explode("\n", $descTemplate)));
if (!empty($descLines)) {
    $descTemplate = $descLines[array_rand($descLines)];
}

// Resolve geography details for placeholders
$wardFullName = '';
$provinceName = '';
$wardName = '';
$districtName = '';
$projectName = '';
$chuDauTu = '';
$diaChi = '';
$quyMo = '';

if ($match) {
    $meta = $match['meta_data'];
    $locationType = $match['type'];
    if ($locationType === 'chungcu') {
        $projectName = $meta['ten_du_an'] ?? '';
        $chuDauTu = $meta['chu_dau_tu'] ?? '';
        $diaChi = $meta['dia_chi'] ?? '';
        $quyMo = $meta['quy_mo'] ?? '';
    } elseif ($locationType === 'location') {
        $wardFullName = $meta['ward'] ?? '';
        $provinceName = $meta['province'] ?? '';
    } elseif ($locationType === 'diadanhcu') {
        $wardName = $meta['ward'] ?? '';
        $districtName = $meta['district'] ?? '';
        $provinceName = $meta['province'] ?? '';
    }
}

// Graceful fallbacks for empty placeholders
if (empty($wardFullName)) $wardFullName = $locationName;
if (empty($provinceName)) $provinceName = $locationName;
if (empty($wardName)) $wardName = $locationName;
if (empty($districtName)) $districtName = $locationName;
if (empty($projectName)) $projectName = $locationName;

// Dynamic Date/Quarter Tokens (Freshness SEO)
$currentMonth = date('n'); // 1-12
$currentYear = date('Y');  // e.g. 2026
$currentQuarter = ceil($currentMonth / 3);

$placeholderMap = [
    '{KEYWORD}' => $keywordVal,
    '{PHONE_NUMBER}' => $phoneVal,
    '{WEBSITE_LINK}' => $websiteVal,
    '{LOCATION}' => $locationName,
    '{WARD_FULL_NAME}' => $wardFullName,
    '{PROVINCE_NAME}' => $provinceName,
    '{WARD_NAME}' => $wardName,
    '{DISTRICT_NAME}' => $districtName,
    '{PROJECT_NAME}' => $projectName,
    '{CHU_DAU_TU}' => $chuDauTu,
    '{DIA_CHI}' => $diaChi,
    '{QUY_MO}' => $quyMo,
    '{month}' => $currentMonth,
    '{year}' => $currentYear,
    '{quarter}' => $currentQuarter,
    '{MONTH}' => 'Tháng ' . $currentMonth,
    '{YEAR}' => $currentYear,
    '{QUARTER}' => 'Quý ' . $currentQuarter
];

// Add dynamic car prices from CRM catalog to placeholder map (Freshness SEO)
if (isset($cars) && is_array($cars)) {
    foreach ($cars as $car) {
        if (!empty($car['slug'])) {
            $placeholderMap['{price_' . $car['slug'] . '}'] = $car['price'];
        }
    }
}

// Text interpolation helper function for dynamic heading/FAQ token replacements
if (!function_exists('interpolate_pseo_text')) {
    function interpolate_pseo_text($text) {
        global $placeholderMap;
        if (empty($text)) return '';
        return str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $text);
    }
}

// Perform replacements
$titleTemplate = str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $titleTemplate);
$descTemplate = str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $descTemplate);

// Process templates through spintax engine
$siteTitle = PSEO_Helper::processSpintax($titleTemplate);
$siteDesc = PSEO_Helper::processSpintax($descTemplate);
$siteKeywords = "$slug, " . mb_strtolower($keywordVal, 'UTF-8') . " tai $locationName, " . mb_strtolower($keywordVal, 'UTF-8') . " gan $locationName";

// Pick dynamic campaign featured image randomly from selected pool
$selectedImage = '';
if (!empty($matchedKeyword['image_ids'])) {
    $images = array_filter(array_map('trim', explode(',', $matchedKeyword['image_ids'])));
    if (!empty($images)) {
        $selectedImage = $images[array_rand($images)];
    }
}

// 5. Generate custom spun body copy
$spunContentParagraph = '';
if (!empty($contentTemplate)) {
    $contentTemplate = str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $contentTemplate);
    $spunContentParagraph = PSEO_Helper::processSpintax($contentTemplate);
} else {
    if ($isProject && !empty($projectData)) {
        $projText = !empty($pseoSettings['pseo_content_project']) ? $pseoSettings['pseo_content_project'] : "<h3>{Đặc quyền di chuyển|Chính sách đặc quyền|Ưu đãi cư dân cao cấp|Chương trình di chuyển xanh} dành riêng cho cư dân sinh sống tại <strong>{LOCATION}</strong></h3><p>{VinFast Việt Nam|Đại lý ủy quyền|Ban quản lý dự án cùng đại lý} hân hạnh mang đến chương trình ưu đãi {phục vụ đặc quyền|VIP đặc chế|lái thử xe xanh|hỗ trợ tài chính đặc biệt} cho toàn bộ cư dân sinh sống tại <strong>{LOCATION}</strong>. Với mong muốn mang lại {giải pháp di chuyển xanh vượt trội|sự tiện lợi tuyệt đối|không gian sống xanh thông minh|trải nghiệm xe điện tương lai}, chúng tôi hỗ trợ {giao xe lái thử tại nhà riêng|dịch vụ cứu hộ kỹ thuật 24/7 tận nơi|hướng dẫn vận hành sạc pin tại nhà} hoàn toàn miễn phí.</p><p>{Đặc biệt|Đáng chú ý|Hơn thế nữa}, cư dân sở hữu xe điện VinFast sẽ được hỗ trợ {lắp đặt trạm sạc tại chỗ|áp dụng gói thuê pin ưu đãi doanh nghiệp|đặc quyền sạc pin nhanh tại hầm gửi xe} cùng {dịch vụ bảo dưỡng giao nhận xe tận nhà|sự đồng hành trực tiếp từ đội ngũ cố vấn VIP|chính sách ưu tiên xử lý dịch vụ tại xưởng} giúp hành trình di chuyển luôn diễn ra hoàn mỹ nhất.</p>";
        $projText = str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $projText);
        $spunContentParagraph = PSEO_Helper::processSpintax($projText);
    } elseif ($isPriceSEO) {
        $priceText = !empty($pseoSettings['pseo_content_price']) ? $pseoSettings['pseo_content_price'] : "<h3>{Đại lý|Showroom|Cửa hàng ủy quyền 3S|Hệ thống phân phối|Đại lý ủy quyền 5S} VinFast {Tam Phong|Chính Hãng|Việt Nam|3S} {hân hạnh cập nhật|cung cấp|gửi tới quý khách|công bố|giới thiệu} {báo giá|bảng giá lăn bánh|bảng báo giá chi tiết|biểu phí đăng ký} {mới nhất|cập nhật mới|thời hạn 2026} cho dòng xe {ô tô điện|xe điện thông minh|các dòng xe EV|xe xanh tự động} tại {khu vực|địa bàn|thị trường|địa phương} <strong>{LOCATION}</strong></h3><p>{Thương hiệu ô tô điện|Hãng xe điện|Hệ sinh thái di chuyển xanh} VinFast {Việt Nam|chính hãng|Tam Phong} {đang ngày càng khẳng định vị thế|đang tạo nên làn sóng xanh|đang dẫn đầu xu hướng xe thông minh} {mạnh mẽ tại thị trường|với các dòng xe thông minh thế hệ mới|trên mọi cung đường tại Việt Nam}. {Để phục vụ tối ưu cho quý khách hàng|Nhằm đem lại sự thuận tiện tốt nhất cho cư dân|Với mong muốn hỗ trợ tối đa cho người mua xe|Nhằm tối ưu hóa trải nghiệm khách hàng} tại <strong>{LOCATION}</strong>, chúng tôi {xin gửi tới|hân hạnh công bố|cung cấp nhanh|đồng bộ thông tin} {bảng giá niêm yết|báo giá chính thức|chương trình giá ưu đãi|biểu phí mua xe} {được cập nhật trực tiếp từ hệ thống CRM|được đồng bộ từ nhà sản xuất|mới nhất từ tổng công ty} trong tháng {month}/{year}.</p><p>{Khi mua xe điện VinFast|Lựa chọn sở hữu các dòng xe thông minh này|Sở hữu xe điện thương hiệu Việt}, quý khách hàng {không chỉ nhận được|sẽ được đặc quyền áp dụng|sẽ được hưởng trọn} {chính sách miễn 100% lệ phí trước bạ|ưu đãi thuế trước bạ 0% của Chính phủ|chính sách hỗ trợ lệ phí đăng ký} giúp tiết kiệm {hàng chục đến hàng trăm triệu đồng|khoản ngân sách lăn bánh cực kỳ lớn|chi phí xuống đường tối đa}. Bên cạnh đó là {gói ưu đãi miễn phí sạc công cộng V-Green|chính sách bảo hành chính hãng lên tới 10 năm hoặc 200.000km|hệ thống hỗ trợ kỹ thuật lưu động 24/7} {giúp tối ưu chi phí sử dụng vượt trội|mang lại sự an tâm tuyệt đối trên mọi hành trình|tạo điều kiện sử dụng thuận lợi nhất}.</p>";
        $priceText = str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $priceText);
        $spunContentParagraph = PSEO_Helper::processSpintax($priceText);
    } else {
        $dealerText = !empty($pseoSettings['pseo_content_dealer']) ? $pseoSettings['pseo_content_dealer'] : "<h3>{Không gian trưng bày|Showroom đại lý ủy quyền|Điểm trải nghiệm xe điện|Trung tâm dịch vụ đạt chuẩn} VinFast {Tam Phong|3S|ủy quyền chính hãng} phục vụ quý khách tại <strong>{LOCATION}</strong></h3><p>{Nhằm đáp ứng nhu cầu|Để hỗ trợ tốt nhất cho trải nghiệm|Với mong muốn đem lại sự thuận tiện|Nhằm gia tăng cơ hội trải nghiệm} {tìm hiểu và đăng ký lái thử|mua sắm và bảo dưỡng xe điện|tư vấn chuyên sâu các dòng xe xanh|trải nghiệm các tính năng ADAS thông minh} của khách hàng tại <strong>{LOCATION}</strong>, {chúng tôi cung cấp|đại lý mang đến|showroom thiết lập|VinFast Tam Phong triển khai} {dịch vụ chuẩn 5 sao toàn cầu|hệ thống phục vụ chuyên nghiệp đạt tiêu chuẩn VinFast Terminal|quy trình phục vụ VIP khép kín|tiêu chuẩn phục vụ thượng lưu}. {Showroom được trang bị|Đại lý sở hữu|Trung tâm trải nghiệm tích hợp|Không gian trưng bày} {khu trưng bày xe sang trọng|không gian trải nghiệm đẳng cấp châu Âu|phòng trưng bày đầy đủ mẫu xe mới nhất|khu vực lái thử đa dạng}, {xưởng dịch vụ kỹ thuật cao|phòng chờ VIP Lounge sang trọng|khu kỹ thuật sửa chữa nhanh|khu vực đồng sơn hiện đại} cùng {kho phụ tùng thay thế chính hãng luôn sẵn sàng|hệ thống sạc siêu nhanh DC công suất lớn|đội ngũ nhân viên đạt chuẩn đào tạo quốc tế|chính sách hỗ trợ đăng ký đăng kiểm trọn gói} phục vụ.</p><p>{Đặc biệt|Đáng chú ý|Hơn thế nữa}, quý khách hàng tại <strong>{LOCATION}</strong> {sẽ được phục vụ|có thể đăng ký|được áp dụng chính sách} {chính sách lái thử xe tại nhà riêng hoặc cơ quan miễn phí|dịch vụ cứu hộ khẩn cấp 24/7 của V-Green|giao nhận xe bảo trì tận nhà} cùng {quy trình giao nhận xe bảo trì tận nơi|sự đồng hành trọn đời của đội ngũ kỹ thuật viên chuyên nghiệp|chế độ bảo hành chính hãng dài hạn nhất thị trường} {để đảm bảo hành trình luôn thông suốt|mang lại trải nghiệm sở hữu xe hoàn mỹ nhất|giúp bạn an tâm di chuyển xanh}.</p>";
        $dealerText = str_ireplace(array_keys($placeholderMap), array_values($placeholderMap), $dealerText);
        $spunContentParagraph = PSEO_Helper::processSpintax($dealerText);
    }
}

if (!empty($spunContentParagraph)) {
    // Automatically wrap tables in a responsive container with a pulsing "VUỐT ĐỂ SO SÁNH" visual hint pill above them for mobile viewports
    $spunContentParagraph = preg_replace('/<table(.*?)>(.*?)<\/table>/is', '
      <div class="swipe-hint-container">
        <div class="swipe-hint-btn">
          VUỐT ĐỂ SO SÁNH ↔
        </div>
      </div>
      <div class="seo-price-table-container"><table$1>$2</table></div>
    ', $spunContentParagraph);
}

$pageBodyClass = 'page-local-seo';

return get_defined_vars();





