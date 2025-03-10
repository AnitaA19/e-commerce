<?php
namespace App\GraphQL;

use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Resolvers\AttributeResolver;
use App\GraphQL\Resolvers\OrderResolver;
use App\Models\SizeAttribute;
use App\Models\ColorAttribute;
use App\Repository\AttributeRepository;
use App\Config\Database;
use App\GraphQL\Types\OrderType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\InputObjectType;

class GraphQLSchema {
    private static $types = [];

    public static function getType($type) {
        if (!isset(self::$types[$type])) {
            self::$types[$type] = new $type(); 
        }
        return self::$types[$type];
    }

    public static function buildQuery() {
        $db = new Database();
        $repository = new AttributeRepository($db->getConnection());

        $sizeAttribute = new SizeAttribute($repository);
        $colorAttribute = new ColorAttribute($repository);

        $attributeResolver = new AttributeResolver($sizeAttribute, $colorAttribute, $repository);

        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'type' => Type::listOf(self::getType(ProductType::class)),
                    'args' => [
                        'categoryName' => Type::string()  
                    ],
                    'resolve' => [new ProductResolver(), 'resolveProducts']
                ],
                'product' => [
                    'type' => self::getType(ProductType::class),
                    'args' => ['id' => Type::nonNull(Type::string())],
                    'resolve' => [new ProductResolver(), 'resolveProductById']
                ],
                'categories' => [
                    'type' => Type::listOf(CategoryType::getInstance()), 
                    'resolve' => [new CategoryResolver(), 'resolveCategories']
                ],
            ]
        ]);
    }
    
    public static function buildMutation() {
        $orderAttributeInputType = new InputObjectType([
            'name' => 'OrderAttributeInput',
            'fields' => [
                'attribute_set_id' => Type::nonNull(Type::string()),
                'attribute_item_id' => Type::nonNull(Type::string())
            ]
        ]);
        
        $orderInputType = new InputObjectType([
            'name' => 'OrderInput',
            'fields' => [
                'productId' => Type::nonNull(Type::string()),
                'quantity' => Type::nonNull(Type::int()),
                'attributes' => Type::listOf($orderAttributeInputType)
            ]
        ]);
        
        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'placeOrder' => [
                    'type' => self::getType(OrderType::class),
                    'args' => [
                        'items' => Type::nonNull(Type::listOf(Type::nonNull($orderInputType)))
                    ],
                    'resolve' => [new OrderResolver(), 'resolvePlaceOrder']
                ]
            ]
        ]);
    }

    public static function buildSchema() {
        return new Schema([
            'query' => self::buildQuery(),
            'mutation' => self::buildMutation()
        ]);
    }
}