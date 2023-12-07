<?php

declare(strict_types=1);

namespace A50\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use A50\EventDispatcher\NullableEventListener;

/**
 * @internal
 */
final class NullableEventListenerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeCallableAndReturnObject(): void
    {
        $listener = new NullableEventListener();
        $event = new stdClass();

        Assert::assertEquals($event, $listener($event));
    }
}
