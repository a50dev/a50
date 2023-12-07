<?php

declare(strict_types=1);

namespace A50\Http\Providers;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\ServerRequestFilter\FilterServerRequestInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterStack;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\MiddlewarePipe;
use Mezzio\Application as MezzioApplication;
use Mezzio\Container\NotFoundHandlerFactory;
use Mezzio\Container\StreamFactoryFactory;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Helper\UrlHelperMiddlewareFactory;
use Mezzio\Middleware\ErrorResponseGenerator;
use Mezzio\Middleware\WhoopsErrorResponseGenerator;
use Mezzio\MiddlewareContainer;
use Mezzio\MiddlewareFactory;
use Mezzio\Response\ServerRequestErrorResponseGenerator;
use Mezzio\Router\FastRouteRouter;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddlewareFactory;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddlewareFactory;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddlewareFactory;
use Mezzio\Router\Middleware\RouteMiddleware;
use Mezzio\Router\RouteCollector;
use Mezzio\Router\RouteCollectorInterface;
use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Throwable;
use Whoops\RunInterface;
use A50\Container\ServiceProvider;
use A50\Http\Application;
use A50\Http\HttpApplication;
use A50\Http\Middleware\MiddlewaresConfig;
use A50\Http\Response\LaminasResponseFactory;
use A50\Http\Router\Route;
use A50\Http\Router\RouterConfig;
use A50\Http\Whoops\WhoopsConfig;
use A50\Http\Whoops\WhoopsFactory;
use A50\Http\Whoops\WhoopsPageHandler;
use A50\Http\Whoops\WhoopsPageHandlerFactory;

final class HttpServiceProvider implements ServiceProvider
{
    public static function getDefinitions(): array
    {
        return [
            /* Config */
            RouterConfig::class => static fn () => RouterConfig::withDefaults(),
            MiddlewaresConfig::class => static fn () => MiddlewaresConfig::withDefaults(),
            WhoopsConfig::class => static fn () => WhoopsConfig::withDefaults(),

            /* Middlewares */
            ImplicitHeadMiddleware::class => static fn (ContainerInterface $container) => (new ImplicitHeadMiddlewareFactory())($container),
            ImplicitOptionsMiddleware::class => static fn (ContainerInterface $container) => (new ImplicitOptionsMiddlewareFactory())($container),
            MethodNotAllowedMiddleware::class => static fn (ContainerInterface $container) => (new MethodNotAllowedMiddlewareFactory())($container),
            UrlHelperMiddleware::class => static fn (ContainerInterface $container) => (new UrlHelperMiddlewareFactory())($container),
            NotFoundHandler::class => static fn (ContainerInterface $container) => (new NotFoundHandlerFactory())($container),

            /* Whoops */
            RunInterface::class => static fn (ContainerInterface $container) => (new WhoopsFactory())($container),
            WhoopsPageHandler::class => static fn (ContainerInterface $container) => (new WhoopsPageHandlerFactory())($container),

            \A50\Http\Response\ResponseFactory::class => static fn () => new LaminasResponseFactory(),
            StreamInterface::class => static fn (ContainerInterface $container) => (new StreamFactoryFactory())($container),
            ResponseFactoryInterface::class => static fn (ContainerInterface $container) => new ResponseFactory(),

            ServerRequestErrorResponseGenerator::class => static function (): callable {
                return static function (Throwable $e) {
                    $response = (new ResponseFactory())->createResponse(500);
                    $response->getBody()->write(sprintf(
                        'An error occurred: %s',
                        $e->getMessage()
                    ));
                    return $response;
                };
            },
            ServerRequestFactoryInterface::class => static function (ContainerInterface $container): callable {
                /** @var FilterServerRequestInterface|null $filter */
                $filter = $container->has(FilterServerRequestInterface::class)
                    ? $container->get(FilterServerRequestInterface::class)
                    : null;

                return static fn (): ServerRequest => ServerRequestFactory::fromGlobals(null, null, null, null, null, $filter);
            },
            RouterInterface::class => static function (ContainerInterface $container) {
                /** @var RouterConfig $config */
                $config = $container->get(RouterConfig::class);

                $cacheEnabled = $config->cacheFile() !== null;
                $options = [
                    'cache_enabled' => $cacheEnabled,
                ];

                if ($cacheEnabled) {
                    $options['cache_file'] = $config->cacheFile();
                }

                /* @phpstan-ignore-next-line */
                return new FastRouteRouter(null, null, $options);
            },
            RouteCollectorInterface::class => static function (ContainerInterface $container) {
                /** @var RouterInterface $router */
                $router = $container->get(RouterInterface::class);

                return new RouteCollector(
                    $router,
                    true,
                );
            },
            ErrorResponseGenerator::class => static function (ContainerInterface $container) {
                /** @var RunInterface $whoops */
                $whoops = $container->get(RunInterface::class);

                return new WhoopsErrorResponseGenerator($whoops);
            },
            ErrorHandler::class => static function (ContainerInterface $container) {
                /** @var ErrorResponseGenerator $generator */
                $generator = $container->get(ErrorResponseGenerator::class);

                return new ErrorHandler(static fn (): Response => new Response(), $generator);
            },
            Application::class => static function (ContainerInterface $container) {
                $pipeline = new MiddlewarePipe();

                $stack = new EmitterStack();
                $stack->push(new SapiEmitter());
                $emitter = $stack;

                /** @var callable $serverRequestFactory */
                $serverRequestFactory = $container->get(ServerRequestFactoryInterface::class);

                /** @var callable $serverRequestErrorResponseGenerator */
                $serverRequestErrorResponseGenerator = $container->get(ServerRequestErrorResponseGenerator::class);

                $requestHandlerRunner = new RequestHandlerRunner(
                    $pipeline,
                    $emitter,
                    $serverRequestFactory,
                    $serverRequestErrorResponseGenerator,
                );

                $middlewareFactory = new MiddlewareFactory(
                    new MiddlewareContainer($container)
                );
                /** @var RouteCollectorInterface $routeCollector */
                $routeCollector = $container->get(RouteCollectorInterface::class);

                $application = new MezzioApplication(
                    $middlewareFactory,
                    $pipeline,
                    $routeCollector,
                    $requestHandlerRunner,
                );

                // The error handler should be the first (most outer) middleware to catch
                // all Exceptions.
                $application->pipe(ErrorHandler::class);
                $application->pipe(ServerUrlMiddleware::class);

                // Pipe more middleware here that you want to execute on every request:
                // - bootstrapping
                // - pre-conditions
                // - modifications to outgoing responses
                //
                // Piped Middleware may be either callables or service names. Middleware may
                // also be passed as an array; each item in the array must resolve to
                // middleware eventually (i.e., callable or service name).
                //
                // Middleware can be attached to specific paths, allowing you to mix and match
                // applications under a common domain.  The handlers in each middleware
                // attached this way will see a URI with the matched path segment removed.
                //
                // i.e., path of "/api/member/profile" only passes "/member/profile" to $apiMiddleware
                // - $app->pipe('/api', $apiMiddleware);
                // - $app->pipe('/docs', $apiDocMiddleware);
                // - $app->pipe('/filesystem', $filesMiddleware);

                // Register the routing middleware in the middleware pipeline.
                // This middleware registers the Mezzio\Router\RouteResult request attribute.
                $application->pipe(RouteMiddleware::class);

                // The following handle routing failures for common conditions:
                // - HEAD request but no routes answer that method
                // - OPTIONS request but no routes answer that method
                // - method not allowed
                // Order here matters; the MethodNotAllowedMiddleware should be placed
                // after the Implicit*Middleware.
                $application->pipe(ImplicitHeadMiddleware::class);
                $application->pipe(ImplicitOptionsMiddleware::class);
                $application->pipe(MethodNotAllowedMiddleware::class);

                // Seed the UrlHelper with the routing results:
                $application->pipe(UrlHelperMiddleware::class);

                // Add more middleware here that needs to introspect the routing results; this
                // might include:
                //
                // - route-based authentication
                // - route-based validation
                // - etc.

                // Register the dispatch middleware in the middleware pipeline
                $application->pipe(DispatchMiddleware::class);

                // At this point, if no Response is returned by any middleware, the
                // NotFoundHandler kicks in; alternately, you can provide other fallback
                // middleware to execute.
                $application->pipe(NotFoundHandler::class);

                /* Routes */
                /** @var RouterConfig $config */
                $config = $container->get(RouterConfig::class);
                $routes = $config->routes();

                foreach ($routes as $route) {
                    $application->route($route->path(), $route->handler(), [$route->httpMethod()], $route->name());
                }

                return new HttpApplication($application);
            },
        ];
    }

    public static function getExtensions(): array
    {
        return [];
    }
}
