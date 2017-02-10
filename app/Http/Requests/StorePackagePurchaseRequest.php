<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackagePurchaseRequest extends FormRequest
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
            'member_id' => ['required'],
            'applicationpackage_id' => ['required'],
            'price_incl_discount' => ['required'],
            'package' => ['mimes:' . config('app.allowedPackageFileTypes'), 'max:' . config('app.maxPackageFileSize')]
        ];
    }

    public function messages()
    {
        return [
            'member_id.required' => 'Member is required',
            'applicationpackage_id.required' => 'Application Package is required',
            'price_incl_discount.required' => 'Price is required',
            'package.mimes' => 'Wrong Filetype',
            'package.uploaded' => 'Filesize exceeded'
        ];
    }
}
