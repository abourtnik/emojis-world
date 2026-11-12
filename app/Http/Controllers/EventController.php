<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('pages.events', [
            'events' => EventService::getEvents(),
        ]);
    }

    public function show(Event $event): View
    {
        return view('pages.event', [
            'event' => $event,
            'emojis' => $event->getEmojis()
        ]);
    }
}
