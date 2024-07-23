<?php
declare(strict_types=1);

namespace App\Services\Evenues\Admin;

use App\Models\Evenues\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\EventsRequest;
use RuntimeException;
use Exception;

class EventsService
{
    public function getEvents(EventsRequest $request): array
    {
        $eventsData = [];

        $data = $request->validated();

        $eventsPerPage = $data['per_page'] ?? '20';
        $sorting = $data['sorting'] ?? '';
        $direction = $data['direction'] ?? '';

        try {
            $eventsData['events'] = $this->getEventsWithPagination($sorting, $direction, $eventsPerPage);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        $eventsData['sorting'] = $sorting;
        $eventsData['perPage'] = $eventsPerPage;
        $eventsData['direction'] = $direction;
        $eventsData['currentDate'] = date('d-m-Y');

        return $eventsData;
    }

    public function getEventsWithPagination(string $sorting, string $direction, string $perPage): LengthAwarePaginator
    {
        $table = $sorting === 'venue' ? 'venues' : 'events';

        $sorting = $sorting === 'venue' ? 'name' : $sorting;

        $events = Event::query()
            ->join('venues', 'events.venue_id', '=', 'venues.id')
            ->select('events.*')
            ->with('venue');

        // Return depends on sorting options
        return $sorting
            ? $events->orderBy($table . '.' . $sorting, $direction)->paginate($perPage)
            : $events->paginate($perPage);

    }
}
