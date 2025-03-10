<?php
namespace App\Models;

abstract class AbstractCategory extends AbstractModel {
    protected $id;
    protected $name;

    public function __construct($repository, $id, $name) {
        parent::__construct($repository);
        $this->id = $id;
        $this->name = $name;
    }
}