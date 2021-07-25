<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;

class UserRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user, 'id')],
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'age' => 'required|integer|max:255',
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
            'login.max' => 'Field login must be no more than two hundred and fifty five characters',
            'email.required' =>'Field email is required',
            'email.max' => 'Field description must be no more than two hundred and fifty five characters',
            'email.unique' => 'Field email must be unique',
            'name.required' => 'Field name is required',
            'name.max' => 'Field name must be no more than two hundred and fifty five characters',
            'surname.required' => 'Field surname is required',
            'surname.max' => 'Field surname must be no more than two hundred and fifty five characters',
            'age.required' => 'Field age is required',
            'age.max' => 'Field age must be no more than two hundred and fifty five characters',
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
