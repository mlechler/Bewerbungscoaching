<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => ['required', 'unique:posts'],
            'slug' => ['required'],
            'published_at' => ['date_format:Y-m-d H:i:s'],
            'body' => ['required'],
            'image' => ['mimes:' . config('app.allowedImageFileTypes'), 'max:' . config('app.maxFileSize')]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Blog Posts',
            'slug.required' => 'Slug is required',
            'body.required' => 'Body is required',
            'image.mimes' => 'Wrong Filetype',
            'image.max' => 'Filesize exceeded'
        ];
    }
}
