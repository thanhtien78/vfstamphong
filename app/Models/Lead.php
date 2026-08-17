<?php
namespace App\Models;

use App\Core\Database;

/**
 * VinFast Lead Submission Model
 */
class Lead {
    /**
     * Creates a new lead in the database.
     */
    public static function create($data) {
        $db = Database::getConnection();
        
        $fields = [
            'car_id'             => !empty($data['car_id']) ? (int)$data['car_id'] : null,
            'fullname'           => $data['fullname'] ?? '',
            'phone'              => $data['phone'] ?? '',
            'email'              => $data['email'] ?? '',
            'preferred_date'     => $data['preferred_date'] ?? null,
            'test_drive_type'    => $data['test_drive_type'] ?? 'Tại Showroom',
            'test_drive_address' => $data['test_drive_address'] ?? '',
            'notes'              => $data['notes'] ?? null,
            'status'             => $data['status'] ?? 'Chưa liên hệ'
        ];

        $columns = implode(', ', array_keys($fields));
        $placeholders = implode(', ', array_fill(0, count($fields), '?'));

        $stmt = $db->prepare("INSERT INTO leads ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($fields));
        return $db->lastInsertId();
    }
}
