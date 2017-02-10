<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Post;

class DeletePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $post = Post::findOrFail($this->route('blog'));
        $return = null;

        if (Auth::guard('employee')->user()->isAdmin()) {
            $return = true;
        }
        elseif ($post->author_id != Auth::guard('employee')->id()) {
            if ($post->author_id == null) {
                $return = true;
            }
            $return = false;
        } else {
            $return = true;
        }

        return $return;
    }

    public function forbiddenresponse()
    {
        return redirect(route('blog.index'))->withErrors([
            'error' => 'You are not able to delete the blog post of another person.'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
