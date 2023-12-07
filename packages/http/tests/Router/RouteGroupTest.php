<?php

declare(strict_types=1);

namespace A50\Http\Tests\Router;

use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use A50\Http\Router\Route;
use A50\Http\Router\RouteGroup;

/**
 * @internal
 */
final class RouteGroupTest extends TestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionIfPrefixIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RouteGroup::withRoutes('', [
            /** @phpstan-ignore-next-line */
            $this->createStub(Route::class),
        ]);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfRoutesIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        RouteGroup::withRoutes('/prefix', []);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfRouteIsNotInstanceOfRoute(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line */
        RouteGroup::withRoutes('/prefix', [
            /** @phpstan-ignore-next-line */
            $this->createStub(Route::class),
            $this->createStub(stdClass::class),
        ]);
    }

    /**
     * @test
     */
    public function shouldCanBeCreatedWithPrefixAndRoutes(): void
    {
        $routes = [
            /** @phpstan-ignore-next-line */
            $this->createStub(Route::class),
        ];

        $group = RouteGroup::withRoutes('/prefix', $routes);

        Assert::assertEquals('/prefix', $group->prefix());
        Assert::assertEquals($routes, $group->routes());
    }
}
