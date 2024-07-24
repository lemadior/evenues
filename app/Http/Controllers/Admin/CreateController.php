<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Evenues\Admin\EventsService;
use App\Http\Controllers\Controller;
use App\Models\Evenues\Venue;
class CreateController extends Controller
{
    protected EventsService $service;

    public function __construct() {
        $this->service = new EventsService();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createVenue()
    {
        $currentDate = date('d-m-Y');
        $weather = $this->service->getWetherData($currentDate);

        return view('admin.venue.create', compact(['currentDate', 'weather']));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createEvent()
    {
        $currentDate = date('d-m-Y');
        $venues = Venue::all();

        $weather = $this->service->getWetherData($currentDate);

        return view('admin.event.create', compact(['currentDate', 'venues', 'weather']));
    }
}
