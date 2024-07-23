<?php
declare(strict_types=1);

namespace App\Services\Evenues\Admin;

use App\Models\Evenues\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\EventsRequest;
use App\Services\Evenues\ImportExternalJsonData;
use RuntimeException;
use Exception;

class EventsService
{
    const int SECOND_IN_DAY = 86399;
    protected ImportExternalJsonData $externalApiService;

    public function __construct() {
        $this->externalApiService = new ImportExternalJsonData();
    }

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

    public function getWetherData(string $date): array
    {
        $weather = [];
        $start = strtotime($date);
        $end = (int)$start + self::SECOND_IN_DAY;

        try {
            $location = $this->externalApiService->getLocationData();

            if (!isset($location['latitude'], $location['longitude'])) {
                throw new RuntimeException('Error. Cannot retrieve location data');
            }

            $lat = $location['latitude'];
            $lng = $location['longitude'];

            $responce = $this->externalApiService->getWeatherData($lat, $lng, (string)$start, (string)$end) ;

            if (!$responce || count($responce) === 0 || !isset($responce['hours'])) {
                throw new RuntimeException('Error. Cannot retrieve weather data');
            }

            $weather = $this->parseWeatherData($responce);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        return $weather;
    }

    public function parseWeatherData(array $data): array
    {
        $arr = [];
        $source = $data['meta']['source'][0];
        $weather = $data['hours'][15];

        foreach ($weather as $param => $value) {
            if ($param === 'time') {
                continue;
            }

            $arr[$param] = $value[$source];
        }

        return $arr;
    }
}
