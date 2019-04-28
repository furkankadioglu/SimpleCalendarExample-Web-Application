<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CalendarEventsCollection;
use App\Http\Requests\CalendarEventCreateRequest;
use Validator;
use App\CalendarEvent;
use App\Http\Resources\CalendarEventResource;
use Cache;

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
        if(auth()->payload()->get("isBanned")){
            return [
                'success' => false
            ];
        }

        $events = Cache::get(auth()->user()->id.":calendarEvents");
        if(!$events) 
        {
            $events = auth()->user()->calendarEvents;
            Cache::forever(auth()->user()->id.":calendarEvents", $events);
        }

        return [
            "success" => true,
            "payload" => new CalendarEventsCollection($events)
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
            'title' => 'required|min:2|max:90',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'required|date_format:Y-m-d|after_or_equal:start',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $calendarEvent = new CalendarEvent;
        $calendarEvent->title = request()->title;
        $calendarEvent->start = request()->start;
        $calendarEvent->end = request()->end;
        $calendarEvent->user_id = auth()->user()->id;
        $calendarEvent->save();

        Cache::pull(auth()->user()->id.":calendarEvents");

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

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|max:90',
            'start' => 'required|date_format:Y-m-d',
            'end' => 'required|date_format:Y-m-d|after_or_equal:start',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $calendarEvent->title = request()->title;
        $calendarEvent->start = request()->start;
        $calendarEvent->end = request()->end;
        $calendarEvent->user_id = auth()->user()->id;
        $calendarEvent->save();

        Cache::pull(auth()->user()->id.":calendarEvents");

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
        Cache::pull(auth()->user()->id.":calendarEvents");

        return [
            "success" => true
        ];
    }
}
