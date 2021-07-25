<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\LoginResource;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return response()->json([
            'redirectUrl' => Socialite::driver('facebook')
                ->stateless()
                ->redirect()
                ->getTargetUrl()
        ]);
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $token = $user->token;
            $$findUser = User::where('facebook_id', $user->id)->first();
            if ($$findUser) {
                Auth::login($$findUser);
                $findUser->token = $token;
                return response()->json($this->jResponse(true, 'User facebook login api', new LoginResource($findUser)), 200);
            } else {
                $newUser = User::create([
                    'login' => $user->login,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => bcrypt($user->password),
                    'name' => $user->name,
                ]);
                $newUser->attachRole('user');
                $newUser->token = $token;
                Auth::login($newUser);
                return response()->json($this->jResponse(true, 'User facebook register api', new RegisterResource($newUser)), 200);
            }

        } catch (Exception $e) {
            return response()->json($this->jResponse(false, $e->getMessage(), []), 400);
        }
    }
}
