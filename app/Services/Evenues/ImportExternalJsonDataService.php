<?php
declare(strict_types=1);

namespace App\Services\Evenues;

use Illuminate\Support\Facades\Session;
use App\Components\ImportDataClient;
use RuntimeException;
use Exception;

class ImportExternalJsonDataService
{
    const array LOCATE_KEYS = ['ip', 'city', 'latitude', 'longitude'];

    public function getWeatherData(string $lat, string $lng, string $start, string $end)
    {
        $baseUrl = config('app.weather_location_service');
        $authkey = config('app.weather_location_service_authkey');

        $import = new ImportDataClient($baseUrl);

        try {
            $response = $import->client->request('GET',
                "point?lat={$lat}&lng={$lng}&params=airTemperature,pressure,humidity,visibility,waterTemperature,windDirection,windSpeed&start={$start}&end={$end}&source=noaa",
                [
                    'headers' => [
                        'Authorization' => $authkey
                    ]
                ]
            );

        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getLocationData(bool $update = false)
    {
        if ($update || !$this->checkLocateDataInSession()) {
            $baseUrl = config('app.geoip_location_service');

            $import = new ImportDataClient($baseUrl);
            $response = $import->client->request('GET');
            $data = json_decode($response->getBody()->getContents(), true);

            $this->putLocateDataInSession($data);
        } else {
            $data = $this->getLocateDataFromSession();
        }

        return $data;
    }

    public function checkLocateDataInSession(): bool
    {
        foreach (self::LOCATE_KEYS as $key) {
            if (!Session::has($key)) {
                return false;
            }
        }

        return true;
    }

    public function putLocateDataInSession(array $data): void
    {
        foreach (self::LOCATE_KEYS as $key) {
            Session::put($key, $data[$key]);
        }
    }

    public function getLocateDataFromSession(): array
    {
        $data = [];

        if ($this->checkLocateDataInSession()) {
            foreach (self::LOCATE_KEYS as $key) {
                $data[$key] = Session::get($key);
            }
        }

        return $data;
    }

    public function cleanLocateDataInSession(): void
    {
        foreach (self::LOCATE_KEYS as $key) {
            if (Session::has($key)) {
                Session::forget($key);
            }
        }
    }
}
