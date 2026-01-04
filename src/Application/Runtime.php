<?php

declare(strict_types=1);

namespace MicroRuntime\Application;

use MicroRuntime\Infrastructure\Socket\TcpSocket;
use MicroRuntime\Domain\Http\Request;
use MicroRuntime\Domain\Http\Response;
use MicroRuntime\Application\Http\Router;


final class Runtime
{
    private TcpSocket $socket;
    private Router $router;
    private bool $running = true;

    public function __construct(TcpSocket $socket, Router $router)
    {
        $this->socket = $socket;
        $this->router = $router;
    }

    public function run(): void 
    {
        $this->socket->open();

        while ($this->running) {
            $client = $this->socket->accept();

            if ($client === false) {
                continue;
            }

            $input = $this->socket->read($client);
            
            $request = Request::fromRaw($input);
            $response = $this->router->dispatch($request);

            $this->socket->write($client, $response->toHttpString());
            $this->socket->closeClient($client);
        }

        $this->socket->close();
    }

    public function stop(): void 
    {
        $this->running = false;
    }
}