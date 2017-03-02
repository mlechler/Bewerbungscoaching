<?php
namespace App\Http\Controllers\Backend;

use App\ApplicationLayout;
use App\LayoutPurchase;
use App\Http\Requests;
use Dropbox\WriteMode;
use GrahamCampbell\Dropbox\Facades\Dropbox;

class ApplicationLayoutsController extends Controller
{
    protected $layouts;

    public function __construct(ApplicationLayout $layouts)
    {
        $this->layouts = $layouts;
        parent::__construct();
    }

    public function index()
    {
        $layouts = ApplicationLayout::orderBy('title')->paginate(10);
        return view('backend.applicationlayouts.index', compact('layouts'));
    }

    public function create(ApplicationLayout $layout)
    {
        return view('backend.applicationlayouts.form', compact('layout'));
    }

    public function store(Requests\Backend\StoreLayoutRequest $request)
    {
        $layout = ApplicationLayout::create(array(
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
        $layout = ApplicationLayout::findOrFail($id);
        return view('backend.applicationlayouts.form', compact('layout'));
    }

    public function update(Requests\Backend\UpdateLayoutRequest $request, $id)
    {
        $previewFile = null;
        $layoutFile = null;
        $layout = ApplicationLayout::findOrFail($id);
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
        $layout = ApplicationLayout::findOrFail($id);
        return view('backend.applicationlayouts.confirm', compact('layout'));
    }

    public function destroy($id)
    {
        $layout = ApplicationLayout::whereId($id)->first();
        if ($layout->preview) {
            Dropbox::delete($layout->preview);
        }
        if ($layout->layout) {
            Dropbox::delete($layout->layout);
        }
        ApplicationLayout::destroy($id);
        $this->deletePurchases($id);
        return redirect(route('applicationlayouts.index'))->with('status', 'Application Layout has been deleted.');
    }

    public function detail($id)
    {
        $layout = ApplicationLayout::findOrFail($id);
        return view('backend.applicationlayouts.detail', compact('layout'));
    }

    public function storeFiles($previewFile, $layoutFile, $layout_id)
    {
        $uploadedPreview = null;
        $uploadedLayout = null;
        if ($previewFile) {
            $previewFileName = $previewFile->getClientOriginalName();
            $previewDestinationPath = '/layouts/' . $layout_id . '/' . $previewFileName;
            Dropbox::uploadFileFromString($previewDestinationPath, WriteMode::force(), file_get_contents($previewFile));

            $layout = ApplicationLayout::findOrFail($layout_id);
            $layout->fill(array(
                'preview' => $previewDestinationPath
            ))->save();
        }
        if ($layoutFile) {
            $layoutFileName = $layoutFile->getClientOriginalName();
            $layoutDestinationPath = '/layouts/' . $layout_id . '/' . $layoutFileName;
            Dropbox::uploadFileFromString($layoutDestinationPath, WriteMode::force(), file_get_contents($layoutFile));

            $layout = ApplicationLayout::findOrFail($layout_id);
            $layout->fill(array(
                'layout' => $layoutDestinationPath
            ))->save();
        }
    }

    public function deletePreviewFile($id)
    {
        $layout = ApplicationLayout::findOrFail($id);
        Dropbox::delete($layout->preview);
        $layout->fill(array(
            'preview' => null
        ))->save();
        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function deleteLayoutFile($id)
    {
        $layout = ApplicationLayout::findOrFail($id);
        Dropbox::delete($layout->layout);
        $layout->fill(array(
            'layout' => null
        ))->save();
        return redirect()->back()->with('status', 'File has been deleted.');
    }

    public function deletePurchases($applicationlayout_id)
    {
        $purchases = LayoutPurchase::all()->where('applicationlayout_id', '=', $applicationlayout_id);
        foreach ($purchases as $purchase) {
            LayoutPurchase::destroy($purchase->id);
        }
    }
}
