<?php

namespace Core;

/**
 * @todo: comment
 */
class Router
{

    private array $routes = [];
    private array $paramNames = [];

    public function __construct()
    {
        // Routen laden
        $this->loadRoutes();
    }

    private function loadRoutes()
    {
        $webRoutes = require_once __DIR__ . '/../routes/web.php';
        $apiRoutes = require_once __DIR__ . '/../routes/api.php';

        $this->routes = $webRoutes;

        foreach ($apiRoutes as $apiRoute => $callable) {
            $route = "/api/$apiRoute";
            $route = str_replace('//', '/', $route);

            $this->routes[$route] = $callable;
        }
    }

    public function route()
    {
        // Alle Routen durchgehen und mit $_GET['path'] vergleichen
        $path = '';
        if (isset($_GET['path'])) {
            $path = $_GET['path'];
        }

        $path = '/' . rtrim($path, '/');

        $callable = [];
        $params = [];

        if (array_key_exists($path, $this->routes)) {
            $callable = $this->routes[$path];
        } else {
            foreach ($this->routes as $route => $_callable) {
                if (str_contains($route, '{')) {
                    $regex = $this->buildRegex($route);

                    $matches = [];

                    if (preg_match_all($regex, $path, $matches, PREG_SET_ORDER) >= 1) {
                        $callable = $_callable;

                        foreach ($this->paramNames as $paramName) {
                            $params[$paramName] = $matches[0][$paramName];
                        }
                        break;
                    }
                }
            }
        }

        // Controller laden & Action aufrufen
        if (empty($callable)) {
            throw new \Exception('Not Found', 404);
        } else {
            $controller = new $callable[0]();
            $action = $callable[1];

            /**
             * @todo: NEU!
             */
            $controller->$action(...$params);
        }
    }

    private function buildRegex(string $route): string
    {
        $matches = [];
        preg_match_all('/{([a-zA-Z0-9]+)}/', $route, $matches);
        $this->paramNames = $matches[1];

        $regex = str_replace('/', '\/', $route);
        foreach ($this->paramNames as $paramName) {
            $regex = str_replace("{{$paramName}}", "(?<$paramName>[^\/]+)", $regex);
        }

        $regex = "/^$regex$/";

        return $regex;
    }
}
