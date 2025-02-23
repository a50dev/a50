<?php

declare(strict_types=1);

namespace A50\Mapper;

use A50\Database\Repository\MapperRepository;
use A50\Database\Repository\MapperRepositoryFactory;

final readonly class UserRepository
{
    private MapperRepository $repository;

    public function __construct(
        MapperRepositoryFactory $repositoryFactory
    )
    {
        $this->repository = $repositoryFactory->createMapperRepository(
            User::class,
            Table::USERS
        );
    }

    public function save(User $user): void
    {
        $this->repository->save($user);
    }

    public function getById(UserId $id): User
    {
        /* @var User */
        return $this->repository->getOneById($id);
    }
}
