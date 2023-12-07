<?php

declare(strict_types=1);

namespace A50\CommandBus\Tactician;

use League\Tactician\CommandBus as TacticianBus;
use A50\CommandBus\CommandBus;

/**
 * @template T
 * @implements CommandBus<T>
 */
final class TacticianCommandBus implements CommandBus
{
    private TacticianBus $bus;

    public function __construct(TacticianBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * Handle command.
     * @return T
     */
    public function handle(object $command)
    {
        return $this->bus->handle($command);
    }
}
