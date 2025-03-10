<?php
namespace App\GraphQL\Resolvers;

use App\Repository\GalleryRepository;

class GalleryResolver {
    private $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository) {
        $this->galleryRepository = $galleryRepository;
    }

    public function resolveGallery($root) {
        if (isset($root['id'])) {
            return $this->galleryRepository->getGalleryByProductId($root['id']);
        }
        return [];
    }
}