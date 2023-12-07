<?php

declare(strict_types=1);

namespace A50\Directories\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Directories\Directories;
use A50\Directories\DirectoriesConfig;
use A50\Directories\Exception\CouldNotFindDirectoryWithAlias;
use A50\Directories\FilesystemDirectories;

/**
 * @internal
 */
final class FilesystemDirectoriesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCreatedFromDirectoriesConfig(): void
    {
        $config = DirectoriesConfig::withDefaults([
            '@directory' => __DIR__,
        ]);
        $directories = FilesystemDirectories::fromConfig($config);

        Assert::assertInstanceOf(Directories::class, $directories);
        Assert::assertTrue($directories->has('@directory'));
        Assert::assertEquals(__DIR__ . '/', $directories->get('@directory'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfDirectoryDoesntExists(): void
    {
        $this->expectException(CouldNotFindDirectoryWithAlias::class);
        $config = DirectoriesConfig::withDefaults([
            '@directory' => __DIR__,
        ]);
        $directories = FilesystemDirectories::fromConfig($config);
        $directories->get('@directories');
    }

    /**
     * @test
     */
    public function shouldBeAbleToCheckThatDirectoryExists(): void
    {
        $config = DirectoriesConfig::withDefaults([
            '@directory' => __DIR__,
        ]);
        $directories = FilesystemDirectories::fromConfig($config);

        Assert::assertTrue($directories->has('@directory'));
        Assert::assertFalse($directories->has('@directories'));
    }

    /**
     * @test
     */
    public function shouldBeAbleToResolveDirectoryWithAlias(): void
    {
        $config = DirectoriesConfig::withDefaults([
            '@root' => __DIR__,
            '@public' => '@root/public',
        ]);
        $directories = FilesystemDirectories::fromConfig($config);
        Assert::assertEquals(__DIR__ . '/public/', $directories->get('@public'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfDirectoryWithAliasDoesntExists(): void
    {
        $this->expectException(CouldNotFindDirectoryWithAlias::class);
        $config = DirectoriesConfig::withDefaults([
            '@main' => __DIR__,
            '@public' => '@root/public',
        ]);
        $directories = FilesystemDirectories::fromConfig($config);
        $directories->get('@public');
    }
}
