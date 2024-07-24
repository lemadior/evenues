<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Services\Evenues\Admin\EventsService;
use App\Http\Controllers\Controller;
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
        $currentDate = date('d-m-Y');
        $weather = $this->service->getWetherData(date('Y-m-d')) ?? [];

        return view('admin.index', compact(['currentDate', 'weather']));
    }
}
