<?php

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'OrderItem',
            'fields' => [
                'product_id' => Type::nonNull(Type::string()),
                'quantity' => Type::nonNull(Type::int()),
                'price' => Type::nonNull(Type::float()),
                'attributes' => Type::listOf(new OrderAttributeType()),
            ]
        ]);
    }
}
