<?php
namespace App\Models;

use App\Repository\ProductRepository;
use App\Repository\AttributeRepository;

class Product extends AbstractProduct {
    protected $attributeRepository;

    public function __construct(ProductRepository $repository, AttributeRepository $id, $name, $description, $inStock, $category) {
        parent::__construct($repository, $id, $name, $description, $inStock, $category);
    }

    public function getAll() {
        return $this->repository->getAllProducts();
    }

    public function getById($id) {
        return $this->repository->getProductById($id);
    }

    public function getAttributes() {
        return $this->attributeRepository->getAttributesByProductId($this->id);
    }
}
?>
