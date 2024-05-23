<?php
declare(strict_types=1);

namespace App\Core;

class Router {
    private array $routes = [];

    public function add($method, $route, $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback
        ];
    }

    public function dispatch($requestUri, $requestMethod): void
    {
        foreach ($this->routes as $route) {
            if ($route['route'] === $requestUri && $route['method'] === $requestMethod) {
                call_user_func($route['callback']);
                return;
            }
        }
        // ルートが見つからない場合
        http_response_code(404);
        echo "404 Not Found";
    }
}
