<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Evenues\Admin\VenuesService;
use App\Services\Evenues\Admin\EventsService;
use App\Http\Requests\Admin\VenuesRequest;
use Exception;

class VenuesController extends Controller
{
    protected VenuesService $venuesService;

    protected EventsService $eventsService;

    public function __construct() {
        $this->venuesService = new VenuesService();
        $this->eventsService = new EventsService();
    }

    public function __invoke(VenuesRequest $request)
    {
        try {
            $venuesData = $this->venuesService->getVenues($request);
            $weather = $this->eventsService->getWetherData(date('Y-m-d')) ?? [];
        } catch(Exception $err) {
            redirect()->back()->with('error', $err->getMessage());
        }

        return view('admin.venues', compact(['venuesData', 'weather']));
    }
}
