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
class UserDtoTest extends TestCase
{
    public function testUserDtoFromUserInfo(): void
    {
        $user = [
            'id' => '3',
            'email' => 'janet.weaver@reqres.in',
            'first_name' => 'Janet',
            'last_name' => 'Weaver',
            'avatar' => 'https://reqres.in/img/faces/2-image.jpg',
        ];

        $userDto = UserDTO::fromGetJson($user);

        $this->assertNull($userDto->job);
        $this->assertEquals($user, $userDto->toGetJson());
    }

    public function testUserDtoFromCreateUserInfo(): void
    {
        $expectedJob = 'CTO';
        $expectedName = 'Diego Daniel';

        $user = [
            'id' => '3',
            'job' => $expectedJob,
            'name' => $expectedName,
        ];

        $userDto = UserDTO::fromCreateJson($user);

        $this->assertNull($userDto->email);
        $this->assertNull($userDto->lastName);
        $this->assertNull($userDto->avatar);
        $this->assertEquals($expectedJob, $userDto->job);
        $this->assertEquals($expectedName, $userDto->firstName);
        $this->assertEquals(3, $userDto->id);
    }
}
