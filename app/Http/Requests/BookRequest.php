<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class BookRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:50',
            'description' => 'required|min:10|max:500',
            'author' => 'required|string|max:50',
            'image' => 'mimes:jpg,jpeg,bmp,png|max:5000',
            'genre' => 'required|string|max:50',
            'year' => 'required|integer|max:2021',
            'country' => 'required|string|max:50',
            'pages' => 'required|integer|min:1',
            'book' => 'required'
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
            'title.required' => 'Field title is required',
            'title.min' => 'Field title must be at least three characters',
            'title.max' => 'Field title must be no more than fifty characters',
            'description.required' =>'Field description is required',
            'description.min' => 'Field description must be at least ten characters',
            'description.max' => 'Field description must be no more than five hundred characters',
            'author.required' => 'Field author is required',
            'author.max' => 'Field author must be no more than fifty characters',
            'image.mimes' => 'Field image supports formats jpg, jpeg, bmp and png',
            'image.max' => 'Field image maximum file size 5 mb',
            'genre.required' => 'Field genre is required',
            'genre.max' => 'Field genre must be no more than fifty characters',
            'year.required' => 'Field year is required',
            'year.max' => 'Field year supports no more than 2021',
            'country.required' => 'Field country is required',
            'country.max' => 'Field country must be no more than fifty characters',
            'pages.required' => 'Field pages is required',
            'pages.min' => 'Field pages must be at least one number',
            'book.required' => 'Field book is required'
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
