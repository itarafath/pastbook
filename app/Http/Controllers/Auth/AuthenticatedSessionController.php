<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\ImagesReposotory;
use App\Repositories\UserRepository;
use App\Services\FacebookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

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

    public function callback(UserRepository $userRepository, ImagesReposotory $imageRepository): RedirectResponse
    {
        try {
            $facebook_user = Socialite::driver('facebook')->user();
            $user = User::where('facebook_id', $facebook_user->getId())->first();

            // dd($this->facebookService->getImages($facebook_user->token));
            $facebookImages = $this->facebookService->getDummyImages();

            if ($user) {
                Auth::login($user);
            } else {
                $user = $userRepository->insert($facebook_user);
                $imageRepository->insert($facebookImages);

                Auth::login($user);
            }

            return redirect()->route('dashboard');
        } catch (InvalidStateException $e) {
            return back();
        }
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
