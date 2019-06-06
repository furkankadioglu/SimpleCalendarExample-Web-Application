<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CalendarEventTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function getEvents()
    {
        $token = $this->log_in();

        $postParameters = [
        ];

        $headerParameters = [
            "Authorization" => "Bearer ".$token
        ];



        $response = $this->get('/api/calendarEvents/getEvents', $postParameters, $headerParameters);

        $response->assertJsonStructure([
            'success',
            'payload'
        ]);
    }

    /** @test */
    public function createEvent($token = null)
    {
        if(!$token)
        {
            $token = $this->log_in();
        }

        $postParameters = [
            "name" => "PHPUnit Test Event",
            "start" => "2045-01-01",
            "end" => "2045-01-01",
            "allDay" => true
        ];

        $headerParameters = [
            "Authorization" => "Bearer ".$token
        ];


        $response = $this->post('/api/calendarEvents/create', $postParameters, $headerParameters);

        $response->assertJsonStructure([
            'success',
            'payload'
        ]);

        $data = json_decode($response->getContent());
        return $data->payload->id;
    }


    /** @test */
    public function editEvent($token = null)
    {
        if(!$token)
        {
            $token = $this->log_in();
        }

        $event_id = $this->createEvent($token);

        $postParameters = [
            "name" => "PHPUnit Test Event Edited",
            "start" => "2045-01-02",
            "end" => "2045-01-02",
            "allDay" => true
        ];

        $headerParameters = [
            "Authorization" => "Bearer ".$token
        ];



        $response = $this->post('/api/calendarEvents/update/'.$event_id, $postParameters, $headerParameters);

        $response->assertJson([
            'success' => true,
            'payload' => [
                "id" => $event_id,
                "title" => "PHPUnit Test Event Edited",
                "start" => "2045-01-02",
                "end"   => "2045-01-02",
            ]
        ]);
    }


    /** @test */
    public function deleteEvent()
    {
        $token = $this->log_in();
        $event_id = $this->createEvent($token);

        $postParameters = [
        ];

        $headerParameters = [
            "Authorization" => "Bearer ".$token
        ];

        $response = $this->post('/api/calendarEvents/delete/'.$event_id, $postParameters, $headerParameters);

        $response->assertJson([
            'success' => true,
        ]);

    }


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
        $content = json_decode($response->getContent());
        return $content->payload->access_token;
    }

}