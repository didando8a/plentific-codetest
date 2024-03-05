<?php

declare(strict_types=1);

namespace Didando8a\Plentific\Service;

use Didando8a\Plentific\DTO\Exception\UserDomainException;
use Didando8a\Plentific\Helper\EncoderDecoderHelperTrait;
use Didando8a\Plentific\Repository\UserApiImpl;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @integration
 *
 * @internal
 *
 * @coversNothing
 */
class UserReqrestServiceTest extends TestCase
{
    use EncoderDecoderHelperTrait;

    public function testCreatesUserAndReturnsId959(): void
    {
        $expectedId = 959;
        $expectedResponse = ['id' => (string) $expectedId, 'createdAt' => '2024-03-05T15:17:22.088Z'];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($expectedResponse)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client(['handler' => $handlerStack])
            )
        );

        $result = $userReqrestService->create('successfulUser', 'successfulJob');

        $this->assertEquals($expectedId, $result);
    }

    public function testCreatesUserThrowsBadRequest(): void
    {
        $expectedResponse = 'Bad request: the request could not be processed';
        $this->expectException(UserDomainException::class);
        $this->expectExceptionMessage($expectedResponse);
        $this->expectExceptionCode(400);

        $mockHandler = new MockHandler([
            new Response(400, ['X-Test' => 'Test'], $expectedResponse),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client(['handler' => $handlerStack])
            )
        );

        $result = $userReqrestService->create('successfulUser', 'successfulJob');

        $this->assertEquals($expectedResponse, $result);
    }

    public function testListUsers(): void
    {
        $page = 2;
        $perPage = 6;

        $expectedResponse = [
            'page' => $page,
            'per_page' => $perPage,
            'total' => 12,
            'total_pages' => 2,
            'data' => [
                [
                    'id' => 7,
                    'email' => 'michael.lawson@reqres.in',
                    'first_name' => 'Michael',
                    'last_name' => 'Lawson',
                    'avatar' => 'https://reqres.in/img/faces/7-image.jpg',
                ],
                [
                    'id' => 8,
                    'email' => 'lindsay.ferguson@reqres.in',
                    'first_name' => 'Lindsay',
                    'last_name' => 'Ferguson',
                    'avatar' => 'https://reqres.in/img/faces/8-image.jpg',
                ],
                [
                    'id' => 9,
                    'email' => 'tobias.funke@reqres.in',
                    'first_name' => 'Tobias',
                    'last_name' => 'Funke',
                    'avatar' => 'https://reqres.in/img/faces/9-image.jpg',
                ],
                [
                    'id' => 10,
                    'email' => 'byron.fields@reqres.in',
                    'first_name' => 'Byron',
                    'last_name' => 'Fields',
                    'avatar' => 'https://reqres.in/img/faces/10-image.jpg',
                ],
                [
                    'id' => 11,
                    'email' => 'george.edwards@reqres.in',
                    'first_name' => 'George',
                    'last_name' => 'Edwards',
                    'avatar' => 'https://reqres.in/img/faces/11-image.jpg',
                ],
                [
                    'id' => 12,
                    'email' => 'rachel.howell@reqres.in',
                    'first_name' => 'Rachel',
                    'last_name' => 'Howell',
                    'avatar' => 'https://reqres.in/img/faces/12-image.jpg',
                ],
            ],
        ];

        $response = $expectedResponse;
        $response['support'] = [
            'url' => 'https://reqres.in/#support-heading',
            'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
        ];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($response)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client(['handler' => $handlerStack])
            )
        );

        $result = $userReqrestService->list($page, $perPage);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testListUsersNonExistingPageReturnsEmptyDataWithInfoAboutThePages(): void
    {
        $page = 3;
        $perPage = 6;

        $expectedResponse = [
            'page' => $page,
            'per_page' => $perPage,
            'total' => 12,
            'total_pages' => 2,
            'data' => [
            ],
        ];

        $response = $expectedResponse;
        $response['support'] = [
            'url' => 'https://reqres.in/#support-heading',
            'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
        ];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($response)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client(['handler' => $handlerStack])
            )
        );

        $result = $userReqrestService->list($page, $perPage);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testRetrieveUser2(): void
    {
        $id = 2;

        $expectedResponse = [
            'id' => $id,
            'email' => 'janet.weaver@reqres.in',
            'first_name' => 'Janet',
            'last_name' => 'Weaver',
            'avatar' => 'https://reqres.in/img/faces/2-image.jpg',
        ];

        $response = [];
        $response['data'] = $expectedResponse;
        $response['support'] = [
            'url' => 'https://reqres.in/#support-heading',
            'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
        ];

        $mockHandler = new MockHandler([
            new Response(201, ['X-Test' => 'Test'], $this->encodeString($response)),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client(['handler' => $handlerStack])
            )
        );

        $result = $userReqrestService->find($id);

        $this->assertEquals($expectedResponse, $result);
    }

    public function testRetrieveUserNotFound(): void
    {
        $id = 23;
        $expectedResponse = 'Bad request: the request could not be processed';
        $this->expectException(UserDomainException::class);
        $this->expectExceptionMessage($expectedResponse);
        $this->expectExceptionCode(404);

        $mockHandler = new MockHandler([
            new Response(404, ['X-Test' => 'Test'], $expectedResponse),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client(['handler' => $handlerStack])
            )
        );

        $result = $userReqrestService->find($id);

        $this->assertEquals($expectedResponse, $result);
    }

    // @phpstan-ignore-next-line
    private function testRealClient(): void
    {
        //        $this->markTestSkipped();
        //        $result = $this->userReqrestService->create('morpheus', 'leader');
        //        $result = $this->userReqrestService->create('successfulUser', 'successfulJob');

        $expectedResponse = ['id' => '959', 'createdAt' => '2024-03-05T15:17:22.088Z'];

        $userReqrestService = new UserReqrestService(
            new UserApiImpl(
                new Client()
            )
        );

        $result = $userReqrestService->find(2);
        $this->assertEquals($expectedResponse, $result);
    }
}
