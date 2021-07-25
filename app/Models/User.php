<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use Laratrust\Traits\LaratrustUserTrait;


class User extends Authenticatable implements MustVerifyEmail
{
    use LaratrustUserTrait, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'name',
        'surname',
        'age',
        'facebook_id',
        'google_id',
        'profile_photo_url',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function newUser(RegisterRequest $request)
    {
        $user =new self(array_merge($request->all(), ['password' => bcrypt($request->password)]));
        $user->save();
        $user->attachRole('user');
        return $user;
    }

    public static function updateUser(UserRequest $request, int $id)
    {
        $user = self::find($id);
        if(is_null($user)){
            return null;
        }
        $user->update($request->all());
        return $user;
    }

    public static function deleteUser(int $id)
    {
        $user = self::find($id);
        if(is_null($user)){
            return null;
        }
        $user->delete();
        return $user;
    }
}
