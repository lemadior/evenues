<?php
declare(strict_types=1);

namespace Database\Factories\Evenues;

use App\Models\Evenues\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Sometimes $image returns 'null'. To avoid this while statement is used.
        while (!$image = $this->faker->image()) {
            continue;
        }

        $imagePath = 'images/' . basename($image);
        Storage::disk('public')->put($imagePath, file_get_contents($image));

        return [
            'name' => $this->faker->sentence(4),
            'poster' => $imagePath,
            'event_date' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'venue_id' => Venue::factory()
        ];
    }
}
