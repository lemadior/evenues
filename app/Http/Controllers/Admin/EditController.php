<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Evenues\Admin\EventsService;
use App\Http\Controllers\Controller;
use App\Models\Evenues\Event;
use App\Models\Evenues\Venue;

class EditController extends Controller
{
    protected EventsService $service;

    public function __construct() {
        $this->service = new EventsService();
    }

    public function editEvent(Event $event)
    {
        $venues = Venue::all();
        dump($event->event_date);
        $weather = $this->service->getWeather($event->event_date, $event->id);

        return view('admin.event.edit', compact('event', 'venues', 'weather'));
    }

    public function editVenue(Venue $venue)
    {
        $currentDate = date('Y-m-d');
        $weather = $this->service->getWeather($currentDate);

        return view('admin.venue.edit',compact(['venue', 'currentDate', 'weather']));
    }
}
