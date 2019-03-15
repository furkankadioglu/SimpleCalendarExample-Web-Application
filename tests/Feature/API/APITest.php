<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{
    /** @test */
    public function get_api_status()
    {
        $response = $this->get('/api/status');
        $response->assertStatus(200);
    }

    /** @test */
    public function get_api_status_success()
    {
        $response = $this->get('/api/status');
        $response->assertJson([
            'success' => true,
        ]);
    }
}
