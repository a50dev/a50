<?php

declare(strict_types=1);

namespace A50\Console\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Console\Application;
use A50\Console\ConsoleConfig;
use A50\Console\ConsoleApplicationProvider;

/**
 * @internal
 */
final class ConsoleApplicationProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainDefinitions(): void
    {
        Assert::assertEquals([
            ConsoleConfig::class,
            Application::class,
        ], array_keys(ConsoleApplicationProvider::getDefinitions()));
    }
}
