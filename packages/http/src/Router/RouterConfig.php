<?php

declare(strict_types=1);

namespace A50\Http\Router;

use Webmozart\Assert\Assert;

final class RouterConfig
{
    /**
     * @var Route[]
     */
    private array $routes;
    /**
     * @var RouteGroup[]
     */
    private array $groups;
    private ?string $cacheFile;

    /**
     * @param Route[] $routes
     * @param RouteGroup[] $groups
     */
    private function __construct(array $routes, array $groups, ?string $cacheFile)
    {
        Assert::allIsInstanceOf($routes, Route::class);
        Assert::allIsInstanceOf($groups, RouteGroup::class);

        $this->routes = $routes;
        $this->groups = $groups;
        $this->cacheFile = $cacheFile;
    }

    /**
     * @param Route[] $routes
     * @param RouteGroup[] $groups
     * @return static
     */
    public static function withDefaults(array $routes = [], array $groups = [], ?string $cacheFile = null): self
    {
        return new self($routes, $groups, $cacheFile);
    }

    public function withRoute(Route $route): self
    {
        $new = clone $this;
        $new->routes[] = $route;

        return $new;
    }

    public function withGroup(RouteGroup $routeGroup): self
    {
        $new = clone $this;
        $new->groups[] = $routeGroup;

        return $new;
    }

    public function withCacheFile(?string $cacheFile): self
    {
        $new = clone $this;
        $new->cacheFile = $cacheFile;

        return $new;
    }

    /**
     * @return Route[]
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @return RouteGroup[]
     */
    public function groups(): array
    {
        return $this->groups;
    }

    public function cacheFile(): ?string
    {
        return $this->cacheFile;
    }
}
