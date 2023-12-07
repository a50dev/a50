<?php

declare(strict_types=1);

namespace A50\Environment\Tests\Unit;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use A50\Directories\Directories;
use A50\Directories\DirectoriesConfig;
use A50\Directories\FilesystemDirectories;
use A50\Environment\EnvironmentValuesUsingEnv;

/**
 * @internal
 */
final class EnvironmentValuesUsingEnvTest extends TestCase
{
    private Directories $directories;

    protected function setUp(): void
    {
        parent::setUp();
        $this->directories = FilesystemDirectories::fromConfig(
            DirectoriesConfig::withDefaults([
                '@root' => dirname(__DIR__),
            ])
        );
    }

    /**
     * @test
     */
    public function shouldReturnCorrectValues(): void
    {
        $_ENV['KEY'] = 'value';

        $environment = new EnvironmentValuesUsingEnv($this->directories);

        Assert::assertEquals('value', $environment->get('KEY'));
        Assert::assertEquals('default', $environment->get('KEY_NOT_EXISTS_WITH_DEFAULT', 'default'));
    }

    /**
     * @test
     */
    public function shouldReadValueFromFileAndTrimContent(): void
    {
        $filePath = '@root/Datasets/db_password';
        $_ENV['DB_PASSWORD_FILE'] = $filePath;

        $environment = new EnvironmentValuesUsingEnv($this->directories);

        Assert::assertEquals('secret', $environment->get('DB_PASSWORD'));
    }

    /**
     * @test
     */
    public function shouldThrowExceptionIfValueDoesntExists(): void
    {
        $environment = new EnvironmentValuesUsingEnv($this->directories);

        $this->expectException(RuntimeException::class);
        /* @phpstan-ignore-next-line */
        Assert::assertNull($environment->get('KEY_NOT_EXISTS'));
    }

    /**
     * @test
     */
    public function shouldMapValues(): void
    {
        $_ENV['BOOLEAN_TRUE'] = 'true';
        $_ENV['BOOLEAN_(TRUE)'] = '(true)';
        $_ENV['BOOLEAN_FALSE'] = 'false';
        $_ENV['BOOLEAN_(FALSE)'] = '(false)';
        $_ENV['EMPTY'] = '';

        $environment = new EnvironmentValuesUsingEnv($this->directories);

        Assert::assertTrue($environment->get('BOOLEAN_TRUE'));
        Assert::assertTrue($environment->get('BOOLEAN_(TRUE)'));
        Assert::assertFalse($environment->get('BOOLEAN_FALSE'));
        Assert::assertFalse($environment->get('BOOLEAN_(FALSE)'));
        Assert::assertEmpty($environment->get('EMPTY'));
    }
}
