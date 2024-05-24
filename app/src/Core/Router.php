<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $route, callable $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback
        ];
    }

    public function dispatch(string $requestUri, string $requestMethod): void
    {
        foreach ($this->routes as $route) {
            if ($route['route'] === $requestUri && $route['method'] === $requestMethod) {
                call_user_func($route['callback']);
                return;
            }
        }
        http_response_code(404);
    }
}
