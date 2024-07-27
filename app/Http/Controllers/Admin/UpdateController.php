<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\UpdateRequest as EventUpdateRequest;
use App\Http\Requests\Admin\Venue\CreateRequest as VenueUpdateRequest;
use App\Models\Evenues\Event;
use App\Models\Evenues\Venue;
use App\Services\Evenues\Admin\EventService;
use App\Services\Evenues\Admin\VenueService;
use Exception;

class UpdateController extends Controller
{
    protected VenueService $venueService;
    protected EventService $eventService;

    public function __construct()
    {
        $this->venueService = new VenueService();
        $this->eventService = new EventService();
    }

    public function updateEvent(EventUpdateRequest $request, Event $event)
    {
        try {
            $this->eventService->updateEvent($request, $event);
        } catch (Exception $err) {
            redirect()->back()->with('error', $err->getMessage());
        }

        return redirect()->route('admin.show.event', $event->id)->with([
            'success' => 'The event\'s data has been updated successfully'
        ]);
    }

    public function updateVenue(VenueUpdateRequest $request, Venue $venue)
    {
        try {
            $this->venueService->updateVenue($request, $venue);
        } catch (Exception $err) {
            redirect()->back()->with('error', $err->getMessage());
        }

        return redirect()->route('admin.venues')->with([
            'success' => 'The venue\'s data has been updated successfully'
        ]);
    }
}
