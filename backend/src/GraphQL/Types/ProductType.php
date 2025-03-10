<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use App\GraphQL\Resolvers\CategoryResolver;
use App\GraphQL\Resolvers\AttributeResolver;
use App\GraphQL\Resolvers\BrandResolver;
use App\GraphQL\Resolvers\PriceResolver;
use App\GraphQL\Resolvers\GalleryResolver;
use App\Repository\AttributeRepository;
use App\Repository\BrandRepository;
use App\Repository\PriceRepository;
use App\Repository\GalleryRepository;
use App\Config\Database;
use App\Models\SizeAttribute;
use App\Models\ColorAttribute;

class ProductType extends ObjectType {
    public function __construct() {
        $db = new Database();
        $repository = new AttributeRepository($db->getConnection());
        $brandRepository = new BrandRepository($db->getConnection());
        $priceRepository = new PriceRepository($db->getConnection());
        $galleryRepository = new GalleryRepository($db->getConnection());

        $sizeAttribute = new SizeAttribute($repository);
        $colorAttribute = new ColorAttribute($repository);
        $attributeResolver = new AttributeResolver($sizeAttribute, $colorAttribute, $repository);
        $brandResolver = new BrandResolver($brandRepository);
        $priceResolver = new PriceResolver($priceRepository);
        $galleryResolver = new GalleryResolver($galleryRepository);

        parent::__construct([
            'name' => 'Product',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'name' => Type::nonNull(Type::string()),
                'description' => Type::string(),
                'inStock' => Type::nonNull(Type::boolean()),
               'category' => [
   'type' => CategoryType::getInstance(),
    'resolve' => function ($root) {
        error_log("Resolving category for product: " . print_r($root, true)); 
        if (isset($root['category_id']) && !empty($root['category_id'])) {
            $categoryResolver = new CategoryResolver();
            $category = $categoryResolver->resolveCategoryById(null, ['id' => $root['category_id']]);
            error_log("Resolved category: " . print_r($category, true)); 
            return $category;
        }
        return null;
    }
],
                'attributes' => [
                    'type' => Type::listOf(new AttributeSetType()),
                    'resolve' => function($root) use ($attributeResolver) {
                        return $attributeResolver->resolveAttributes($root) ?: [];
                    }
                ],
                'attribute' => [
    'type' => new AttributeType(),
    'args' => [
        'id' => Type::nonNull(Type::int())
    ],
    'resolve' => function($root, $args) use ($attributeResolver) {
        return $attributeResolver->resolveAttributeById($root, $args);
    }
],

                'prices' => [
    'type' => Type::listOf(new PriceType(new CurrencyType())),
    'resolve' => function ($root) {
        $priceRepository = new PriceRepository((new Database())->getConnection());
        return $priceRepository->getPricesByProductId($root['id']);
    }
],
                'brand' => [
                    'type' => Type::string(),
                    'resolve' => function($root) use ($brandResolver) {
                        return $brandResolver->resolveBrandName($root);
                    }
                ],
                'gallery' => [
                    'type' => Type::listOf(Type::string()),
                    'resolve' => function($root) use ($galleryResolver) {
                        return $galleryResolver->resolveGallery($root);
                    }
                ]
            ]
        ]);
    }
}