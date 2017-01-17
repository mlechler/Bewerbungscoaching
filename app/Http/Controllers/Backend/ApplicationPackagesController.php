<?php

namespace App\Http\Controllers\Backend;

use App\Applicationpackage;
use Illuminate\Http\Request;
use App\Http\Requests;

class ApplicationPackagesController extends Controller
{
    protected $packages;

    public function __construct(Applicationpackage $packages)
    {
        $this->packages = $packages;

        parent::__construct();
    }

    public function index()
    {
        $packages = Applicationpackage::orderBy('title')->paginate(10);

        return view('backend.applicationpackages.index', compact('packages'));
    }

    public function create(Applicationpackage $package)
    {
        return view('backend.applicationpackages.form', compact('package'));
    }

    public function store(Requests\StorePackageRequest $request)
    {
        Applicationpackage::create(array(
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ));

        return redirect(route('applicationpackages.index'))->with('status', 'Application Package has been created.');
    }

    public function edit($id)
    {
        $package = Applicationpackage::findOrFail($id);

        return view('backend.applicationpackages.form', compact('package'));
    }

    public function update(Requests\UpdatePackageRequest $request, $id)
    {
        $package = Applicationpackage::findOrFail($id);

        $package->fill(array(
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ))->save();

        return redirect(route('applicationpackages.index'))->with('status', 'Application Package has been updated.');
    }

    public function confirm($id)
    {
        $package = Applicationpackage::findOrFail($id);

        return view('backend.applicationpackages.confirm', compact('package'));
    }

    public function destroy($id)
    {
        Applicationpackage::destroy($id);

        return redirect(route('applicationpackages.index'))->with('status', 'Application Package has been deleted.');
    }

    public function detail($id)
    {
        $package = Applicationpackage::findOrFail($id);

        return view('backend.applicationpackages.detail', compact('package'));
    }

    /*public function storeFile($packageFile, $package_id)
    {
            $fileName = $packageFile->getClientOriginalName();
            $destinationPath = config('app.packageDestinationPath') . '/' . $package_id . '/' . $fileName;
            $uploaded = Storage::put($destinationPath, file_get_contents($packageFile->getRealPath()));

        if ($uploaded) {
            $package = Applicationpackage::findOrFail($package_id);

            $package->fill(array(
                'path' => $destinationPath
            ))->save();
        }
    }

    public function deleteFile($id)
    {
        $package = Applicationpackage::whereId($id)->first();

        $package->fill(array(
            'path' => null
        ))->save();

        Storage::delete($package->path);

        return redirect()->back()->with('status', 'File has been deleted.');
    }*/
}
