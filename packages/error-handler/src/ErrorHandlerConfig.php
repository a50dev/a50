<?php

declare(strict_types=1);

namespace A50\ErrorHandler;

final class ErrorHandlerConfig
{
    private bool $catchExceptions;

    public function __construct(bool $catchExceptions)
    {
        $this->catchExceptions = $catchExceptions;
    }

    public static function withDefaults(
        bool $catchExceptions = false,
    ): self {
        return new self($catchExceptions);
    }

    public function withCatchExceptions(bool $catchExceptions): self
    {
        $new = clone $this;
        $new->catchExceptions = $catchExceptions;

        return $new;
    }

    public function catchExceptions(): bool
    {
        return $this->catchExceptions;
    }
}
