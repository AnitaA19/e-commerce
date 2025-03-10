<?php
namespace App\Repository;

use PDO;

class OrderRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
    
    public function createMultiItemOrder($items) {
        try {
            $this->db->beginTransaction();
            
            $totalPrice = 0;
            $productIds = [];

            foreach ($items as $item) {
                $productId = $item['productId'];
                $quantity = $item['quantity'] ?? 1;
                
                $stmt = $this->db->prepare("SELECT id FROM products WHERE id = :product_id");
                $stmt->execute(['product_id' => $productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$product) {
                    throw new \Exception("Product with ID $productId does not exist.");
                }
                
                $stmt = $this->db->prepare("SELECT p.amount, p.currency_id FROM prices p WHERE p.product_id = :product_id LIMIT 1");
                $stmt->execute(['product_id' => $productId]);
                $price = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if (!$price) {
                    throw new \Exception("Price not found for product with ID $productId.");
                }
                
                $totalPrice += $price['amount'] * $quantity;
                $productIds[] = $productId;
            }
            
            $stmt = $this->db->prepare("INSERT INTO orders (product_id, quantity, price) VALUES (:product_id, :quantity, :price)");
            $stmt->execute([
                'product_id' => $productIds[0], 
                'quantity' => count($items),    
                'price' => $totalPrice        
            ]);
            $orderId = $this->db->lastInsertId();
            
            $orderItems = [];
            $itemStmt = $this->db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity) 
                VALUES (:order_id, :product_id, :quantity)
            ");

            $attrStmt = $this->db->prepare("
                INSERT INTO order_attributes (order_id, product_id, attribute_set_id, attribute_item_id) 
                VALUES (:order_id, :product_id, :attribute_set_id, :attribute_item_id)
            ");
            
            foreach ($items as $item) {
                $productId = $item['productId'];
                $quantity = $item['quantity'] ?? 1;
                $attributes = $item['attributes'] ?? [];
                
                $itemStmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
                
                $stmt = $this->db->prepare("SELECT p.amount FROM prices p WHERE p.product_id = :product_id LIMIT 1");
                $stmt->execute(['product_id' => $productId]);
                $price = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $orderItem = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price['amount'],
                    'attributes' => []
                ];
                
                if (!empty($attributes)) {
                    foreach ($attributes as $attr) {
                        $attrStmt->execute([
                            'order_id' => $orderId,
                            'product_id' => $productId,
                            'attribute_set_id' => $attr['attribute_set_id'],
                            'attribute_item_id' => $attr['attribute_item_id']
                        ]);
                        
                        $orderItem['attributes'][] = [
                            'attribute_set_id' => $attr['attribute_set_id'],
                            'attribute_item_id' => $attr['attribute_item_id']
                        ];
                    }
                }
                
                $orderItems[] = $orderItem;
            }
            
            $this->db->commit();

            return [
                'id' => $orderId,
                'items' => $orderItems
            ];
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error creating order: " . $e->getMessage());
            throw $e;  
        }
    }

    public function createOrder($productId, $quantity, $attributes = []) {
        try {
            $this->db->beginTransaction();
    
            $stmt = $this->db->prepare("SELECT id FROM products WHERE id = :product_id");
            $stmt->execute(['product_id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$product) {
                throw new \Exception("Product with ID $productId does not exist.");
            }

            $stmt = $this->db->prepare("SELECT p.amount, p.currency_id FROM prices p WHERE p.product_id = :product_id LIMIT 1");
            $stmt->execute(['product_id' => $productId]);
            $price = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$price) {
                throw new \Exception("Price not found for product with ID $productId.");
            }

            $stmt = $this->db->prepare("INSERT INTO orders (product_id, quantity, price) VALUES (:product_id, :quantity, :price)");
            $stmt->execute([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price['amount'] * $quantity 
            ]);
            $orderId = $this->db->lastInsertId();
            
            $itemStmt = $this->db->prepare("
                INSERT INTO order_items (order_id, product_id, quantity) 
                VALUES (:order_id, :product_id, :quantity)
            ");
            $itemStmt->execute([
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);

            if (!empty($attributes)) {
                $attrStmt = $this->db->prepare("
                    INSERT INTO order_attributes (order_id, product_id, attribute_set_id, attribute_item_id) 
                    VALUES (:order_id, :product_id, :attribute_set_id, :attribute_item_id)
                ");
                foreach ($attributes as $attr) {
                    $attrStmt->execute([
                        'order_id' => $orderId,
                        'product_id' => $productId,
                        'attribute_set_id' => $attr['attribute_set_id'],
                        'attribute_item_id' => $attr['attribute_item_id']
                    ]);
                }
            }
    
            $this->db->commit();
    
            return [
                'id' => $orderId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price['amount'],  
                'attributes' => $attributes
            ];
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Error creating order: " . $e->getMessage());
            throw $e;  
        }
    }
}