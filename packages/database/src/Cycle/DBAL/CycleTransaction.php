<?php

declare(strict_types=1);

namespace A50\Database\Cycle\DBAL;

use Cycle\Database\Database;
use Throwable;
use A50\Database\Transaction;

final class CycleTransaction implements Transaction
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function begin(): void
    {
        $this->database->begin();
    }

    public function commit(): void
    {
        $this->database->commit();
    }

    public function rollback(): void
    {
        $this->database->rollback();
    }

    /**
     * @throws Throwable
     */
    public function transactionally(callable $callback): void
    {
        $this->database->transaction(static function () use ($callback): void {
            $callback();
        });
    }
}
