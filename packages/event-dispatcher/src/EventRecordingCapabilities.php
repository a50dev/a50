<?php

declare(strict_types=1);

namespace A50\EventDispatcher;

use Innmind\Immutable\Sequence;

trait EventRecordingCapabilities
{
    /**
     * Array of events to dispatch.
     * @var object[]
     */
    private readonly Sequence $events;

    /**
     * Register that event was created.
     */
    private function registerThat(object $event): void
    {
        if ($this->events->empty()) {
            $this->events = Sequence::of($event);
        } else {
            $this->events->add($event);
        }
    }

    /**
     * Release array of events.
     * @return object[]
     */
    public function releaseEvents(): array
    {
        $events = $this->events->toList();
        $this->events->clear();

        return $events;
    }
}
