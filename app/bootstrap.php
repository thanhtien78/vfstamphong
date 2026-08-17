<?php
/**
 * VinFast Premium App Bootstrap
 * Initializes autoloader, environment variables, and core database components.
 */

// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Setup PSR-4 Autoloader for the "App" namespace
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require_once $file;
    }
});

// 2. Initialize the global Database Connection
$db = \App\Core\Database::getConnection();

// 3. Register legacy global helpers for backward compatibility
if (!function_exists('get_env_val')) {
    function get_env_val($key, $default = null) {
        return \App\Core\Config::getEnv($key, $default);
    }
}

if (!function_exists('send_telegram_notification')) {
    function send_telegram_notification($message) {
        return \App\Core\Notification::sendTelegram($message);
    }
}
