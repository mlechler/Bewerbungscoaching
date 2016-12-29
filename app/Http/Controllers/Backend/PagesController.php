<?php

namespace App\Http\Controllers\Backend;

use App\Page;
use Illuminate\Http\Request;

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

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function confirm()
    {

    }

    public function destroy()
    {

    }
}