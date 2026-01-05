<?php

declare(strict_types=1);

namespace Tests\Http;

use PHPUnit\Framework\TestCase;
use MicroRuntime\Domain\Http\Response;

final class ResponseTest extends TestCase
{
    public function test_it_formats_http_response_string(): void
    {
        $body = "Hello!";
        $response = new Response($body, 200);

        $httpString = $response->toHttpString();

        // status line
        $this->assertStringContainsString("HTTP/1.1 200 OK", $httpString);

        // Headers
        $this->assertStringContainsString("Content-length: " . strlen($body), $httpString);
        $this->assertStringContainsString("Content-Type: text/plain; charset=UTF-8", $httpString);
        
        // Body separator + body
        $this->assertStringContainsString("Connection: close", $httpString);
        $this->assertStringEndsWith("\r\n\r\n" . $body, $httpString);
    }

    public function test_it_handles_unknown_status_code(): void
    {
        $body = "Error occurred";
        $response = new Response($body, 999);

        $httpString = $response->toHttpString();

        $this->assertStringContainsString("HTTP/1.1 999 OK", $httpString);
    }

    public function test_it_supports_custom_status_code(): void
    {
        $response = new Response('Not Found', 404);

        $http = $response->toHttpString();

        $this->assertStringStartsWith('HTTP/1.1 404 Not Found', $http);
    }
}