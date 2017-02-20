<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberPasswordRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'old_password' => ['required'],
            'password' => ['required_with:password_confirmation', 'min:8', 'max:50', 'numbers', 'case_diff', 'letters', 'symbols', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email has to be a valid Email',
            'old_password.required' => 'Old Password is required',
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
