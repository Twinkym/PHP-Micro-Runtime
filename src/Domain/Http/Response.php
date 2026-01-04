<?php

declare(strict_types=1);

namespace MicroRuntime\Domain\Http;

final class Response
{
    private int $status;
    private array $headers = [];
    private string $body;

    private const STATUS_TEXT = [
        200 => 'OK',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    public function __construct(string $body, int $status = 200)
    {
        $this->body = $body;
        $this->status = $status;

        $this->headers['Content-length'] = (string) strlen($body);
        $this->headers['Content-Type'] = 'text/plain; charset=UTF-8';
        $this->headers['Connection'] = 'close';
    }

    public function toHttpString(): string
    {
        $statusText = self::STATUS_TEXT[$this->status] ?? 'OK';

        $lines = [];
        $lines[] = "HTTP/1.1 {$this->status} {$statusText}";

        foreach ($this->headers as $key => $value) {
            $lines[] = "{$key}: {$value}";
        }

        return implode("\r\n", $lines) . "\r\n\r\n" . $this->body;
    }
}