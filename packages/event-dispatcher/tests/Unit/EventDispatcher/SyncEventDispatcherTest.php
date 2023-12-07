<?php

declare(strict_types=1);

namespace A50\EventDispatcher\Tests\Unit\EventDispatcher;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;
use A50\EventDispatcher\SyncEventDispatcher;
use A50\EventDispatcher\Tests\Datasets\EventDispatcher\Application\SendEmailToModerator;
use A50\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostId;
use A50\EventDispatcher\Tests\Datasets\EventDispatcher\Domain\PostWasCreated;

/**
 * @internal
 */
final class SyncEventDispatcherTest extends TestCase
{
    /**
     * @test
     */
    public function shouldDispatch(): void
    {
        $event = PostWasCreated::withId(
            PostId::fromString('00000000-0000-0000-0000-000000000000')
        );

        $listeners = [
            $listener = new SendEmailToModerator(),
        ];
        $registry = $this->createMock(ListenerProviderInterface::class);
        $registry->expects(self::atLeastOnce())
            ->method('getListenersForEvent')
            ->with($event)
            ->willReturn($listeners);

        $dispatcher = new SyncEventDispatcher($registry);

        Assert::assertEquals($event, $dispatcher->dispatch($event));
        Assert::assertTrue($listener->isWasCalled());
    }
}
