<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect(route('admin.index'));
        }

        return view('auth.login');
    }

    /**
     * Method to proceed POST request from login page
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function loginPost(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            return redirect()->intended(route('admin.index'));
        }

        Log::error('[LOGIN] wrong login attempt for user with email: ' . $data['email']);

        return redirect()->route('auth.login')->with('error', 'Login details are not valid')->withInput();
    }
}