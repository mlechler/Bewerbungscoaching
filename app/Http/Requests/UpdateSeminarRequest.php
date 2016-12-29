<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeminarRequest extends FormRequest
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
        $id = $this->route('seminar');
        return [
            'title' => ['required', 'unique:seminars,title,'.$id],
            'description' => ['required'],
            'services' => ['required'],
            'maxMembers' => ['required'],
            'duration' => ['required'],
            'price' => ['required'],
        ];
    }
}
