<?php
namespace App\GraphQL\Resolvers;

use App\Repository\PriceRepository; 

class PriceResolver {
    private $priceRepository;

    public function __construct(PriceRepository $priceRepository) {
        $this->priceRepository = $priceRepository;
    }

    public function resolvePrices($root) {
        if (isset($root['id'])) {
            return $this->priceRepository->getPricesByProductId($root['id']);
        }
        return [];
    }
}