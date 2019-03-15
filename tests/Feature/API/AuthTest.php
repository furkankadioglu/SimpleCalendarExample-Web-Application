<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;


    /** @test */
    public function try_log_in_and_fail()
    {
        $response = $this->post('/api/auth/login', [
            "email" => "wrong@email.com",
            "password" => "awrongpassword",
        ]);

        $response->assertJson([
            'success' => false,
        ]);
    }


    /** @test */
    public function try_create_an_user_and_fail()
    {
        $response = $this->post('/api/auth/register', [
            "email" => "unit@test.com",
            "password" => "unittest",
        ]);

        $response->assertJsonStructure([
            'success',
            'errors'
        ]);

    }

    /** @test */
    public function create_an_user()
    {
        $postParameters = [
            "email" => "unit@test.com",
            "password" => "unittest",
            "name" => "Admin",
        ];

        $headerParameters = [
        ];
        
        $response = $this->post('/api/auth/register', $postParameters, $headerParameters);

        $response->assertJsonStructure([
            "success",
            "payload" => [
                "id",
                "name",
                "email",
            ]
        ]);
        
    }

    /** @test */
    public function log_in()
    {
        $user = factory(\App\User::class)->create();

        $postParameters = [
            "email" => "$user->email",
            "password" => "password"
        ];

        $headerParameters = [
        ];

        $response = $this->post('/api/auth/login', $postParameters, $headerParameters);

        $response->assertJsonStructure([
            "success",
            "payload" => [
                "access_token",
                "token_type",
                "expires_in",
                "user" => [
                    "id",
                    "name",
                    "email",
                    "created_at",
                    "updated_at"
                ]
            ]
        ]);

        $content = json_decode($response->getContent());
        return $content->payload->access_token;
    }

    /** @test */
    public function me()
    {   
        $token = $this->log_in();

        $postParameters = [
        ];

        $headerParameters = [
            "Authorization" => "Bearer ".$token
        ];


        $response = $this->post('/api/auth/me', $postParameters, $headerParameters);

        $response->assertJson([
            'success' => true,
        ]);
    }
}
