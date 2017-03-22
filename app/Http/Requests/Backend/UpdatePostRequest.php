<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use App\Post;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
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
            $return = false;
        } else {
            $return = true;
        }

        return $return;
    }

    public function forbiddenresponse()
    {
        return redirect(route('blog.index'))->withErrors([
            'error' => 'You are not able to edit the blog post of another person.'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('blog');
        return [
            'title' => ['required', 'unique:posts,title,'.$id],
            'slug' => ['required'],
            'published_at' => ['date_format:Y-m-d H:i:s'],
            'body' => ['required'],
            'image' => ['mimes:' . config('app.allowedImageFileTypes'), 'max:' . config('app.maxFileSize')]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required',
            'title.unique' => 'Title has to be unique in Blog Posts',
            'slug.required' => 'Slug is required',
            'body.required' => 'Body is required',
            'image.mimes' => 'Wrong Filetype',
            'image.max' => 'Filesize exceeded'
        ];
    }
}
