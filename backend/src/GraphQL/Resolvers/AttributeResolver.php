<?php
namespace App\GraphQL\Resolvers;

use App\Models\SizeAttribute;
use App\Models\ColorAttribute;
use App\Repository\AttributeRepository;

class AttributeResolver {
    private $repository;
    private $sizeAttribute;
    private $colorAttribute;

    public function __construct(SizeAttribute $sizeAttribute, ColorAttribute $colorAttribute, AttributeRepository $repository) {
        $this->sizeAttribute = $sizeAttribute;
        $this->colorAttribute = $colorAttribute;
        $this->repository = $repository;
    }

    public function resolveAttributes($root) {
        $productId = $root['id'] ?? null;
        
        if (!$productId) {
            return [];
        }
    
        return $this->repository->getAttributesByProductId($productId);
    }
    
    public function resolveSizeAttributes() {
        return $this->repository->getAllSizeAttributes();
    }

    public function resolveColorAttributes() {
        return $this->repository->getAllColorAttributes();
    }

    public function resolveAttributeById($root, $args) {
         return $this->repository->getAttributesByProductId($root['id']);
    }
}