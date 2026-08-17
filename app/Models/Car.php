<?php
namespace App\Models;

use App\Core\Database;

/**
 * VinFast Car Catalog Model
 */
class Car {
    /**
     * Gets all cars ordered by ID.
     */
    public static function all() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM cars ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    /**
     * Finds a car by ID.
     */
    public static function find($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM cars WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Finds a car by its URL slug.
     */
    public static function findBySlug($slug) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM cars WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Gets the model name of a car by ID.
     */
    public static function getNameById($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT model_name FROM cars WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() ?: 'Không xác định';
    }

    /**
     * Gets all cars ordered by segment and price.
     */
    public static function getPricelist() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM cars ORDER BY segment ASC, price ASC");
        return $stmt->fetchAll();
    }
}
