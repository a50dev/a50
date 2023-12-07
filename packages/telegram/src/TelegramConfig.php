<?php

declare(strict_types=1);

namespace A50\Telegram;

final class TelegramConfig
{
    private string $token;
    private array $commands;
    private array $listeners;

    private function __construct(string $token, array $commands, array $listeners)
    {
        $this->token = $token;
        $this->commands = $commands;
        $this->listeners = $listeners;
    }

    public static function withDefaults(
        string $token = 'bot',
        array $commands = [],
        array $listeners = [],
    ) {
        return new self($token, $commands, $listeners);
    }

    public function token(): string
    {
        return $this->token;
    }

    public function withToken(string $token): self
    {
        $new = clone $this;
        $new->token = $token;

        return $new;
    }

    public function commands(): array
    {
        return $this->commands;
    }

    /**
     * @param class-string $commandClassName
     * @return $this
     */
    public function withCommand(string $commandClassName): self
    {
        $new = clone $this;
        $new->commands[] = $commandClassName;

        return $new;
    }

    public function listeners(): array
    {
        return $this->listeners;
    }

    /**
     * @param class-string $listenerClassName
     * @return $this
     */
    public function withListener(string $listenerClassName): self
    {
        $new = clone $this;
        $new->listeners[] = $listenerClassName;

        return $new;
    }
}
