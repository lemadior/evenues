<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Evenues\Admin\EventsService;
use App\Http\Controllers\Controller;
use App\Models\Evenues\Event;
use App\Models\Evenues\Venue;
use Exception;

class EditController extends Controller
{
    protected EventsService $service;

    public function __construct()
    {
        $this->service = new EventsService();
    }

    public function editEvent(Event $event)
    {
        $venues = Venue::all();
        $weather = [];

        try {
            $weather = $this->service->getWeather($event->event_date, $event->id);
        } catch (Exception $err) {
            redirect()->route('admin.edit.event', $event->id)->with([
                'error' => $err->getMessage(),
                'event' => $event,
                'venues' => $venues,
                'weather' => []
            ]);
        }

        return view('admin.event.edit', compact('event', 'venues', 'weather'));
    }

    public function editVenue(Venue $venue)
    {
        $currentDate = date('Y-m-d');
        $weather = [];

        try {
            $weather = $this->service->getWeather($currentDate);
        } catch (Exception $err) {
            redirect()->route('admin.edit.venue', $venue->id)->with([
                'error' => $err->getMessage(),
                'venue' => $venue,
                'currentDate' => $currentDate,
                'weather' => []
            ]);
        }

        return view('admin.venue.edit', compact(['venue', 'currentDate', 'weather']));
    }
}
