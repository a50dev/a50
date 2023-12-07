<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\ErrorHandler\ErrorHandlerConfig;

/**
 * @internal
 */
final class ErrorHandlerConfigTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCreatedWithDefaults(): void
    {
        $defaultConfig = ErrorHandlerConfig::withDefaults();

        Assert::assertFalse($defaultConfig->catchExceptions());
    }

    /**
     * @test
     */
    public function shouldBeAbleToSetCatchExceptions(): void
    {
        $defaultConfig = ErrorHandlerConfig::withDefaults();
        $newConfig = $defaultConfig->withCatchExceptions(true);

        Assert::assertTrue($newConfig->catchExceptions());
    }
}
