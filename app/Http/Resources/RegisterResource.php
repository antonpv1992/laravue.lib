<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'login' => $this->login ?? '',
            'email' => $this->email,
            'name' => $this->name ?? '',
            'token' => $this->token,
            'surname' => $this->surname ?? '',
            'age' => $this->age ?? '',
            'facebook_id' => $this->facebook_id ?? null,
            'google_id' => $this->google_id ?? null,
            'profile_photo_url' => $this->profile_photo_url ?? null,
            'create' => $this->created_at->format('d.m.Y'),
            'verify' => $this->email_verified_at !== null ? true : false,
            'role' => $this->hasRole('admin') ? 'admin' : 'user'
        ];
    }
}
