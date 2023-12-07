<?php

declare(strict_types=1);

namespace A50\Console;

final class ConsoleConfig
{
    private string $appName;
    private bool $catchExceptions;
    /**
     * @var array<class-string>
     */
    private array $commands;

    /**
     * @param array<class-string> $commands
     */
    private function __construct(string $appName, bool $catchExceptions, array $commands)
    {
        $this->appName = $appName;
        $this->catchExceptions = $catchExceptions;
        $this->commands = $commands;
    }

    /**
     * @param array<class-string> $commands
     * @return ConsoleConfig
     */
    public static function withDefaults(
        string $appName = 'Console App',
        bool $catchExceptions = false,
        array $commands = []
    ) {
        return new self($appName, $catchExceptions, $commands);
    }

    public function appName(): string
    {
        return $this->appName;
    }

    public function withAppName(string $appName): self
    {
        $new = clone $this;
        $new->appName = $appName;

        return $new;
    }

    public function catchExceptions(): bool
    {
        return $this->catchExceptions;
    }

    public function withCatchExceptions(bool $catchExceptions): self
    {
        $new = clone $this;
        $new->catchExceptions = $catchExceptions;

        return $new;
    }

    /**
     * @return array<class-string>
     */
    public function commands(): array
    {
        return $this->commands;
    }

    /**
     * @param class-string $commandClassName Class name
     * @return $this
     */
    public function withCommand(string $commandClassName): self
    {
        $new = clone $this;
        $new->commands[] = $commandClassName;

        return $new;
    }

    /**
     * @param array<class-string> $commands
     * @return $this
     */
    public function withCommands(array $commands): self
    {
        $new = clone $this;
        foreach ($commands as $commandClassName) {
            $new = $new->withCommand($commandClassName);
        }

        return $new;
    }
}
