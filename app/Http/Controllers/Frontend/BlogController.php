<?php

namespace App\Http\Controllers\Frontend;

use App\Post;
use Carbon\Carbon;

class BlogController extends Controller
{
    protected $posts;

    public function __construct(Post $posts)
    {
        $this->posts = $posts;
    }

    public function index()
    {
        $posts = Post::with('author')->where('published_at','!=',null)->where('published_at','<=',Carbon::now())->orderBy('published_at', 'desc')->paginate(10);

        return view('frontend.blog.index', compact('posts'));
    }

    public function detail($slug)
    {
        $post = Post::with('author')->where('slug', '=', $slug)->first();

        return view('frontend.blog.detail', compact('post'));
    }
}
