<?php
namespace App\Repository;

use PDO;

class GalleryRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getGalleryByProductId($productId) {
        $stmt = $this->db->prepare("
            SELECT image_url 
            FROM product_gallery 
            WHERE product_id = :productId 
            ORDER BY display_order
        ");
        $stmt->execute(['productId' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}