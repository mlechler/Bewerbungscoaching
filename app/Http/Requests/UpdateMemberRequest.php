<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
{
    protected $fileindex;
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
        $id = $this->route('member');
        $rules = [
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'phone' => ['required'],
            'mobile' => ['required', 'unique:employees', 'unique:members,mobile,' . $id],
            'email' => ['required', 'email', 'unique:employees', 'unique:members,email,' . $id],
            'files' => ['array'],
            'zip' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'housenumber' => ['required'],
            'role_id' => ['required'],
            'password' => ['required_with:password_confirmation', 'min:8', 'max:50', 'numbers', 'case_diff', 'letters', 'symbols', 'confirmed']
        ];

        $files = $this->file('files');

        if (!empty($files)) {
            foreach ($files as $key => $file) // add individual rules to each image
            {
                $rules[sprintf('files.%d', $key)] = ['required', 'mimes:' . config('app.allowedFileTypes'), 'max:' . config('app.maxFileSize')];
                $this->fileindex[] = [
                    sprintf('files.%d', $key) . '.required',
                    sprintf('files.%d', $key) . '.mimes',
                    sprintf('files.%d', $key) . '.uploaded'
                ];
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'lastname.required' => 'Lastname is required',
            'firstname.required' => 'Firstname is required',
            'birthday.required' => 'Birthday is required',
            'phone.required' => 'Phone is required',
            'mobile.required' => 'Mobile is required',
            'mobile.unique' => 'Mobile has to be unique in Members and Employees',
            'email.required' => 'Email is required',
            'email.unique' => 'Email has to be unique in Members and Employees',
            'email.email' => 'Email has to be a valid Email',
            'zip.required' => 'Zip is required',
            'city.required' => 'City is required',
            'street.required' => 'Street is required',
            'housenumber.required' => 'Housenumber is required',
            'role_id.required' => 'Role is required',
            'password.min' => 'Password has to have at least eight characters',
            'password.max' => 'Password could have a maximum of 50 characters',
            'password.numbers' => 'Password has to have at least one number',
            'password.case_diff' => 'Password has to have upper and lower case letters',
            'password.letters' => 'Password has to have at least one letter',
            'password.symbols' => 'Password has to have at least one symbol',
            'password.confirmed' => 'Password has to be confirmed'
        ];

        if ($this->fileindex) {
            foreach ($this->fileindex as $file) {
                $messages[$file[0]] = 'File is required';
                $messages[$file[1]] = 'Wrong Filetype';
                $messages[$file[2]] = 'Filesize exceeded';
            }
        }
        return $messages;
    }
}
