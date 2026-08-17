<?php
namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * VinFast News & Articles Model
 */
class News {
    /**
     * Gets all posts ordered by ID descending.
     */
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM posts ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    /**
     * Gets the latest posts with limit.
     */
    public static function getLatest($limit = 3) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Finds a post by its URL slug.
     */
    public static function findBySlug($slug) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM posts WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Gets related posts excluding current post ID.
     */
    public static function getRelated($excludeId, $limit = 3) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM posts WHERE id != ? ORDER BY id DESC LIMIT ?");
        $stmt->bindValue(1, (int)$excludeId, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
