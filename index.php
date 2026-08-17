<?php
/**
 * VinFast Premium Web Front Controller (Router)
 * Coordinates dynamic MVC routes, loads controllers, sets meta context, and renders layouts.
 */
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/cache.php';

// Determine request path relative to subfolder or root domain
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = rtrim(dirname($scriptName), '/\\');

if ($basePath !== '' && strpos($requestUri, $basePath) === 0) {
    $path = substr($requestUri, strlen($basePath));
} else {
    $path = $requestUri;
}

$path = parse_url($path, PHP_URL_PATH);
$path = '/' . trim($path, '/');

// Override route if bootstrapped by legacy file (e.g. $_GET['route'] = 'about')
$route = $_GET['route'] ?? '';

if (empty($route)) {
    if ($path === '/' || $path === '/index.php' || $path === '/admin/index.php') {
        $route = 'home';
    } elseif ($path === '/gioi-thieu' || $path === '/about.php') {
        $route = 'about';
    } elseif ($path === '/mua-xe-tra-gop' || $path === '/installment.php') {
        $route = 'installment';
    } elseif ($path === '/bang-gia-xe-vinfast' || $path === '/pricelist.php') {
        $route = 'pricelist';
    } elseif ($path === '/dong-xe-vinfast' || $path === '/cars.php') {
        $route = 'cars';
    } elseif ($path === '/tram-sac-vinfast' || $path === '/charging-stations.php') {
        $route = 'charging-stations';
    } elseif ($path === '/tin-tuc-su-kien' || $path === '/news.php') {
        $route = 'news';
    } elseif (preg_match('#^/sitemap(-[a-zA-Z0-9-]+)?\.xml$#', $path)) {
        $route = 'sitemap';
    } elseif ($path === '/robots.txt') {
        $route = 'robots';
    } elseif ($path === '/admin' || $path === '/admin/' || $path === '/admin/admin.php' || $path === '/admin.php') {
        $route = 'admin';
    } elseif ($path === '/login' || $path === '/login.php' || $path === '/admin/login' || $path === '/admin/login.php') {
        $route = 'login';
    } elseif ($path === '/logout' || $path === '/logout.php' || $path === '/admin/logout' || $path === '/admin/logout.php') {
        $route = 'logout';
    } elseif ($path === '/ajax-vip-lead' || $path === '/ajax-vip-lead.php' || $path === '/admin/ajax-vip-lead' || $path === '/admin/ajax-vip-lead.php') {
        $route = 'ajax-vip-lead';
    } elseif ($path === '/debug' || $path === '/debug.php' || $path === '/admin/debug' || $path === '/admin/debug.php') {
        $route = 'debug';
    } elseif ($path === '/car-detail.php') {
        $route = 'car-detail';
    } elseif ($path === '/news-detail.php') {
        $route = 'news-detail';
    } elseif ($path === '/local-seo' || $path === '/local-seo.php') {
        $route = 'local-seo';
    }
    // Dynamic patterns
    elseif (preg_match('#^/xe-vinfast/([a-zA-Z0-9-]+)/?$#i', $path, $matches)) {
        $route = 'car-detail';
        $_GET['slug'] = $matches[1];
    } elseif (preg_match('#^/tin-tuc/([a-zA-Z0-9-]+)/?$#i', $path, $matches)) {
        $route = 'news-detail';
        $_GET['slug'] = $matches[1];
    } elseif (preg_match('#^/([a-zA-Z0-9-]+)-(tai|gan)-([a-zA-Z0-9-]+)\.html$#i', $path, $matches)) {
        $route = 'local-seo';
        $_GET['slug'] = $matches[1] . '-' . $matches[2] . '-' . $matches[3];
    }
}

// Default to 404 if route not mapped
if (empty($route)) {
    $route = '404';
}

$controllerFile = __DIR__ . "/controllers/{$route}.php";
$viewFile = __DIR__ . "/views/{$route}.php";

// If admin, login, logout, ajax-vip-lead, debug, sitemap or robots, run directly without layout wrapper
$directRoutes = ['admin', 'login', 'logout', 'ajax-vip-lead', 'debug', 'sitemap', 'robots'];
if (in_array($route, $directRoutes)) {
    $controllerFile = __DIR__ . "/controllers/{$route}.php";
    if (file_exists($controllerFile)) {
        include $controllerFile;
        exit;
    }
}

// Fallback to 404 if files don't exist
if (!file_exists($controllerFile) || !file_exists($viewFile)) {
    $controllerFile = __DIR__ . "/controllers/404.php";
    $viewFile = __DIR__ . "/views/404.php";
}

// Define currentPage filename mapping for header.php styling logic
$routeToPageMap = [
    'home'         => 'index.php',
    'about'        => 'about.php',
    'cars'         => 'cars.php',
    'car-detail'   => 'car-detail.php',
    'installment'  => 'installment.php',
    'local-seo'    => 'local-seo.php',
    'charging-stations' => 'charging-stations.php',
    'news'         => 'news.php',
    'news-detail'  => 'news-detail.php',
    'pricelist'    => 'pricelist.php'
];
$currentPage = $routeToPageMap[$route] ?? 'index.php';
$GLOBALS['currentPage'] = $currentPage;

// Expose variables globally so that templates (header.php, footer.php) can read them
$pageData = include $controllerFile;
if (is_array($pageData)) {
    foreach ($pageData as $key => $val) {
        $GLOBALS[$key] = $val;
        ${$key} = $val;
    }
}

// Execute caching wrappers (PageCache contains disabled methods but keeps logic clean)
PageCache::start($route);

// Render page view wrapped inside Master Layout
include __DIR__ . '/views/layout.php';

PageCache::end($route);

