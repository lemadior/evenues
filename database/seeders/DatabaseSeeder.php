<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Evenues\Venue;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Venue::factory()->count(19)->hasEvents(2)->create();

        Venue::factory()->hasEvents(12)->create();

         User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@example.com',
         ]);
    }
}
