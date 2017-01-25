<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFreeTimeRequest extends FormRequest
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
            'date' => ['required'],
            'starttime' => ['required'],
            'endtime' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee is required',
            'date.required' => 'Date is required',
            'starttime.required' => 'Start Time is required',
            'endtime.required' => 'End Time is required'
        ];
    }
}
