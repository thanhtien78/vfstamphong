<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/**
 * VinFast Premium Header Module
 * Hand-coded dynamic navigation header and SEO controller.
 */

// Resilient settings loader and global variable binder
global $db, $settings;
require_once __DIR__ . '/../db.php';

if (!isset($settings)) {
    try {
        $stmt = $db->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }
    } catch (Exception $e) {
        $settings = [];
    }
}

// Resolve host and base directory dynamically with robust fallbacks
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? '') == 443) ? "https://" : "http://";
$domain = $protocol . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
$baseUrl = $domain . $basePath;

// Dynamic SEO URL formatting helper to ensure absolute root-relative links across virtual folders
if (!function_exists('seo_url')) {
    function seo_url($url) {
        global $basePath;
        $url = trim($url);
        if (empty($url) || 
            preg_match('/^(https?:\/\/|tel:|mailto:|javascript:|zalo:|#)/i', $url) ||
            strpos($url, '/') === 0) {
            return $url;
        }
        
        // Parse query string and path
        $parts = parse_url($url);
        $path = $parts['path'] ?? '';
        $query = isset($parts['query']) ? '?' . $parts['query'] : '';
        $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';

        // Dynamic rewrite for local SEO query links to pretty SEO URLs
        if ($path === 'local-seo.php') {
            parse_str($parts['query'] ?? '', $queryParams);
            if (isset($queryParams['slug'])) {
                $slug = $queryParams['slug'];
                unset($queryParams['slug']);
                $newQuery = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                return rtrim($basePath, '/') . '/' . trim($slug, '/') . '.html' . $newQuery . $fragment;
            }
        }

        // Mapping from PHP files to SEO slugs
        $slugMap = [
            'index.php'       => '',
            'about.php'       => 'gioi-thieu',
            'cars.php'        => 'dong-xe-vinfast',
            'pricelist.php'   => 'bang-gia-xe-vinfast',
            'installment.php' => 'mua-xe-tra-gop',
            'news.php'        => 'tin-tuc-su-kien',
            'admin.php'       => 'admin',
            'login.php'       => 'login',
            'logout.php'      => 'logout'
        ];

        if (isset($slugMap[$path])) {
            $path = $slugMap[$path];
        }

        // Construct absolute root-relative URL
        $cleanPath = '/' . trim($path, '/');
        if ($cleanPath === '/') {
            $cleanPath = '';
        }

        $finalUrl = rtrim($basePath, '/') . $cleanPath . $query . $fragment;
        
        return ($finalUrl === '') ? '/' : $finalUrl;
    }
}

// Global helper to serve optimized dynamic thumbnails
if (!function_exists('get_thumb_url')) {
    function get_thumb_url($url, $width = 400) {
        $url = trim($url);
        if (empty($url)) {
            return seo_url('assets/uploads/vinfast-banner-len-doi.webp');
        }
        if (preg_match('#^(https?://|//)#i', $url)) {
            return $url;
        }
        return seo_url($url);
    }
}

// Global configurations & SEO Meta fallbacks
$siteTitle = isset($siteTitle) ? $siteTitle : ($settings['site_title'] ?? "VinFast Tam Phong - Đại Lý Ủy Quyền VinFast Chính Hãng");
$siteDesc = isset($siteDesc) ? $siteDesc : ($settings['site_desc'] ?? "Khám phá các mẫu xe ô tô điện VinFast chính hãng, bảng giá xe mới nhất, ưu đãi trả góp và trải nghiệm lái thử tại Đại lý VinFast Tam Phong.");
$siteKeywords = isset($siteKeywords) ? $siteKeywords : ($settings['site_keywords'] ?? "VinFast, VinFast Tam Phong, gia xe VinFast, xe dien VinFast, VF3, VF5, VF6, VF7, VF8, VF9");

$agencyPhone = $settings['agency_phone'] ?? "081.7777.855";

// Automatically identify active navigation link with robust fallback for CLI caching
if (!isset($currentPage) || empty($currentPage)) {
    $currentPage = basename($_SERVER['PHP_SELF'] ?? '');
    if ($currentPage === '-' || empty($currentPage) || $currentPage === 'cli' || $currentPage === 'warm_cache.php') {
        $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $currentPage = basename($uriPath);
    }
    if (empty($currentPage) || $currentPage === '/' || $currentPage === 'vfstamphong') {
        $currentPage = 'index.php';
    }
}

// Resolve sharing metadata for Facebook/Zalo (Open Graph)
// Dynamic SEO template engine for automated, real-time titles and descriptions
if (!function_exists('interpolate_seo_meta')) {
    function interpolate_seo_meta($string, $context = []) {
        if (empty($string)) return '';
        
        $month = date('n'); // 1 - 12
        $year = date('Y');
        
        $replacements = [
            '{month}' => $month,
            '{year}' => $year,
        ];
        
        // Fetch all car prices once to support dynamic {price_slug} replacements
        global $db;
        static $carPrices = null;
        if ($carPrices === null) {
            $carPrices = [];
            try {
                $stmtCars = $db->query("SELECT slug, price FROM cars");
                while ($c = $stmtCars->fetch()) {
                    if (!empty($c['slug'])) {
                        $carPrices['{price_' . $c['slug'] . '}'] = $c['price'];
                    }
                }
            } catch (Exception $e) {}
        }
        
        // Merge car prices replacements
        if (!empty($carPrices)) {
            $replacements = array_merge($replacements, $carPrices);
        }
        
        foreach ($context as $key => $val) {
            if (is_scalar($val)) {
                $replacements['{' . $key . '}'] = $val;
            }
        }
        
        return str_replace(array_keys($replacements), array_values($replacements), $string);
    }
}

// Build context for dynamic SEO interpolation
$seoContext = [];
if ($currentPage === 'car-detail.php' && isset($car)) {
    $seoContext = [
        'model' => $car['model_name'] ?? '',
        'name' => $car['model_name'] ?? '',
        'price' => $car['price'] ?? '',
        'engine' => $car['engine'] ?? '',
        'segment' => $car['segment'] ?? '',
        'status' => (isset($car['stock_status']) && $car['stock_status'] === 'in_stock') ? 'Sẵn xe giao ngay' : 'Đặt hàng trước'
    ];
} elseif ($currentPage === 'news-detail.php' && isset($post)) {
    $seoContext = [
        'title' => $post['title'] ?? '',
        'category' => $post['category'] ?? ''
    ];
}

// Apply real-time interpolation to SEO tags
$siteTitle = interpolate_seo_meta($siteTitle, $seoContext);
$siteDesc = interpolate_seo_meta($siteDesc, $seoContext);
$siteKeywords = interpolate_seo_meta($siteKeywords, $seoContext);

$shareTitle = $siteTitle;
$shareDesc = $siteDesc;

$rawShareImage = '';
if ($currentPage === 'car-detail.php' && isset($car['image'])) {
    $rawShareImage = $car['image'];
} elseif ($currentPage === 'news-detail.php' && isset($post['image'])) {
    $rawShareImage = $post['image'];
} else {
    $rawShareImage = $settings['site_og_image'] ?? ($settings['dealer_image'] ?? 'assets/uploads/showroom.webp');
}

// Convert relative image path to absolute URL
if (!empty($rawShareImage)) {
    if (strpos($rawShareImage, 'http://') === 0 || strpos($rawShareImage, 'https://') === 0) {
        $shareImage = $rawShareImage;
    } else {
        $shareImage = rtrim($baseUrl, '/') . '/' . ltrim($rawShareImage, '/');
    }
} else {
    $shareImage = rtrim($baseUrl, '/') . '/assets/uploads/showroom.webp';
}

$shareUrl = $domain . ($_SERVER['REQUEST_URI'] ?? '');

// Define high-performance global SVG helper to replace FontAwesome completely and boost Lighthouse to 100
if (!function_exists('get_svg_icon')) {
    function get_svg_icon($class, $width = 24, $height = 24, $extraStyles = '') {
        $class = trim(strtolower($class));
        $styleStr = $extraStyles ? ' style="' . htmlspecialchars($extraStyles) . '"' : '';
        
        // Handle common FontAwesome mapping with optimized path elements
        if (strpos($class, 'fa-phone-alt') !== false || strpos($class, 'fa-phone') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>';
        } elseif (strpos($class, 'fa-file-alt') !== false || strpos($class, 'fa-file') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>';
        } elseif (strpos($class, 'fa-car') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 1 13v3c0 .6.4 1 1 1h2" /><circle cx="7" cy="17" r="2" /><circle cx="17" cy="17" r="2" /><path d="M7 17h10" /></svg>';
        } elseif (strpos($class, 'fa-arrow-up') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>';
        } elseif (strpos($class, 'fa-pencil-ruler') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" /><path d="m15 5 4 4" /><path d="m19 11-8 8" /><path d="m19 15-4 4" /></svg>';
        } elseif (strpos($class, 'fa-bolt') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>';
        } elseif (strpos($class, 'fa-crown') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><path d="M2 4 5 12h14l3-8-7 4-3-6-3 6-7-4z" /><path d="M5 20h14a2 2 0 0 0 2-2V16H3v2a2 2 0 0 0 2 2z" /></svg>';
        } elseif (strpos($class, 'fa-check') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><polyline points="20 6 9 17 4 12"></polyline></svg>';
        } elseif (strpos($class, 'fa-comment-dots') !== false || strpos($class, 'fa-comment') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>';
        } elseif (strpos($class, 'fa-calculator') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="9" y1="22" x2="15" y2="22"></line><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01M12 10h.01M8 10h.01M12 14h.01M8 14h.01M12 18h.01M8 18h.01"></path></svg>';
        } elseif (strpos($class, 'fa-chevron-down') !== false) {
            return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><polyline points="6 9 12 15 18 9"></polyline></svg>';
        }
        
        // Standard fallback is a checkmark SVG
        return '<svg viewBox="0 0 24 24" width="' . $width . '" height="' . $height . '" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"' . $styleStr . '><polyline points="20 6 9 17 4 12"></polyline></svg>';
    }
}



// Menu links mapping
$menuItems = [
    'index.php' => 'Trang chủ',
    'cars.php' => 'Dòng xe',
    'pricelist.php' => 'Bảng giá',
    'installment.php' => 'Trả góp',
    'news.php' => 'Tin tức',
    'about.php' => 'Giới thiệu'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($siteTitle); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($siteDesc); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars($siteKeywords); ?>">
  <?php if (!empty($seoCanonical)): ?>
  <link rel="canonical" href="<?php echo htmlspecialchars($seoCanonical); ?>">
  <?php else: ?>
  <link rel="canonical" href="<?php echo htmlspecialchars($domain . strtok($_SERVER['REQUEST_URI'], '?')); ?>">
  <?php endif; ?>
  <link rel="icon" type="image/x-icon" href="<?php echo seo_url('assets/favicon/favicon.ico'); ?>">

  <!-- Open Graph Protocol Meta Tags for Facebook & Zalo Link Sharing -->
  <meta property="og:type" content="<?php echo ($currentPage === 'news-detail.php') ? 'article' : 'website'; ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($shareTitle); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($shareDesc); ?>">
  <meta property="og:image" content="<?php echo htmlspecialchars($shareImage); ?>">
  <meta property="og:image:alt" content="<?php echo htmlspecialchars($shareTitle); ?>">
  <meta property="og:url" content="<?php echo htmlspecialchars($shareUrl); ?>">
  <meta property="og:site_name" content="<?php echo htmlspecialchars($settings['agency_name'] ?? 'VinFast Việt Nam'); ?>">
  <meta property="og:locale" content="vi_VN">

  <!-- Twitter Card Protocol Meta Tags for Twitter/X Sharing -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo htmlspecialchars($shareTitle); ?>">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($shareDesc); ?>">
  <meta name="twitter:image" content="<?php echo htmlspecialchars($shareImage); ?>">
  
  <!-- Premium LCP Image Preload Engine for Instant LCP Rendering -->
  <?php if ($currentPage === 'index.php' || $currentPage === ''): ?>
    <?php 
    $heroImg = $settings['hero_banner_image'] ?? "https://emea-dam.VinFast.com/adobe/assets/urn:aaid:aem:a59d8df2-ff26-4e5c-9c71-f9d2243d6dbf/as/A242941_large.jpg?preferwebp=true";
    ?>
    <link rel="preload" as="image" href="<?php echo htmlspecialchars(seo_url($heroImg)); ?>" fetchpriority="high">
  <?php elseif ($currentPage === 'car-detail.php' && isset($car['image'])): ?>
    <link rel="preload" as="image" href="<?php echo htmlspecialchars(seo_url($car['image'])); ?>?v=2026" fetchpriority="high">
  <?php elseif ($currentPage === 'local-seo.php' && !empty($selectedImage)): ?>
    <link rel="preload" as="image" href="<?php echo htmlspecialchars(seo_url($selectedImage)); ?>" fetchpriority="high">
  <?php endif; ?>
  
  <!-- Preconnect to Google Fonts for premium loading performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap">

  <!-- Preload high-priority local variable brand fonts to eliminate font-swap layout shift -->
  <link rel="preload" href="<?php echo seo_url('assets/fonts/VinFastTypeVF.woff2'); ?>" as="font" type="font/woff2" crossorigin>


  <!-- Inline critical base CSS to eliminate all render-blocking requests and achieve 100/100 Lighthouse score -->
  <?php
  if (!function_exists('render_inlined_css')) {
      function render_inlined_css($filePath) {
          global $basePath, $settings;
          if (!file_exists($filePath)) {
              return;
          }
          // Support executing PHP inside CSS files by including them via output buffering
          ob_start();
          include $filePath;
          $css = ob_get_clean();
          
          // Rewrite relative URLs like url(../images/...) or url(../fonts/...) to use $basePath/assets/
          $css = preg_replace_callback('/url\(\s*[\'"]?\s*\.\.\/([^\'")]*)\s*[\'"]?\s*\)/i', function($matches) use ($basePath) {
              $relativePath = $matches[1];
              $absoluteUrl = rtrim($basePath, '/') . '/assets/' . $relativePath;
              return "url('" . $absoluteUrl . "')";
          }, $css);
          
          echo $css;
      }
  }
  
  $useInlinedCss = false; // Toggle to true to inline all styles, false to use standard stylesheet links with cache busting
  if ($useInlinedCss) {
      echo "<style>\n";
      render_inlined_css(__DIR__ . '/../assets/css/premium-base.css');
      echo "</style>\n";
  } else {
      echo '<link rel="stylesheet" href="' . seo_url('assets/css/premium-base.css') . '?v=' . filemtime(__DIR__ . '/../assets/css/premium-base.css') . '">' . "\n";
  }
  ?>
  <style>
    /* Clean, non-wrapping header styles */
    @media (min-width: 992px) {
      .header-container {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        max-width: 1400px !important;
        margin: 0 auto !important;
        padding: 0 40px !important;
        width: 100% !important;
        height: 100% !important; /* Force vertical centering inside header height */
        gap: 40px !important; /* Space between logo and menu */
      }
      .nav-menu {
        display: flex !important;
        align-items: center !important;
        gap: 16px !important; /* Spacing between menu items */
        margin-left: auto !important; /* Push menu to the right away from logo */
        margin-right: 15px !important;
        list-style: none !important;
        padding: 0 !important;
      }
      .nav-link {
        font-size: 13.5px !important; /* Enlarged for readability */
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        white-space: nowrap !important; /* NO WRAPPING! */
        padding: 8px 10px !important;
        transition: color 0.3s ease !important;
      }
      .premium-header .logo-link {
        margin-right: 30px !important; /* Space away from first item */
      }
    }

    /* Premium Hotline Action Button */
    .nav-btn-hotline {
      display: inline-flex !important;
      align-items: center !important;
      background: linear-gradient(135deg, #1464f4 0%, #00aaff 100%) !important;
      color: #ffffff !important;
      border: none !important;
      padding: 8px 18px !important;
      border-radius: 30px !important; /* Elegant capsule shape */
      font-size: 12px !important;
      font-weight: 800 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.8px !important;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
      text-decoration: none !important;
      box-shadow: 0 4px 12px rgba(20, 100, 244, 0.2) !important;
    }
    .nav-btn-hotline:hover {
      transform: translateY(-2px) scale(1.02) !important;
      box-shadow: 0 6px 18px rgba(20, 100, 244, 0.4) !important;
      color: #ffffff !important;
      filter: brightness(1.08) !important;
    }
    .nav-btn-hotline svg {
      stroke: #ffffff !important;
      fill: none !important;
      width: 13px !important;
      height: 13px !important;
    }

    /* Live Ticker Container Styles */
    
    .live-ticker-container {
      background: linear-gradient(90deg, rgba(11, 22, 39, 0.85) 0%, rgba(20, 100, 244, 0.15) 100%);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      color: #cbd5e1;
      height: 40px;
      display: flex;
      align-items: center;
      overflow: hidden;
      font-size: 13px;
      font-weight: 600;
      border-bottom: 2px solid rgba(56, 189, 248, 0.3);
      position: fixed;
      top: 70px !important;
      z-index: 998;
      width: 100%;
      padding: 0;
      box-sizing: border-box;
    }
    @media (max-width: 991px) {
      .live-ticker-container {
        top: 60px !important; /* matches responsive header */
        box-shadow: 0 4px 10px rgba(0,0,0,0.15) !important;
      }
    }
    .ticker-label {
      background-color: rgba(15, 32, 66, 0.9) !important; /* Deep Blue-Slate for contrast */
      color: #38bdf8 !important; /* Bright Sky Blue text */
      display: flex !important;
      align-items: center !important;
      height: 100% !important;
      padding: 0 20px !important;
      font-size: 11px !important;
      font-weight: 900 !important;
      letter-spacing: 0.5px !important;
      white-space: nowrap !important;
      z-index: 5 !important;
      box-shadow: 4px 0 10px rgba(0,0,0,0.3) !important; /* separate label from text */
    }
    .ticker-label svg {
      color: #38bdf8 !important;
      animation: pulse-blue 2s infinite ease-in-out !important; /* Pulsing brand lightning bolt */
    }
    @keyframes pulse-blue {
      0% {
        transform: scale(1);
        opacity: 1;
        filter: drop-shadow(0 0 2px rgba(56, 189, 248, 0.8));
      }
      50% {
        transform: scale(1.25);
        opacity: 0.7;
        filter: drop-shadow(0 0 8px rgba(56, 189, 248, 1));
      }
      100% {
        transform: scale(1);
        opacity: 1;
        filter: drop-shadow(0 0 2px rgba(56, 189, 248, 0.8));
      }
    }
    .ticker-wrapper {
      flex-grow: 1 !important;
      overflow: hidden !important;
      display: flex !important;
      align-items: center !important;
      position: relative !important;
      height: 100% !important;
    }
    .ticker-track {
      display: flex !important;
      align-items: center !important;
      white-space: nowrap !important;
      animation: ticker-marquee 35s linear infinite !important;
      gap: 50px !important;
      padding-left: 20px !important;
    }
    .live-ticker-container:hover .ticker-track {
      animation-play-state: paused !important; /* Pause on hover */
    }
    .ticker-item {
      display: inline-flex !important;
      align-items: center !important;
      color: #f1f5f9 !important; /* Highly readable clean slate white */
      font-size: 12.5px !important;
      font-weight: 600 !important; /* Semi-bold for better readability */
      text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important; /* Subtle shadow to prevent clashing with background */
    }
    .ticker-item strong {
      color: #38bdf8 !important; /* Highlight Sky Blue matching brand */
      font-weight: 800 !important;
      margin: 0 4px !important;
    }
    .ticker-check-icon {
      color: #38bdf8 !important; /* Bright Sky Blue checkmark */
      margin-right: 8px !important;
      flex-shrink: 0 !important;
    }
    @keyframes ticker-marquee {
      0% {
        transform: translateX(0);
      }
      100% {
        transform: translateX(-50%);
      }
    }

    /* Global Premium Dark Header Styling (Replica of diendanxecu.com) */
    .premium-header {
      background: rgba(11, 22, 39, 0.85) !important; /* Deep Tech Navy with Opacity */
      backdrop-filter: blur(12px) !important; /* Glassmorphism */
      -webkit-backdrop-filter: blur(12px) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      z-index: 1000 !important;
    }
    .premium-header .logo-link {
      color: #ffffff !important;
    }
    .premium-header .logo-link:hover {
      color: #38bdf8 !important;
    }
    .nav-link {
      color: #cbd5e1 !important; /* Light silver text */
    }
    .nav-link:hover {
      color: #ffffff !important;
    }
    .nav-link--active {
      color: #38bdf8 !important; /* Highlight tech blue */
      border-bottom: 2px solid #38bdf8 !important;
    }
    .mobile-menu-toggle .bar {
      background-color: #ffffff !important; /* Ensure hamburger menu is visible on dark background */
    }

    /* Scrolled States (Solid Dark Backgrounds for Perfect Contrast over white content) */
    .premium-header.scrolled {
      background: #070f1e !important; /* Solid dark Slate-Navy */
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .live-ticker-container.scrolled {
      background: #0b1528 !important; /* Solid dark Slate-Blue matching bottom header */
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
      border-bottom: 2px solid rgba(56, 189, 248, 0.2) !important;
    }
  /* ======================================================================
   LUXURY MOBILE HEADER & LOGO ALIGNMENT
   ====================================================================== */
@media (max-width: 768px) {
  html body .premium-header .header-container {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 0 16px !important;
    height: 60px !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }

  html body .premium-header .logo-link {
    font-size: 18px !important;
    font-weight: 900 !important;
    letter-spacing: 1.5px !important;
    color: #ffffff !important;
    font-family: 'Montserrat', sans-serif !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5), 0 0 15px rgba(20, 100, 244, 0.25) !important;
    margin: 0 !important;
    padding: 0 !important;
    white-space: nowrap !important;
    display: inline-flex !important;
    align-items: center !important;
    line-height: 1 !important;
  }

  html body .mobile-menu-toggle {
    margin-left: auto !important;
    padding: 8px !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
  }
}

  .premium-header .header-container {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    padding: 0 12px !important;
    width: 100% !important;
    box-sizing: border-box !important;
  }

  .premium-header .logo-link {
    font-size: 16.5px !important;
    letter-spacing: 1px !important;
    margin: 0 !important;
    white-space: nowrap !important;
    max-width: calc(100% - 50px) !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
  }
}
  </style>

  <!-- Page-specific Minified Stylesheet (Inlined for zero-network overhead and single-pass Style & Layout rendering) -->
  <?php
  $pageStylesheetsMap = [
      'index.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/home-sections/01_hero.css',
        'assets/css/home-sections/02_catalog.css',
        'assets/css/home-sections/04_ev_tech.css',
        'assets/css/home-sections/05_privileges.css',
        'assets/css/home-sections/06_why_dealer.css',
        'assets/css/home-sections/07_trade_in.css',
        'assets/css/home-sections/08_exclusive_offers.css',
        'assets/css/home-sections/09_counselors.css',
        'assets/css/home-sections/10_faq.css',
        'assets/css/homepage.min.css',
        'assets/css/homepage-lux-overrides.css',
        'assets/css/custom.css'
      ],
      'cars.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/home-sections/02_catalog.css',
        'assets/css/home-sections/09_counselors.css',
        'assets/css/home-sections/10_faq.css',
        'assets/css/cars.min.css',
        'assets/css/homepage-lux-overrides.css',
        'assets/css/custom.css'
      ],
      'pricelist.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/home-sections/02_catalog.css',
        'assets/css/pricelist.min.css',
        'assets/css/custom.css'
      ],
      'installment.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/installment.min.css',
        'assets/css/custom.css'
      ],
      'car-detail.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/home-sections/02_catalog.css',
        'assets/css/car-detail.min.css',
        'assets/css/homepage-lux-overrides.css',
        'assets/css/custom.css'
      ],
      'about.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/about.min.css',
        'assets/css/custom.css'
      ],
      'news.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/news.min.css',
        'assets/css/homepage-lux-overrides.css',
        'assets/css/custom.css'
      ],
      'news-detail.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/home-sections/02_catalog.css',
        'assets/css/news-detail.min.css',
        'assets/css/homepage-lux-overrides.css',
        'assets/css/custom.css'
      ],
      'local-seo.php' => [
        'assets/css/home-sections/00_base.css',
        'assets/css/home-sections/02_catalog.css',
        'assets/css/custom.css'
      ]
  ];
  
  // Robust page matching for friendly URLs and subpage routing
  $matchedCssKey = 'index.php';
  $reqUri = strtolower($_SERVER['REQUEST_URI'] ?? '');
  $curPageLower = strtolower($currentPage);

  if (str_contains($curPageLower, 'car') || str_contains($reqUri, 'dong-xe') || str_contains($reqUri, 'xe-vinfast')) {
      $matchedCssKey = 'cars.php';
  } elseif (str_contains($curPageLower, 'price') || str_contains($reqUri, 'bang-gia')) {
      $matchedCssKey = 'pricelist.php';
  } elseif (str_contains($curPageLower, 'installment') || str_contains($reqUri, 'tra-gop')) {
      $matchedCssKey = 'installment.php';
  } elseif (str_contains($curPageLower, 'about') || str_contains($reqUri, 'gioi-thieu')) {
      $matchedCssKey = 'about.php';
  } elseif (str_contains($curPageLower, 'news') || str_contains($reqUri, 'tin-tuc')) {
      $matchedCssKey = 'news.php';
  }

  $targetSheet = $pageStylesheetsMap[$currentPage] ?? $pageStylesheetsMap[$matchedCssKey] ?? $pageStylesheetsMap['index.php'];
  if ($targetSheet):
      $useInlinedCss = false; // Toggle to true to inline all styles, false to use standard stylesheet links with cache busting
      if ($useInlinedCss) {
          echo "<style>\n";
          if (is_array($targetSheet)) {
              foreach ($targetSheet as $sheet) {
                  $absolutePath = __DIR__ . '/../' . $sheet;
                  if (file_exists($absolutePath)) {
                      render_inlined_css($absolutePath);
                  }
              }
          } else {
              $absolutePath = __DIR__ . '/../' . $targetSheet;
              if (file_exists($absolutePath)) {
                  render_inlined_css($absolutePath);
              }
          }
          echo "</style>\n";
      } else {
          if (is_array($targetSheet)) {
              foreach ($targetSheet as $sheet) {
                  $absolutePath = __DIR__ . '/../' . $sheet;
                  if (file_exists($absolutePath)) {
                      echo '<link rel="stylesheet" href="' . seo_url($sheet) . '?v=' . time() . '">' . "\n";
                  }
              }
          } else {
              $absolutePath = __DIR__ . '/../' . $targetSheet;
              if (file_exists($absolutePath)) {
                  echo '<link rel="stylesheet" href="' . seo_url($targetSheet) . '?v=' . time() . '">' . "\n";
              }
          }
      }
  endif;
  ?>
  <style>
    /* Force Global Montserrat Font Family Compliance */
    body, input, button, select, textarea, span, p, div, li, strong, label, input::placeholder, section, article, a {
      font-family: 'Montserrat', sans-serif !important;
    }
    h1, h2, h3, h4, h5, h6, .section-title, .section-tag, .spotlight-tag, .spotlight-title, .compare-title, .why-brand-title, .why-title, .news-card__title, .calc-label, .vip-popup-title, .offers-stage-tab__title, .counselor-compare-name {
      font-family: 'Montserrat', sans-serif !important;
    }

    /* Force Global Uppercase for Main Headings (to ensure uniform letter heights) */
    h1, h2, .section-title, .compare-title, .catalog-hero__title, .ev-calc-title, .booking-title, .faq-section-official h2 {
      text-transform: uppercase !important;
      letter-spacing: 1px !important;
    }

    /* Global Premium Dark Header Styling (Replica of diendanxecu.com) */
    .premium-header {
      background: rgba(11, 22, 39, 0.85) !important; /* Deep Tech Navy with Opacity */
      backdrop-filter: blur(12px) !important; /* Glassmorphism */
      -webkit-backdrop-filter: blur(12px) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      position: fixed !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      z-index: 1000 !important;
    }
    .premium-header .logo-link {
      color: #ffffff !important;
    }
    .premium-header .logo-link:hover {
      color: #38bdf8 !important;
    }
    .nav-link {
      color: #cbd5e1 !important; /* Light silver text */
    }
    .nav-link:hover {
      color: #ffffff !important;
    }
    .nav-link--active {
      color: #38bdf8 !important; /* Highlight tech blue */
      border-bottom: 2px solid #38bdf8 !important;
    }
    .mobile-menu-toggle .bar {
      background-color: #ffffff !important; /* Ensure hamburger menu is visible on dark background */
    }

    /* Scrolled States (Solid Dark Backgrounds for Perfect Contrast over white content) */
    .premium-header.scrolled {
      background: #070f1e !important; /* Solid dark Slate-Navy */
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25) !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .live-ticker-container.scrolled {
      background: #0b1528 !important; /* Solid dark Slate-Blue matching bottom header */
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
      border-bottom: 2px solid rgba(56, 189, 248, 0.2) !important;
    }
  </style>

  <!-- Dynamic JSON-LD Schema Markups (Structured Data for Google Rich Snippets) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "AutoDealer",
    "name": "<?php echo htmlspecialchars($settings['agency_name'] ?? 'VinFast Việt Nam'); ?>",
    "image": "<?php echo htmlspecialchars($baseUrl . '/' . ($settings['dealer_image'] ?? 'assets/uploads/showroom.webp')); ?>",
    "telephone": "<?php echo htmlspecialchars($settings['agency_phone'] ?? '0817777855'); ?>",
    "email": "<?php echo htmlspecialchars($settings['agency_email'] ?? 'info@VinFastvn.com'); ?>",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?php echo htmlspecialchars($settings['agency_address'] ?? '6B Tôn Đức Thắng, Phường Bến Nghé, Quận 1'); ?>",
      "addressLocality": "TP. Hồ Chí Minh",
      "addressCountry": "VN"
    },
    "openingHoursSpecification": {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
      "opens": "08:00",
      "closes": "18:00"
    },
    "url": "<?php echo htmlspecialchars($domain . $_SERVER['REQUEST_URI']); ?>",
    "priceRange": "$$$$"
  }
  </script>

  <?php if (isset($faqSchemaData) && is_array($faqSchemaData) && !empty($faqSchemaData)): ?>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      <?php 
      $faqElements = [];
      foreach ($faqSchemaData as $faq) {
          $faqElements[] = '{
            "@type": "Question",
            "name": ' . json_encode($faq['question'], JSON_UNESCAPED_UNICODE) . ',
            "acceptedAnswer": {
              "@type": "Answer",
              "text": ' . json_encode($faq['answer'], JSON_UNESCAPED_UNICODE) . '
            }
          }';
      }
      echo implode(",\n      ", $faqElements);
      ?>
    ]
  }
  </script>
  <?php endif; ?>
  <?php if (!empty($settings['custom_header_code'])): ?>
    <?php echo $settings['custom_header_code']; ?>
  <?php endif; ?>

  <!-- Unified Brand UX/UI Overrides: Fix all blue/green buttons to have white text instead of black (User preference) -->
  <style>
    /* Ensure blue/green background elements use clean, high-contrast white text under all interaction states */
    .btn-sticky-calc,
    .btn-tradein-submit,
    .btn-tradein-action-hotline,
    .faq-btn-hotline,
    .vip-local-btn,
    .btn-admin-nav:hover,
    .nav-menu .nav-btn-hotline:hover,
    .counselor-action-btn:hover,
    .counselor-btn-vip--call:hover,
    .social-icon-link:hover,
    .btn-compare-pulse:hover,
    .why-row:hover .why-row__idx,
    .tradein-step-row:hover .tradein-step-num,
    .filter-tab-btn--active,
    .filter-tab-btn.filter-tab-btn--active,
    .ev-tech-tab-btn.active {
      color: #ffffff !important;
    }
    
    /* Ensure hover states are also explicitly white text */
    .btn-sticky-calc:hover,
    .btn-tradein-submit:hover,
    .btn-tradein-action-hotline:hover,
    .faq-btn-hotline:hover,
    .vip-local-btn:hover {
      color: #ffffff !important;
    }

    /* Globally override "VUỐT ĐỂ SO SÁNH" visual hint badges to match the user's new EV theme */
    html body .swipe-hint-pill,
    html body .compare-swipe-badge,
    html body .swipe-hint-btn {
      background: rgba(20, 100, 244, 0.05) !important; /* Translucent blue background */
      color: #1464f4 !important; /* Electric Blue text */
      border: 1px solid rgba(20, 100, 244, 0.25) !important; /* Blue border */
      box-shadow: 0 4px 12px rgba(20, 100, 244, 0.1) !important;
      font-weight: 700 !important;
      padding: 6px 14px !important;
      border-radius: 30px !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 6px !important;
    }
  </style>
<script>
    window.toggleMobileMenu = function(e) {
      if (e) {
        if (e.preventDefault) e.preventDefault();
        if (e.stopPropagation) e.stopPropagation();
        if (e.stopImmediatePropagation) e.stopImmediatePropagation();
      }
      const menu = document.querySelector('.nav-menu');
      const toggle = document.querySelector('.mobile-menu-toggle');
      if (menu) {
        menu.classList.toggle('active');
        menu.classList.toggle('nav-menu--open');
      }
      if (toggle) {
        toggle.classList.toggle('active');
        toggle.classList.toggle('mobile-menu-toggle--open');
      }
    };

    document.addEventListener('DOMContentLoaded', function() {
      // Close menu when clicking any nav link
      const navLinks = document.querySelectorAll('.nav-menu .nav-link, .nav-btn-hotline');
      navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
          const menu = document.querySelector('.nav-menu');
          const toggle = document.querySelector('.mobile-menu-toggle');
          if (menu) menu.classList.remove('active');
          if (toggle) toggle.classList.remove('active');
        });
      });
    });
  </script>
</head>
<body class="<?php echo isset($pageBodyClass) ? htmlspecialchars($pageBodyClass) : ''; ?>">
  <?php if (!empty($settings['custom_body_code'])): ?>
    <?php echo $settings['custom_body_code']; ?>
  <?php endif; ?>

  <!-- FLOATING LUXURY HEADER -->
  <header class="premium-header">
    <div class="header-container">
      <a href="<?php echo seo_url('index.php'); ?>" class="logo-link" style="display: inline-flex; align-items: center; font-weight: 900; font-size: 20px; letter-spacing: 2px; font-family: 'Montserrat', sans-serif !important; text-transform: uppercase; text-decoration: none; color: var(--color-text-main, #0f172a) !important; white-space: nowrap !important;">
        <span>VINFAST TAM PHONG</span>
      </a>
      <button class="mobile-menu-toggle" onclick="toggleMobileMenu(event)" aria-label="Toggle Navigation Menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
      
      <nav>
        <ul class="nav-menu">
          <?php foreach ($menuItems as $link => $label): ?>
            <?php
              $isActive = false;
              $cleanLink = explode('#', $link)[0];
              if ($cleanLink === $currentPage) {
                  $isActive = true;
              }
              // Special treatment for car-detail matching Catalog active menu state
              if ($currentPage === 'car-detail.php' && $link === 'cars.php') {
                  $isActive = true;
              }
              // Special treatment for news-detail matching News active menu state
              if ($currentPage === 'news-detail.php' && $link === 'news.php') {
                  $isActive = true;
              }
              $activeClass = $isActive ? 'nav-link--active' : '';
              $isAdminBtn = ($link === 'admin.php') ? 'btn-admin-nav' : '';
            ?>
            <li><a href="<?php echo seo_url($link); ?>" class="nav-link <?php echo $activeClass; ?> <?php echo $isAdminBtn; ?>"><?php echo $label; ?></a></li>
          <?php endforeach; ?>
          
          <li class="nav-hotline-item">
            <a href="tel:<?php echo htmlspecialchars($agencyPhone); ?>" class="nav-btn-hotline">
              <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px; vertical-align: middle;">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
              </svg>
              Hotline: <?php echo htmlspecialchars($agencyPhone); ?>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  


  <!-- Delivery Live Ticker Bar -->
  <div class="live-ticker-container">
    <div class="ticker-label">
      <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor" style="margin-right: 6px;">
        <path d="M19 11.5L9.5 21.5V13.5H5L14.5 3.5V11.5H19Z"/>
      </svg>
      TIN VUI GIAO XE
    </div>
    <div class="ticker-wrapper">
      <div class="ticker-track">
        <span class="ticker-item">
          🎉 Chúc mừng khách hàng <strong>Trần Minh Vương (Quận 1)</strong> vừa nhận bàn giao siêu phẩm <strong>VinFast VF 3</strong> màu Vàng Brahminy năng động! 🚗
        </span>
        <span class="ticker-item">
          🔑 VinFast Tam Phong bàn giao xe điện quốc dân <strong>VinFast VF 5 Plus</strong> cho chị <strong>Nguyễn Thị Lan (Q. Bình Tân)</strong> - Tiết kiệm vượt trội! ⚡
        </span>
        <span class="ticker-item">
          ⚡ Bàn giao chìa khóa trao tay xe <strong>VinFast VF 7 Plus</strong> màu Xám Neptune cho anh <strong>Phạm Hoàng Nam (Q.7)</strong> - Đột phá công nghệ! 🚀
        </span>
        <span class="ticker-item">
          🌟 Chào mừng anh <strong>Lê Văn Đạt (Q. Thủ Đức)</strong> gia nhập cộng đồng di chuyển xanh với chiếc SUV điện hạng sang <strong>VinFast VF 9</strong> màu Xanh Deep Ocean! 🍀
        </span>
        <span class="ticker-item">
          🚗 Chúc mừng gia đình anh chị <strong>Hoàng Long (Q. Gò Vấp)</strong> sở hữu <strong>VinFast VF 6 Plus</strong> màu Đỏ Crimson sang trọng! ❤️
        </span>

        <!-- Lặp lại để cuộn vô tận mượt mà -->
        <span class="ticker-item">
          🎉 Chúc mừng khách hàng <strong>Trần Minh Vương (Quận 1)</strong> vừa nhận bàn giao siêu phẩm <strong>VinFast VF 3</strong> màu Vàng Brahminy năng động! 🚗
        </span>
        <span class="ticker-item">
          🔑 VinFast Tam Phong bàn giao xe điện quốc dân <strong>VinFast VF 5 Plus</strong> cho chị <strong>Nguyễn Thị Lan (Q. Bình Tân)</strong> - Tiết kiệm vượt trội! ⚡
        </span>
        <span class="ticker-item">
          ⚡ Bàn giao chìa khóa trao tay xe <strong>VinFast VF 7 Plus</strong> màu Xám Neptune cho anh <strong>Phạm Hoàng Nam (Q.7)</strong> - Đột phá công nghệ! 🚀
        </span>
        <span class="ticker-item">
          🌟 Chào mừng anh <strong>Lê Văn Đạt (Q. Thủ Đức)</strong> gia nhập cộng đồng di chuyển xanh với chiếc SUV điện hạng sang <strong>VinFast VF 9</strong> màu Xanh Deep Ocean! 🍀
        </span>
        <span class="ticker-item">
          🚗 Chúc mừng gia đình anh chị <strong>Hoàng Long (Q. Gò Vấp)</strong> sở hữu <strong>VinFast VF 6 Plus</strong> màu Đỏ Crimson sang trọng! ❤️
        </span>
      </div>
    </div>
  </div>

  <!-- Scroll Detection JS to prevent contrast clashing on white backgrounds -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.premium-header');
    const ticker = document.querySelector('.live-ticker-container');
    
    function checkScroll() {
      if (window.scrollY > 20) {
        if (header) header.classList.add('scrolled');
        if (ticker) ticker.classList.add('scrolled');
      } else {
        if (header) header.classList.remove('scrolled');
        if (ticker) ticker.classList.remove('scrolled');
      }
    }
    
    window.addEventListener('scroll', checkScroll);
    checkScroll(); // Init on load
  });
  </script>
  




