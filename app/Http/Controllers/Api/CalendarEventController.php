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

    /**
     * Calendar Event create method
     *
     * @param Request $request
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6|max:90',
            'date' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $calendarEvent = new CalendarEvent;
        $calendarEvent->name = request()->name;
        $calendarEvent->date = request()->date;
        $calendarEvent->user_id = auth()->user()->id;
        $calendarEvent->save();

        // Time consumer TODO: Destroy the main getEvents cache

        return [
            "success" => true,
            "payload" => new CalendarEventResource($calendarEvent)
        ];
    }

    /**
     * Calendar Event update method
     *
     * @param Request $request
     * @param Integer $calendar_event_id
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $calendar_event_id)
    {
        $calendarEvent = CalendarEvent::userEvents()->find($calendar_event_id);

        if(!$calendarEvent)
        {
            return [
                'success' => false,
                'errors' => [
                    "noEvent" => "Please check the event id."
                ]
            ];
        }

        $calendarEvent->name = request()->name;
        $calendarEvent->date = request()->date;
        $calendarEvent->user_id = auth()->user()->id;
        $calendarEvent->save();

        // Time consumer TODO: Destroy the main getEvents cache

        return [
            "success" => true,
            "payload" => new CalendarEventResource($calendarEvent)
        ];
    }

    /**
     * Calendar Event delete method
     *
     * @param Request $request
     * @param Integer $calendar_event_id
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, $calendar_event_id)
    {
        $calendarEvent = CalendarEvent::userEvents()->find($calendar_event_id);
    
        if(!$calendarEvent)
        {
            return [
                'success' => false,
                'errors' => [
                    "noEvent" => "Please check the event id."
                ]
            ];
        }

        $calendarEvent->delete();

        return [
            "success" => true
        ];
    }
}
