<?php

declare(strict_types=1);

namespace A50\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;

interface EventDispatcher extends EventDispatcherInterface
{
    public function dispatchAll(array $events): array;
}
