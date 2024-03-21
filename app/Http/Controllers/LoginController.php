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
            // Store user information in session
            session(['user' => $user]);

            // Redirect the user to the intended page or a default page
            return redirect()->intended('/');
        } else {
            // If the user's email does not match, redirect them back with an error.
            return redirect()->to('/login')->withErrors(['msg' => 'Only ICOA email addresses are allowed.']);
        }
    } catch (\Exception $e) {
        // In case of error, redirect back with an error message.
        return redirect()->to('/login')->withErrors(['msg' => 'Error authenticating with Google.']);
    }
}


}

