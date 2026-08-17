<?php
namespace App\Core;

/**
 * VinFast Config & Environment Loader
 */
class Config {
    private static $envData = null;

    /**
     * Reads environment variables from the root .env file.
     */
    public static function getEnv($key, $default = null) {
        if (self::$envData === null) {
            $envFile = dirname(dirname(__DIR__)) . '/.env';
            self::$envData = [];
            if (file_exists($envFile)) {
                $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    $parts = explode('=', $line, 2);
                    if (count($parts) === 2) {
                        $envKey = trim($parts[0]);
                        $envVal = trim($parts[1]);
                        
                        if (preg_match('/^["\'](.*?)["\']$/', $envVal, $matches)) {
                            $envVal = $matches[1];
                        } else {
                            $commentPos = strpos($envVal, '#');
                            if ($commentPos !== false) {
                                $envVal = trim(substr($envVal, 0, $commentPos));
                            }
                        }
                        self::$envData[$envKey] = $envVal;
                    }
                }
            }
        }
        return self::$envData[$key] ?? $default;
    }
}
