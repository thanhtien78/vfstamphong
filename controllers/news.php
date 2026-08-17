<?php
/**
 * Controller for route: news
 */

/**
 * VinFast Premium News Portal
 * Highly scalable, high-performance, search-engine-optimized news hub.
 * Designed to cleanly handle up to 100,000+ posts with indexed queries.
 */




// Safe input sanitization
$categoryFilter = isset($_GET['category']) ? trim($_GET['category']) : '';
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 6; // 6 articles per page
$offset = ($page - 1) * $limit;

// Define available categories
$categories = [
    'Thế giới VinFast',
    'Chương trình khuyến mãi',
    'Bảo dưỡng & Bảo hành',
    'Tin tuyển dụng',
    'Báo giá theo địa phương'
];

try {
    // 1. Fetch Featured articles for the top editorial grid (latest 3 published articles)
    // Handled separately from paginated lists to guarantee premium layout styling
    $stmtFeatured = $db->query("SELECT id, title, slug, category, summary, image, created_at, views 
                                FROM posts 
                                WHERE status = 'published' 
                                ORDER BY id DESC LIMIT 3");
    $featuredPosts = $stmtFeatured->fetchAll();

    // Initialize regular posts variables for safety
    $posts = [];
    $totalPosts = 0;
    $totalPages = 1;

    // Run query for standard categories only (Báo giá theo địa phương is a programmatic directory list)
    if ($categoryFilter !== 'Báo giá theo địa phương') {
        // 2. Build dynamic query for regular posts list
        $queryStr = "SELECT id, title, slug, category, summary, image, created_at, views 
                     FROM posts 
                     WHERE status = 'published'";
        $params = [];

        // Exclude featured posts from the main catalog list to avoid visual duplication on page 1
        if ($page === 1 && count($featuredPosts) > 0) {
            $excludedIds = array_column($featuredPosts, 'id');
            $queryStr .= " AND id NOT IN (" . implode(',', $excludedIds) . ")";
        }

        if (!empty($categoryFilter)) {
            $queryStr .= " AND category = ?";
            $params[] = $categoryFilter;
        }

        if (!empty($searchQuery)) {
            $queryStr .= " AND (title LIKE ? OR summary LIKE ?)";
            $params[] = '%' . $searchQuery . '%';
            $params[] = '%' . $searchQuery . '%';
        }

        // Add ordering and pagination
        $queryStr .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";

        $stmtList = $db->prepare($queryStr);
        $stmtList->execute($params);
        $posts = $stmtList->fetchAll();

        // 3. Build total count query for SEO-friendly crawlable pagination
        $countQueryStr = "SELECT COUNT(*) FROM posts WHERE status = 'published'";
        $countParams = [];

        if ($page === 1 && count($featuredPosts) > 0) {
            $countQueryStr .= " AND id NOT IN (" . implode(',', $excludedIds) . ")";
        }

        if (!empty($categoryFilter)) {
            $countQueryStr .= " AND category = ?";
            $countParams[] = $categoryFilter;
        }

        if (!empty($searchQuery)) {
            $countQueryStr .= " AND (title LIKE ? OR summary LIKE ?)";
            $countParams[] = '%' . $searchQuery . '%';
            $countParams[] = '%' . $searchQuery . '%';
        }

        $stmtCount = $db->prepare($countQueryStr);
        $stmtCount->execute($countParams);
        $totalPosts = (int)$stmtCount->fetchColumn();
        $totalPages = max(1, ceil($totalPosts / $limit));
    }

    // 4. Fetch top 3 read articles for sidebar
    $stmtPopular = $db->query("SELECT title, slug, category, views 
                               FROM posts 
                               WHERE status = 'published' 
                               ORDER BY views DESC LIMIT 3");
    $popularPosts = $stmtPopular->fetchAll();

} catch (Exception $e) {
    die("Lỗi truy vấn tin tức: " . $e->getMessage());
}

// SEO configurations
$siteTitle = "Góc Tư Vấn & Tin Tức Xe Điện VinFast | Đại lý VinFast Tam Phong";
$siteDesc = "Cập nhật các chương trình ưu đãi mới nhất, tin tức xe thuần điện EV, lễ ra mắt xe VinFast và cẩm nang kỹ thuật chuyên sâu từ các chuyên gia.";
$siteKeywords = "tin tuc VinFast, tin tuc EV, xe dien VinFast, uu dai VinFast, kinh nghiem lai xe VinFast";

$pageBodyClass = 'page-news';

return get_defined_vars();




