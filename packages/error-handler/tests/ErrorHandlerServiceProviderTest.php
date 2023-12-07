<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\ErrorHandler\ErrorHandler;
use A50\ErrorHandler\ErrorHandlerConfig;
use A50\ErrorHandler\ErrorHandlerServiceProvider;

/**
 * @internal
 */
final class ErrorHandlerServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainDefinitions(): void
    {
        Assert::assertEquals([
            ErrorHandler::class,
            ErrorHandlerConfig::class,
        ], array_keys(ErrorHandlerServiceProvider::getDefinitions()));
    }
}
