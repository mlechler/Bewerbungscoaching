<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'title' => ['required', 'unique:pages'],
            'uri' => ['required', 'unique:pages'],
            'name' => ['unique:pages'],
            'pagecontent' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Pages',
            'uri.required' => 'URI is required',
            'uri.unique' => 'URI has to be unique in Pages',
            'name.unique' => 'Name has to be unique in Pages',
            'pagecontent.required' => 'Pagecontent is required'
        ];
    }
}
