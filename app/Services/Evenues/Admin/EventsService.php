<?php
declare(strict_types=1);

namespace App\Services\Evenues\Admin;

use App\Models\Evenues\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\EventsRequest;
use App\Services\Evenues\ImportExternalJsonDataService;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Exception;

class EventsService
{
    const int SECONDS_IN_DAY = 86399;
    const int SECONDS_IN_HOUR = 3600;
    protected ImportExternalJsonDataService $externalApiService;

    public function __construct()
    {
        $this->externalApiService = new ImportExternalJsonDataService();
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
        // Set table for sorting
        $table = $sorting === 'venue' ? 'venues' : 'events';

        // Set column for sorting
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

    // Get weather date depends on existence appropriate data in the Redis.
    public function getWeather(string $date, $eventId = 0): array
    {
        $weather = [];

        $date = explode(' ', $date)[0];

        try {
            $redis = Cache::store('redis')->getRedis();

            // Check if the weather data of the event has been stored in the Redis
            if ($redis->hexists($date, $eventId)) {
                $weather = json_decode($redis->hget($date, $eventId), true, 512, JSON_THROW_ON_ERROR);
            } else {
                $weather = $this->getWeatherData($date);

                $redis->hset($date, $eventId, json_encode($weather, JSON_THROW_ON_ERROR));
            }
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        return $weather;
    }

    // Get weather data for current location depends on specified date
    public function getWeatherData(string $date): array
    {
        $start = (string)strtotime($date);
        $end = (string)((int)$start + self::SECONDS_IN_DAY);

        $location = $this->getCurrentLocation();

        $lat = (string)$location['latitude'];
        $lng = (string)$location['longitude'];

        try {
            $response = $this->externalApiService->getWeatherData($lat, $lng, $start, $end);
        } catch (Exception $err) {
            throw new RuntimeException('Error. Cannot retrieve weather data');
        }

        return $this->parseWeatherData($response, $location);
    }

    // Get location data based on latitude and longitude
    public function getCurrentLocation(): array
    {
        if ($this->externalApiService->checkLocateDataInSession()) {
            $location = $this->externalApiService->getLocateDataFromSession();
        } else {
            $location = $this->externalApiService->getLocationData(true);
        }

        if (!isset($location['latitude'], $location['longitude'])) {
            throw new RuntimeException('Error. Cannot retrieve current location data');
        }

        return $location;
    }

    // Format weather (and location) data to used in blade templates
    public function parseWeatherData(array $data, array $location): array
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

        $arr['location'] = $location;

        return $arr;
    }
}
