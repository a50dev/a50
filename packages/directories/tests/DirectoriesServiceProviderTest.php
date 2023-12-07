<?php

declare(strict_types=1);

namespace A50\Directories\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Directories\Directories;
use A50\Directories\DirectoriesConfig;
use A50\Directories\DirectoriesServiceProvider;

/**
 * @internal
 */
final class DirectoriesServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainDefinitions(): void
    {
        Assert::assertEquals([
            Directories::class,
            DirectoriesConfig::class,
        ], \array_keys(DirectoriesServiceProvider::getDefinitions()));
    }
}
