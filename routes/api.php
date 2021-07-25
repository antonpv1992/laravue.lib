<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest:api')->group( function () {
    Route::post('/register', 'App\Http\Controllers\AuthController@register')->name('register');
    Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::post('/forgot', 'App\Http\Controllers\AuthController@forgot')->name('forgot');//->name('password.email');
    Route::post('/reset', 'App\Http\Controllers\AuthController@reset')->name('reset');//->name('password.update');
    Route::get('/reset/{token}', function(Request $request){
        return $request->all();
    })->name('password.reset');
    Route::get('/book', 'App\Http\Controllers\BookController@index');
    Route::get('/auth/facebook', 'App\Http\Controllers\FacebookController@redirectToFacebook');
    Route::get('/auth/facebook/callback', 'App\Http\Controllers\FacebookController@handleFacebookCallback');
    Route::get('/auth/google', 'App\Http\Controllers\GoogleController@redirectToGoogle');
    Route::get('/auth/google/callback', 'App\Http\Controllers\GoogleController@handleGoogleCallback');
});

Route::middleware('auth:api')->group( function () {
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
    Route::get('/verify/{id}/{hash}', 'App\Http\Controllers\AuthController@verify')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/verify', 'App\Http\Controllers\AuthController@resend')->middleware(['throttle:6,1'])->name('verification.send');
    Route::post('/book', 'App\Http\Controllers\BookController@store')->middleware('role:admin');
    Route::get('/book/{id}', 'App\Http\Controllers\BookController@show');
    Route::patch('/book/{id}', 'App\Http\Controllers\BookController@update')->middleware('role:admin');
    Route::delete('/book/{id}', 'App\Http\Controllers\BookController@destroy')->middleware('role:admin');
    Route::get('/user', 'App\Http\Controllers\UserController@index');
    Route::post('/user', 'App\Http\Controllers\UserController@store')->middleware('role:admin');
    Route::get('/user/{id}', 'App\Http\Controllers\UserController@show');
    Route::patch('/user/{id}', 'App\Http\Controllers\UserController@update');
    Route::delete('/user/{id}', 'App\Http\Controllers\UserController@destroy')->middleware('role:admin');
});
