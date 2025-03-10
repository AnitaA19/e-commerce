<?php
require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\GraphQL;
use App\GraphQL\GraphQLSchema;
use GraphQL\Type\Schema;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); 
    exit;
}

header('Content-Type: application/json');

try {
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);

    if ($input === null) {
        echo json_encode(["error" => "No JSON input received"]);
        exit;
    }
    if (!isset($input['query'])) {
        echo json_encode(["error" => "Missing 'query' key in request"]);
        exit;
    }

    $schema = new Schema([
        'query' => GraphQLSchema::buildQuery(),
        'mutation' => GraphQLSchema::buildMutation()
    ]);

    $result = GraphQL::executeQuery($schema, $input['query'], null, null, $input['variables'] ?? []);
    echo json_encode($result->toArray(), JSON_PRETTY_PRINT);
} catch (\Exception $e) {
    echo json_encode([
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}