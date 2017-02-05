<?php

namespace App\Http\Controllers\Backend;

use App\ApplicationPackage;
use App\PackagePurchase;
use App\Http\Requests;

class ApplicationPackagesController extends Controller
{
    protected $packages;

    public function __construct(ApplicationPackage $packages)
    {
        $this->packages = $packages;

        parent::__construct();
    }

    public function index()
    {
        $packages = ApplicationPackage::orderBy('title')->paginate(10);

        return view('backend.applicationpackages.index', compact('packages'));
    }

    public function create(ApplicationPackage $package)
    {
        return view('backend.applicationpackages.form', compact('package'));
    }

    public function store(Requests\StorePackageRequest $request)
    {
        ApplicationPackage::create(array(
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ));

        return redirect(route('applicationpackages.index'))->with('status', 'Application Package has been created.');
    }

    public function edit($id)
    {
        $package = ApplicationPackage::findOrFail($id);

        return view('backend.applicationpackages.form', compact('package'));
    }

    public function update(Requests\UpdatePackageRequest $request, $id)
    {
        $package = ApplicationPackage::findOrFail($id);

        $package->fill(array(
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price
        ))->save();

        return redirect(route('applicationpackages.index'))->with('status', 'Application Package has been updated.');
    }

    public function confirm($id)
    {
        $package = ApplicationPackage::findOrFail($id);

        return view('backend.applicationpackages.confirm', compact('package'));
    }

    public function destroy($id)
    {
        ApplicationPackage::destroy($id);

        $this->deletePurchases($id);

        return redirect(route('applicationpackages.index'))->with('status', 'Application Package has been deleted.');
    }

    public function detail($id)
    {
        $package = ApplicationPackage::findOrFail($id);

        return view('backend.applicationpackages.detail', compact('package'));
    }

    public function deletePurchases($applicationpackage_id)
    {
        $purchases = PackagePurchase::all()->where('applicationpackage_id', '=', $applicationpackage_id);

        foreach ($purchases as $purchase) {
            PackagePurchase::destroy($purchase->id);
        }
    }
}
