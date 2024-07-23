<?php
declare(strict_types=1);

namespace App\Services\Evenues\Admin;

use App\Models\Evenues\Venue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\VenuesRequest;
use RuntimeException;
use Exception;

class VenuesService
{
    public function getVenues(VenuesRequest $request): array
    {
        $venuesData = [];

        $data = $request->validated();

        $venuesPerPage = $data['per_page'] ?? '20';
        $sorting = $data['sorting'] ?? '';
        $direction = $data['direction'] ?? '';

        try {
            $venuesData['venues'] = $this->getVenuesWithPagination($sorting, $direction, $venuesPerPage);
        } catch (Exception $err) {
            throw new RuntimeException($err->getMessage());
        }

        $venuesData['perPage'] = $venuesPerPage;
        $venuesData['currentDate'] = date('d-m-Y');
        $venuesData['sorting'] = $sorting;
        $venuesData['direction'] = $direction;

        return $venuesData;
    }

    public function getVenuesWithPagination(string $sorting, string $direction, string $perPage): LengthAwarePaginator
    {
        $venues = Venue::query();

        return $sorting
            ? $venues->orderBy($sorting, $direction)->paginate($perPage)
            : $venues->paginate($perPage);
    }
}
