<?php

namespace Didando8a\Plentific\Service;

interface UserPlentificInterface
{
    public function create(string $name, string $job): int;

    /**
     * @return array<mixed>
     */
    public function list(int $page = 1, int $perPage = 1): array;

    /**
     * @return array<mixed>
     */
    public function find(int $id): array;
}
