<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeminarRequest extends FormRequest
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
        $id = $this->route('seminar');
        $rules = [
            'title' => ['required', 'unique:seminars,title,'.$id],
            'description' => ['required'],
            'services' => ['required'],
            'maxMembers' => ['required'],
            'duration' => ['required'],
            'price' => ['required'],
            'files' => ['array']
        ];

        $files = $this->file( 'files' );

        if ( !empty( $files ) )
        {
            foreach ( $files as $key => $file ) // add individual rules to each image
            {
                $rules[ sprintf( 'files.%d', $key ) ] = ['required','mimes:'.config('app.allowedFileTypes'), 'max:'.config('app.maxFileSize')] ;
            }
        }

        return $rules;
    }
}
