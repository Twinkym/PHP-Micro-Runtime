<?php

declare(strict_types=1);

namespace MicroRuntime\Application;

use MicroRuntime\Infrastructure\Socket\TcpSocket;
use MicroRuntime\Domain\Http\Request;
use MicroRuntime\Domain\Http\Response;


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
            
            $request = Request::fromRaw($input);

            $response = new Response(
                "Hello from PHP Micro Runtime!\n"
            );

            $this->socket->write($client, $response->toHttpString());
            // $this->socket->closeClient($client);
        }

        $this->socket->close();
    }

    public function stop(): void 
    {
        $this->running = false;
    }
}