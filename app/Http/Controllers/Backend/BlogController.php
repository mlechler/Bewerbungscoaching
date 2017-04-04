<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Http\Requests;
use Dropbox\WriteMode;
use GrahamCampbell\Dropbox\Facades\Dropbox;
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

    public function store(Requests\Backend\StorePostRequest $request)
    {
        $post = Post::create(array(
            'author_id' => Auth::guard('employee')->id(),
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'published_at' => $request->published_at
        ));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $this->storeImage($image, $post->id);
        }

        return redirect(route('blog.index'))->with('status', 'Blog Post has been created.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.form', compact('post'));
    }

    public function update(Requests\Backend\UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->fill(array(
            'title' => $request->title,
            'slug' => $request->slug,
            'body' => $request->body,
            'excerpt' => $request->excerpt,
            'published_at' => $request->published_at
        ))->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $this->storeImage($image, $post->id);
        }

        return redirect(route('blog.index'))->with('status', 'Blog Post has been updated.');
    }

    public function confirm(Requests\Backend\DeletePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.confirm', compact('post'));
    }

    public function destroy(Requests\Backend\DeletePostRequest $request, $id)
    {
        Post::destroy($id);

        return redirect(route('blog.index'))->with('status', 'Blog Post has been deleted.');
    }

    public function detail($id)
    {
        $post = Post::findOrFail($id);

        return view('backend.blog.detail', compact('post'));
    }

    public function storeImage($image, $post_id)
    {
        $fileName = $image->getClientOriginalName();
        $destinationPath = '/blog/' . $post_id . '/' . $fileName;

        Dropbox::uploadFileFromString($destinationPath, WriteMode::force(), file_get_contents($image));

        $downloadLink = Dropbox::createShareableLink($destinationPath);

        $post = Post::findOrFail($post_id);

        $post->fill(array(
            'image' => $destinationPath,
            'preview' => $downloadLink
        ))->save();

    }

    public function deleteImage($post_id)
    {
        $post = Post::findOrFail($post_id);

        Dropbox::delete($post->image);

        $post->fill(array(
            'image' => null,
            'preview' => null
        ))->save();

        return redirect()->back()->with('status', 'Image has been deleted.');
    }
}
