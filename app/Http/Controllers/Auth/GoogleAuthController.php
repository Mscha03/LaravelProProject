<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use SweetAlert2\Laravel\Swal;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(){
        try{
            $googleUser = Socialite::driver('google')->user();

            // Check if the user already exists in the database
            if (User::where('email', $googleUser->getEmail())->exists()) {
                $user = User::where('email', $googleUser->getEmail())->first();
            } else {
                $user = User::updateOrCreate([
                    'id' => $googleUser->getId(),
                ],[
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(\Str::random(16)), // Generate a random password
//                    'google_token' => $googleUser->token,
//                    'google_refresh_token' => $googleUser->refreshToken,
                ]);

            }
            Auth::login($user);


            return redirect('/');

        }catch (\Exception $exception){
            $mesage = $exception->getMessage();
            Swal::fire([
                'title' => 'Error',
                'text' => "Login with google was not seccessfully - $mesage",
                'icon' => 'error',
                'confirmButtonText' => 'OK'
            ]);
            return redirect('/login');
        }

    }
}
