<?php
/**
 * Controller: Robots.txt
 */
header("Content-Type: text/plain; charset=utf-8");
global $db, $settings;

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || ($_SERVER['SERVER_PORT'] ?? '') == 443) ? "https://" : "http://";
$domain = $protocol . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
$baseUrl = $domain . $basePath;
?>
# ==========================================
# ROBOTS.TXT FOR VinFast CENTRAL PORTAL
# Designed to optimize crawling and security.
# ==========================================

User-agent: *
Allow: /

# Block search engines from crawling administration, login and scratch directories
Disallow: /admin.php
Disallow: /login.php
Disallow: /logout.php
Disallow: /ajax-vip-lead.php
Disallow: /scratch/

# Pointer to your dynamic XML sitemap
Sitemap: <?php echo $baseUrl; ?>/sitemap.xml




