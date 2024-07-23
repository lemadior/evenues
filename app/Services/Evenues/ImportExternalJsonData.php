<?php

namespace App\Services\Evenues;

use App\Components\ImportDataClient;

class ImportExternalJsonData
{


    public function getWeatherData(string $lat, string $lng, string $start, string $end)
    {
        $baseUrl = config('app.weather_location_service');

        $import = new ImportDataClient($baseUrl);

//        $response = $import->client->request('GET', 'geo.json');
        $response = $import->client->request('GET',
            "wthr.json?lat={$lat}&lng={$lng}&params=airTemperature,pressure,humidity,visibility,waterTemperature,windDirection,windSpeed&start={$start}&end={$end}&source=noaa",
//            [
//                'headers' => [
//                    'Authorization' => 'cf7e3688-4206-11ef-968a-0242ac130004-cf7e376e-4206-11ef-968a-0242ac130004',
//                ]
//            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getLocationData()
    {
        $baseUrl = config('app.geoip_location_service');

        $import = new ImportDataClient($baseUrl);

//        $response = $import->client->request('GET', 'geo.json');
        $response = $import->client->request('GET',
            "geo.json",
//            [
//                'headers' => [
//                    'Authorization' => 'cf7e3688-4206-11ef-968a-0242ac130004-cf7e376e-4206-11ef-968a-0242ac130004',
//                ]
//            ]
        );
        return json_decode($response->getBody()->getContents(), true);
    }
}