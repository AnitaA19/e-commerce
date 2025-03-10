<?php
namespace App\GraphQL\Resolvers;

use App\Models\Category;
use App\Config\Database;
use App\Repository\CategoryRepository;

class CategoryResolver {
    private $categoryRepository;

    public function __construct() {
        $db = new Database();
        $this->categoryRepository = new CategoryRepository($db->getConnection());
    }

    public function resolveCategories() {
        return $this->categoryRepository->getAllCategories();
    }    

    public function resolveCategoryById($root, $args) {
        $categoryData = $this->categoryRepository->getCategoryById($args['id']);
    
        if (!$categoryData) {
            return null;
        }
    
        return [
            'id' => $categoryData['id'],
            'name' => $categoryData['name']
        ];
    }
    
    
}