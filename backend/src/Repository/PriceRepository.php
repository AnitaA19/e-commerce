<?php
namespace App\Repository;

use PDO;

class PriceRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getPricesByProductId($productId) {
        $stmt = $this->db->prepare("
            SELECT p.amount, c.label, c.symbol 
            FROM prices p 
            JOIN currencies c ON p.currency_id = c.id 
            WHERE p.product_id = :productId
        ");
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}