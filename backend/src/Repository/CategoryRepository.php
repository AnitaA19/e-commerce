<?php
namespace App\Repository;

use PDO;

class CategoryRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        $stmt = $this->db->query("SELECT id, name FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT id, name FROM categories WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $category ? ['id' => $category['id'], 'name' => $category['name']] : null;
    }
    
}
