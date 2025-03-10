<?php
require_once __DIR__ . '/vendor/autoload.php'; 
require_once __DIR__ . '/src/config/Database.php';

use App\Config\Database;

$database = new Database();
$db = $database->getConnection();

if ($db) {
    fwrite(STDOUT, "Database connection successful\n");
} else {
    fwrite(STDERR, "Database connection failed\n");
}
