<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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
        $id = $this->route('page');
        return [
            'title' => ['required', 'unique:pages,title,'.$id],
            'uri' => ['required', 'unique:pages,uri,'.$id],
            'name' => ['unique:pages,name,'.$id],
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
