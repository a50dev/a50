<?php

declare(strict_types=1);

namespace A50\Environment\Tests\Unit;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Environment\EnvironmentName;

/**
 * @internal
 */
final class EnvironmentNameTest extends TestCase
{
    /**
     * @test
     */
    public function shouldContainValues(): void
    {
        $production = EnvironmentName::PRODUCTION->value;
        Assert::assertIsString($production);
        Assert::assertEquals('prod', $production);
        Assert::assertNotEmpty($production);

        $development = EnvironmentName::DEVELOPMENT->value;
        Assert::assertIsString($development);
        Assert::assertEquals('dev', $development);
        Assert::assertNotEmpty($development);

        $test = EnvironmentName::TEST->value;
        Assert::assertIsString($test);
        Assert::assertEquals('test', $test);
        Assert::assertNotEmpty($test);
    }
}
