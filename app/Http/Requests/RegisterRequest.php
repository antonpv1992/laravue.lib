<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'name' => 'string|max:255',
            'surname' => 'string|max:255',
            'age' => 'integer|max:255',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'login.required' => 'Field login is required',
            'login.max' => 'Field login must be no more than two hundred fifty five characters',
            'email.required' => 'Field email is required',
            'email.email' => 'Field email must contain an email address',
            'email.unique' => 'User with such mail is already registered',
            'password.require' => 'Field password is required',
            'name.max' => 'Field name must be no more than two hundred fifty five characters',
            'surname.max' => 'Field surname must be no more than two hundred fifty five characters',
            'age.max' => 'Field age must be no more than two hundred fifty five year'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => $validator->errors(),
            'data' => []
        ]);
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
