<?php

declare(strict_types=1);

namespace Didando8a\Plentific\Repository;

use Didando8a\Plentific\DTO\Exception\UserDomainException;
use Didando8a\Plentific\Helper\EncoderDecoderHelperTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class UserApiImplTest extends TestCase
{
    use EncoderDecoderHelperTrait;

    /**
     * @throws UserDomainException
     */
    public function testCreatesUser(): void
    {
        $expectedId = 300;
        $expectedResponse = ['id' => (string) $expectedId, 'createdAt' => '2024-03-05T15:17:22.088Z'];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($expectedResponse)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userApiImpl = new UserApiImpl(
            new Client(['handler' => $handlerStack])
        );

        $result = $userApiImpl->create('successfulUser', 'successfulJob');

        $this->assertEquals($expectedResponse, $result);
    }

    /**
     * @throws UserDomainException
     */
    public function testListUsers(): void
    {
        $page = 1;
        $perPage = 3;

        $expectedResponse = [
            'page' => $page,
            'per_page' => $perPage,
            'total' => 2,
            'total_pages' => 1,
            'data' => [
                [
                    'id' => 1,
                    'email' => 'michael.lawson@reqres.in',
                    'first_name' => 'Michael',
                    'last_name' => 'Lawson',
                    'avatar' => 'https://reqres.in/img/faces/7-image.jpg',
                ],
                [
                    'id' => 2,
                    'email' => 'lindsay.ferguson@reqres.in',
                    'first_name' => 'Lindsay',
                    'last_name' => 'Ferguson',
                    'avatar' => 'https://reqres.in/img/faces/8-image.jpg',
                ],
                'support' => [
                    'url' => 'https://reqres.in/#support-heading',
                    'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
                ],
            ],
        ];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($expectedResponse)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userApiImpl = new UserApiImpl(
            new Client(['handler' => $handlerStack])
        );

        $result = $userApiImpl->list($page, $perPage);

        $this->assertEquals($expectedResponse, $result);
    }

    /**
     * @throws UserDomainException
     */
    public function testRetrieveUser(): void
    {
        $id = 1;

        $expectedResponse = [
            'data' => [
                'id' => $id,
                'email' => 'janet.weaver@reqres.in',
                'first_name' => 'Janet',
                'last_name' => 'Weaver',
                'avatar' => 'https://reqres.in/img/faces/2-image.jpg',
            ],
            'support' => [
                'url' => 'https://reqres.in/#support-heading',
                'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
            ],
        ];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($expectedResponse)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userApiImpl = new UserApiImpl(
            new Client(['handler' => $handlerStack])
        );

        $result = $userApiImpl->find($id);

        $this->assertEquals($expectedResponse, $result);
    }
}
