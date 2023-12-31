<?php

declare(strict_types=1);

namespace A50\Database\Yii;

use RuntimeException;
use Throwable;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Db\Exception\Exception;
use Yiisoft\Db\Exception\InvalidConfigException;
use Yiisoft\Db\Query\Query;
use A50\Database\Repository\EntityRepository;
use A50\Database\Repository\Exception\CouldNotDeleteEntities;
use A50\Database\Repository\Exception\CouldNotDeleteEntity;
use A50\Database\Repository\Exception\CouldNotGetEntityById;
use A50\Database\Repository\Exception\CouldNotSaveEntity;
use A50\Database\Repository\Exception\CouldNotUpdateEntity;

final class EntityRepositoryUsingYii implements EntityRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
    ) {
    }

    public function getById(string $id, string $from): array
    {
        try {
            $data = (new Query($this->connection))
                ->select('*')
                ->from($from)
                ->where(['id' => $id])
                ->one();

            if (!is_array($data)) {
                throw new RuntimeException('Array of data is empty');
            }

            return $data;
        } catch (Throwable $exception) {
            throw CouldNotGetEntityById::withId($id, $exception->getMessage());
        }
    }

    /**
     * @throws InvalidConfigException
     * @throws Throwable
     * @throws Exception
     */
    public function hasById(string $id, string $in): bool
    {
        return (new Query($this->connection))
            ->select('*')
            ->from($in)
            ->where(['id' => $id])
            ->exists();
    }

    public function save(array $data, string $to): void
    {
        try {
            $command = $this->connection->createCommand();
            $command->insert($to, $data)->execute();
        } catch (Throwable $exception) {
            throw CouldNotSaveEntity::withReason($exception->getMessage());
        }
    }

    public function update(array $data, string $in, array $condition): void
    {
        try {
            $command = $this->connection->createCommand();
            $command->update($in, $data, $condition)->execute();
        } catch (Throwable $exception) {
            throw CouldNotUpdateEntity::withReason($exception->getMessage());
        }
    }

    public function deleteOne(string $id, string $in): void
    {
        try {
            $command = $this->connection->createCommand();
            $command->delete($in, ['id' => $id])->execute();
        } catch (Throwable $exception) {
            throw CouldNotDeleteEntity::withReason($exception->getMessage());
        }
    }

    public function deleteMany(array $ids, string $in): void
    {
        try {
            $command = $this->connection->createCommand();
            $command->delete($in, ['id' => $ids])->execute();
        } catch (Throwable $exception) {
            throw CouldNotDeleteEntities::withReason($exception->getMessage());
        }
    }
}
