<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeFreeTimeRequest extends FormRequest
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
            'endtime' => ['required'],
            'hourlyrate' => ['required'],
            'services' => ['required'],
            'zip' => ['required'],
            'city' => ['required'],
            'street' => ['required'],
            'housenumber' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => 'Employee is required',
            'date.required' => 'Date is required',
            'starttime.required' => 'Start Time is required',
            'endtime.required' => 'End Time is required',
            'hourlyrate.required' => 'Hourly Rate is required',
            'services.required' => 'Services is required',
            'zip.required' => 'Zip is required',
            'city.required' => 'City is required',
            'street.required' => 'Street is required',
            'housenumber.required' => 'Housenumber is required',
        ];
    }
}
