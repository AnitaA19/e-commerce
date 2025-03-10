<?php

namespace App\Models;

class TechProduct extends Product {
    public function getProductType() {
        return 'Tech';
    }

    public function getAll() {
        return $this->repository->getAllTechProducts();
    }

    public function getById($id) {
        return $this->repository->getTechProductById($id);
    }
}
