<?php
namespace App\Repository;

use PDO;

class BrandRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getBrandNameById($brandId) {
        $stmt = $this->db->prepare("SELECT name FROM brands WHERE id = :id");
        $stmt->execute(['id' => $brandId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : null;
    }
}