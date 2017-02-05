<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeminarRequest extends FormRequest
{
    protected $fileindex;
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
        $rules = [
            'title' => ['required', 'unique:seminars'],
            'description' => ['required'],
            'services' => ['required'],
            'maxMembers' => ['required'],
            'duration' => ['required'],
            'price' => ['required'],
            'files' => ['array']
        ];

        $files = $this->file('files');

        if (!empty($files)) {
            foreach ($files as $key => $file) // add individual rules to each image
            {
                $rules[sprintf('files.%d', $key)] = ['required', 'mimes:' . config('app.allowedFileTypes'), 'max:' . config('app.maxFileSize')];
                $this->fileindex[] = [
                    sprintf('files.%d', $key) . '.required',
                    sprintf('files.%d', $key) . '.mimes',
                    sprintf('files.%d', $key) . '.max'
                ];
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Seminars',
            'description.required' => 'Description is required',
            'services.required' => 'Services is required',
            'maxMembers.required' => 'Maximum Participants is required',
            'duration.required' => 'Duration is required',
            'price.required' => 'Price is required'
        ];

        if ($this->fileindex) {
            foreach ($this->fileindex as $file) {
                $messages[$file[0]] = 'File is required';
                $messages[$file[1]] = 'Wrong Filetype';
                $messages[$file[2]] = 'Filesize exceeded';
            }
        }
        return $messages;
    }
}
