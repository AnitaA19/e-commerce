<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

class PriceType extends ObjectType {
    public function __construct(CurrencyType $currencyType) { 
        parent::__construct([
            'name' => 'Price',
            'fields' => [
                'amount' => Type::float(),
                'currency' => [
                    'type' => $currencyType,
                    'resolve' => function($root) {
                        return [
                            'label' => $root['label'],
                            'symbol' => $root['symbol']
                        ];
                    }
                ]
            ]
        ]);
    }
}
