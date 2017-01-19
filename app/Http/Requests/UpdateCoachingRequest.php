<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoachingRequest extends FormRequest
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
            'employee_id' => ['required'],
            'member_id' => ['required'],
            'services' => ['required'],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i'],
            'duration' => ['required'],
            'price_incl_discount' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee is required',
            'member_id.required' => 'Member is required',
            'services.required' => 'Services is required',
            'date.required' => 'Date is required',
            'time.required' => 'Start Time is required',
            'duration.required' => 'Duration is required',
            'price_incl_discount.required' => 'Price is required'
        ];
    }
}
