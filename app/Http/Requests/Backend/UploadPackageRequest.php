<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UploadPackageRequest extends FormRequest
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
            'package' => ['mimes:' . config('app.allowedPackageFileTypes'), 'max:' . config('app.maxPackageFileSize')]
        ];
    }

    public function messages()
    {
        return [
            'package.mimes' => 'Wrong Filetype',
            'package.max' => 'Filesize exceeded'
        ];
    }
}