<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests;

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

    /*public function store(Requests\StorePageRequest $request)
    {
        $post = Post::create(array(
            'author_id' => $request->author_id,
            'title' => $request->title,
            'uri' => $request->uri,
            'name' => $request->name,
            'pagecontent' => $request->pagecontent,
            'template' => $request->template
        ));

        $this->updatePageOrder($page, $request);

        return redirect(route('pages.index'))->with('status', 'Page has been created.');
    }*/

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.form', compact('post'));
    }

    /*public function update(Requests\UpdatePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        if ($response = $this->updatePageOrder($page, $request)) {
            return $response;
        }

        $page->fill(array(
            'title' => $request->title,
            'uri' => $request->uri,
            'name' => $request->name,
            'pagecontent' => $request->pagecontent,
            'template' => $request->template
        ))->save();

        return redirect(route('pages.index'))->with('status', 'Page has been updated.');
    }*/

    public function confirm($id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.confirm', compact('post'));
    }

    public function destroy($id)
    {
        Post::destroy($id);

        return redirect(route('blog.index'))->with('status', 'Blog post has been deleted.');
    }
}
