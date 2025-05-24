<?php

require_once 'vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\AuthController;
use App\Controllers\EventController;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set headers for CORS and JSON
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Parse the URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/endama2/', '', $uri);
$segments = explode('/', trim($uri, '/'));

// Set default controller and action
$controller = !empty($segments[0]) ? $segments[0] : 'events';
$action = isset($segments[1]) ? $segments[1] : 'index';
$param = isset($segments[2]) ? $segments[2] : null;

try {
    switch ($controller) {
        case 'auth':
            $controllerInstance = new AuthController();
            switch ($action) {
                case 'register':
                    $controllerInstance->register();
                    break;
                case 'login':
                    $controllerInstance->login();
                    break;
                case 'logout':
                    $controllerInstance->logout();
                    break;
                default:
                    throw new Exception('Action not found');
            }
            break;

        case 'event':
        case 'events':
            $controllerInstance = new EventController();
            switch ($action) {
                case '':
                case 'index':
                    $controllerInstance->index();
                    break;
                case 'create':
                    $controllerInstance->create();
                    break;
                case 'update':
                    $controllerInstance->update($param);
                    break;
                case 'delete':
                    $controllerInstance->delete($param);
                    break;
                case 'register':
                    $controllerInstance->register($param);
                    break;
                case 'my-events':
                    $controllerInstance->myEvents();
                    break;
                case 'participants':
                    $controllerInstance->participants($param);
                    break;
                case 'manage':
                    $controllerInstance->manage();
                    break;
                case 'cancel-registration':
                    $controllerInstance->cancelRegistration($param);
                    break;
                default:
                    throw new Exception('Action not found');
            }
            break;

        default:
            // Redirect to events index for the root URL
            if (empty($controller)) {
                $controllerInstance = new EventController();
                $controllerInstance->index();
            } else {
                throw new Exception('Controller not found');
            }
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(['error' => $e->getMessage()]);
} 