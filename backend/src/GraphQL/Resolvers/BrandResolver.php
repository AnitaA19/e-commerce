<?php
namespace App\GraphQL\Resolvers;

use App\Repository\BrandRepository;

class BrandResolver {
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository) {
        $this->brandRepository = $brandRepository;
    }

    public function resolveBrandName($root) {
        if (isset($root['brand_id'])) {
            return $this->brandRepository->getBrandNameById($root['brand_id']);
        }
        return null;
    }
}
