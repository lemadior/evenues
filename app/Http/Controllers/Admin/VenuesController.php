<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Evenues\Admin\VenuesService;
use App\Http\Requests\Admin\VenuesRequest;
use Exception;

class VenuesController extends Controller
{
    protected VenuesService $service;

    public function __construct() {
        $this->service = new VenuesService();
    }

    public function __invoke(VenuesRequest $request)
    {
        try {
            $venuesData = $this->service->getVenues($request);
        } catch(Exception $err) {
            redirect()->back()->with('error', $err->getMessage());
        }

        return view('admin.venues', compact('venuesData'));
    }
}
