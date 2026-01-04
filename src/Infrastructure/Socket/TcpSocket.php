<?php

declare(strict_types=1);

namespace MicroRuntime\Infrastructure\Socket;

final class TcpSocket
{
    private string $host;
    private int $port;
    private $socket;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function open(): void
    {
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($this->socket, $this->host, $this->port);
        socket_listen($this->socket);

        echo "Listening on {$this->host}:{$this->port}\n";
    }

    public function accept()
    {
        return socket_accept($this->socket);
    }

    public function read($client, int $length = 1024): string
    {
        return socket_read($client, $length) ?: '';
    }

    public function write($client, string $data): void
    {
        socket_write($client, $data);
    }

    public function closeClient($client): void
    {
        socket_close($client);

    }

    public function close(): void 
    {
        socket_close($this->socket);
    }
}

