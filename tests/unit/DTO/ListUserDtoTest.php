<?php

declare(strict_types=1);

namespace Didando8a\Plentific\DTO;

use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class ListUserDtoTest extends TestCase
{
    public function testListUserDtoFromList(): void
    {
        $fistUserRetrieved = [
            'id' => 1,
            'email' => 'george.bluth@reqres.in',
            'first_name' => 'George',
            'last_name' => 'Bluth',
            'avatar' => 'https://reqres.in/img/faces/1-image.jpg',
        ];

        $userList = [
            'page' => 1,
            'per_page' => 6,
            'total' => 12,
            'total_pages' => 2,
            'data' => [
                $fistUserRetrieved,
                [
                    'id' => 2,
                    'email' => 'janet.weaver@reqres.in',
                    'first_name' => 'Janet',
                    'last_name' => 'Weaver',
                    'avatar' => 'https://reqres.in/img/faces/2-image.jpg',
                ],
                [
                    'id' => 3,
                    'email' => 'emma.wong@reqres.in',
                    'first_name' => 'Emma',
                    'last_name' => 'Wong',
                    'avatar' => 'https://reqres.in/img/faces/3-image.jpg',
                ],
                [
                    'id' => 4,
                    'email' => 'eve.holt@reqres.in',
                    'first_name' => 'Eve',
                    'last_name' => 'Holt',
                    'avatar' => 'https://reqres.in/img/faces/4-image.jpg',
                ],
                [
                    'id' => 5,
                    'email' => 'charles.morris@reqres.in',
                    'first_name' => 'Charles',
                    'last_name' => 'Morris',
                    'avatar' => 'https://reqres.in/img/faces/5-image.jpg',
                ],
                [
                    'id' => 6,
                    'email' => 'tracey.ramos@reqres.in',
                    'first_name' => 'Tracey',
                    'last_name' => 'Ramos',
                    'avatar' => 'https://reqres.in/img/faces/6-image.jpg',
                ],
            ],
        ];

        $userListResponse = $userList;
        $userListResponse['support'] = [
            'url' => 'https://reqres.in/#support-heading',
            'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
        ];

        $listUserDto = ListUserDTO::fromGetJson($userListResponse);

        $this->assertEquals(6, $listUserDto->perPage);
        $this->assertEquals(1, $listUserDto->page);
        $this->assertEquals(12, $listUserDto->total);
        $this->assertEquals(2, $listUserDto->totalPages);

        $this->assertEquals($fistUserRetrieved, $listUserDto->users[0]->toGetJson());
        $this->assertEquals($userList, $listUserDto->toGetJson());
    }

    public function testUserDtoFromOffsetPagination(): void
    {
        $userList = [
            'page' => 5,
            'per_page' => 6,
            'total' => 15,
            'total_pages' => 3,
            'data' => [],
        ];

        $userListResponse = $userList;
        $userListResponse['support'] = [
            'url' => 'https://reqres.in/#support-heading',
            'text' => 'To keep ReqRes free, contributions towards server costs are appreciated!',
        ];

        $listUserDto = ListUserDTO::fromGetJson($userListResponse);

        $this->assertEquals(6, $listUserDto->perPage);
        $this->assertEquals(5, $listUserDto->page);
        $this->assertEquals(15, $listUserDto->total);
        $this->assertEquals(3, $listUserDto->totalPages);
        $this->assertEquals([], $listUserDto->users);
        $this->assertEquals($userList, $listUserDto->toGetJson());
    }
}
