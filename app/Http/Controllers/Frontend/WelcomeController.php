<?php

namespace App\Http\Controllers\Frontend;

use App\Post;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('published_at','!=',null)->where('published_at','<=',Carbon::now())->orderBy('published_at', 'desc')->take(3)->get();

        return view('frontend.welcome', compact('posts'));
    }
}
