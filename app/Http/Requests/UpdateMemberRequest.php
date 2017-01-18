<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            'password' => ['required_with:password_confirmation', 'confirmed']
        ];

        $files = $this->file('files');

        if (!empty($files)) {
            foreach ($files as $key => $file) // add individual rules to each image
            {
                $rules[sprintf('files.%d', $key)] = ['required', 'mimes:' . config('app.allowedFileTypes'), 'max:' . config('app.maxFileSize')];
            }
        }

        return $rules;
    }

    public function messages(){
        return [
            'lastname.required' => 'Lastname is required',
            'email.email' => 'Email must be a valid Email'
        ];
    }
}
