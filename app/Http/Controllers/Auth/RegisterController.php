<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register()
    {
        if (Auth::check()) {
            return redirect(route('admin.faux.index'));
        }

        return view('auth.register');
    }

    /**
     * Method to proceed POST request from register page
     *
     * @param RegisterRequest $request
     * @return Application|\Illuminate\Foundation\Application|RedirectResponse|Redirector
     */
    public function registerPost(RegisterRequest $request)
    {
        $data = $request->validated();

        unset($data['confirm']);

        $data['password'] = Hash::make($data['password']);

        try {
            $user = User::create($data);
        } catch (Exception $err) {
            $user = null;

            Log::error("[REGISTER] Cannot create user via 'User' model");
        } finally {
            if (!$user) {
                return redirect()->route('auth.register')->with('error', 'DB: Cannot create user')->withInput();
            }
        }

        Log::info('[REGISTER] New user with ID=' . $user->id . ' has been created successfully');

        return redirect()->route('auth.login')->with('success', 'Registration successful. Login to admin dashboard');
    }
}
