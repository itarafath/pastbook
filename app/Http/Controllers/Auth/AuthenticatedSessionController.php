<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\FacebookService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * @var \App\Services\FacebookService
     */
    private $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    public function create()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $facebook_user = Socialite::driver('facebook')->user();
        $user = User::where('facebook_id', $facebook_user->getId())->first();
        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'name' => $facebook_user->getName(),
                'email' => $facebook_user->getEmail(),
                'password' => Hash::make('password'),
                'facebook_id' => $facebook_user->getId(),
            ]);

            Auth::login($user);
        }

//        dd($this->facebookService->getImages($facebook_user->token));


        return redirect()->route('home');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
