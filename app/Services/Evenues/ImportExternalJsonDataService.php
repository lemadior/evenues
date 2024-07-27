<?php
declare(strict_types=1);

namespace App\Services\Evenues;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
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
        // Authorization key from the https://api.stormglass.io service
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
        } catch (RequestException $err) {
            Log::error('Guzzle error: ' . $err->getMessage());

            if ($err->hasResponse()) {
                $code = $err->getResponse()->getStatusCode();

                if ($code == 402) {
                    throw new RuntimeException('Error. Service payment Required. Exceed quota of free API requests');
                }
            }

            throw new RuntimeException($err->getMessage());
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getLocationData(bool $update = false)
    {
        if ($update || !$this->checkLocateDataInSession()) {
            $baseUrl = config('app.geoip_location_service');

            $import = new ImportDataClient($baseUrl);
            try {
                $response = $import->client->request('GET');
            } catch (RequestException $err) {
                Log::error('Guzzle error: ' . $err->getMessage());

                throw new RuntimeException($err->getMessage());
            }

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
