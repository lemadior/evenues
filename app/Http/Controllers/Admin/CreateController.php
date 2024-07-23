<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenues\Venue;
class CreateController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createVenue()
    {
        $currentDate = date('d-m-Y');

        return view('admin.venue.create', compact('currentDate'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function createEvent()
    {
        $currentDate = date('d-m-Y');
        $venues = Venue::all();

        return view('admin.event.create', compact(['currentDate', 'venues']));
    }
}
