<?php

declare(strict_types=1);

namespace Didando8a\Plentific\Repository;

interface UserRepositoryInterface
{
    /**
     * @return array<mixed>
     */
    public function create(string $name, string $job): array;

    /**
     * @return array<mixed>
     */
    public function list(int $page, int $perPage): array;

    /**
     * @return array<mixed>
     */
    public function find(int $name): array;
}
