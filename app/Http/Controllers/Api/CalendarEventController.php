<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarEventsCollection;
use App\Http\Requests\CalendarEventCreateRequest;
use Validator;
use App\CalendarEvent;
use App\Http\Resources\CalendarEventResource;

class CalendarEventController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get user events
     *
     * @return  \Illuminate\Http\JsonResponse
     */
    public function getEvents()
    {
        // Time consumer TODO: Save this response to cache for forever. 
        
        return [
            "success" => true,
            "payload" => new CalendarEventsCollection(auth()->user()->calendarEvents)
        ];
    }
}
