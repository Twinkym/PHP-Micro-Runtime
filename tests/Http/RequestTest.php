<?php

declare(strict_types=1);

namespace MicroRuntime\Tests\Http;

use PHPUnit\Framework\TestCase;
use MicroRuntime\Domain\Http\Request;

final class RequestTest extends TestCase
{
    public function test_it_parses_method_and_uri(): void
    {
        $raw = "GET /health HTTP/1.1\r\nHost: localhost\r\n\r\n";

        $request = Request::fromRaw($raw);

        $this->assertEquals('GET', $request->method());
        $this->assertEquals('/health', $request->uri());
    }

    public function test_it_returns_null_for_missing_header(): void
    {
        $raw = "GET / HTTP/1.1\r\nHost: localhost\r\n\r\n";

        $request = Request::fromRaw($raw);

        $this->assertNull($request->header('Authorization'));
    }
}