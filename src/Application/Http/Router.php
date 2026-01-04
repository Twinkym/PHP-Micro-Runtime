<?php

declare(strict_types=1);

namespace MicroRuntime\Application\Http;

use MicroRuntime\Domain\Http\Request;
use MicroRuntime\Domain\Http\Response;

final class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->method();
        $uri = $request->uri();

        if (!isset($this->routes[$method][$uri])) {
            return new Response('404 Not Found', 404);
        }

        $handler = $this->routes[$method][$uri];

        return $handler($request);
    }
}

