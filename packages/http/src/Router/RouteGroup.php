<?php

declare(strict_types=1);

namespace A50\Http\Router;

use Webmozart\Assert\Assert;

final class RouteGroup
{
    private string $prefix;
    /**
     * @var Route[]
     */
    private array $routes;
    /**
     * @var array<class-string>
     */
    private array $middlewares;

    /**
     * @param Route[] $routes
     */
    private function __construct(string $prefix, array $routes)
    {
        Assert::stringNotEmpty($prefix);
        Assert::notEmpty($routes);
        Assert::allIsInstanceOf($routes, Route::class);

        $this->prefix = $prefix;
        $this->routes = $routes;
    }

    /**
     * @param Route[] $routes
     */
    public static function withRoutes(string $prefix, array $routes): self
    {
        return new self($prefix, $routes);
    }

    /**
     * @param class-string $middlewareClassName
     */
    public function withMiddleware(string $middlewareClassName): RouteGroup
    {
        $new = clone $this;
        $new->middlewares[] = $middlewareClassName;

        return $new;
    }

    public function prefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return Route[]
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @return array<class-string>
     */
    public function middlewares(): array
    {
        return $this->middlewares;
    }
}
