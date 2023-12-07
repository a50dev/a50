<?php

declare(strict_types=1);

namespace A50\Console\Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use A50\Console\Application;
use A50\Console\ConsoleApplication;

use function array_keys;

/**
 * @internal
 */
final class ConsoleApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCreated(): void
    {
        $application = new ConsoleApplication(
            appName: 'Console App',
        );

        Assert::assertInstanceOf(Application::class, $application);
        Assert::assertEquals('Console App', $application->getName());
        Assert::assertEquals(['help', 'list', '_complete', 'completion'], array_keys($application->getCommands()));
    }
}
