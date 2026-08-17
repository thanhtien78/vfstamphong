<?php
namespace App\Core;

use PDO;
use PDOException;

/**
 * VinFast Resilient Database Connection Wrapper
 */
class Database {
    private static $connection = null;

    /**
     * Retrieves the active PDO connection instance, falling back to SQLite if MySQL fails.
     */
    public static function getConnection() {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $dbConfig = [
            'driver'    => Config::getEnv('DB_DRIVER', 'mysql'),
            'host'      => Config::getEnv('DB_HOST', '127.0.0.1'),
            'port'      => Config::getEnv('DB_PORT', '3306'),
            'dbname'    => Config::getEnv('DB_DATABASE', 'vfstamphong'),
            'username'  => Config::getEnv('DB_USERNAME', 'root'),
            'password'  => Config::getEnv('DB_PASSWORD', ''),
            'charset'   => Config::getEnv('DB_CHARSET', 'utf8mb4')
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
                $driver = 'sqlite';
            }
        }

        if ($driver === 'sqlite' || !$db) {
            try {
                $db = new PDO('sqlite:' . dirname(dirname(__DIR__)) . '/database.sqlite');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                // Optimize SQLite settings
                $db->exec("PRAGMA journal_mode=WAL;");
                $db->exec("PRAGMA synchronous=NORMAL;");
                $db->exec("PRAGMA busy_timeout=5000;");
                
                $driver = 'sqlite';
            } catch (PDOException $ex) {
                die("Database Connection failed: " . $ex->getMessage());
            }
        }

        self::$connection = $db;
        return self::$connection;
    }
}
