<?php

namespace App\Models;

abstract class AbstractProduct extends AbstractModel {
    protected $id;
    protected $name;
    protected $description;
    protected $inStock;
    protected $category;

    public function __construct($repository, $id, $name, $description, $inStock, $category) {
        parent::__construct($repository);
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->inStock = $inStock;
        $this->category = $category;
    }
}