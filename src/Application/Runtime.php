<?php

declare(strict_types=1);

namespace MicroRuntime\Application;

use MicroRuntime\Infrastructure\Socket\TcpSocket;

final class Runtime
{
    private TcpSocket $socket;
    private bool $running = true;

    public function __construct(TcpSocket $socket)
    {
        $this->socket = $socket;
    }

    public function run(callable $handler): void 
    {
        $this->socket->open();

        while ($this->running) {
            $client = $this->socket->accept();

            if ($client === false) {
                continue;
            }

            $input = $this->socket->read($client);
            $output = $handler($input);

            $this->socket->write($client, $output);
            $this->socket->closeClient($client);
        }

        $this->socket->close();
    }

    public function stop(): void 
    {
        $this->running = false;
    }
}