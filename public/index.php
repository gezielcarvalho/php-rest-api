<?php
use Core\Router;

spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . "/" . str_replace("\\", '/', $class) . ".php";
    if (is_readable($file)) {
        require $root . "/" . str_replace("\\", "/", $class) . ".php";
    }
});

/**
 * Routing 
 */
$router = new Router();

// Add the routes
$router->add('/', ['controller' => 'Home', 'action' => 'index', 'request' => 'GET']); // METHOD GET
$router->add('/users', ['controller' => 'App\Controllers\UserController', 'action' => 'index', 'request' => 'GET']); // METHOD GET
$router->add('/users', ['controller' => 'App\Controllers\UserController', 'action' => 'show', 'request' => 'GET', 'args' => ['id']]); // METHOD GET
$router->add('/users', ['controller' => 'App\Controllers\UserController', 'action' => 'store', 'request' => 'POST']); // METHOD POST
$router->add('/users', ['controller' => 'App\Controllers\UserController', 'action' => 'update', 'request' => 'PUT', 'args' => ['id']]); // METHOD PUT
$router->add('/users', ['controller' => 'App\Controllers\UserController', 'action' => 'destroy', 'request' => 'DELETE', 'args' => ['id']]); // METHOD DELETE


// Get route from external URL
$url = $_SERVER['QUERY_STRING'];

// Check if route exists
if ($router->match($url)) {
    $router->dispatch(); 
} else {
    header("Content-Type: application/json");
    http_response_code(404);
    echo json_encode(["error" => "No route found from URL $url"]);
}