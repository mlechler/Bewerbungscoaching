<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
        $id = $this->route('discount');
        return [
            'title' => ['required', 'unique:discounts,title,'.$id],
            'service' => ['required'],
            'amount' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Discounts',
            'service.required' => 'Service is required',
            'amount.required' => 'Amount is required'
        ];
    }
}
