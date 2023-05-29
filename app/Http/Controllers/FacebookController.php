<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function loginFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFromFacebook()
    {
        
        try {
            $user = Socialite::driver('facebook')->user();
            
            $saveUser = User::updateOrCreate([
                'facebook_id' => $user->getId(),
            ],[
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getName()),
                'confirmed' => 1
            ]);

            Auth::loginUsingId($saveUser->id);

            return redirect()->route('shopping.home');

        } catch(\Exception $e) {
            Log::error($e);
        };
    }
}
