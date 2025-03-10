<?php
namespace App\Controller;

use GraphQL\GraphQL;
use App\GraphQL\GraphQLSchema;

class GraphQLHandler {
    public static function handle($query, $variables = []) {
        try {
            $schema = GraphQLSchema::buildSchema();

            $result = GraphQL::executeQuery($schema, $query, null, null, $variables);
            return $result->toArray();
        } catch (\Exception $e) {
            return [
                'errors' => [
                    ['message' => $e->getMessage()]
                ]
            ];
        }
    }
}