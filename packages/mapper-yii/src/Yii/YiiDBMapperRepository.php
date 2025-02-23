<?php

declare(strict_types=1);

namespace A50\Mapper\Yii;

use A50\Database\Id;
use A50\Database\Repository\MapperRepository;
use A50\Database\Repository\ObjectRepository;
use A50\Database\Repository\SelectRepository;
use A50\Mapper\Hydrator;
use A50\Mapper\Serializer;

final readonly class YiiDBMapperRepository implements MapperRepository
{
    public function __construct(
        private Serializer $serializer,
        private ObjectRepository $objectRepository,
        private Hydrator $hydrator,
        private SelectRepository $selectRepository,
        private string $entityClassName,
    )
    {
    }

    public function save(object $entity): void
    {
        $data = $this->serializer->serialize($entity);
        $this->objectRepository->save($data);
    }

    private function getFilteredArrayWithKeys(array $array, array $keys): array
    {
        return array_filter($array, static fn ($key) => in_array($key, $keys, true), ARRAY_FILTER_USE_KEY);
    }

    public function updateBy(object $entity, array $criteria, ?array $fields = null): void
    {
        $data = $this->serializer->serialize($entity);

        if (!empty($fields)) {
            $data = $this->getFilteredArrayWithKeys($data, $fields);
        }

        $this->objectRepository->updateBy($data, $criteria);
    }

    public function updateOneById(object $entity, Id $id, ?array $fields = null): void
    {
        $data = $this->serializer->serialize($entity);

        if (!empty($fields)) {
            $data = $this->getFilteredArrayWithKeys($data, $fields);
        }

        $this->objectRepository->updateOneById($data, $id->asString());
    }

    public function deleteBy(array $criteria): void
    {
        $this->objectRepository->deleteBy($criteria);
    }

    public function deleteOneById(Id $id): void
    {
        $this->objectRepository->deleteOneById($id->asString());
    }

    public function deleteManyByIds(array $ids): void
    {
        $ids = \array_map(static fn (Id $item) => $item->asString(), $ids);
        $this->objectRepository->deleteManyByIds($ids);
    }

    public function findAll(?array $select = null, ?array $orderBy = null): ?array
    {
        $collection = $this->selectRepository->findAll($select, $orderBy);

        if (null === $collection) {
            return null;
        }

        $result = [];

        foreach ($collection as $entity) {
            $result[] = $this->hydrator->hydrate($this->entityClassName, $entity);
        }

        return $result;
    }

    public function findBy(
        array $criteria,
        ?array $select = null,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): ?array {
        $collection = $this->selectRepository->findBy($criteria, $select, $orderBy, $limit, $offset);

        if (null === $collection) {
            return null;
        }

        $result = [];

        foreach ($collection as $entity) {
            $result[] = $this->hydrator->hydrate($this->entityClassName, $entity);
        }

        return $result;
    }

    public function findOneBy(array $criteria, ?array $select = null): ?object
    {
        $data = $this->selectRepository->findOneBy($criteria, $select);

        if (null === $data) {
            return null;
        }

        return $this->hydrator->hydrate($this->entityClassName, $data);
    }

    public function findOneById(Id $id, ?array $select = null): ?object
    {
        $data = $this->selectRepository->findOneById($id->asString(), $select);

        if (null === $data) {
            return null;
        }

        return $this->hydrator->hydrate($this->entityClassName, $data);
    }

    public function count(?array $criteria = null): int
    {
        return $this->selectRepository->count($criteria);
    }

    public function getBy(
        array $criteria,
        ?array $select = null,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $collection = $this->selectRepository->getBy($criteria, $select, $orderBy, $limit, $offset);

        $result = [];
        foreach ($collection as $entity) {
            $result[] = $this->hydrator->hydrate($this->entityClassName, $entity);
        }

        return $result;
    }

    public function getOneBy(
        array $criteria,
        ?array $select = null,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): object {
        $data = $this->selectRepository->getOneBy($criteria, $select, $orderBy, $limit, $offset);

        return $this->hydrator->hydrate($this->entityClassName, $data);
    }

    public function getOneById(Id $id, ?array $select = null): object
    {
        $data = $this->selectRepository->getOneById($id->asString(), $select);

        return $this->hydrator->hydrate($this->entityClassName, $data);
    }

    public function existsBy(array $criteria): bool
    {
        return $this->selectRepository->existsBy($criteria);
    }
}
