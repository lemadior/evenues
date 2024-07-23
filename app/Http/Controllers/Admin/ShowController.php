<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenues\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class ShowController extends Controller
{
    /**
     * Just show data about specified event (with venue and weather data)
     *
     * @param Event $event
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showEvent(Event $event)
    {
        session()->put('events_url', url()->previous());

        return view('admin.event.show', compact('event'));
    }
}
