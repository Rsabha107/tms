<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\Event;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('tracki.auth.sign-in');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        Log::info($request);

        $request->authenticate();

        $request->session()->regenerate();

                //set the default workspace as set during user creation
                session()->put('workspace_id', $request->user()->workspace_id);
                Log::info('AuthenticatedSessionController:store workspace_id: '.$request->user()->workspace_id);

        // Log::info($request->authenticate());
        // Log::info($request->user()->role);
        $url = '';
        if ($request->user()->role === 'admin'){
            $url = 'tracki/dashboard';
        } elseif  ($request->user()->role === 'agent'){
            $url = 'tracki/dashboard';
        } elseif  ($request->user()->role === 'user'){
            $url = 'tracki/dashboard';
        }


        return redirect()->intended($url);
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
