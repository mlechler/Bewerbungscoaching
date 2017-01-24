<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberdiscountRequest extends FormRequest
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
            'discount_id' => ['required'],
            'startdate' => ['required'],
            'code' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'member_id.required' => 'Member is required',
            'discount_id.required' => 'Discount is required',
            'startdate.required' => 'Start Date is required',
            'code.required' => 'Code is required',
        ];
    }
}
