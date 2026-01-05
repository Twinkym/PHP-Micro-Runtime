<?php

declare(strict_types=1);

namespace Tests\Http;

use PHPUnit\Framework\TestCase;
use MicroRuntime\Domain\Http\Response;
use MicroRuntime\Domain\Http\Request;
use MicroRuntime\Application\Http\Router;

final class RouterTest extends TestCase
{
    public function test_it_returns_for_known_route(): void
    {
        $router = new Router();

        $router->get('/', fn () => new Response('Home'));

        $request = Request::fromRaw("GET / HTTP/1.1\r\nHost: localhost\r\n\r\n");

        $response = $router->dispatch($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('Home', $response->toHttpString());
    }

    public function test_it_returns404_for_unknown_route(): void
    {
        $router = new Router();

        $request = Request::fromRaw("GET /unknown HTTP/1.1\r\nHost: localhost\r\n\r\n");

        $response = $router->dispatch($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('404 Not Found', $response->toHttpString());

    }
}

?>