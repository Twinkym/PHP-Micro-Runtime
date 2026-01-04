<?php

declare(strict_types=1);

namespace MicroRuntime\Domain\Http;

final class Request
{
    private string $method;
    private string $uri;
    private array $headers;

    private function __construct(string $method, string $uri, array $headers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
    }

    public static function fromRaw(string $raw): self
    {
        $lines = preg_split("/\r\n|\n|\r/", trim($raw));

        $requestLine = array_shift($lines);
        [$method, $uri] = explode(' ', $requestLine);

        $headers = [];

        foreach ($lines as $line) {
            if (str_contains($line, ':')) {
                [$key, $value] = explode(':', $line, 2);
                $headers[trim($key)] = trim($value);
            }
        }

        return new self(
            strtoupper($method),
            $uri, $headers
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function header(string $key, ?String $default = null): ?string
    {
        return $this->headers[$key] ?? $default;
    }
}

?>