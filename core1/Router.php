<?php
namespace core;

class Router{

    /**
     * Associative array of routes (the routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $params = [];

        /**
     * String containig the route extracted from URL
     * @var array
     */
    protected $incomingRoute = '';

    /**
     * String containig the parameters extracted from URL
     * @var array
     */
    protected $incomingParams = '';

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $executionPackage = [];
 
    /**
     * Add a route to the routing table
     * @param string $route The route URL
     * @param array  $params Parameters (controller, action, etc)
     */
    public function add($route, $params)
    {
        $this->routes[] = array('route' => $route, 'params' => $params);
    }

        /**
     * Get incoming route
     * 
     * @return array  
     */
    public function getIncomingRoute()
    {
        return $this->incomingRoute;
    }

    /**
     * Get all the params from the routing table
     * 
     * @return array  
     */
    public function getIncomingParams()
    {
        return $this->incomingParams;
    }

    private function validateRoute($incomingRoute, $incomingParams)
    {
        $request = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            if ($route['route'] === $incomingRoute && $route['params']['request'] === $request && !($incomingParams xor isset($route['params']['args']))) {
                $this->executionPackage = array_merge($route['params'], ['payload' => $incomingParams]);
                return true;
            }
        }
        return false;
    }

    /**
     * Match the REST route to the routes in the routing table, setting the $params
     * property if a route is found
     * 
     * @param string $url The route URL
     * 
     * @return boolean true if a match found, false otherwise
     */
    public function match ($query_string_received)
    {
        $reg_exp = "/[&=?]/";

        $query_parts = explode('/', $query_string_received);

        foreach ($query_parts as $part) {
            if (preg_match($reg_exp, $part)) {
                $this->incomingParams = rtrim($part, "/");
            } else {
                $this->incomingRoute .= '/' . rtrim($part, "/");
            }
        }

        if ($this->validateRoute($this->incomingRoute, $this->incomingParams)) {
            return true;
        }

        $this->incomingRoute = '/' . implode( '/',array_slice($query_parts, 0, sizeof($query_parts) - 1));
        $this->incomingParams = $query_parts[sizeof($query_parts) - 1];

        if ($this->validateRoute($this->incomingRoute, $this->incomingParams)) {
            return true;
        }

        return false; 
    }

    /**
     * Dispatches the route by calling the appropriate controller method
     */
    public function dispatch()
    {
        $controller = $this->executionPackage['controller'];
        $action = $this->executionPackage['action'];
        $id = $this->executionPackage['payload'] ?? null;

        if (class_exists($controller)) {
            $controller_object = new $controller($this->executionPackage);
            if (is_callable([$controller_object, $action])) {
                $controller_object->$action($id);
            } else {
                http_response_code(404);
                throw new \Exception("Method $action (in controller $controller) not found");
            }
        } else {
            http_response_code(404);
            throw new \Exception("Controller class $controller not found");
        }
    }
}
