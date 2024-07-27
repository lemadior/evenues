<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Evenues\Admin\EventsService;
use App\Http\Controllers\Controller;
use App\Models\Evenues\Venue;
use Exception;

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
        $currentDate = date('Y-m-d');
        $weather = [];

        try {
            $weather = $this->service->getWeather($currentDate);
        } catch (Exception $err) {
            redirect()->route('admin.venue.create')->with([
                'error' => $err->getMessage(),
                'currentDate' => $currentDate,
                'weather' => []
            ]);
        }

        return view('admin.venue.create', compact(['currentDate', 'weather']));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createEvent()
    {
        $currentDate = date('Y-m-d');
        $venues = Venue::all();
        $weather = [];

        try {
            $weather = $this->service->getWeather($currentDate);
        } catch (Exception $err) {
            redirect()->route('admin.event.create')->with([
                'error' => $err->getMessage(),
                'currentDate' => $currentDate,
                'venues' => $venues,
                'weather' => []
            ]);
        }

        return view('admin.event.create', compact(['currentDate', 'venues', 'weather']));
    }
}
