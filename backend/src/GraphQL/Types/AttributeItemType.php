<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class AttributeItemType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'AttributeItem',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'displayValue' => Type::string(),
                'value' => Type::string(),
            ]
        ]);
    }
}
