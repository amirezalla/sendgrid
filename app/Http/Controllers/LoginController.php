<?php

namespace App\Http\Controllers;

use App\Services\SendGridService;
use App\Services\DomainAuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
 

    public function getLogin(Request $request){

        
        return view('login');


    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();

    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Check if the user's email is from the domain m.icoa.it
            if (str_ends_with($user->email, '@m.icoa.it')) {
                // Here you might want to check if the user exists in your database,
                // and if not, create the user. Then, log the user in.

                // For the sake of this example, let's assume you're directly logging in the user
                // This is a simplified approach. You should adapt it to your needs.
                // e.g., $appUser = User::firstOrCreate(['email' => $user->email], [...]);

                // Logging in the user using Laravel's Auth facade
                Auth::login($appUser, true);

                return redirect()->intended('dashboard');
            } else {
                // If the user's email does not match, redirect them back with an error.
                return redirect()->to('/login')->withErrors(['msg' => 'Only m.icoa.it email addresses are allowed.']);
            }
        } catch (\Exception $e) {
            // In case of error, redirect back with an error message.
            return redirect()->to('/login')->withErrors(['msg' => 'Error authenticating with Google.']);
        }
    }

}

