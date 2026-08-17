<?php
/**
 * VinFast Premium Page Cache Engine
 * Caches fully rendered HTML output of public GET requests.
 */
class PageCache {
    private static $cacheDir = __DIR__ . '/../cache';
    private static $cacheLifeTime = 3600; // Cache duration: 1 hour (3600 seconds)
    private static $isEligible = null;
    private static $cacheFile = null;

    /**
     * Checks if the current request can be cached or served from cache.
     */
    private static function checkEligibility($pageKey) {
        // PageCache is disabled globally by user request to prevent caching issues on local virtual domains and during updates.
        self::$isEligible = false;
        return false;

        if (self::$isEligible !== null) {
            return self::$isEligible;
        }

        // Tự động bỏ qua bộ nhớ đệm (Page Cache) trên môi trường phát triển cục bộ
        $host = $_SERVER['HTTP_HOST'] ?? '';
        if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false || strpos($host, '.local') !== false) {
            self::$isEligible = false;
            return false;
        }

        // Do not cache non-GET requests
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
            self::$isEligible = false;
            return false;
        }

        // Do not cache if admin user is logged in
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['user_id'])) {
            self::$isEligible = false;
            return false;
        }

        // Do not cache administrative or API endpoints
        $bypassKeys = ['admin', 'login', 'logout', 'ajax-vip-lead', 'debug', 'sitemap', 'robots'];
        if (in_array($pageKey, $bypassKeys)) {
            self::$isEligible = false;
            return false;
        }

        self::$isEligible = true;
        return true;
    }

    /**
     * Starts buffering the page output, checks for existing cache.
     */
    public static function start($pageKey) {
        ob_start();

        if (!self::checkEligibility($pageKey)) {
            return;
        }

        // Ensure the cache directory exists and is writable
        if (!is_dir(self::$cacheDir)) {
            @mkdir(self::$cacheDir, 0777, true);
        }

        // Calculate unique cache file path based on request URI (nested subdirectories structure for massive scale)
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $hash = md5($requestUri);
        $subDir1 = substr($hash, 0, 2);
        $subDir2 = substr($hash, 2, 2);
        $targetDir = self::$cacheDir . '/' . $subDir1 . '/' . $subDir2;
        self::$cacheFile = $targetDir . '/' . $hash . '.html';

        // Serve from cache if valid file exists and is not expired
        if (file_exists(self::$cacheFile) && (time() - filemtime(self::$cacheFile) < self::$cacheLifeTime)) {
            $cachedHtml = @file_get_contents(self::$cacheFile);
            if ($cachedHtml !== false) {
                ob_end_clean();
                // Append a debugging comment to verify cache hitting
                echo $cachedHtml . "\n<!-- Served from PageCache (Remaining: " . (self::$cacheLifeTime - (time() - filemtime(self::$cacheFile))) . "s) -->";
                exit;
            }
        }
    }

    /**
     * Ends memory buffering, writes HTML to cache if eligible, and echoes it.
     */
    public static function end($pageKey) {
        $html = ob_get_clean();
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');

        // Rewrite relative image src paths to root-relative dynamically in memory (ignoring script tags)
        $html = preg_replace_callback('/<script\b[^>]*?>[\s\S]*?<\/script>|<img\b([^>]*?)>/is', function($matches) use ($basePath) {
            if (strpos($matches[0], '<script') === 0) {
                return $matches[0];
            }
            $attrs = $matches[1];
            if (preg_match('/\bsrc=["\']([^"\']+)["\']/i', $attrs, $srcMatch)) {
                $srcPath = $srcMatch[1];
                // Check if it's a relative path (doesn't start with http, https, data:, or a slash)
                if (!preg_match('/^(https?:\/\/|data:|\/)/i', $srcPath)) {
                    $absoluteSrc = $basePath . '/' . $srcPath;
                    $attrs = preg_replace('/\bsrc=["\'][^"\']+["\']/i', 'src="' . htmlspecialchars($absoluteSrc) . '"', $attrs);
                }
            }
            return '<img ' . $attrs . '>';
        }, $html);

        // Write the processed output to the cache file (creates dynamic subdirectories recursively if not present)
        if (self::checkEligibility($pageKey) && self::$cacheFile) {
            $dir = dirname(self::$cacheFile);
            if (!is_dir($dir)) {
                @mkdir($dir, 0777, true);
            }
            if (is_dir($dir) && is_writable($dir)) {
                @file_put_contents(self::$cacheFile, $html);
            }
        }

        echo $html;
    }

    /**
     * Clears all cached pages recursively (called automatically during admin updates).
     */
    public static function clear() {
        if (is_dir(self::$cacheDir)) {
            self::recursiveRemove(self::$cacheDir, false); // Clear contents but keep root cache folder
        }
    }

    /**
     * Helper to recursively delete files and folders
     */
    private static function recursiveRemove($dir, $removeSelf = true) {
        if (!is_dir($dir)) return;
        $items = array_diff(scandir($dir), ['.', '..']);
        foreach ($items as $item) {
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                self::recursiveRemove($path, true);
            } else {
                @unlink($path);
            }
        }
        if ($removeSelf) {
            @rmdir($dir);
        }
    }
}




