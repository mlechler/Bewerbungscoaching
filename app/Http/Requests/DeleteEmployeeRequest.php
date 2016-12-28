<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->route('id') == auth()->user()->id) {
            return false;
        }

        return true;
    }

    public function forbiddenresponse()
    {
        return redirect()->back()->withErrors([
           'error' => 'You are not able to delete yourself.'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
