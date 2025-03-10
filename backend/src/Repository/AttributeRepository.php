<?php
namespace App\Repository;

use PDO;

class AttributeRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllAttributes() {
        $stmt = $this->db->query("SELECT * FROM attribute_sets");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAttributeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM attribute_sets WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllSizeAttributes() {
        $stmt = $this->db->query("SELECT * FROM attribute_sets WHERE type = 'Size'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAttributesByProductId($productId) {
        $query = "
            SELECT 
                ats.id AS attribute_set_id,
                ats.name AS attribute_set_name,
                ats.type AS type,
                ai.id AS item_id,
                ai.display_value AS display_value,
                ai.value AS value
            FROM 
                attribute_sets ats
            JOIN 
                product_attributes pa ON pa.attribute_set_id = ats.id
            JOIN 
                attribute_items ai ON ai.id = pa.attribute_item_id
            WHERE 
                pa.product_id = :productId
            ORDER BY 
                ats.id, ai.display_value
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($results)) {
            return [];
        }
    
        $detailedAttributes = [];
    
        foreach ($results as $row) {
            $existingSetIndex = null;
            foreach ($detailedAttributes as $index => $set) {
                if ($set['id'] === $row['attribute_set_id']) {
                    $existingSetIndex = $index;
                    break;
                }
            }
    
            if ($existingSetIndex === null) {
                $detailedAttributes[] = [
                    'id' => $row['attribute_set_id'],
                    'name' => $row['attribute_set_name'],
                    'items' => [],
                    'type' => $row['type'],
                    '__typename' => 'AttributeSet'
                ];
                $existingSetIndex = count($detailedAttributes) - 1;
            }
    
            $detailedAttributes[$existingSetIndex]['items'][] = [
                'displayValue' => $row['display_value'],
                'value' => $row['value'] ?? $row['display_value'],
                'id' => $row['item_id'],
                '__typename' => 'AttributeItem'
            ];
        }
    
        return $detailedAttributes;
    }

    public function getAllColorAttributes() {
        $stmt = $this->db->query("SELECT * FROM attribute_sets WHERE type = 'Color'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getColorAttributeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM attribute_sets WHERE type = 'Color' AND id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllSizeAttributesByProductId($productId) {
        $stmt = $this->db->prepare("
            SELECT ai.* 
            FROM attribute_items ai
            JOIN product_attributes pa ON ai.attribute_set_id = pa.attribute_set_id
            WHERE pa.product_id = :product_id AND ai.display_value = 'Size'
        ");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllColorAttributesByProductId($productId) {
        $stmt = $this->db->prepare("
            SELECT ai.* 
            FROM attribute_items ai
            JOIN product_attributes pa ON ai.attribute_set_id = pa.attribute_set_id
            WHERE pa.product_id = :product_id AND ai.display_value = 'Color'
        ");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}
