<?php

declare(strict_types=1);

namespace A50\Environment\Tests\Unit;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Environment\CurrentEnvironment;
use A50\Environment\Environment;
use A50\Environment\EnvironmentConfig;
use A50\Environment\EnvironmentServiceProvider;

/**
 * @internal
 */
final class EnvironmentServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainDefinitions(): void
    {
        Assert::assertEquals([
            Environment::class,
            CurrentEnvironment::class,
            EnvironmentConfig::class,
        ], array_keys(EnvironmentServiceProvider::getDefinitions()));
    }
}
