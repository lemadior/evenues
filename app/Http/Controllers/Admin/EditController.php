<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenues\Event;
use App\Models\Evenues\Venue;

class EditController extends Controller
{
    public function editEvent(Event $event)
    {
        $venues = Venue::all();

        return view('admin.event.edit', compact('event', 'venues'));
    }

    public function editVenue(Venue $venue)
    {
        $currentDate = date('d-m-Y');

        return view('admin.venue.edit',compact(['venue', 'currentDate']));
    }
}
