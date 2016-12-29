<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
        $id = $this->route('member');
        return [
            'lastname' => ['required'],
            'firstname' => ['required'],
            'birthday' => ['required'],
            'phone' => ['required'],
            'mobile' => ['required', 'unique:members,mobile,'.$id],
            'email' => ['required', 'email', 'unique:members,email,'.$id],
            'password' => ['required_with:password_confirmation','confirmed']
        ];
    }
}
