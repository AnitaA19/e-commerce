<?php

namespace App\Models;

abstract class AbstractAttribute extends AbstractModel {
    protected $id;
    protected $name;
    protected $type;

    public function __construct($repository) {
        parent::__construct($repository);
    }

    public function getAll() {
        return $this->repository->getAllAttributes();
    }

    public function getById($id) {
        return $this->repository->getAttributeById($id);
    }
}
