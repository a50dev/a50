<?php

declare(strict_types=1);

namespace A50\Database;

interface DatabaseTransaction
{
    public function begin(): void;

    public function commit(): void;

    public function rollback(): void;

    public function wrap(callable $callback): void;
}
