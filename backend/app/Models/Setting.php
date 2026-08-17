<?php
namespace App\Models;

use App\Core\Database;

/**
 * VinFast Setting Model
 */
class Setting {
    private static $cachedSettings = null;

    /**
     * Retrieves all settings as an associative key-value array.
     */
    public static function getAll() {
        if (self::$cachedSettings !== null) {
            return self::$cachedSettings;
        }

        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['key']] = $row['value'];
        }

        self::$cachedSettings = $settings;
        return $settings;
    }

    /**
     * Gets a specific setting value by key, with default fallback.
     */
    public static function get($key, $default = null) {
        $settings = self::getAll();
        return $settings[$key] ?? $default;
    }
}
