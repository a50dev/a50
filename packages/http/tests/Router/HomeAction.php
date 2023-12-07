<?php

declare(strict_types=1);

namespace A50\Http\Tests\Router;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HomeAction implements RequestHandlerInterface
{
    /**
     *
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}
