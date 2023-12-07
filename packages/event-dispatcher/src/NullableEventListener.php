<?php

declare(strict_types=1);

namespace A50\EventDispatcher;

final class NullableEventListener
{
    public function __invoke(object $event): object
    {
        return $event;
    }
}
