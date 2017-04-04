<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreIndividualCoachingRequestRequest extends FormRequest
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
        if(Auth::guard('member')->user()) {
            return [
                'message' => ['required'],
                'category' => ['required']
            ];
        } else {
            return [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'message' => ['required'],
                'category' => ['required']
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email has to be a valid Email',
            'message.required' => 'Message is required',
            'category.required' => 'Category is required',
        ];
    }
}
