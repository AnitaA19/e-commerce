<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderAttributeType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'OrderAttribute',
            'fields' => [
                'attribute_set_id' => Type::nonNull(Type::string()),
                'attribute_item_id' => Type::nonNull(Type::string())
            ]
        ]);
    }
}