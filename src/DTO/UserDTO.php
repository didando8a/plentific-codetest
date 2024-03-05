<?php

declare(strict_types=1);

namespace Didando8a\Plentific\DTO;

class UserDTO
{
    private function __construct(
        public int $id,
        public ?string $email,
        public ?string $firstName,
        public ?string $lastName,
        public ?string $job,
        public ?string $avatar,
    ) {}

    /**
     * @param array<string> $userArray
     */
    public static function fromGetJson(array $userArray): self
    {
        $id = $userArray['id'];
        $email = $userArray['email'] ?? null;
        $firstName = $userArray['first_name'] ?? null;
        $lastName = $userArray['last_name'] ?? null;
        $job = $userArray['job'] ?? null;
        $avatar = $userArray['avatar'] ?? null;

        return new self((int) $id, $email, $firstName, $lastName, $job, $avatar);
    }

    /**
     * @return array<mixed>
     */
    public function toGetJson(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'avatar' => $this->avatar,
        ];
    }

    /**
     * @param array<string> $userArray
     */
    public static function fromCreateJson(array $userArray): self
    {
        $id = $userArray['id'];
        $firstName = $userArray['name'] ?? null;
        $job = $userArray['job'] ?? null;

        return new self((int) $id, null, $firstName, null, $job, null);
    }
}
