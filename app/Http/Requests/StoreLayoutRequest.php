<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLayoutRequest extends FormRequest
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
            'title' => ['required', 'unique:applicationlayouts'],
            'description' => ['required'],
            'price' => ['required'],
            'preview' => ['mimes:' . config('app.allowedPreviewFileTypes'), 'max:' . config('app.maxFileSize')],
            'layout' => ['mimes:' . config('app.allowedLayoutFileTypes'), 'max:' . config('app.maxFileSize')]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Application Layouts',
            'description.required' => 'Description is required',
            'price.required' => 'Price is required',
            'preview.mimes' => 'Wrong Filetype for Preview',
            'preview.uploaded' => 'Filesize exceeded for Preview',
            'layout.mimes' => 'Wrong Filetype for Layout',
            'layout.uploaded' => 'Filesize exceeded for Layout',
        ];
    }
}
