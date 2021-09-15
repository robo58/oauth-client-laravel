<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('passport')->stateless()->redirect();
    }


    public function handleProviderCallback()
    {
        $user_socialite = Socialite::driver('passport')->stateless()->user();
            $user = User::updateOrCreate(
                [
                    'name' => $user_socialite->getName(),
                    'email' => $user_socialite->getEmail(),
                ],[
                'name' => $user_socialite->getName(),
                'email' => $user_socialite->getEmail(),
            ]);
         $user_token = $user->createToken('my token')->plainTextToken;
        return redirect('eduid://callback?first_api_token='.$user_token.'&central_api_token='.$user_socialite->token);
    }}
