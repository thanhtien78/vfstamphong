<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * VinFast Sales Counselor Model
 */
class Counselor {
    /**
     * Gets the primary sales counselor (usually first online).
     */
    public static function getPrimary() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM counselors WHERE status = 'ONLINE' ORDER BY id ASC LIMIT 1");
        return $stmt->fetch();
    }

    /**
     * Gets online sales counselors with a limit.
     */
    public static function getOnline($limit = 3) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM counselors WHERE status = 'ONLINE' ORDER BY id ASC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
