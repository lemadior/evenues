<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    // This is a start point
    public function __invoke()
    {
        return view('main.index');
    }
}
