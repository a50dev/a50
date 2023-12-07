<?php

declare(strict_types=1);

namespace A50\Environment\Tests\Unit;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Environment\CurrentEnvironment;
use A50\Environment\EnvironmentName;

/**
 * @internal
 */
final class CurrentEnvironmentTest extends TestCase
{
    /**
     * @test
     */
    public function shouldHaveAGivenName(): void
    {
        $environment = new CurrentEnvironment(
            name: EnvironmentName::DEVELOPMENT,
        );

        Assert::assertTrue($environment->isA(EnvironmentName::DEVELOPMENT));
    }
}
