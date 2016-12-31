<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    protected $posts;

    public function __construct(Post $posts)
    {
        $this->posts = $posts;

        parent::__construct();
    }

    public function index()
    {
        $posts = Post::with('author')->orderBy('published_at', 'desc')->paginate(10);

        return view('backend.blog.index', compact('posts'));
    }

    public function create(Post $post)
    {
        return view('backend.blog.form', compact('post'));
    }

    public function store(Requests\StorePostRequest $request)
    {
        Post::create(array(
            'author_id' => Auth::id(),
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'published_at' => $request->published_at
        ));

        return redirect(route('blog.index'))->with('status', 'Blog Post has been created.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.form', compact('post'));
    }

    public function update(Requests\UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->fill(array(
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'published_at' => $request->published_at
        ))->save();

        return redirect(route('blog.index'))->with('status', 'Blog Post has been updated.');
    }

    public function confirm(Requests\DeletePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.confirm', compact('post'));
    }

    public function destroy(Requests\DeletePostRequest $request, $id)
    {
        Post::destroy($id);

        return redirect(route('blog.index'))->with('status', 'Blog post has been deleted.');
    }
}
