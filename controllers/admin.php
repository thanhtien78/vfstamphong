<?php
/**
 * VinFast Central Administrative MVC Front Controller
 * Handles CSRF, login gates, AJAX endpoints for media libraries, routing, and modular views rendering.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';
require_once 'includes/admin-helpers.php';
$basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');

// Ensure CSRF token is generated for the session
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// CSRF validation for all admin POST requests (except TinyMCE image upload AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_GET['upload_tinymce_image'])) {
        $postToken = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $postToken)) {
            header('HTTP/1.1 403 Forbidden');
            die("Xác thực bảo mật (CSRF Token) không hợp lệ hoặc đã hết hạn! Vui lòng quay lại, tải lại trang (F5) và thử lại.");
        }
    }
}

// Enable Output Buffering to automatically inject CSRF tokens into all forms
ob_start(function($output) {
    if (!empty($_SESSION['csrf_token'])) {
        $token = $_SESSION['csrf_token'];
        $input = "\n" . '<input type="hidden" name="csrf_token" value="' . $token . '">';
        // Match both single/double quotes, and cases where action comes before/after method
        $output = preg_replace('/(<form\b[^>]*method=["\']post["\'][^>]*>)/i', '$1' . $input, $output);
    }
    return $output;
});

// Auth validation gate - blocks unauthorized viewing
if (!isset($_SESSION['user_id'])) {
    $basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
    header('Location: ' . $basePath . '/login');
    exit;
}

// AJAX API endpoint for TinyMCE local image uploads (direct drag and drop / browse inserts)
if (isset($_GET['upload_tinymce_image'])) {
    header('Content-Type: application/json');
    $uploadError = null;
    $uploaded = handleImageUpload('file', '', $uploadError);
    if ($uploaded) {
        echo json_encode(['location' => $uploaded]);
    } else {
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(['error' => $uploadError ?: 'Không thể tải lên hình ảnh.']);
    }
    exit;
}

// AJAX API endpoint to fetch all files in the Media Library for the WordPress-style picker
if (isset($_GET['get_media_library_files'])) {
    header('Content-Type: application/json');
    $uploadsDir = dirname(__DIR__) . '/assets/uploads';
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
                            'url' => 'assets/uploads/' . $basename,
                            'name' => $basename,
                            'time' => filemtime($file),
                            'size' => filesize($file)
                        ];
                    }
                }
            }
            // Sort by file modification time DESC (newest first)
            usort($mediaFiles, function($a, $b) {
                return $b['time'] - $a['time'];
            });
        }
    }
    echo json_encode($mediaFiles);
    exit;
}

$page = isset($_GET['p']) ? trim($_GET['p']) : 'dashboard';

// Backward compatibility redirectors
if ($page === 'cars') {
    $page = 'inventory';
} elseif ($page === 'leads') {
    $page = 'appointments';
}

// Active User session data
$userId = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch();

// Security Gate: Restrict administrative pages to Quản trị viên role only
$sensitivePages = ['branding', 'pseo'];
if (in_array($page, $sensitivePages) && ($currentUser['role'] ?? '') !== 'Quản trị viên') {
    $page = 'dashboard';
    $errorMessage = 'Bạn không có quyền truy cập vào khu vực cấu hình này!';
}

// Retrieve all Sales specialists for lead assignment
$stmtSales = $db->prepare("SELECT * FROM users WHERE role = ? OR role = ? ORDER BY fullname ASC");
$stmtSales->execute(['Chuyên viên Sale', 'Quản trị viên']);
$salesStaff = $stmtSales->fetchAll();

// Retrieve all Technicians for service assignment
$stmtTechs = $db->prepare("SELECT * FROM users WHERE role = ? OR role = ? ORDER BY fullname ASC");
$stmtTechs->execute(['Kỹ thuật viên', 'Quản trị viên']);
$techStaff = $stmtTechs->fetchAll();

// ----------------------------------------------------
// PAGE ROUTER ACTIONS (POST request handlers)
// ----------------------------------------------------
$successMessage = '';
$errorMessage = '';

// ==========================================
// DYNAMIC MODULE CONTROLLERS ROUTING
// ==========================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'includes/cache.php';
    PageCache::clear();
    $action = isset($_POST['action']) ? trim($_POST['action']) : '';
    
    $allowedControllers = ['media', 'inventory', 'appointments', 'crm', 'service', 'cms', 'settings', 'branding', 'counselors', 'pseo'];
    if (in_array($page, $allowedControllers) && file_exists(dirname(__DIR__) . "/admin/controllers/{$page}.php")) {
        require dirname(__DIR__) . "/admin/controllers/{$page}.php";
    }
}

// ----------------------------------------------------
// RENDERING DYNAMIC MODULAR LAYOUT
// ----------------------------------------------------
include dirname(__DIR__) . '/admin/views/layout/header.php';
include dirname(__DIR__) . '/admin/views/layout/sidebar.php';
?>

<!-- RIGHT CONTENT AREA -->
<main class="content-area">
  
  <!-- Top Nav Header -->
  <header class="header-bar">
    <h1 class="header-bar__title">
      <?php 
        if ($page === 'dashboard') echo 'Tổng quan hệ thống (Dashboard)';
        elseif ($page === 'inventory') echo 'Quản lý Kho xe đại lý';
        elseif ($page === 'appointments') echo 'Quản lý Lịch hẹn & Đăng ký Lái thử';
        elseif ($page === 'crm') echo 'Quản trị quan hệ khách hàng (CRM)';
        elseif ($page === 'service') echo 'Quản lý Dịch vụ sửa chữa & Bảo dưỡng';
        elseif ($page === 'cms') echo 'Quản lý Nội dung & Thiết lập SEO';
        elseif ($page === 'media') echo 'Thư viện ảnh & Media máy chủ';
        elseif ($page === 'branding') echo 'Cấu hình giao diện Header & Footer';
        elseif ($page === 'counselors') echo 'Quản lý Đội ngũ tư vấn & Hỗ trợ VIP';
        elseif ($page === 'settings') echo 'Cấu hình hệ thống & Phân quyền tài khoản';
        elseif ($page === 'pseo') echo 'Quản lý Programmatic Local SEO PRO';
      ?>
    </h1>
    <a href="index.php" target="_blank" class="btn-gold" style="font-size: 11px; padding: 8px 16px;" rel="noopener">
      <span>Xem Trang Chủ</span>
    </a>
  </header>

  <!-- Notification banners -->
  <?php if ($successMessage): ?>
    <div class="alert-banner alert-banner--success">
      <span>✓ <?php echo htmlspecialchars($successMessage); ?></span>
    </div>
  <?php endif; ?>

  <?php if ($errorMessage): ?>
    <div class="alert-banner alert-banner--error">
      <span>✗ <?php echo htmlspecialchars($errorMessage); ?></span>
    </div>
  <?php endif; ?>

  <!-- DYNAMIC VIEW ROUTER -->
  <?php
  $allowedViews = ['dashboard', 'inventory', 'appointments', 'crm', 'service', 'cms', 'settings', 'branding', 'counselors', 'media', 'pseo'];
  if (in_array($page, $allowedViews) && file_exists(dirname(__DIR__) . "/admin/views/{$page}.php")) {
      require dirname(__DIR__) . "/admin/views/{$page}.php";
  } else {
      echo "<div class='card__title'>Trang không tồn tại hoặc bạn không có quyền truy cập!</div>";
  }
  ?>

<?php
include dirname(__DIR__) . '/admin/views/layout/media-picker.php';
include dirname(__DIR__) . '/admin/views/layout/footer.php';
?>
