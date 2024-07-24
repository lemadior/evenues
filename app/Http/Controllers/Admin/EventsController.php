<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Exception;
use App\Services\Evenues\Admin\EventsService;

use App\Http\Requests\Admin\EventsRequest;

class EventsController extends Controller
{
    protected EventsService $service;


    public function __construct() {
        $this->service = new EventsService();
    }

    public function __invoke(EventsRequest $request)
    {
        $weather = [];

        try {
            $eventsData = $this->service->getEvents($request);
            $weather = $this->service->getWetherData(date('Y-m-d'));
//            dd($weather);
        } catch(Exception $err) {
            redirect()->back()->with('error', $error = $err->getMessage());
        }

        return view('admin.events', compact(['eventsData', 'weather']));
    }
}
