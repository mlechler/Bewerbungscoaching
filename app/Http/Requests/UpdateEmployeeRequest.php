<?php

namespace App\Http\Requests;

use App\Employee;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $id = $this->route('employee');
        $rules = [
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthday' => ['required', 'date_format:Y-m-d'],
            'phone' => ['required'],
            'mobile' => ['required', 'unique:employees,mobile,' . $id],
            'email' => ['required', 'email', 'unique:employees,email,' . $id],
            'password' => ['required_with:password_confirmation', 'confirmed'],
            'files' => ['array'],
            'zip' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'housenumber' => ['required']
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
}
