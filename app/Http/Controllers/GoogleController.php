<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RegisterResource;
use App\Http\Resources\LoginResource;

class GoogleController extends Controller
{

    public function redirectToGoogle()
    {
        return response()->json([
            'redirectUrl' => Socialite::driver('google')
                ->redirect()
                ->getTargetUrl()
        ]);
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $token = $user->token;
            $findUser = User::where('google_id', $user->id)->first();
            if($findUser){
                Auth::login($findUser);
                $findUser->token = $token;
                return response()->json($this->jResponse(true, 'User facebook login api', new LoginResource($findUser)), 200);
            } else {
                $newUser = User::create([
                    'login' => $user->nickname,
                    'email' => $user->email,
                    'google_id'=> $user->id,
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
