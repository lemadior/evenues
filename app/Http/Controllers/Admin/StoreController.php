<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\CreateRequest as EventCreateRequest;
use App\Http\Requests\Admin\Venue\CreateRequest as VenueCreateRequest;
use App\Services\Evenues\Admin\EventService;
use App\Services\Evenues\Admin\VenueService;
use Exception;

class StoreController extends Controller
{
    protected VenueService $venueService;
    protected EventService $eventService;

    public function __construct()
    {
        $this->venueService = new VenueService();
        $this->eventService = new EventService();
    }

    /**
     * Save venue's data from the form to the database
     *
     * @param VenueCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeVenue(VenueCreateRequest $request)
    {
        try {
            $this->venueService->createVenue($request);
        } catch (Exception $err) {
            redirect()->back()->with('error', $err->getMessage());
        }

        return redirect()->route('admin.venues')->with('success', 'New venue has been created successfully');
    }

    /**
     * Save event's data from the form to the database
     *
     * @param EventCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEvent(EventCreateRequest $request)
    {
        try {
            $this->eventService->createEvent($request);
        } catch (Exception $err) {
            redirect()->back()->with('error', $err->getMessage());
        }

        return redirect()->route('admin.events')->with('success', 'New event has been created successfully');
    }
}
