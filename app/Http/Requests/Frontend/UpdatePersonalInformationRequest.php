<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePersonalInformationRequest extends FormRequest
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
        $member = Auth::guard('member')->user();
        return [
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'phone' => ['required'],
            'mobile' => ['required', 'unique:employees', 'unique:members,mobile,' . $member->id],
            'email' => ['required', 'email', 'unique:employees', 'unique:members,email,' . $member->id],
            'zip' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'housenumber' => ['required'],
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
            'mobile.unique' => 'Mobile has already been taken',
            'email.required' => 'Email is required',
            'email.unique' => 'Email has already been taken',
            'email.email' => 'Email has to be a valid Email',
            'zip.required' => 'Zip is required',
            'city.required' => 'City is required',
            'street.required' => 'Street is required',
            'housenumber.required' => 'Housenumber is required',
        ];
    }
}
