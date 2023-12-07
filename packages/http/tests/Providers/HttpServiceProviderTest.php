<?php

declare(strict_types=1);

namespace A50\Http\Tests\Providers;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Middleware\ErrorResponseGenerator;
use Mezzio\Response\ServerRequestErrorResponseGenerator;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\RouteCollectorInterface;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Whoops\RunInterface;
use A50\Http\Application;
use A50\Http\Middleware\MiddlewaresConfig;
use A50\Http\Providers\HttpServiceProvider;
use A50\Http\Router\RouterConfig;
use A50\Http\Whoops\WhoopsConfig;
use A50\Http\Whoops\WhoopsPageHandler;

/**
 * @internal
 */
final class HttpServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainDefinitions(): void
    {
        Assert::assertEquals([
            /* Config */
            RouterConfig::class,
            MiddlewaresConfig::class,
            WhoopsConfig::class,
            /* Middlewares */
            ImplicitHeadMiddleware::class,
            ImplicitOptionsMiddleware::class,
            MethodNotAllowedMiddleware::class,
            UrlHelperMiddleware::class,
            NotFoundHandler::class,
            /* Whoops */
            RunInterface::class,
            WhoopsPageHandler::class,

            /* PSR */
            \A50\Http\Response\ResponseFactory::class,
            StreamInterface::class,
            ResponseFactoryInterface::class,

            /* Application */
            ServerRequestErrorResponseGenerator::class,
            ServerRequestFactoryInterface::class,
            RouterInterface::class,
            RouteCollectorInterface::class,
            ErrorResponseGenerator::class,
            ErrorHandler::class,
            Application::class,
        ], array_keys(HttpServiceProvider::getDefinitions()));
    }
}
