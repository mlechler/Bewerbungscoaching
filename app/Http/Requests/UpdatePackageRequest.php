<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
        $id = $this->route('applicationpackage');
        return [
            'title' => ['required', 'unique:applicationpackages,title,' . $id],
            'description' => ['required'],
            'price' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Application Packages',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required'
        ];
    }
}
