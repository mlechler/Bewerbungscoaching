<?php

namespace App\Http\Requests\Frontend;

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
            'lastname' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:2'],
            'firstname' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:2'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'phone' => ['required', 'numeric'],
            'mobile' => ['required', 'numeric', 'unique:members', 'unique:employees'],
            'email' => ['required', 'email', 'unique:members', 'unique:employees'],
            'zip' => ['required', 'integer', 'min:4'],
            'city' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:2'],
            'street' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:2'],
            'housenumber' => ['required', 'alpha_num'],
            'job' => ['regex:/^[\pL\s\-]+$/u', 'min:2'],
            'employer' => ['regex:/^[\pL\s\-]+$/u', 'min:2'],
            'university' => ['regex:/^[\pL\s\-]+$/u', 'min:2'],
            'courseofstudies' => ['regex:/^[\pL\s\-]+$/u', 'min:2'],
            'password' => ['required', 'min:8', 'max:50', 'numbers', 'case_diff', 'letters', 'symbols', 'confirmed']
        ];
    }

    public function messages()
    {
        return [
            'lastname.required' => 'Lastname is required',
            'lastname.alpha' => 'Lastname could only contain letters',
            'lastname.min' => 'Lastname has to have at least two characters',
            'firstname.required' => 'Firstname is required',
            'firstname.alpha' => 'Firstname could only contain letters',
            'firstname.min' => 'Firstname has to have at least two characters',
            'birthday.required' => 'Birthday is required',
            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone has to be a valid Number',
            'mobile.required' => 'Mobile is required',
            'mobile.unique' => 'Mobile is already taken',
            'mobile.numeric' => 'Mobile has to be a valid Number',
            'email.required' => 'Email is required',
            'email.unique' => 'Email is already taken',
            'email.email' => 'Email has to be a valid Email',
            'zip.required' => 'Zip is required',
            'zip.integer' => 'Zip has to be a valid ZIP',
            'zip.min' => 'Zip has to have at least four characters',
            'city.required' => 'City is required',
            'city.regex' => 'City could only contain letters',
            'city.min' => 'City has to have at least two characters',
            'street.required' => 'Street is required',
            'street.alpha' => 'Street could only contain letters',
            'street.min' => 'Street has to have at least two characters',
            'housenumber.required' => 'Housenumber is required',
            'housenumber.alpha_num' => 'Housenumber could only contain letters and numbers',
            'job.regex' => 'Job could only contain letters',
            'job.min' => 'Job has to have at least two characters',
            'employer.regex' => 'Employer could only contain letters',
            'employer.min' => 'Employer has to have at least two characters',
            'university.regex' => 'University could only contain letters',
            'university.min' => 'University has to have at least two characters',
            'courseofstudies.alpha' => 'Course Of Studies could only contain letters',
            'courseofstudies.min' => 'Course Of Studies has to have at least two characters',
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
