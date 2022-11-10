<?php

namespace Tests\Unit\Api;

use Tests\ApiBaseTest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends ApiBaseTest
{
    use DatabaseTransactions;

    public function testLogin()
    {
        $user = $this->factoryUser();

        $this->authenticateUser([
            'email' => $user->email,
            'password' => 'secret',
        ]);
    }

    public function testCreateUser()
    {
        $userData = [
            'email' => 'test@test.com',
            'name' => 'create test account',
            'password' => 'secret',
        ];

        $response = $this->postJson(
            self::$baseApi.'/user',
            $userData,
            $this->getHeaders()
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

        //Retry using the same email, it must fail
        $response = $this->postJson(
            self::$baseApi.'/user',
            $userData,
            $this->getHeaders()
        );

        $response->assertJsonValidationErrors(['email']);
    }

    public function testUpdateUser()
    {
        $user = $this->factoryUser();

        $user = $this->authenticateUser([
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response = $this->putJson(self::$baseApi.'/user/'.$user->id, [
            'email' => 'foo@barupdate.com',
            $this->getAuthHeader(),
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'user',
            ],
        ]);

        $newUser = $this->factoryUser();

        $this->authenticateUser([
            'email' => $newUser->email,
            'password' => 'secret',
        ]);

        //Will try to update another user.
        $response = $this->putJson(
            self::$baseApi.'/user/'.$user->id, [
                'email' => $user->email,
            ],
            $this->getHeaders()
        );

        $response->assertForbidden();
    }
}
