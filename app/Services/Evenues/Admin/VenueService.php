<?php
declare(strict_types=1);

namespace App\Services\Evenues\Admin;

use App\Http\Requests\Admin\Venue\CreateRequest;
use App\Http\Requests\Admin\Venue\CreateRequest as UpdateRequest;
use App\Models\Evenues\Venue;
use Exception;

use RuntimeException;

class VenueService
{
    public function createVenue(CreateRequest $request): void
    {
        $data = $request->validated();

        try {
            Venue::firstOrCreate($data);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }
    }

    public function updateVenue(UpdateRequest $request, Venue $venue): void
    {
        $data = $request->validated();

        try {
            $venue->update($data);

            $venue->refresh();
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }
    }
}
