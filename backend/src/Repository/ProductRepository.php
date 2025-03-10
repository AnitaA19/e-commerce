<?php
namespace App\Repository;

use PDO;

class ProductRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategoryName($categoryName) {
        $query = "
            SELECT p.* 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE c.name = :categoryName
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':categoryName', $categoryName);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
}
