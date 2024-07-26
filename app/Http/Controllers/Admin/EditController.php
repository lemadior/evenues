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
        $weather = $this->service->getWeatherData($event->event_date);

        return view('admin.event.edit', compact('event', 'venues', 'weather'));
    }

    public function editVenue(Venue $venue)
    {
        $currentDate = date('d-m-Y');
        $weather = $this->service->getWeatherData($currentDate);

        return view('admin.venue.edit',compact(['venue', 'currentDate', 'weather']));
    }
}
