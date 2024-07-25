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
            'timeout' => 2.0,
            'verify' => false
        ]);
    }
}
