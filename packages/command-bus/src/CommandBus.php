<?php

declare(strict_types=1);

namespace A50\CommandBus;

/**
 * @template T
 */
interface CommandBus
{
    /**
     * Handle command.
     * @return T
     */
    public function handle(object $command);
}
