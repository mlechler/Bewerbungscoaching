<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'seminar_id' => ['required'],
            'date' => ['required', 'date_format:Y-m-d'],
            'time' => ['required', 'date_format:H:i'],
            'zip' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'housenumber' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee is required',
            'seminar_id.required' => 'Seminar is required',
            'date.required' => 'Date is required',
            'time.required' => 'Time is required',
            'zip.required' => 'Zip is required',
            'city.required' => 'City is required',
            'street.required' => 'Street is required',
            'housenumber.required' => 'Housenumber is required'
        ];
    }
}
