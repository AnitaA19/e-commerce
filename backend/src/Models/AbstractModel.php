<?php
namespace App\Models;

abstract class AbstractModel {
    protected $repository;

    public function __construct($repository) {
        $this->repository = $repository;
    }

    abstract public function getAll();
    abstract public function getById($id);
}