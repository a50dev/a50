<?php

declare(strict_types=1);

namespace A50\Database\Cycle\Repository;

use Cycle\Database\Database;
use Exception;
use RuntimeException;
use A50\Database\Repository\EntityRepository;
use A50\Database\Repository\Exception\CouldNotGetEntityById;
use A50\Database\Repository\Exception\CouldNotSaveEntity;

final class DatabaseEntityRepositoryUsingCycle implements EntityRepository
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getById(string $id, string $from): array
    {
        try {
            $data = $this->database
                ->select()
                ->from($from)
                ->where('id', $id)
                ->run()
                ->fetch();

            if (!is_array($data)) {
                throw new RuntimeException('Array of data is empty');
            }

            return $data;
        } catch (Exception $exception) {
            throw CouldNotGetEntityById::withId($id, $exception->getMessage());
        }
    }

    public function save(array $data, string $to): void
    {
        try {
            $this->database->table($to)
                ->insertOne($data);
        } catch (Exception $exception) {
            throw CouldNotSaveEntity::withReason($exception->getMessage());
        }
    }

    public function hasById(string $id, string $in): bool
    {
        return (bool)$this->database
            ->select()
            ->from($in)
            ->where('id', $id)
            ->run()
            ->fetch();
    }

    public function update(array $data, string $in, array $condition): void
    {
        try {
            $this->database->table($in)
                ->update($data, $condition);
        } catch (Exception $exception) {
            throw CouldNotSaveEntity::withReason($exception->getMessage());
        }
    }

    public function deleteOne(string $id, string $in): void
    {
        // TODO: Implement deleteOne() method.
    }

    public function deleteMany(array $ids, string $in): void
    {
        // TODO: Implement deleteMany() method.
    }
}
