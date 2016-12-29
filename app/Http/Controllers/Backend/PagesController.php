<?php

namespace App\Http\Controllers\Backend;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Requests;

class PagesController extends Controller
{
    protected $pages;

    public function __construct(Page $pages)
    {
        $this->pages = $pages;

        parent::__construct();
    }

    public function index()
    {
        $pages = Page::paginate(10);

        return view('backend.pages.index', compact('pages'));
    }

    public function create(Page $page)
    {
        return view('backend.pages.form', compact('page'));
    }

    public function store(Requests\StorePageRequest $request)
    {
        Page::create(array(
            'title' => $request->title,
            'uri' => $request->uri,
            'name' => $request->name,
            'pagecontent' => $request->pagecontent
        ));

        return redirect(route('pages.index'))->with('status', 'Page has been created.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('backend.pages.form', compact('page'));
    }

    public function update(Requests\UpdatePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->fill(array(
            'title' => $request->title,
            'uri' => $request->uri,
            'name' => $request->name,
            'pagecontent' => $request->pagecontent
        ))->save();

        return redirect(route('pages.index'))->with('status', 'Page has been updated.');
    }

    public function confirm($id)
    {
        $page = Page::findOrFail($id);

        return view('backend.pages.confirm', compact('page'));
    }

    public function destroy($id)
    {
        Page::destroy($id);

        return redirect(route('pages.index'))->with('status', 'Page has been deleted.');
    }
}