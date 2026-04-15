<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Load database config (also starts session & loads .env)
require_once __DIR__ . '/../config/db.php';

// Load helpers
require_once __DIR__ . '/../app/helpers/ApiResponse.php';
require_once __DIR__ . '/../app/helpers/Auth.php';
require_once __DIR__ . '/../app/helpers/Router.php';

// CORS headers — must specify exact origin (not wildcard) when credentials are used
$allowedOrigins = [
    'http://localhost',
    'http://127.0.0.1',
    'http://localhost:5173',
];
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins, true)) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header('Access-Control-Allow-Origin: http://localhost');
}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Load all routes
require_once __DIR__ . '/../config/routes.php';

// Dispatch the request
$router->dispatch();