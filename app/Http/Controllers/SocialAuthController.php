<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\SocialAccountServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        $valid_domain = env('VALID_AUTH_DOMAIN', false);

        if ($valid_domain && $provider === 'google') {
            return Socialite::driver($provider)->with(['hd' => $valid_domain])->redirect();
        } else {
            return Socialite::driver($provider)->redirect();
        }
    }

    public function callback(Request $request, SocialAccountServiceProvider $service, $provider)
    {

        $user = $service->createOrGetUser($request, Socialite::driver($provider));

        if (is_a($user, 'Illuminate\Http\RedirectResponse')) return $user;

        auth()->login($user);

        /**
         * add JWT
         */
        $token = JWTAuth::fromUser(Auth::user());
        if ($token) {
            setcookie('accessToken', $token);
        } else {
            abort(500);
        }

        return redirect()->intended('/');
    }
}
