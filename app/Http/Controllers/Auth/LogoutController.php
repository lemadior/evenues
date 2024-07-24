<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Services\Evenues\ImportExternalJsonDataService;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class LogoutController extends Controller
{
    public function logout()
    {
        $service = new ImportExternalJsonDataService();

        Session::flush();

        Auth::logout();

        $service->cleanLocateDataInSession();

        return redirect()->route('main.index')->setStatusCode(302);
    }
}
