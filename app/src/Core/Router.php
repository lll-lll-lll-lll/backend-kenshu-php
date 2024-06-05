<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $route, callable $callback, callable $middleware = null): void
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback,
            'middleware' => $middleware
        ];
    }

    public function dispatch(string $requestUri, string $requestMethod): void
    {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)}/', '(?P<$1>[a-zA-Z0-9_-]+)', $route['route']);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $requestUri, $matches) && $route['method'] === $requestMethod) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                if (!is_null($route['middleware'])) {
                    $middleware = $route['middleware'];
                    $middleware();
                }
                call_user_func_array($route['callback'], $params);
                return;
            }
        }
        http_response_code(404);
        echo 'Not Found';
    }
}
