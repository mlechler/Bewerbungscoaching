<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterNewMember extends FormRequest
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
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'phone' => ['required'],
            'mobile' => ['required', 'unique:members', 'unique:employees'],
            'email' => ['required', 'email', 'unique:members', 'unique:employees'],
            'zip' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'housenumber' => ['required'],
            'password' => ['required', 'min:8', 'max:50', 'numbers', 'case_diff', 'letters', 'symbols', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'lastname.required' => 'Lastname is required',
            'firstname.required' => 'Firstname is required',
            'birthday.required' => 'Birthday is required',
            'phone.required' => 'Phone is required',
            'mobile.required' => 'Mobile is required',
            'mobile.unique' => 'Mobile is already taken',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'email.email' => 'Email has to be a valid Email',
            'zip.required' => 'Zip is required',
            'city.required' => 'City is required',
            'street.required' => 'Street is required',
            'housenumber.required' => 'Housenumber is required',
            'password.required' => 'Password is required',
            'password.min' => 'Password has to have at least eight characters',
            'password.max' => 'Password could have a maximum of 50 characters',
            'password.numbers' => 'Password has to have at least one number',
            'password.case_diff' => 'Password has to have upper and lower case letters',
            'password.letters' => 'Password has to have at least one letter',
            'password.symbols' => 'Password has to have at least one symbol',
            'password.confirmed' => 'Password has to be confirmed'
        ];
    }
}
