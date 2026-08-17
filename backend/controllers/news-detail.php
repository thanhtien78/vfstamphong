<?php
/**
 * Controller for route: news-detail
 */

/**
 * VinFast Premium News Detail Portal
 * Renders full article content with automatic dynamic JSON-LD Article Schema,
 * dynamic SEO optimizations, and high-readability luxury typography spacing.
 */




use App\Core\Database;

$db = Database::getConnection();

// Safe input sanitization
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = null;

try {
    // 1. Fetch post by slug first (extremely SEO-friendly), fallback to ID if needed
    if (!empty($slug)) {
        $stmt = $db->prepare("SELECT * FROM posts WHERE slug = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$slug]);
        $post = $stmt->fetch();
        
        // Automatic 301 Redirection to prevent broken links (SEO Redirection Plugin)
        if (!$post) {
            $stmtRedir = $db->prepare("SELECT new_url FROM redirects WHERE old_url = ? LIMIT 1");
            $stmtRedir->execute([$slug]);
            $redir = $stmtRedir->fetch();
            if ($redir && !empty($redir['new_url'])) {
                $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
                $queryParams = $_GET;
                unset($queryParams['slug']);
                $newQuery = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $basePath . "/tin-tuc/" . urlencode($redir['new_url']) . $newQuery);
                exit;
            }
        }
    }
    
    if (!$post && $id > 0) {
        $stmt = $db->prepare("SELECT * FROM posts WHERE id = ? AND status = 'published' LIMIT 1");
        $stmt->execute([$id]);
        $post = $stmt->fetch();
    }

    // Redirect to news index if article is not found or not published
    if (!$post) {
        $basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        header("Location: " . $basePath . "/tin-tuc-su-kien");
        exit;
    }

    // Redirect raw access to clean URL
    if ($post && !empty($post['slug'])) {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
        if (strpos($_SERVER['REQUEST_URI'] ?? '', 'news-detail.php') !== false) {
            $queryParams = $_GET;
            unset($queryParams['slug']);
            unset($queryParams['id']);
            $newQuery = !empty($queryParams) ? '?' . http_build_query($queryParams) : '';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $basePath . "/tin-tuc/" . $post['slug'] . $newQuery);
            exit;
        }
    }

    // 2. Increment view count asynchronously/safely for popular reads metrics
    $stmtUpdateViews = $db->prepare("UPDATE posts SET views = views + 1 WHERE id = ?");
    $stmtUpdateViews->execute([$post['id']]);

    // 3. Fetch 3 related posts (same category, excluding current post) for sidebar
    $stmtRelated = $db->prepare("SELECT id, title, slug, image, category, created_at 
                                 FROM posts 
                                 WHERE status = 'published' AND category = ? AND id != ? 
                                 ORDER BY id DESC LIMIT 3");
    $stmtRelated->execute([$post['category'], $post['id']]);
    $relatedPosts = $stmtRelated->fetchAll();

} catch (Exception $e) {
    die("Lỗi kết nối bài viết: " . $e->getMessage());
}

// Bind custom SEO meta tags before includes/header.php runs
$siteTitle = !empty($post['seo_title']) ? htmlspecialchars($post['seo_title']) : "{title} - Cập nhật mới nhất tháng {month}/{year} | VinFast Việt Nam";
$siteDesc = !empty($post['seo_desc']) ? htmlspecialchars($post['seo_desc']) : (htmlspecialchars(mb_substr(strip_tags($post['summary']), 0, 150, 'utf-8')) . "... Đọc tin tức mới nhất tháng {month}/{year} cập nhật bởi đại lý VinFast.");
$seoCanonical = !empty($post['seo_canonical']) ? htmlspecialchars($post['seo_canonical']) : "";
$siteKeywords = !empty($post['focus_keyword']) ? htmlspecialchars($post['focus_keyword']) : "VinFast, {category}, tin tuc VinFast, {title}";

$pageBodyClass = 'page-news-detail';

return get_defined_vars();




