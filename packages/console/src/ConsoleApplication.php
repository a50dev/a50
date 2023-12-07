<?php

declare(strict_types=1);

namespace A50\Console;

use Exception;
use Symfony\Component\Console\Application as SymfonyConsoleApplication;
use Symfony\Component\Console\Command\Command;

final class ConsoleApplication implements Application
{
    private SymfonyConsoleApplication $cli;

    /**
     * ConsoleApplication constructor.
     * @param Command[] $commands
     */
    public function __construct(
        string $appName,
        bool $catchExceptions = false,
        array $commands = []
    ) {
        $this->cli = new SymfonyConsoleApplication($appName);

        $this->cli->setCatchExceptions($catchExceptions);

        if ($commands) {
            foreach ($commands as $command) {
                $this->cli->add($command);
            }
        }
    }

    public function getName(): string
    {
        return $this->cli->getName();
    }

    /**
     * @return array<Command>
     */
    public function getCommands(): array
    {
        return $this->cli->all();
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->cli->run();
    }
}
