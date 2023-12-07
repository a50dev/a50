<?php

declare(strict_types=1);

namespace A50\Console\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use A50\Console\ConsoleConfig;

/**
 * @internal
 */
final class ConsoleConfigTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCreatedWithDefaults(): void
    {
        $defaultConfig = ConsoleConfig::withDefaults();

        Assert::assertEquals('Console App', $defaultConfig->appName());
        Assert::assertFalse($defaultConfig->catchExceptions());
        Assert::assertEquals([], array_keys($defaultConfig->commands()));
    }

    /**
     * @test
     */
    public static function shouldBeAbleToChangeName(): void
    {
        $defaultConfig = ConsoleConfig::withDefaults();
        $newConfig = $defaultConfig->withAppName('Super Console App');

        Assert::assertEquals('Super Console App', $newConfig->appName());
    }

    /**
     * @test
     */
    public static function shouldBeAbleToChangeCatchExceptions(): void
    {
        $defaultConfig = ConsoleConfig::withDefaults();
        $newConfig = $defaultConfig->withCatchExceptions(true);

        Assert::assertTrue($newConfig->catchExceptions());
    }

    /**
     * @test
     */
    public static function shouldBeAbleToAddNewCommand(): void
    {
        $defaultConfig = ConsoleConfig::withDefaults();
        $newConfig = $defaultConfig->withCommand(stdClass::class);

        Assert::assertContains(stdClass::class, $newConfig->commands());
    }

    /**
     * @test
     */
    public static function shouldBeAbleToAddNewCommands(): void
    {
        $defaultConfig = ConsoleConfig::withDefaults();
        $newConfig = $defaultConfig->withCommands([stdClass::class]);

        Assert::assertContains(stdClass::class, $newConfig->commands());
    }
}
