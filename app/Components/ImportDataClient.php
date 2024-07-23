<?php

namespace App\Components;

use GuzzleHttp\Client;

class ImportDataClient
{
    public Client $client;

    public function __construct(string $basePoint)
    {
        $this->client = new Client([
            'base_uri' => $basePoint . '/',
//            'base_uri' => 'https://api.stormglass.io/v2/weather/point',
            'timeout' => 2.0,
            'verify' => false
        ]);
    }


}
