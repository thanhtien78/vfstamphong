<?php
/**
 * CẤU HÌNH & KẾT NỐI CƠ SỞ DỮ LIỆU (DATABASE CONFIG & CONNECTION)
 * Anh chỉnh sửa thông số kết nối CSDL trực tiếp tại mảng cấu hình dưới đây:
 */
/**
 * Helper function to read environment variables from a .env file
 */
if (!function_exists('get_env_val')) {
    function get_env_val($key, $default = null) {
        static $envData = null;
        if ($envData === null) {
            $envFile = __DIR__ . '/.env';
            $envData = [];
            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $envKey = trim($parts[0]);
                        $envVal = trim($parts[1]);
                        
                        // Parse quoted values or strip inline comments
                        if (preg_match('/^["\'](.*?)["\']$/', $envVal, $matches)) {
                            $envVal = $matches[1];
                        } else {
                            $commentPos = strpos($envVal, '#');
                            if ($commentPos !== false) {
                                $envVal = trim(substr($envVal, 0, $commentPos));
                            }
                        }
                        $envData[$envKey] = $envVal;
                    }
                }
            }
        }
        return $envData[$key] ?? $default;
    }
}

$dbConfig = [
    'driver'    => get_env_val('DB_DRIVER', 'mysql'),
    'host'      => get_env_val('DB_HOST', '127.0.0.1'),
    'port'      => get_env_val('DB_PORT', '3306'),
    'dbname'    => get_env_val('DB_DATABASE', 'vfstamphong'),
    'username'  => get_env_val('DB_USERNAME', 'root'),
    'password'  => get_env_val('DB_PASSWORD', ''),
    'charset'   => get_env_val('DB_CHARSET', 'utf8mb4')
];

$driver = 'sqlite';
$db = null;

if ($dbConfig['driver'] === 'mysql') {
    try {
        $dsn = "mysql:host=" . $dbConfig['host'] . ";port=" . $dbConfig['port'] . ";dbname=" . $dbConfig['dbname'] . ";charset=" . $dbConfig['charset'];
        $db = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $driver = 'mysql';
    } catch (PDOException $e) {
        // Fallback to SQLite if MySQL connection fails
        $driver = 'sqlite';
    }
}

if ($driver === 'sqlite' || !$db) {
    try {
        $db = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // Tối ưu hóa SQLite
        $db->exec("PRAGMA journal_mode=WAL;");
        $db->exec("PRAGMA synchronous=NORMAL;");
        $db->exec("PRAGMA busy_timeout=5000;");
        
        $driver = 'sqlite';
    } catch (PDOException $ex) {
        die("Database Connection failed: " . $ex->getMessage());
    }
}

/**
 * Sends a notification message to Telegram using Bot API settings.
 * Fails silently to prevent blocking any front-end user operations.
 */
function send_telegram_notification($message) {
    global $db;
    if (!$db) {
        return false;
    }
    try {
        // Retrieve settings values
        $stmt = $db->prepare("SELECT `value` FROM settings WHERE `key` = ?");
        
        $stmt->execute(['telegram_bot_token']);
        $botToken = $stmt->fetchColumn();

        $stmt->execute(['telegram_chat_id']);
        $chatId = $stmt->fetchColumn();

        // Fallback to .env values if database values are empty
        if (empty($botToken)) {
            $botToken = get_env_val('TELEGRAM_BOT_TOKEN');
        }
        if (empty($chatId)) {
            $chatId = get_env_val('TELEGRAM_CHAT_ID');
        }

        if (empty($botToken) || empty($chatId)) {
            return false;
        }

        $url = "https://api.telegram.org/bot" . urlencode($botToken) . "/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 5
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($url, false, $context);
        return $result !== false;
    } catch (Exception $e) {
        return false;
    }
}



