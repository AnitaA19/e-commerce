<?php
namespace App\Models;

use App\Repository\CategoryRepository;

class Category extends AbstractCategory {
    public function __construct($repository, $id, $name) {
        parent::__construct($repository, $id, $name);
    }

    public function getAll() {
        return $this->repository->getAllCategories();
    }

    public function getById($id) {
        return $this->repository->getCategoryById($id);
    }
}