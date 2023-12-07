<?php

declare(strict_types=1);

namespace A50\Middleware\Cors;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    private CorsConfig $config;

    public function __construct(CorsConfig $config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        $requestHeaders = !empty($this->config->allowedHeaders())
            ? $this->config->allowedHeaders()
            : $request->getHeaderLine('Access-Control-Request-Headers');

        $response = $response
            ->withHeader('Access-Control-Allow-Origin', implode(', ', $this->config->allowedOrigins()))
            ->withHeader('Access-Control-Allow-Methods', implode(', ', $this->config->allowedMethods()))
            ->withHeader('Access-Control-Allow-Headers', $requestHeaders);

        if ($this->config->maxAge()) {
            $response = $response->withHeader('Access-Control-Max-Age', $this->config->maxAge());
        }

        // Optional: Allow Ajax CORS requests with Authorization header
        if ($this->config->supportsCredentials()) {
            $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
        }

        return $response;
    }
}
