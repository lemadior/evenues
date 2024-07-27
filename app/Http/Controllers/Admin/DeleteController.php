<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenues\Event;
use App\Models\Evenues\Venue;
use Illuminate\Support\Facades\Cache;
use Exception;

class DeleteController extends Controller
{
    public function deleteEvent(Event $event)
    {
        // URL to return. In some case redirect()->back() may not works properly
        $previousUrl = session()->get('events_url', route('admin.events'));

        session()->forget('events_url');

        try {
            $redis = Cache::store('redis')->getRedis();
            $date = explode(' ', $event->event_date)[0];

            if ($redis->hexists($date, $event->id)) {
                $redis->hdel($date, $event->id);
            }

            $event->delete();
        } catch (Exception $err) {
            return redirect($previousUrl)->with('error', $err->getMessage());
        }

        return redirect()->route('admin.events')->with('success', 'Event record deleted successfully.');
    }

    public function deleteVenue(Venue $venue)
    {
        try {
            $venue->delete();
        } catch (Exception $err) {
            return redirect()->back()->with('error', $err->getMessage());
        }

        return redirect()->route('admin.venues')->with('success', 'Venue was deleted successfully.');
    }
}
