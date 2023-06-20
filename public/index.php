<?php
use core\Router;
use Core\Config;
use Core\Controller;

spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . "/" . str_replace("\\", '/', $class) . ".php";
    if (is_readable($file)) {
        require $root . "/" . str_replace("\\", "/", $class) . ".php";
    }
});

(new Config(__DIR__ . '/.env'))->load();

/**
 * Routing 
 */
$router = new Router();

// Add the routes
$router->add('/', ['controller' => 'App\Controllers\HomeController', 'action' => 'index', 'request' => 'GET']); // METHOD GET
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
    $results["success"] = false;
    $results["status"] = 404;
    $results["message"] = "Error: No route found from URL $url";
    $results['error'] = "No route found from URL $url";
    Controller::view('index.php', compact('results'));
    exit();
}