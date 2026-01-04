<?php

declare(strict_types=1);

namespace MicroRuntime\Infrastructure\Socket;

final class TcpSocket
{
    private string $host;
    private int $port;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function listen(callable $handler): void
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($socket, $this->host, $this->port);
        socket_listen($socket);

        echo "Listening on {$this->host}:{$this->port}\n";

        $client = socket_accept($socket);

        if ($client === false) {
            echo "Failed to accept connection\n";
            socket_close($socket);
            return;
        }

        $input = socket_read($client, 1024) ?: '';

        $response = $handler($input);

        socket_write($client, $response);

        socket_close($client);
        socket_close($socket);      
    }
}

