<?php


namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiBaseTest extends  TestCase
{
    use DatabaseTransactions;

    public $structure;

    public static $baseApi = '/api';

    /**
     * Use it to store data between tests.
     */
    protected $store = [];

    public function settUp(): void {
        parent::setUp();
    }

    /**
     * Gets the standard Headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        return $headers;
    }

    /**
     * Gets the current Headers for make JWT auth request.
     *
     * @return array
     */
    public function getAuthHeader()
    {
        $headers = $this->getHeaders();
        $headers['Authorization'] = 'Bearer ' . $this->store['auth']['token'];
        return $headers;
    }

    /**
     * Authenticates the a User by email.
     *
     * @param array $credentials an array with email and password.
     *
     * @return array The user Response
     */
    public function authenticateUser(array $credentials): object
    {
        $response = $this->postJson(
            self::$baseApi . '/login',
            $credentials,
            $this->getHeaders()
        );

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'token',
                'user'
            ]
        ]);

        $responseContent = json_decode($response->getContent());
        $this->store['auth']['token'] = $responseContent->data->token;

        return $responseContent->data->user;
    }

    /**
     * Fail Auth Header.
     */
    public function getAuthHeaderFail(): array
    {
        $headers = $this->getHeaders();
        $headers['Authorization'] = 'Bearer ' . ' ';
        return $headers;
    }

    public function factoryUser() : \App\Models\User {
        $user = \App\Models\User::factory()->create();
        $user->save();
        return $user;
    }

}
