<?php

namespace App\Http\Controllers\Backend;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Requests;
use Baum\MoveNotPossibleException;

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
        $pages = Page::orderBy('lft')->paginate(10);

        return view('backend.pages.index', compact('pages'));
    }

    public function create(Page $page)
    {
        $orderPages = Page::all();

        return view('backend.pages.form', compact('page', 'orderPages'));
    }

    public function store(Requests\Backend\StorePageRequest $request)
    {
        $page = Page::create(array(
            'title' => $request->title,
            'uri' => $request->uri,
            'name' => $request->name,
            'pagecontent' => $request->pagecontent
        ));

        $this->updatePageOrder($page, $request);

        return redirect(route('pages.index'))->with('status', 'Page has been created.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);

        $orderPages = Page::all();

        return view('backend.pages.form', compact('page', 'orderPages'));
    }

    public function update(Requests\Backend\UpdatePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        if ($response = $this->updatePageOrder($page, $request)) {
            return $response;
        }

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
        $page = Page::findOrFail($id);

        foreach ($page->children as $child) {
            $child->makeRoot();
        }
        Page::destroy($id);

        return redirect(route('pages.index'))->with('status', 'Page has been deleted.');
    }

    public function detail($id)
    {
        $page = Page::findOrFail($id);

        return view('backend.pages.detail', compact('page'));
    }

    protected function updatePageOrder(Page $page, Request $request)
    {
        if ($request->has('order', 'orderPage')) {
            try {
                $page->updateOrder($request->input('order'), $request->input('orderPage'));
            } catch (MoveNotPossibleException $exception) {
                return redirect(route('pages.edit', $page->id))->withInput()->withErrors([
                    'error' => 'Cannot make a page a child of itself.'
                ]);
            }
        }
    }
}