<?php

namespace App\Http\Controllers\Backend;

use App\Applicationlayout;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class ApplicationLayoutsController extends Controller
{
    protected $layouts;

    public function __construct(Applicationlayout $layouts)
    {
        $this->layouts = $layouts;

        parent::__construct();
    }

    public function index()
    {
        $layouts = Applicationlayout::orderBy('title')->paginate(10);

        return view('backend.applicationlayouts.index', compact('layouts'));
    }

    public function create(Applicationlayout $layout)
    {
        return view('backend.applicationlayouts.form', compact('layout'));
    }

    public function store(Requests\StoreLayoutRequest $request)
    {
        $layout = Applicationlayout::create(array(
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'layout' => null,
            'preview' => null
        ));

        $previewFile = $request->file('preview');
        $layoutFile = $request->file('layout');

        $this->storeFiles($previewFile, $layoutFile, $layout->id);


        return redirect(route('applicationlayouts.index'))->with('status', 'Application Layout has been created.');
    }

    public function edit($id)
    {
        $layout = Applicationlayout::findOrFail($id);

        return view('backend.applicationlayouts.form', compact('layout'));
    }

    public function update(Requests\UpdateLayoutRequest $request, $id)
    {
        $previewFile = null;
        $layoutFile = null;
        $layout = Applicationlayout::findOrFail($id);

        $layout->fill(array(
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ))->save();

        if ($request->hasFile('preview')) {
            $previewFile = $request->file('preview');
        }
        if ($request->hasFile('layout')) {
            $layoutFile = $request->file('layout');
        }

        $this->storeFiles($previewFile, $layoutFile, $layout->id);


        return redirect(route('applicationlayouts.index'))->with('status', 'Application Layout has been updated.');
    }

    public function confirm($id)
    {
        $layout = Applicationlayout::findOrFail($id);

        return view('backend.applicationlayouts.confirm', compact('layout'));
    }

    public function destroy($id)
    {
        $layout = Applicationlayout::whereId($id)->first();

        Storage::delete($layout->preview);
        Storage::delete($layout->layout);
        Applicationlayout::destroy($id);

        return redirect(route('applicationlayouts.index'))->with('status', 'Application Layout has been deleted.');
    }

    public function detail($id)
    {
        $layout = Applicationlayout::findOrFail($id);

        return view('backend.applicationlayouts.detail', compact('layout'));
    }

    public function storeFiles($previewFile, $layoutFile, $layout_id)
    {
        $uploadedPreview = null;
        $uploadedLayout = null;
        if ($previewFile) {
            $previewFileName = $previewFile->getClientOriginalName();
            $previewDestinationPath = config('app.layoutDestinationPath') . '/' . $layout_id . '/' . $previewFileName;
            $uploadedPreview = Storage::put($previewDestinationPath, file_get_contents($previewFile->getRealPath()));
        }
        if ($layoutFile) {
            $layoutFileName = $layoutFile->getClientOriginalName();
            $layoutDestinationPath = config('app.layoutDestinationPath') . '/' . $layout_id . '/' . $layoutFileName;
            $uploadedLayout = Storage::put($layoutDestinationPath, file_get_contents($layoutFile->getRealPath()));
        }
        if ($uploadedPreview) {
            $layout = Applicationlayout::findOrFail($layout_id);

            $layout->fill(array(
                'preview' => $previewDestinationPath
            ))->save();
        }
        if ($uploadedLayout) {
            $layout = Applicationlayout::findOrFail($layout_id);

            $layout->fill(array(
                'layout' => $layoutDestinationPath
            ))->save();
        }
    }

    public function deletePreviewFile($id)
    {
        $layout = Applicationlayout::findOrFail($id);

        $layout->fill(array(
            'preview' => null
        ))->save();

        Storage::delete($layout->preview);

        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function deleteLayoutFile($id)
    {
        $layout = Applicationlayout::findOrFail($id);

        $layout->fill(array(
            'layout' => null
        ))->save();

        Storage::delete($layout->layout);

        return redirect()->back()->with('status', 'File has been deleted.');
    }
}
