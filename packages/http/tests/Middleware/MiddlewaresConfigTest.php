<?php

declare(strict_types=1);

namespace A50\Http\Tests\Middleware;

use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use A50\Http\Middleware\MiddlewaresConfig;

/**
 * @internal
 */
final class MiddlewaresConfigTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCanBeCreatedWithDefaults(): void
    {
        $config = MiddlewaresConfig::withDefaults();

        Assert::assertIsArray($config->middlewares());
        Assert::assertEmpty($config->middlewares());
    }

    /**
     * @test
     */
    public function shouldBeAbleToAddMiddleware(): void
    {
        $config = MiddlewaresConfig::withDefaults();

        $middleware = TestMiddleware::class;
        $newConfig = $config->withMiddleware($middleware);

        Assert::assertEquals([
            'common' => [$middleware],
        ], $newConfig->middlewares());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfMiddlewareIsNotMiddlewareInterface(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $config = MiddlewaresConfig::withDefaults();

        $middleware = stdClass::class;
        $newConfig = $config->withMiddleware($middleware);

        Assert::assertEquals([
            'common' => [$middleware],
        ], $newConfig->middlewares());
    }
}
