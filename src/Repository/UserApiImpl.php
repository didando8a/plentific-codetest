<?php

declare(strict_types=1);

namespace Didando8a\Plentific\Repository;

use Didando8a\Plentific\DTO\Exception\UserDomainException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface as PsrClientInterface;

class UserApiImpl implements UserRepositoryInterface
{
    final public const POST = 'POST';
    final public const GET = 'GET';
    final public const BASE_URI = 'https://reqres.in/api/';

    public function __construct(
        private readonly ClientInterface&PsrClientInterface $client,
    ) {}

    public function create(string $name, string $job): array
    {
        try {
            $url = sprintf('%susers', self::BASE_URI);
            $res = $this->client->request(self::POST, $url, []);
        } catch (GuzzleException $e) {
            $message = sprintf('User creation failed: %s', $e->getMessage());

            throw new UserDomainException($message, $e->getCode());
        }

        $body = $res->getBody();

        return json_decode($body->getContents(), true);
    }

    public function list(int $page, int $perPage): array
    {
        $url = sprintf('%susers?page=%s&per_page=%s', self::BASE_URI, $page, $perPage);

        try {
            $res = $this->client->request(self::GET, $url, []);
        } catch (GuzzleException $e) {
            $message = sprintf('Users list failed: %s', $e->getMessage());

            throw new UserDomainException($message, $e->getCode());
        }

        $body = $res->getBody();

        return json_decode($body->getContents(), true);
    }

    public function find(int $id): array
    {
        $url = sprintf('%susers/%s', self::BASE_URI, $id);

        try {
            $res = $this->client->request(self::GET, $url, []);
        } catch (GuzzleException $e) {
            $message = sprintf('Find user failed: %s', $e->getMessage());

            throw new UserDomainException($message, $e->getCode());
        }

        $body = $res->getBody();

        return json_decode($body->getContents(), true);
    }
}
