<?php

namespace App\Console\Commands;

use App\Components\ImportDataClient;
use Illuminate\Console\Command;

class ImportJsonApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:import-json-from-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from another source via API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $import = new ImportDataClient();

//        $response = $import->client->request('GET', 'geo.json');
        $response = $import->client->request('GET',
            'wthr.json?lat=49.42854&lng=32.06207&params=airTemperature,pressure,humidity,seaLevel,visibility,waterTemperature,windDirection,windSpeed&start=1721692800&end=1721779199&source=noaa',

        );
        dd(json_decode($response->getBody()->getContents(), true)['meta']['start']);
    }
}
