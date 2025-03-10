<?php

namespace App\GraphQL\Resolvers;

use App\Models\Product;
use App\Config\Database;
use App\Repository\ProductRepository;

class ProductResolver {
    private $productRepository;

    public function __construct() {
        $db = new Database();
        $this->productRepository = new ProductRepository($db->getConnection());
    }


    public function resolveProducts($root, $args) {
        if (isset($args['categoryName'])) {
            return $this->productRepository->getProductsByCategoryName($args['categoryName']);
        }
        return $this->productRepository->getAllProducts();
    }
    

    public function resolveProductById($root, $args) {
        $productData = $this->productRepository->getProductById($args['id']);
        
        if (!$productData) {
            return null;
        }

        return new Product(
            $this->productRepository,
            $productData['id'],
            $productData['name'],
            $productData['description'],
            $productData['inStock'],
            $productData['category_id']
        );
    }
}