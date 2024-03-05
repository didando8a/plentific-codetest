<?php

declare(strict_types=1);

namespace Didando8a\Plentific\DTO;

readonly class ListUserDTO
{
    private function __construct(
        public int $page,
        public int $perPage,
        public int $totalPages,
        public int $total,
        /**
         * @var UserDTO[]
         */
        public array $users,
    ) {}

    /**
     * @param array<string, mixed> $userArray
     */
    public static function fromGetJson(array $userArray): self
    {
        $page = $userArray['page'];
        $perPage = $userArray['per_page'];
        $total = $userArray['total'];
        $totalPages = $userArray['total_pages'];
        $users = [];

        foreach ($userArray['data'] as $user) {
            $users[] = UserDTO::fromGetJson($user);
        }

        return new self((int) $page, (int) $perPage, (int) $totalPages, (int) $total, $users);
    }

    /**
     * @return array<mixed>
     */
    public function toGetJson(): array
    {
        $data = [];

        foreach ($this->users as $user) {
            $data[] = $user->toGetJson();
        }

        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'total_pages' => $this->totalPages,
            'data' => $data,
        ];
    }
}
