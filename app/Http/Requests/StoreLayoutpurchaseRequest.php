<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLayoutpurchaseRequest extends FormRequest
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
            'applicationlayout_id' => ['required'],
            'price_incl_discount' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'member_id.required' => 'Member is required',
            'applicationlayout_id.required' => 'Application Layout is required',
            'price_incl_discount.required' => 'Price is required'
        ];
    }
}
