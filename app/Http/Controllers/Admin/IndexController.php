<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Evenues\Admin\EventsService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected EventsService $service;

    public function __construct()
    {
        $this->service = new EventsService();
    }

    public function __invoke(Request $request)
    {
        $currentDate = date('Y-m-d');

        $weather = [];

        try {
            $weather = $this->service->getWeather($currentDate);
        } catch (Exception $err) {
            redirect()->route('admin.index')->with([
                'error' => $err->getMessage(),
                'currentDate' => $currentDate,
                'weather' => []
            ]);
        }

        return view('admin.index', compact(['currentDate', 'weather']));
    }
}
