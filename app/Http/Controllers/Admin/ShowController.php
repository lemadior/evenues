<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenues\Event;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Services\Evenues\Admin\EventsService;


class ShowController extends Controller
{
    protected EventsService $service;

    public function __construct()
    {
        $this->service = new EventsService();
    }

    /**
     * Just show data about specified event (with venue and weather data)
     *
     * @param Event $event
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showEvent(Event $event)
    {
        $weather = [];

        session()->put('events_url', url()->previous());

        try {
            $weather = $this->service->getWeather($event->event_date, $event->id);
        } catch (Exception $err) {
            redirect()->route('admin.show.event', $event->id)->with([
                'error' => $err->getMessage(),
                'event' => $event,
                'weather' => []
            ]);
        }
        return view('admin.event.show', compact(['event', 'weather']));
    }
}
