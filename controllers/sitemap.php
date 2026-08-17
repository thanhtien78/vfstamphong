<?php
/**
 * Controller: Sitemap
 */
header("Content-Type: application/xml; charset=utf-8");
global $db, $settings;

// Resolve host and base directory dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? '') == 443 || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') ? "https://" : "http://";
$domain = $protocol . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
$baseUrl = $domain . $basePath;

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);
$filename = basename($path);

// Determine sitemap status
$pseoStatus = 'live';
try {
    $stmtStatus = $db->query("SELECT value FROM settings WHERE `key` = 'pseo_status' LIMIT 1");
    $val = $stmtStatus->fetchColumn();
    if ($val) {
        $pseoStatus = $val;
    }
} catch (Exception $e) {}

// Calculate local SEO sitemaps count
$numLocalSitemaps = 0;
$locChunkSize = 4000;
$totalLocations = 0;

if ($pseoStatus === 'live') {
    try {
        require_once 'includes/class-pseo-helper.php';
        PSEO_Helper::init();
        $totalLocations = $db->query("SELECT COUNT(*) FROM pseo_index")->fetchColumn();
        if ($totalLocations > 0) {
            $numLocalSitemaps = ceil($totalLocations / $locChunkSize);
        }
    } catch (Exception $e) {}
}

// 1. Render Sitemap Index
if ($filename === 'sitemap.xml') {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc><?php echo $baseUrl; ?>/sitemap-main.xml</loc>
  </sitemap>
  <?php for ($i = 1; $i <= $numLocalSitemaps; $i++): ?>
  <sitemap>
    <loc><?php echo $baseUrl; ?>/sitemap-local-<?php echo $i; ?>.xml</loc>
  </sitemap>
  <?php endfor; ?>
</sitemapindex>
    <?php
    exit;
}

// 2. Render Main Sitemap
if ($filename === 'sitemap-main.xml') {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <!-- Core Static Pages -->
  <url>
    <loc><?php echo $baseUrl; ?>/</loc>
    <lastmod><?php echo date('c', filemtime(dirname(__DIR__) . '/views/home.php')); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc><?php echo $baseUrl; ?>/dong-xe-vinfast</loc>
    <lastmod><?php echo date('c', filemtime(dirname(__DIR__) . '/views/cars.php')); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.9</priority>
  </url>
  <url>
    <loc><?php echo $baseUrl; ?>/gioi-thieu</loc>
    <lastmod><?php echo date('c', filemtime(dirname(__DIR__) . '/views/about.php')); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?php echo $baseUrl; ?>/tin-tuc-su-kien</loc>
    <lastmod><?php echo date('c', filemtime(dirname(__DIR__) . '/views/news.php')); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?php echo $baseUrl; ?>/mua-xe-tra-gop</loc>
    <lastmod><?php echo date('c', filemtime(dirname(__DIR__) . '/views/installment.php')); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <url>
    <loc><?php echo $baseUrl; ?>/bang-gia-xe-VinFast</loc>
    <lastmod><?php echo date('c', filemtime(dirname(__DIR__) . '/views/pricelist.php')); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
  </url>

  <!-- Dynamic Car Details -->
  <?php
  try {
      $stmtCars = $db->query("SELECT id, slug FROM cars ORDER BY id ASC");
      $carDetailTime = filemtime(dirname(__DIR__) . '/views/car-detail.php');
      while ($car = $stmtCars->fetch(PDO::FETCH_ASSOC)) {
          $carLoc = !empty($car['slug']) ? 'xe-vinfast/' . $car['slug'] : 'car-detail.php?id=' . $car['id'];
          ?>
  <url>
    <loc><?php echo $baseUrl; ?>/<?php echo $carLoc; ?></loc>
    <lastmod><?php echo date('c', $carDetailTime); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
          <?php
      }
  } catch (Exception $e) {}
  ?>

  <!-- Dynamic News & Blog Articles -->
  <?php
  try {
      $stmtPosts = $db->query("SELECT id, slug, created_at FROM posts WHERE status = 'published' ORDER BY id DESC");
      while ($post = $stmtPosts->fetch(PDO::FETCH_ASSOC)) {
          $postLoc = !empty($post['slug']) ? 'tin-tuc/' . $post['slug'] : 'news-detail.php?id=' . $post['id'];
          $postTime = !empty($post['created_at']) ? strtotime($post['created_at']) : filemtime(dirname(__DIR__) . '/views/news-detail.php');
          ?>
  <url>
    <loc><?php echo $baseUrl; ?>/<?php echo $postLoc; ?></loc>
    <lastmod><?php echo date('c', $postTime); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>
          <?php
      }
  } catch (Exception $e) {}
  ?>
</urlset>
    <?php
    exit;
}

// 3. Render Local SEO Sub-Sitemaps
if (preg_match('/^sitemap-local-([1-9][0-9]*)\.xml$/', $filename, $matches)) {
    $pageNum = (int)$matches[1];
    if ($pageNum < 1 || $pageNum > $numLocalSitemaps) {
        header("HTTP/1.0 404 Not Found");
        echo "Sitemap chunk not found.";
        exit;
    }

    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php
  try {
      require_once 'includes/class-pseo-helper.php';
      PSEO_Helper::init();
      $customKeywords = PSEO_Helper::getCustomKeywords();
      $pseoTime = filemtime(dirname(__DIR__) . '/views/local-seo.php');
      
      $offset = ($pageNum - 1) * $locChunkSize;
      
      $stmt = $db->prepare("SELECT slug, type FROM pseo_index ORDER BY slug ASC LIMIT :limit OFFSET :offset");
      $stmt->bindValue(':limit', $locChunkSize, PDO::PARAM_INT);
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->execute();
      
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $slug = $row['slug'];
          $type = $row['type'];
          
          foreach ($customKeywords as $kwSlug => $kw) {
              $rel = 'tai';
              if ($type === 'chungcu' && strpos($slug, 'chung-cu-') !== 0) {
                  $rel = 'gan';
              }
              $url = $baseUrl . '/' . $kwSlug . '-' . $rel . '-' . $slug . '.html';
              ?>
  <url>
    <loc><?php echo htmlspecialchars($url); ?></loc>
    <lastmod><?php echo date('c', $pseoTime); ?></lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.7</priority>
  </url>
              <?php
          }
      }
  } catch (Exception $e) {}
  ?>
</urlset>
    <?php
    exit;
}

// 4. Fallback: 404
header("HTTP/1.0 404 Not Found");
echo "Sitemap not found.";
exit;




