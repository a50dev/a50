<?php

declare(strict_types=1);

namespace A50\Directories\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Directories\DirectoriesConfig;

/**
 * @internal
 */
final class DirectoriesConfigTest extends TestCase
{
    /**
     * @test
     */
    public static function shouldBeAbleToBeCreatedWithDefaults(): void
    {
        $config = DirectoriesConfig::withDefaults();

        Assert::assertIsArray($config->directories());
        Assert::assertEmpty($config->directories());
    }

    /**
     * @test
     */
    public static function shouldBeAbleToAddNewDirectory(): void
    {
        $config = DirectoriesConfig::withDefaults();
        $newConfig = $config->withDirectory('@directory', __DIR__);

        Assert::assertEquals(['@directory' => __DIR__  . '/'], $newConfig->directories());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenAliasIsEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $config = DirectoriesConfig::withDefaults();
        $config->withDirectory('', __DIR__);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenPathIsEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $config = DirectoriesConfig::withDefaults();
        $config->withDirectory('@directory', '');
    }
}
