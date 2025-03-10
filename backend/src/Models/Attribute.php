<?php
namespace App\Models;

use App\Repository\AttributeRepository;

class Attribute extends AbstractAttribute {
    public function __construct(AttributeRepository $repository, $id, $name, $type) {
        parent::__construct($repository, $id, $name, $type);
    }

    public function getAttributeType() {
        return $this->type;
    }

    public function getAttributesByProductId($productId) {
        return $this->repository->getAttributesByProductId($productId);
    }
}
?>
