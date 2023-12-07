<?php

declare(strict_types=1);

namespace A50\Http\Tests\Router;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Http\Router\Route;
use A50\Http\Router\RouteGroup;
use A50\Http\Router\RouterConfig;

/**
 * @internal
 */
final class RouterConfigTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCanBeCreatedWithDefaults(): void
    {
        $defaultConfig = RouterConfig::withDefaults();

        Assert::assertIsArray($defaultConfig->routes());
        Assert::assertIsArray($defaultConfig->groups());

        Assert::assertEmpty($defaultConfig->routes());
        Assert::assertEmpty($defaultConfig->groups());
    }

    /**
     * @test
     */
    public function shouldCanBeAbleToAddRoute(): void
    {
        $defaultConfig = RouterConfig::withDefaults();

        /* @phpstan-ignore-next-line */
        $route = $this->createStub(Route::class);
        $newConfig = $defaultConfig->withRoute($route);

        Assert::assertEquals([$route], $newConfig->routes());
    }

    /**
     * @test
     */
    public function shouldCanBeAbleToAddRouteGroup(): void
    {
        $defaultConfig = RouterConfig::withDefaults();

        /* @phpstan-ignore-next-line */
        $group = $this->createStub(RouteGroup::class);
        $newConfig = $defaultConfig->withGroup($group);

        Assert::assertEquals([$group], $newConfig->groups());
    }
}
