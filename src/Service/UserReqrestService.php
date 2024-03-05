<?php

declare(strict_types=1);

namespace Didando8a\Plentific\Service;

use Didando8a\Plentific\DTO\ListUserDTO;
use Didando8a\Plentific\DTO\UserDTO;
use Didando8a\Plentific\Repository\UserRepositoryInterface;

class UserReqrestService implements UserPlentificInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function create(string $name, string $job): int
    {
        $user = UserDTO::fromCreateJson($this->userRepository->create($name, $job));

        return $user->id;
    }

    public function list(int $page = 1, int $perPage = 1): array
    {
        $listUsers = ListUserDTO::fromGetJson($this->userRepository->list($page, $perPage));

        return $listUsers->toGetJson();
    }

    public function find(int $id): array
    {
        $users = UserDTO::fromGetJson($this->userRepository->find($id)['data']);

        return $users->toGetJson();
    }
}
