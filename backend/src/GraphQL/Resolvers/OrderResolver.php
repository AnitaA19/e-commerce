<?php
namespace App\GraphQL\Resolvers;

use App\Repository\OrderRepository;
use App\Config\Database;
use GraphQL\Type\Definition\Type;

class OrderResolver {
    private $orderRepository;

    public function __construct() {
        $db = new Database();
        $this->orderRepository = new OrderRepository($db->getConnection());
    }

    public function resolvePlaceOrder($root, $args) {
        try {
            $items = $args['items'] ?? [];
            
            if (empty($items)) {
                throw new \Exception("No items provided for order");
            }

            return $this->orderRepository->createMultiItemOrder($items);
            
        } catch (\Exception $e) {
            error_log("Error placing order: " . $e->getMessage());
            throw $e; 
        }
    }
}