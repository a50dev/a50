<?php

declare(strict_types=1);

namespace A50\EventDispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use A50\EventDispatcher\Exceptions\CouldNotFindListener;
use A50\EventDispatcher\Exceptions\ListenerShouldReturnEvent;

final class SyncEventDispatcher implements EventDispatcher
{
    private ListenerProviderInterface $listenerProvider;

    public function __construct(ListenerProviderInterface $listenerProvider)
    {
        $this->listenerProvider = $listenerProvider;
    }

    /**
     * @throws CouldNotFindListener
     * @throws ListenerShouldReturnEvent
     */
    public function dispatch(object $event): object
    {
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $returnedEvent = $listener($event);

            if (! $returnedEvent instanceof $event) {
                throw ListenerShouldReturnEvent::for(
                    listenerClassName: $listener::class,
                    eventClassName: $event::class,
                );
            }

            if ($returnedEvent instanceof StoppableEventInterface
                && $returnedEvent->isPropagationStopped()
            ) {
                break;
            }
        }

        return $event;
    }

    public function dispatchAll(array $events): array
    {
        $dispatchedEvents = [];
        foreach ($events as $event) {
            $dispatchedEvent = $this->dispatch($event);
            $dispatchedEvents[] = $dispatchedEvent;
        }

        return $dispatchedEvents;
    }
}
