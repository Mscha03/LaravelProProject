<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try{
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate([
                'id' => $googleUser->getId(),
            ],[
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(\Str::random(16)), // Generate a random password
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            Auth::login($user);

            return redirect('/');
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }
}
