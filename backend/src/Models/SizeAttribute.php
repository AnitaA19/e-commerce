<?php

namespace App\Models;

class SizeAttribute extends AbstractAttribute {
    public function getAttributeType() {
        return 'Size';
    }

    public function getAll() {
        return $this->repository->getAllSizeAttributes();
    }

    public function getById($id) {
        return $this->repository->getSizeAttributeById($id);
    }
}
