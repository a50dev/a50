<?php

declare(strict_types=1);

namespace A50\Http\Tests\Router;

use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use A50\Http\Router\Route;

/**
 * @internal
 */
final class RouteTest extends TestCase
{
    /**
     * @test
     */
    public function routeGetShouldThrowExceptionIfPathIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::get('', HomeAction::class);
    }

    /**
     * @test
     */
    public function routePostShouldThrowExceptionIfPathIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::post('', HomeAction::class);
    }

    /**
     * @test
     */
    public function routePutShouldThrowExceptionIfPathIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::put('', HomeAction::class);
    }

    /**
     * @test
     */
    public function routePatchShouldThrowExceptionIfPathIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::patch('', HomeAction::class);
    }

    /**
     * @test
     */
    public function routeDeleteShouldThrowExceptionIfPathIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::delete('', HomeAction::class);
    }

    /**
     * @test
     */
    public function routeGetShouldThrowExceptionIfHandlerIsNotRequestHandlerInterfaceClass(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::get('/', stdClass::class);
    }

    /**
     * @test
     */
    public function routePostShouldThrowExceptionIfHandlerIsNotRequestHandlerInterfaceClass(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::post('/', stdClass::class);
    }

    /**
     * @test
     */
    public function routePutShouldThrowExceptionIfHandlerIsNotRequestHandlerInterfaceClass(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::put('/', stdClass::class);
    }

    /**
     * @test
     */
    public function routePatchShouldThrowExceptionIfHandlerIsNotRequestHandlerInterfaceClass(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::patch('/', stdClass::class);
    }

    /**
     * @test
     */
    public function routeDeleteShouldThrowExceptionIfHandlerIsNotRequestHandlerInterfaceClass(): void
    {
        $this->expectException(InvalidArgumentException::class);

        /** @phpstan-ignore-next-line  */
        Route::delete('/', stdClass::class);
    }

    /**
     * @test
     */
    public function routeGetShouldCanBeCreatedWithPathAndHandler(): void
    {
        $route = Route::get('/route', HomeAction::class);

        Assert::assertEquals('GET', $route->httpMethod());
        Assert::assertEquals('/route', $route->path());
        Assert::assertEquals(HomeAction::class, $route->handler());
    }

    /**
     * @test
     */
    public function routePostShouldCanBeCreatedWithPathAndHandler(): void
    {
        $route = Route::post('/route', HomeAction::class);

        Assert::assertEquals('POST', $route->httpMethod());
        Assert::assertEquals('/route', $route->path());
        Assert::assertEquals(HomeAction::class, $route->handler());
    }

    /**
     * @test
     */
    public function routePutShouldCanBeCreatedWithPathAndHandler(): void
    {
        $route = Route::put('/route', HomeAction::class);

        Assert::assertEquals('PUT', $route->httpMethod());
        Assert::assertEquals('/route', $route->path());
        Assert::assertEquals(HomeAction::class, $route->handler());
    }

    /**
     * @test
     */
    public function routePatchShouldCanBeCreatedWithPathAndHandler(): void
    {
        $route = Route::patch('/route', HomeAction::class);

        Assert::assertEquals('PATCH', $route->httpMethod());
        Assert::assertEquals('/route', $route->path());
        Assert::assertEquals(HomeAction::class, $route->handler());
    }

    /**
     * @test
     */
    public function routeDeleteShouldCanBeCreatedWithPathAndHandler(): void
    {
        $route = Route::delete('/route', HomeAction::class);

        Assert::assertEquals('DELETE', $route->httpMethod());
        Assert::assertEquals('/route', $route->path());
        Assert::assertEquals(HomeAction::class, $route->handler());
    }
}
