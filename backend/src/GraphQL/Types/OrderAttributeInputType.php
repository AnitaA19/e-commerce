<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;

class OrderAttributeInputType extends InputObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'OrderAttributeInput',
            'fields' => [
                'attributeSetId' => Type::nonNull(Type::string()),
                'attributeItemId' => Type::nonNull(Type::string())
            ]
        ]);
    }
}
