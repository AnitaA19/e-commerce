<?php

namespace App\Models;

class ColorAttribute extends AbstractAttribute {
    public function getAttributeType() {
        return 'Color';
    }

    public function getAll() {
        return $this->repository->getAllColorAttributes();
    }

    public function getById($id) {
        return $this->repository->getColorAttributeById($id);
    }
}