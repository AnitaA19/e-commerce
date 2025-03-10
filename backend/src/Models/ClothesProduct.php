<?php
namespace App\Models;

class ClothesProduct extends Product {
    public function getProductType() {
        return 'Clothes';
    }

    public function getAll() {
        return $this->repository->getAllClothesProducts();
    }

    public function getById($id) {
        return $this->repository->getClothesProductById($id);
    }
}
